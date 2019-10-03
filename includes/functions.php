<?php
/**
 * WooCommerce Category Tree Functions
 * @since      1.0.0
 * @package    WooCommerce Category Tree
 */

// SCRIPTS AND STYLES
function wct_assets() {
	wp_register_script('wct-js', WCT_DIR_URL . 'js/woocommerce-category-tree.js', array('jquery'), WCT_VERSION, true);
	wp_enqueue_script('wct-js');

	wp_register_style('wct-css', WCT_DIR_URL . 'css/woocommerce-category-tree.css');
	wp_enqueue_style('wct-css');
}

// REGISTER WIDGET
function wct_register_widget() {
	register_widget( 'Woocommerce_Category_Tree_Widget' );
}

// DISPLAY CATEGORY TREE
function wct_display_category_tree(){
	$categoriesContent = '';
	$allCategories = wct_get_all_categories();

	//loop through main cateogires - array of objects
	foreach ( $allCategories as $category ) {
	  if( $category->category_parent == 0 ) { //only main categories
			//get main category id
	    $categoryID = $category->term_id;
			//get subcategories of this category
			$subCategories = wct_get_subcategories( $categoryID );

			if ( !$subCategories ) { //this category does not have any sub categories
				$categoriesContent .= '<div class="wct-category ' . wct_is_active_category( $categoryID ) . '"><a href="'. get_term_link( $category->slug, 'product_cat' ) .'">'. $category->name .'</a></div>';
			} else { //subcategories are present
				$categoriesContent .= '<div class="wct-category ' . wct_is_active_category( $categoryID ) . '"><a href="'. get_term_link( $category->slug, 'product_cat' ) .'">'. $category->name .'</a>';
				$categoriesContent .= '<span class="main-category-expand"></span>';
				//generate subcategories html
				$categoriesContent .= wct_generate_subcategories_html( $subCategories );
				//subcategories are nested within the main category
				$categoriesContent .= '</div>';
			}
	  } //end of is main category
	} //end of foreach
	//final output
	$html = '<div class="wct-categories">' . $categoriesContent . '</div>';
	return $html;
}

// RETURNS CURRENT CATEGORY ID OR FALSE
function wct_current_category() {
	//currently queried object
	$queriedObject = get_queried_object();
	//check if it has term id
	if ( property_exists( $queriedObject, 'term_id' ) ) {
		return $queriedObject->term_id;
	} else {
		return false; //we must be on the shop page
	}
}


// RETURNS AN ARRAY OF ALL CATEGORIES
function wct_get_all_categories() {

	$args = array(
	 'taxonomy'     => 'product_cat',
	 'orderby'      => 'name',
	 'show_count'   => false,
	 'pad_counts'   => false,
	 'hierarchical' => true,
	 'title_li'     => '',
	 'hide_empty'   => true,
	 'menu_order'   => false
  );

	return get_categories( $args );
}

// RETURNS AN ARRAY OF ALL SUBCATEGORIES
function wct_get_subcategories( $categoryID ) {
	$args = array(
		'taxonomy'     => 'product_cat',
		'child_of'     => false,
		'parent'       => $categoryID,
		'orderby'      => 'name',
		'show_count'   => false,
		'pad_counts'   => false,
		'hierarchical' => true,
		'title_li'     => '',
		'hide_empty'   => true,
		'menu_order'   => false
	);
	return get_categories( $args );
}

// GENERATE HTML FOR SUBCATEGORIES AND THEIR CHILDREN
function wct_generate_subcategories_html( $subCategories ) { //should be passed an array of objects
	$html = '';
	//loop through subcategories
	foreach( $subCategories as $subCategory ) {
		//check if subcategory has subcategories
		$subSubCategories = wct_get_subcategories( $subCategory->term_id );

		if( !$subSubCategories ) { //no sub categories present
			$html .= '<div class="wct-sub-category ' . wct_is_active_category( $subCategory->term_id ) . '"><a href="'. get_term_link( $subCategory->slug, 'product_cat' ) .'">'. $subCategory->name .'</a></div>';
		} else { //sub category has sub categories
			$html .= '<div class="wct-sub-category ' . wct_is_active_category( $subCategory->term_id ) . '"><a href="'. get_term_link( $subCategory->slug, 'product_cat' ) .'">'. $subCategory->name .'</a>';
			//it needs an expand feature
			$html .= '<span class="sub-category-expand"></span>';
			//generate sub sub categories html
			$html .= wct_generate_sub_sub_categories_html( $subSubCategories );
			//close the div as we are nesting
			$html .= '</div>';
		}
	}
	return '<div class="wct-sub-categories">' . $html . '</div>';
}

// GENERATE HTML FOR SUB-SUB CATEGORIES
function wct_generate_sub_sub_categories_html( $subSubCategories ) { //should be passed an array of objects
	$html = '';
	//loop through subcategories
	foreach( $subSubCategories as $subSubCategory ) {
		$html .= '<div class="wct-sub-sub-category ' . wct_is_active_category( $subSubCategory->term_id ) . '"><a href="'. get_term_link( $subSubCategory->slug, 'product_cat' ) .'">'. $subSubCategory->name .'</a></div>';
	}
	return '<div class="wct-sub-sub-categories">' . $html . '</div>';
}

//R ETURNS wct--active IF CURRENT CATEGORIY IS ACTIVE
function wct_is_active_category( $categoryID ) {
	if ( wct_current_category() == $categoryID) {//active category
		return 'wct--active';
	} else { //not active category
		return '';
	}
}
