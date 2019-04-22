<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $apress_data;

$woocommerce_product_style = isset($apress_data["woocommerce_product_style"]) ? $apress_data["woocommerce_product_style"] : 'woocommerce_product_style1';
$woocommerce_shop_page_columns = isset($apress_data["woocommerce_shop_page_columns"]) ? $apress_data["woocommerce_shop_page_columns"] : '4';
$product_hover_image = isset($apress_data["product_hover_image"]) ? $apress_data["product_hover_image"] : 'off';


// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
// Modification by apress
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', $woocommerce_shop_page_columns );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Extra post classes
$classes = array();

$attachment_ids = $product->get_gallery_image_ids();
if( count($attachment_ids) > 0 ) {	
	$classes[] = 'has-gallery';
}

// Increase loop count
$woocommerce_loop['loop']++;


if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
	
$woo_layout = isset($apress_data["woo_layout"]) ? $apress_data["woo_layout"] : 'woo_fitrows';
	if($woo_layout == 'woo_fitrows'){
		$classes[] = 'fitrow_columns';
	}else{
		$classes[] = 'masonry-item';
		}

	
?>
<?php
if($woocommerce_product_style == 'woocommerce_product_style2'){ ?>

<li <?php post_class( $classes );?>>
	<?php	
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
	?>
    <div class="product_list_item">
    
    <div class="zolo_product_thumbnail_wrapper">
    <div class="zolo_product_thumbnail alternate_image_on_hover">
    <?php
	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );
	
	//Apress codes
	/*if( $product_hover_image == 'on' ) {	
		$first_gallery_img = reset($attachment_ids); //get the first image of gallery
		$image_link = wp_get_attachment_url( $first_gallery_img );	
		if (isset($image_link)){
			echo '<div class="zolo_product_hover_thumbnail" style="background:url('.$image_link.');"></div>';
		}
	}*/	
	?>
    </div>
    <div class="woo_product_button_group">
        <?php do_action( 'apcore_woocommerce_shop_loop_buttons' );
		//apcore_quick_view();
		 ?>
    </div>
    </div>
    
    <div class="zolo_product_details">
    <?php
	/**
	 * woocommerce_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );
	
	/**
	 * woocommerce_after_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );
	?>
    </div>
    
    </div>
    <?php
	/**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>

<?php
}else if($woocommerce_product_style == 'woocommerce_product_style3' || $woocommerce_product_style == 'woocommerce_product_style4'){ ?>

<li <?php post_class( $classes );?>>
	<?php	
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
	?>
    <div class="product_list_item">
    
    <div class="zolo_product_thumbnail_wrapper">
    <div class="zolo_product_thumbnail alternate_image_on_hover">
    <?php
	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );
	
	//Apress codes
	/*if( $product_hover_image == 'on' ) {	
		$first_gallery_img = reset($attachment_ids); //get the first image of gallery
		$image_link = wp_get_attachment_url( $first_gallery_img );	
		if (isset($image_link)){
			echo '<div class="zolo_product_hover_thumbnail" style="background:url('.$image_link.');"></div>';
		}
	}*/	
	?>
    </div>
    <div class="woo_product_button_group">
        <?php do_action( 'apcore_woocommerce_shop_loop_buttons' );
		//apcore_quick_view();
		 ?>
    </div>
    </div>
    
    <div class="zolo_product_details">
    <?php
	/**
	 * woocommerce_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );
	
	/**
	 * woocommerce_after_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );
	?>
    </div>
    
    </div>
    <?php
	/**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>

<?php
}else if($woocommerce_product_style == 'woocommerce_product_style5'){ ?>

<li <?php post_class( $classes );?>>
	<?php	
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
	?>
    <div class="product_list_item">
    
    <div class="zolo_product_thumbnail_wrapper">
    <div class="zolo_product_thumbnail alternate_image_on_hover">
    <?php
	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );
	
	//Apress codes
	/*if( $product_hover_image == 'on' ) {	
		$first_gallery_img = reset($attachment_ids); //get the first image of gallery
		$image_link = wp_get_attachment_url( $first_gallery_img );	
		if (isset($image_link)){
			echo '<div class="zolo_product_hover_thumbnail" style="background:url('.$image_link.');"></div>';
		}
	}*/	
	?>
    </div>
    
    <div class="woo_product_caption">
    <?php
	/**
	 * woocommerce_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	echo '<span class="zolo_woo_title">';
	do_action( 'woocommerce_shop_loop_item_title' );
	echo '</span>';
	/**
	 * woocommerce_after_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	//do_action( 'woocommerce_after_shop_loop_item_title' );
	echo '<span class="zolo_woo_rating">'.wc_get_rating_html( $product->get_average_rating()).'</span>';
	/*if($product->get_price_html()){
		echo '<span class="zolo_woo_price">'.$product->get_price_html().'</span>';
		echo '<span class="zolo_woo_hover_price">'.$product->get_price_html().'</span>';
		}*/
		if ( $price_html = $product->get_price_html() ) { 
		   echo '<span class="zolo_woo_price">'.$price_html.'</span>';
		  }
		  if ( $price_html) {
		   if(strpos($price_html,"amount") > 0){
			$price_html = str_replace("&ndash;","",$price_html); // remove dash "-" used in variable products
		   }
		   echo '<span class="zolo_woo_hover_price">'.$price_html.'</span>';
		  }
	?>
    </div>
    
    <div class="woo_product_button_group">
        <?php do_action( 'apcore_woocommerce_shop_loop_buttons' );
		//apcore_quick_view();
		 ?>
    </div>
    
    </div>
    
    </div>
    <?php
	/**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>

<?php }else if($woocommerce_product_style == 'woocommerce_product_style6' || $woocommerce_product_style == 'woocommerce_product_style7'){ ?>

<li <?php post_class( $classes );?>>
  <div class="product_list_item">
    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
    <div class="zolo_product_thumbnail alternate_image_on_hover">
      <?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
			
		?>
      <?php
		//Apress codes
		if( $product_hover_image == 'on' ) {	
			$first_gallery_img = reset($attachment_ids); //get the first image of gallery
			$image_link = wp_get_attachment_url( $first_gallery_img );	
			if (isset($image_link)){
				echo '<div class="zolo_product_hover_thumbnail" style="background:url('.$image_link.');"></div>';
			}
		}	
		?>
        <div class="woo_product_button_group">
        	<?php do_action( 'apcore_woocommerce_shop_loop_buttons' );?>
        </div>
        <div class="zolo_cart_but">
        	<?php do_action( 'apcore_woocommerce_shop_addtocart' ); ?>
        </div>
      
    </div>
    
    <div class="zolo_product_details">
      <a href="<?php the_permalink(); ?>"><h3 class="entry-title">
        <?php the_title(); ?>
      </h3></a>
      <?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
    </div>
     </div>
</li>

<?php }else{ ?>

<li <?php post_class( $classes );?>>
  <div class="product_list_item">
    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
    <div class="zolo_product_thumbnail alternate_image_on_hover">
      <?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
			
		?>
      <?php
		//Apress codes
		if( $product_hover_image == 'on' ) {	
			$first_gallery_img = reset($attachment_ids); //get the first image of gallery
			$image_link = wp_get_attachment_url( $first_gallery_img );	
			if (isset($image_link)){
				echo '<div class="zolo_product_hover_thumbnail" style="background:url('.$image_link.');"></div>';
			}
		}	
		?>
      <div class="zolo_cart_but">
      <div class="woo_product_button_group">
        <?php do_action( 'apcore_woocommerce_shop_loop_buttons' );
		//apcore_quick_view();
		 ?>
    </div>
        <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
		<?php do_action( 'apcore_woocommerce_shop_addtocart' ); ?>
      </div>
    </div>
    
    <div class="zolo_product_details">
      <a href="<?php the_permalink(); ?>"><h3 class="entry-title">
        <?php the_title(); ?>
      </h3></a>
      <?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
    </div>
     </div>
</li>
<?php } ?>