const pkg				= require( './package.json' );

const slug			= pkg.slug;
const prefix			= pkg.prefix;
const prefixUppercase		= prefix.toUpperCase();
const themeVersion			= pkg.version;

const pluginSlug = pkg.plugin_slug;
const pluginPrefix			= pkg.plugin_prefix;
const pluginPrefixUppercase		= pluginPrefix.toUpperCase();
//const pluginVersion			= pkg.plugin_version;
const pluginVersion			= pkg.version;
const project 			= pkg.name;
const pluginName			= pkg.plugin_name;

const cssPrefix			= pkg.cssPrefix;

// Language Task Vars. for Theme
const textDomain			= pkg.textdomain;
const translatePath		= './src/theme/languages';
const langFile			= slug + '.pot';
const packageName			= project;
const bugReport			= pkg.author_uri;
const lastTranslator		= pkg.author;
const team			= pkg.author_shop;
// Language Task Vars. for Plugin
const pluginTextDomain			= pkg.plugin_textdomain;
const pluginTranslatePath		= './src/theme/languages';
const pluginLangFile			= pkg.plugin_slug + '.pot';
const pluginPackageName			= pluginName;

// Sum Library.
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
const wpPot		= require( 'gulp-wp-pot' );
const sort		= require( 'gulp-sort' );
const replace = require( 'gulp-replace-task' );
const log = require( 'fancy-log' );
const bump = require( 'gulp-bump' );
//const rename = require( 'gulp-rename' );
const git = require( 'gulp-git' );
const filter = require( 'gulp-filter' );
const exec = require( 'child_process' ).exec;
const argv = require( 'yargs' ).option( 'type', {	alias: 't', choices: [ 'patch', 'minor', 'major' ] } ).option( 'fix', {	alias: 'f' } ).option( 'feature', {	alias: 'p' } ).argv;
const tag = require( 'gulp-tag-version' );
const push = require( 'gulp-git-push' );
const date = new Date().toLocaleDateString( 'en-US' ).replace( /\//g, '.' );

/* -------------------------------------------------------------------------------------------------
Theme Name
-------------------------------------------------------------------------------------------------- */
const themeName = slug;
const themePHPWatchFiles	= [ './src/theme/**/*.php', '!./src/theme/assets/**', '!./src/theme/languages/**' ];
const pluginPHPWatchFiles	= [ './src/plugins/palamut/**/.php' ];

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
Baby Steps Tasks
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

function copyDevPlugins() {
	return src( './tools/dev-plugins/**' )
		.pipe( dest( './build/wordpress/wp-content/plugins/' ) );
}

async function installationDone() {
	await gutil.log( '{{ 🙌🏻 yaaaay! }} Installation has done! Let\'s work! Proceed with that command: \x1b[1m npm run dev \x1b[0m' );
}

function editConfig( done ) {
	if ( fs.existsSync( './build/wordpress/wp-config.php' ) ) {
		fs.readFile( './build/wordpress/wp-config.php', ( err, data ) => {
			if ( data ) {
				if ( data.indexOf( 'WP_MEMORY_LIMIT' ) >= 0 ) {
					log( 'WordPress config looks good!' );
				} else {
					return src( './build/wordpress/wp-config.php' )
						.pipe( inject.after( 'define( \'WP_DEBUG\', false );', '\ndefine( \'DISABLE_WP_CRON\', true );\ndefine( \'WP_MEMORY_LIMIT\', \'128M\' );\n' ) )
						.pipe( replace( {
							patterns: [
								{
									match: 'define( \'WP_DEBUG\', false );',
									replacement: 'define( \'WP_DEBUG\', true );',
								},
							],
							usePrefix: false,
						} ) )
						.pipe( dest( './build/wordpress' ) );
				}
			}
		} );
	}
	gutil.log( 'No config? Huh! This is your first time I guess... See ya next time.' );
	done();
}

exports.setup = series( cleanup, downloadWordPress );
exports.install = series( unzipWordPress, copyDevPlugins, installationDone );
exports.config = series( editConfig );
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
	watch( './src/assets/styles/elementor/**', series( ElementorstylesDev ) );
	watch( './src/assets/js/**', series( footerScriptsDev, Reload ) );
	watch( './src/theme/**', series( copyThemeDev, Reload ) );
	watch( './src/plugins/**', series( pluginsDev, Reload ) );
	watch( './build/wordpress/wp-config.php', series( editConfig ) );
}

function Reload( done ) {
	browserSync.reload();
	browserSync.notify( 'Page has been updated.', 1000 );
	gutil.log( '{{ 🍔 work }} \x1b[1m Reloaded \x1b[0m' );
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

function ElementorstylesDev() {
	return src( './src/assets/styles/elementor/main.scss' )
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
		.pipe( concat( 'main.css' ) )
	//		.pipe( lineec() )
		.pipe( dest( './src/plugins/palamut/includes/supports/elementor/assets/css/' ) )
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
	ElementorstylesDev,
	footerScriptsDev,
	pluginsDev,
	devServer,
);

/* -------------------------------------------------------------------------------------------------
Utility Tasks
-------------------------------------------------------------------------------------------------- */

function translateTheme() {
	return src( themePHPWatchFiles )
		.pipe( sort() )
		.pipe( wpPot( {
			domain: textDomain,
			destFile: langFile,
			package: project,
			bugReport: bugReport,
			lastTranslator: lastTranslator,
			team: team,
		} ) )
		.pipe( dest( './src/theme/languages/' + textDomain + '.pot' ) );
}

function translatePlugin() {
	return src( pluginPHPWatchFiles )
		.pipe( sort() )
		.pipe( wpPot( {
			domain: pluginTextDomain,
			destFile: pluginLangFile,
			package: pluginPackageName,
			bugReport: bugReport,
			lastTranslator: lastTranslator,
			team: team,
		} ) )
		.pipe( dest( './src/plugins/palamut/' + pluginSlug + '/languages/' + pluginTextDomain + '.pot' ) );
}

async function changeThemeVars() {
	return src( themePHPWatchFiles )
		.pipe( replace( {
			patterns: [
				{
					match: /pkg.name/g,
					replacement: project,
				},
				{
					match: /pkg.version/g,
					replacement: pkg.version,
				},
				{
					match: /pkg.author/g,
					replacement: pkg.author,
				},
				{
					match: /pkg.author_shop/g,
					replacement: pkg.author_shop,
				},
				{
					match: /pkg.license/g,
					replacement: pkg.license,
				},
				{
					match: /pkg.license_uri/g,
					replacement: pkg.license_uri,
				},
				{
					match: /pkg.slug/g,
					replacement: pkg.slug,
				},
				{
					match: /pkg.copyright/g,
					replacement: pkg.copyright,
				},
				{
					match: /pkg.theme_uri/g,
					replacement: pkg.theme_uri,
				},
				{
					match: /textdomain/g,
					replacement: pkg.textdomain,
				},
				{
					match: /pkg.downloadid/g,
					replacement: pkg.downloadid,
				},
				{
					match: /pkg.description/g,
					replacement: pkg.description,
				},
			],
		} ) )
		.pipe( dest( './build/wordpress/wp-content/themes/' + slug ) );
}

async function changePluginVars() {
	return src( './src/plugins/palamut/**' )
		.pipe( replace( {
			patterns: [
				{
					match: /pkg.name/g,
					replacement: project,
				},
				{
					match: /pkg.version/g,
					replacement: pkg.version,
				},
				{
					match: /pkg.author/g,
					replacement: pkg.author,
				},
				{
					match: /pkg.author_shop/g,
					replacement: pkg.author_shop,
				},
				{
					match: /pkg.license/g,
					replacement: pkg.license,
				},
				{
					match: /pkg.license_uri/g,
					replacement: pkg.license_uri,
				},
				{
					match: /pkg.slug/g,
					replacement: pkg.slug,
				},
				{
					match: /pkg.copyright/g,
					replacement: pkg.copyright,
				},
				{
					match: /pkg.theme_uri/g,
					replacement: pkg.theme_uri,
				},
				{
					match: /textdomain/g,
					replacement: pkg.textdomain,
				},
				{
					match: /pkg.downloadid/g,
					replacement: pkg.downloadid,
				},
				{
					match: /pkg.description/g,
					replacement: pkg.description,
				},
			],
		} ) )
		.pipe( dest( './build/wordpress/wp-content/plugins/' + pluginSlug ) );
}

async function changeThemePrefix() {
	return src( themePHPWatchFiles )
		.pipe( replace( {
			patterns: [
				{
					match: 'prefix',
					replacement: prefix,
				},
				{
					match: '__PRE',
					replacement: prefixUppercase,
				},
			],
			usePrefix: false,
		} ) )
		.pipe( dest( './build/wordpress/wp-content/themes/' + slug ) );
}

async function changePluginPrefix() {
	return src( pluginPHPWatchFiles )
		.pipe( replace( {
			patterns: [
				{
					match: /prefix/g,
					replacement: pluginPrefix,
				},
				{
					match: /PRE/g,
					replacement: pluginPrefixUppercase,
				},
				{
					match: /plugin_name/g,
					replacement: pluginName,
				},
			],
			usePrefix: false,
		} ) )
		.pipe( dest( './build/wordpress/wp-content/plugins/' + pluginSlug ) );
}

async function changeThemeTextdomain() {
	return src( themePHPWatchFiles )
		.pipe( replace( {
			patterns: [
				{
					match: 'textdomain',
					replacement: textDomain,
				},
			],
			usePrefix: false,
		} ) )
		.pipe( dest( './build/wordpress/wp-content/themes/' + slug ) );
}

async function changePluginTextdomain() {
	return src( pluginPHPWatchFiles )
		.pipe( replace( {
			patterns: [
				{
					match: 'textdomain',
					replacement: pluginTextDomain,
				},
			],
			usePrefix: false,
		} ) )
		.pipe( dest( './build/wordpress/wp-content/plugins/' + pluginSlug ) );
}

exports.translate = series( translateTheme, translatePlugin );
exports.change_textdomain = series( changeThemeTextdomain, changePluginTextdomain );
exports.change_vars = series( changeThemeVars, changePluginVars );
exports.change_prefix = series( changeThemePrefix, changePluginPrefix );

exports.build = series(
	changeThemePrefix,
	changePluginPrefix,
	changeThemeVars,
	changePluginVars,
	changeThemeTextdomain,
	changePluginTextdomain,
	translateTheme,
	translatePlugin,
);

/* -------------------------------------------------------------------------------------------------
Build Tasks
-------------------------------------------------------------------------------------------------- */
async function cleanProd() {
	await del( [ './dist' ] );
}

function updateThemeVerMin() {
	return src( './package.json' ).pipe( bump( { type: 'minor' } ) ).pipe( dest( './' ) );
}

function updateThemeVerPrerelease() {
	return src( './package.json' ).pipe( bump( { type: 'prerelease' } ) ).pipe( dest( './' ) );
}

function copyThemeProd() {
	return src( [ './src/theme/**', '!./src/theme/**/node_modules/**' ] )
		.pipe( replace( {
			patterns: [
				{
					match: 'textdomain',
					replacement: textDomain,
				},
				{
					match: /pkg.name/g,
					replacement: project,
				},
				{
					match: /pkg.version/g,
					replacement: pkg.version,
				},
				{
					match: /pkg.author/g,
					replacement: pkg.author,
				},
				{
					match: /pkg.author_shop/g,
					replacement: pkg.author_shop,
				},
				{
					match: /pkg.license/g,
					replacement: pkg.license,
				},
				{
					match: /pkg.license_uri/g,
					replacement: pkg.license_uri,
				},
				{
					match: /pkg.slug/g,
					replacement: pkg.slug,
				},
				{
					match: /pkg.copyright/g,
					replacement: pkg.copyright,
				},
				{
					match: /pkg.theme_uri/g,
					replacement: pkg.theme_uri,
				},
				{
					match: /textdomain/g,
					replacement: pkg.textdomain,
				},
				{
					match: /pkg.downloadid/g,
					replacement: pkg.downloadid,
				},
				{
					match: /pkg.description/g,
					replacement: pkg.description,
				},
				{
					match: 'prefix',
					replacement: prefix,
				},
				{
					match: '__PRE',
					replacement: prefixUppercase,
				},
			],
		} ) )
		.pipe( dest( './dist/themes/' + slug ) );
}

function copyFontsProd() {
	return src( './src/assets/fonts/**' ).pipe( dest( './dist/themes/' + themeName + '/assets/fonts' ) );
}

function StylesProd() {
	return src( './src/assets/styles/style.scss' )
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
		.pipe( replace( {
			patterns: [
				{
					match: 'textdomain',
					replacement: textDomain,
				},
				{
					match: /pkg.name/g,
					replacement: project,
				},
				{
					match: /pkg.version/g,
					replacement: pkg.version,
				},
				{
					match: /pkg.author/g,
					replacement: pkg.author,
				},
				{
					match: /pkg.author_shop/g,
					replacement: pkg.author_shop,
				},
				{
					match: /pkg.license_uri/g,
					replacement: pkg.license_uri,
				},
				{
					match: /pkg.license/g,
					replacement: pkg.license,
				},
				{
					match: /pkg.slug/g,
					replacement: pkg.slug,
				},
				{
					match: /pkg.copyright/g,
					replacement: pkg.copyright,
				},
				{
					match: /pkg.theme_uri/g,
					replacement: pkg.theme_uri,
				},
				{
					match: /textdomain/g,
					replacement: pkg.textdomain,
				},
				{
					match: /pkg.downloadid/g,
					replacement: pkg.downloadid,
				},
				{
					match: /pkg.description/g,
					replacement: pkg.description,
				},
				{
					match: 'prefix',
					replacement: cssPrefix,
				},
			],
		} ) )
		.pipe( autoprefixer( conf.BROWSERS_LIST ) )
		.pipe( gcmq() )
		.pipe( lineec() )
		.pipe( postcss( pluginsListProd ) )
		.pipe( lineec() )
		.pipe( dest( './dist/themes/' + themeName ) );
}

function ClassicStylesProd() {
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
		.pipe( autoprefixer( conf.BROWSERS_LIST ) )
		.pipe( gcmq() )
		.pipe( lineec() )
		.pipe( postcss( pluginsListProd ) )
		.pipe( lineec() )
		.pipe( dest( './dist/themes/' + themeName + '/assets/css' ) );
}

function GutenbergStylesProd() {
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
		.pipe( autoprefixer( conf.BROWSERS_LIST ) )
		.pipe( gcmq() )
		.pipe( lineec() )
		.pipe( postcss( pluginsListProd ) )
		.pipe( lineec() )
		.pipe( dest( './dist/themes/' + themeName + '/assets/css' ) );
}

function headerScriptsProd() {
	return src( headerJS )
		.pipe( plumber( { errorHandler: onError } ) )
		.pipe( concat( 'header-bundle.js' ) )
		.pipe( uglify() )
		.pipe( dest( './dist/themes/' + themeName + '/assets/js' ) );
}

function footerScriptsProd() {
	return src( footerJS )
		.pipe( plumber( { errorHandler: onError } ) )
		.pipe(
			babel( {
				presets: [ '@babel/preset-env' ],
			} ),
		)
		.pipe( concat( 'app.js' ) )
		.pipe( uglify() )
		.pipe( dest( './dist/themes/' + themeName + '/assets/js' ) );
}

function pluginsProd() {
	return src( [ './src/plugins/**', '!./src/plugins/**/*.md' ] ).pipe( dest( './dist/plugins' ) );
}

function processImages() {
	return src( [ './src/assets/img/**', '!./src/assets/img/**/*.ico' ] )
		.pipe( plumber( { errorHandler: onError } ) )
		.pipe(
			imagemin( [ imagemin.svgo( { plugins: [ { removeViewBox: true } ] } ) ], {
				verbose: true,
			} ),
		)
		.pipe( dest( './dist/themes/' + themeName + '/img' ) );
}

function zipProd() {
	return src( './dist/themes/' + slug + '/**/*' )
		.pipe( zip.dest( './dist/' + slug + '_' + themeVersion + '.zip' ) )
		.on( 'end', () => {
			log( pluginsGenerated );
			log( filesGenerated );
		} );
}

async function cleanPalamutProd() {
	await del( [ './dist/plugins/palamut' ] );
}

function copyPalamutProd() {
	return src( [ './src/plugins/palamut/**', '!./src/theme/**/node_modules/**' ] )
		.pipe( dest( './dist/plugins/palamut' ) );
}

function ShortCodestylesProd() {
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
		.pipe( autoprefixer( conf.BROWSERS_LIST ) )
		.pipe( gcmq() )
		.pipe( lineec() )
		.pipe( postcss( pluginsListProd ) )
		.pipe( concat( 'shortcodes.css' ) )
		.pipe( lineec() )
		.pipe( dest( './dist/plugins/palamut/includes/supports/classic-editor/shortcodes/assets/css/' ) )
		.pipe( browserSync.stream( { match: '**/*.css' } ) );
}

function WidgetsstylesProd() {
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
		.pipe( autoprefixer( conf.BROWSERS_LIST ) )
		.pipe( gcmq() )
		.pipe( lineec() )
		.pipe( postcss( pluginsListProd ) )
		.pipe( concat( 'widgets.css' ) )
		.pipe( lineec() )
		.pipe( dest( './dist/plugins/palamut/includes/widgets/assets/css/' ) )
		.pipe( browserSync.stream( { match: '**/*.css' } ) );
}

function zipPalamutProd() {
	return src( './dist/plugins/palamut/**/*' )
		.pipe( zip.dest( './dist/' + pluginSlug + '_' + pluginVersion + '.zip' ) )
		.on( 'end', () => {
			log( pluginsGenerated );
		} );
}

function copyZip() {
	return src( './dist/' + pluginSlug + '_' + pluginVersion + '.zip' )
		.pipe( dest( './dist/themes/' + themeName + '/inc/plugins/trunk' ) );
}

exports.build = series(
	cleanProd,
	updateThemeVerMin,
	cleanPalamutProd,
	copyPalamutProd,
	WidgetsstylesProd,
	ShortCodestylesProd,
	translatePlugin,
	zipPalamutProd,
	copyThemeProd,
	copyZip,
	translateTheme,
	StylesProd,
	GutenbergStylesProd,
	ClassicStylesProd,
	footerScriptsProd,
	zipProd,
);

/* -------------------------------------------------------------------------------------------------
Utils
-------------------------------------------------------------------------------------------------- */

const onError = err => {
	gutil.beep();
	gutil.log( '{{ 😱 Shit Happened }} ' + errorMsg + ' ' + err.toString() );
	this.emit( 'end' );
};

function endOfTheDay() {
	return src( './package.json' )
	// bump package.json and bowser.json version
		.pipe( bump( {
			type: argv.type || 'prerelease',
		} ) )
	// save the bumped files into filesystem
		.pipe( dest( './' ) )
	// commit the changed files
		.pipe( git.commit( '🍔 v' + themeVersion + ' - 🐛 FIX: ' + argv.fix + ' - 🍭 FEATURE: ' + argv.feature + ' ' ) )
	// filter one file
	//	.pipe( filter( 'package.json' ) )
	// create tag based on the filtered file
	//	.pipe( tag() )
	// push changes into repository
		.pipe( push( {
			repository: 'origin',
			refspec: 'HEAD',
		} ) )
		.on( 'end', () => {
			gutil.beep();
			gutil.log( '{{ 🍟 Well Done }} It was really productive day! You are awesome! 🙌🏻' );
		} );
}

exports.zreport = series( endOfTheDay );

async function createFreshTheme() {
	return src( './src/**' )
		.pipe( dest( './tools/fresh-theme' ) )
		.on( 'end', () => {
			gutil.beep();
			gutil.log( '{{ 🍟 Well Done }} A fresh theme created.' );
		} );
}

exports.createfresh = series( createFreshTheme );

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
			} );
	}
}

exports.backup = series( Backup );

/* -------------------------------------------------------------------------------------------------
Messages
-------------------------------------------------------------------------------------------------- */

const errorMsg = '\x1b[41mError\x1b[0m';
const warning = '\x1b[43mWarning\x1b[0m';
const buildNotFound = '{{ ⚠️ Bad Stuff }} - There is no active WordPress installation. Run the command: $ \x1b[1mnpm run install:wordpress\x1b[0m or follow README.md instructions.';
const filesGenerated =
	'{{ 🍩 Good Stuff }} ' + project + ' has been created. Theme zip file in: \x1b[1m' +
	__dirname +
	'/dist/' +
	slug +
	'_' +
	themeVersion +
	'.zip\x1b[0m - 📦';
const pluginsGenerated =
	'{{ 🍩 Good Stuff }} Palamut for ' + project + 'has been created: Plugin zip file in: \x1b[1m' + __dirname + '/dist/plugins/palamut_' + pluginVersion + '\x1b[0m - 📦';
const backupsGenerated =
	'{{ 🍟 Well Done }} A Backup zip has been generated: \x1b[1m' + __dirname + '/backups/' + date + '.zip\x1b[0m - ✅';

/* -------------------------------------------------------------------------------------------------
End of all Tasks
-------------------------------------------------------------------------------------------------- */
