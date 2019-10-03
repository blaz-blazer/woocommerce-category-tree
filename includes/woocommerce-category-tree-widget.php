<?php

/**
 * WooCommerce Category Tree Widget
 * @since      1.0.0
 * @package    WooCommerce Category Tree
 */

 class Woocommerce_Category_Tree_Widget extends WP_Widget {
   public function __construct() {
     parent::__construct(
       'wct-widget',
       'WooCommerce Category Tree',
       array(
         'description' => esc_html__( 'Displays a category tree for WooCommerce', 'wct' ),
       )
     );
   }

   // OUTPUT CONTENT
   public function widget( $args, $instance ) {
      extract( $args );

      $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

      echo $before_widget;

      if ( ! empty( $title ) ) {
        echo $before_title . $title . $after_title;
      }

      echo wct_display_category_tree();

      echo $after_widget;
    }

    // FORM - OPTIONS
    public function form( $instance ) {
      $title = ( isset( $instance['title'] ) ) ? strip_tags( $instance['title'] ) : '';
  		?>
  		<p>
  			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
          <?php echo esc_html__( 'Title:', 'wct' ); ?>
        </label>
  			<input
          class="wct-widget-input"
          id="<?php echo $this->get_field_id( 'title' ); ?>"
          name="<?php echo $this->get_field_name( 'title' ); ?>"
          type="text"
          value="<?php echo esc_attr( $title ); ?>"
        />
  		</p>
  		<?php
  	 }

     // UPDATE
     public function update( $new_instance, $old_instance ) {

  		$instance['title'] = sanitize_text_field( $new_instance['title'] );
  		return $instance;
  	}

 }
