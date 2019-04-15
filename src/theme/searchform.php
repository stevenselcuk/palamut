<?php
/**
 * { Document title }
 *
 * { Document descriptions will be add. }
 *
 * @link to be defined
 *
 * @package pdwname
 *
 * @subpackage Template Functions
 * @category Theme Framework
 *
 * @version pdwversion
 * @since 1.0.1
 *
 * @author pdwauthor
 * @copyright pdwcopyright
 * @license pdwlicense
 */

?>

<form role="search" class="search search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="GET">
	<label>
		<span class="screen-reader-text"><?php echo esc_html__( 'Search for', 'palamut' ) . ':'; ?></span>
		<input type="text" class="search-field" name="s" placeholder="<?php esc_html_e( 'Search...', 'palamut' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
	</label>
	<button type="submit" class="search search-submit">
		<span class="fas fa-search"></span>
	</button>
</form>
