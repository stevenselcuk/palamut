const { gulp, series, parallel, dest, src, watch } = require( 'gulp' );
const babel = require( 'gulp-babel' );
const browserSync = require( 'browser-sync' );
const concat = require( 'gulp-concat' );
const connect = require( 'gulp-connect-php' );
const del = require( 'del' );
const fs = require( 'fs' );
const gutil = require( 'gulp-util' );
const imagemin = require( 'gulp-imagemin' );
const inject = require( 'gulp-inject-string' );
const partialimport = require( 'postcss-easy-import' );
const plumber = require( 'gulp-plumber' );
const postcss = require( 'gulp-postcss' );
const postCSSMixins = require( 'postcss-mixins' );
const postcssPresetEnv = require( 'postcss-preset-env' );
const remoteSrc = require( 'gulp-remote-src' );
const sourcemaps = require( 'gulp-sourcemaps' );
const uglify = require( 'gulp-uglify' );
const zip = require( 'gulp-vinyl-zip' );
const sass = require( 'gulp-sass' );
const bulkSass = require( 'gulp-sass-bulk-import' );
const autoprefixer = require( 'gulp-autoprefixer' );
const gcmq = require( 'gulp-group-css-media-queries' );
const lineec = require( 'gulp-line-ending-corrector' );
/* -------------------------------------------------------------------------------------------------
Theme Name
-------------------------------------------------------------------------------------------------- */
const themeName = 'palamut';

/* -------------------------------------------------------------------------------------------------
PostCSS Plugins
-------------------------------------------------------------------------------------------------- */
const pluginsListDev = [
	partialimport,
	postCSSMixins,
	postcssPresetEnv( {
		stage: 0,
		features: {
			'nesting-rules': true,
			'color-mod-function': true,
			'custom-media': true,
		},
	} ),
];

const pluginsListProd = [
	partialimport,
	postCSSMixins,
	postcssPresetEnv( {
		stage: 0,
		features: {
			'nesting-rules': true,
			'color-mod-function': true,
			'custom-media': true,
		},
	} ),
	require( 'cssnano' )( {
		preset: [
			'default',
			{
				discardComments: false,
			},
		],
	} ),
];

const conf = {
	BROWSERS_LIST: [
		'last 2 version',
		'> 1%',
		'ie >= 11',
		'last 1 Android versions',
		'last 1 ChromeAndroid versions',
		'last 2 Chrome versions',
		'last 2 Firefox versions',
		'last 2 Safari versions',
		'last 2 iOS versions',
		'last 2 Edge versions',
		'last 2 Opera versions',
	],
};
/* -------------------------------------------------------------------------------------------------
Header & Footer JavaScript Boundles
-------------------------------------------------------------------------------------------------- */
const headerJS = [
	'./node_modules/jquery/dist/jquery.js',
//	'./node_modules/nprogress/nprogress.js',
//	'./node_modules/aos/dist/aos.js',
];

const footerJS = [ './src/assets/js/**' ];

/* -------------------------------------------------------------------------------------------------
Installation Tasks
-------------------------------------------------------------------------------------------------- */
async function cleanup() {
	await del( [ './build' ] );
	await del( [ './dist' ] );
}

async function downloadWordPress() {
	await remoteSrc( [ 'latest.zip' ], {
		base: 'https://wordpress.org/',
	} ).pipe( dest( './build/' ) );
}

async function unzipWordPress() {
	return await zip.src( './build/latest.zip' ).pipe( dest( './build/' ) );
}

async function copyConfig() {
	if ( await fs.existsSync( './wp-config.php' ) ) {
		return src( './wp-config.php' )
			.pipe( inject.after( 'define(\'DB_COLLATE\', \'\');', '\ndefine(\'DISABLE_WP_CRON\', true);' ) )
			.pipe( dest( './build/wordpress' ) );
	}
}

async function installationDone() {
	await gutil.beep();
	await gutil.log( devServerReady );
	await gutil.log( thankYou );
}

exports.setup = series( cleanup, downloadWordPress );
exports.install = series( unzipWordPress, copyConfig, installationDone );

/* -------------------------------------------------------------------------------------------------
Development Tasks
-------------------------------------------------------------------------------------------------- */
function devServer() {
	connect.server(
		{
			base: './build/wordpress',
			port: '3020',
		},
		() => {
			browserSync( {
				logPrefix: 'Palamut',
				proxy: '127.0.0.1:3020',
				host: '127.0.0.1',
				port: '3010',
				open: 'external',
			} );
		},
	);

	watch( './src/assets/styles/**/*.scss', series( stylesDev, GutenbergStylesDev, ClassicStylesDev ) );
	watch( './src/assets/styles/widgets/**', series( WidgetsstylesDev ) );
	watch( './src/assets/styles/shortcodes/**', series( ShortCodestylesDev ) );
	watch( './src/assets/js/**', series( footerScriptsDev, Reload ) );
	watch( './src/theme/**', series( copyThemeDev, Reload ) );
	watch( './src/plugins/**', series( pluginsDev, Reload ) );
	watch( './build/wordpress/wp-config.php', { events: 'add' }, series( disableCron ) );
}

function Reload( done ) {
	browserSync.reload();
	browserSync.notify( 'Page has been updated.', 1000 );
	done();
}

function copyThemeDev() {
	if ( ! fs.existsSync( './build' ) ) {
		gutil.log( buildNotFound );
		process.exit( 1 );
	} else {
		return src( './src/theme/**' ).pipe( dest( './build/wordpress/wp-content/themes/' + themeName ) );
	}
}

function stylesDev() {
	return src( './src/assets/styles/style.scss' )
		.pipe( plumber( function( error ) {
			gutil.log( error.message );
			this.emit( 'end' );
		} ) )
		.pipe( bulkSass() )
		.pipe( sourcemaps.init() )
		.pipe(
			sass( {
				errLogToConsole: true,
				outputStyle: 'compact',
				precision: 10,
			} )
		)
	//		.pipe( autoprefixer( conf.BROWSERS_LIST ) )
	//		.pipe( gcmq() )
	//		.pipe( lineec() )
	//		.pipe( postcss( pluginsListDev ) )
	//		.pipe( lineec() )
		.pipe( sourcemaps.write( '.' ) )
		.pipe( dest( './build/wordpress/wp-content/themes/' + themeName ) )
		.pipe( browserSync.stream() );
}

function footerScriptsDev() {
	return src( footerJS )
		.pipe( plumber( { errorHandler: onError } ) )
		.pipe( sourcemaps.init() )
		.pipe(
			babel( {
				presets: [ '@babel/preset-env' ],
			} ),
		)
		.pipe( concat( 'app.js' ) )
		.pipe( sourcemaps.write( '.' ) )
		.pipe( dest( './build/wordpress/wp-content/themes/' + themeName + '/assets/js' ) );
}

function pluginsDev() {
	return src( [ './src/plugins/**', '!./src/plugins/README.md' ] ).pipe(
		dest( './build/wordpress/wp-content/plugins' ),
	);
}

function ShortCodestylesDev() {
	return src( './src/assets/styles/shortcodes/main.scss' )
		.pipe( plumber( function( error ) {
			gutil.log( error.message );
			this.emit( 'end' );
		} ) )
		.pipe( bulkSass() )
		.pipe(
			sass( {
				errLogToConsole: true,
				outputStyle: 'compact',
				precision: 10,
			} )
		)
	//		.pipe( autoprefixer( conf.BROWSERS_LIST ) )
	//		.pipe( gcmq() )
	//		.pipe( lineec() )
	//		.pipe( postcss( pluginsListDev ) )
		.pipe( concat( 'shortcodes.css' ) )
	//		.pipe( lineec() )
		.pipe( dest( './src/plugins/palamut/includes/supports/classic-editor/shortcodes/assets/css/' ) )
		.pipe( browserSync.stream( { match: '**/*.css' } ) );
}

function WidgetsstylesDev() {
	return src( './src/assets/styles/widgets/main.scss' )
		.pipe( plumber( function( error ) {
			gutil.log( error.message );
			this.emit( 'end' );
		} ) )
		.pipe( bulkSass() )
		.pipe(
			sass( {
				errLogToConsole: true,
				outputStyle: 'compact',
				precision: 10,
			} )
		)
	//		.pipe( autoprefixer( conf.BROWSERS_LIST ) )
	//		.pipe( gcmq() )
	//		.pipe( lineec() )
	//		.pipe( postcss( pluginsListDev ) )
		.pipe( concat( 'widgets.css' ) )
	//		.pipe( lineec() )
		.pipe( dest( './src/plugins/palamut/includes/widgets/assets/css/' ) )
		.pipe( browserSync.stream( { match: '**/*.css' } ) );
}

function ClassicStylesDev() {
	return src( './src/assets/styles/classic-editor-style.scss' )
		.pipe( plumber( function( error ) {
			gutil.log( error.message );
			this.emit( 'end' );
		} ) )
		.pipe( bulkSass() )
		.pipe(
			sass( {
				errLogToConsole: true,
				outputStyle: 'compact',
				precision: 10,
			} )
		)
	//		.pipe( autoprefixer( conf.BROWSERS_LIST ) )
	//		.pipe( gcmq() )
	//		.pipe( lineec() )
	//		.pipe( postcss( pluginsListDev ) )
	//		.pipe( lineec() )
		.pipe( dest( './src/theme/assets/css/' ) )
		.pipe( browserSync.stream( { match: '**/*.css' } ) );
}

function GutenbergStylesDev() {
	return src( './src/assets/styles/gutenberg-editor-style.scss' )
		.pipe( plumber( function( error ) {
			gutil.log( error.message );
			this.emit( 'end' );
		} ) )
		.pipe( bulkSass() )
		.pipe(
			sass( {
				errLogToConsole: true,
				outputStyle: 'compact',
				precision: 10,
			} )
		)
	//		.pipe( autoprefixer( conf.BROWSERS_LIST ) )
	//		.pipe( gcmq() )
	//		.pipe( lineec() )
	//		.pipe( postcss( pluginsListDev ) )
	//		.pipe( lineec() )
		.pipe( dest( './src/theme/assets/css/' ) )
		.pipe( browserSync.stream( { match: '**/*.css' } ) );
}

exports.start = series(
	copyThemeDev,
	stylesDev,
	ShortCodestylesDev,
	WidgetsstylesDev,
	GutenbergStylesDev,
	ClassicStylesDev,
	footerScriptsDev,
	pluginsDev,
	devServer,
);

/* -------------------------------------------------------------------------------------------------
Utility Tasks
-------------------------------------------------------------------------------------------------- */
const onError = err => {
	gutil.beep();
	gutil.log( wpFy + ' - ' + errorMsg + ' ' + err.toString() );
	this.emit( 'end' );
};

async function disableCron() {
	if ( fs.existsSync( './build/wordpress/wp-config.php' ) ) {
		await fs.readFile( './build/wordpress/wp-config.php', ( err, data ) => {
			if ( err ) {
				gutil.log( wpFy + ' - ' + warning + ' WP_CRON was not disabled!' );
			}
			if ( data ) {
				if ( data.indexOf( 'DISABLE_WP_CRON' ) >= 0 ) {
					gutil.log( 'WP_CRON is already disabled!' );
				} else {
					return src( './build/wordpress/wp-config.php' )
						.pipe( inject.after( 'define(\'DB_COLLATE\', \'\');', '\ndefine(\'DISABLE_WP_CRON\', true);' ) )
						.pipe( dest( './build/wordpress' ) );
				}
			}
		} );
	}
}

async function freshInstall() {
	await del( [ './src/**' ] ).then( () => {
		return src( './tools/fresh-theme/**' ).pipe( dest( './src' ) );
	} );
}

exports.fresh = series( freshInstall );

function Backup() {
	if ( ! fs.existsSync( './build' ) ) {
		gutil.log( buildNotFound );
		process.exit( 1 );
	} else {
		return src( './build/**/*' )
			.pipe( zip.dest( './backups/' + date + '.zip' ) )
			.on( 'end', () => {
				gutil.beep();
				gutil.log( backupsGenerated );
				gutil.log( thankYou );
			} );
	}
}

exports.backup = series( Backup );

/* -------------------------------------------------------------------------------------------------
Messages
-------------------------------------------------------------------------------------------------- */
const date = new Date().toLocaleDateString( 'en-GB' ).replace( /\//g, '.' );
const errorMsg = '\x1b[41mError\x1b[0m';
const warning = '\x1b[43mWarning\x1b[0m';
const devServerReady =
	'Your development server is ready, start the workflow with the command: $ \x1b[1mnpm run dev\x1b[0m';
const buildNotFound =
	errorMsg +
	' ⚠️　- You need to install WordPress first. Run the command: $ \x1b[1mnpm run install:wordpress\x1b[0m';
const filesGenerated =
	'Your ZIP template file was generated in: \x1b[1m' +
	__dirname +
	'/dist/' +
	themeName +
	'.zip\x1b[0m - ✅';
const pluginsGenerated =
	'Plugins are generated in: \x1b[1m' + __dirname + '/dist/plugins/\x1b[0m - ✅';
const backupsGenerated =
	'Your backup was generated in: \x1b[1m' + __dirname + '/backups/' + date + '.zip\x1b[0m - ✅';
const wpFy = '\x1b[42m\x1b[1mPalamutFramework\x1b[0m';
const wpFyUrl = '\x1b[2m - https://hevalandsteven.com/\x1b[0m';
const thankYou = 'Thank you for using ' + wpFy + wpFyUrl;

/* -------------------------------------------------------------------------------------------------
End of all Tasks
-------------------------------------------------------------------------------------------------- */
