<?php
class Wotd_simplebanner extends WP_Widget {
	// Main constructor
	public function __construct() {
		parent::__construct(
			'wotd_promotion_simplebanenr_widget',
			__( 'Word Of The Day', 'text_domain' ),
			array(
				'customize_selective_refresh' => true,
			)
		);	
	}
	
	// The widget form (for the backend )
	public function form( $instance ) {
		// Set widget defaults
		$defaults = array(
			'title'    => '',
			'text'     => '',
			'word'     => ''
		);

		// Parse current settings with defaults
		extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

		<?php // Widget Title ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title of widget', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

        <?php // Word of the day ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'word' ) ); ?>"><?php _e( 'Enter Word', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'word' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'word' ) ); ?>" type="text" value="<?php echo esc_attr( $word ); ?>" />
		</p>
		

		<?php // Description about word ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Description', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
		</p>
	<?php }
	
	// Update widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['word']    = isset( $new_instance['word'] ) ? wp_strip_all_tags( $new_instance['word'] ) : '';
		$instance['text']     = isset( $new_instance['text'] ) ? wp_strip_all_tags( $new_instance['text'] ) : '';
		return $instance;
	}
	// Display the widget
	public function widget( $args, $instance ) {
		extract( $args );
		// Check the widget options
		$title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$word     = isset( $instance['word'] ) ? $instance['word'] : '';
		$text     = isset( $instance['text'] ) ? $instance['text'] : '';
		echo $before_widget;
		if(empty($word) || empty($text) || empty($title)){
			global $wpdb;
			$result = $wpdb->get_results( "SELECT word,meaning FROM wp_word_collection WHERE entery_date = '".date('Y-m-d 00:00:00')."'");
			$title = "Word of the day"; 
			$word = $result[0]->word; 
			$text = $result[0]->meaning; 	
		}
		// Display the widget
		echo '<div class="widget-text wp_widget_plugin_box wp_otd_custom_widget" style="border: 2px solid #ddd;;border-radius: 2px;background-color:#ffffff">';
		?>
		    <div style="padding:25px;">
		        <h4 style="color: #375c71;text-align: center;font-size: 14px;font-weight: 600;margin-bottom: 5px;font-family: 'Dancing script', sans-serif;"><?php echo $title; ?></h4>
		        <div class="wp_otd_border" style="margin-bottom:10px;border-bottom: 1px solid #97b7c9;display: block;height: 1px;margin-right: auto;margin-left: auto;max-width: 80px;"></div>
		        <h4 class="jc-wgt-title-type3" style="color: #375c71;font-family: 'Lato',Helvetica,Arial,sans-serif;font-size: .813em;font-weight: 700;letter-spacing: .177em;line-height: 1.375em;text-align: center;text-transform: uppercase;margin-bottom:15px"><?php echo date('M d,Y') ?></h4>
		    
		        <div style="display: table;margin: 0 auto;table-layout: fixed;vertical-align: middle;">
		            <h4 class="wh-word" style="font-size: 35px;margin: .67em 0 .67em 0;text-align: center;display: inline-block;color: #3b3e41;font-family: 'Playfair Display',serif;font-size: 2.08313em;font-weight: 400;letter-spacing: .07201em;line-height: 1em;">
                      <a href="/word-of-the-day"><?php echo $word; ?></a>
                    </h4>
		        </div>
		        <p style="color: #3b3e41;font-family: 'Open Sans',Helvetica,Arial,sans-serif;font-size: 1em;letter-spacing: .07em;line-height: 1.4em;margin-bottom: 1.25em;text-align: center;font-weight: 400;"><?php echo $text; ?></p>
		    </div>
		    <div class="word-of-day-subscribe-block" style="background-image: url(https://merriam-webster.com/assets/mw/static/app-css-images/sidebar/word-of-the-day-bottom.png);background-position: left top;background-repeat: repeat-x;height: 90px;padding: 0 .75em;">
		        <p class="wod-lead" style="margin-bottom:10px;font-weight: 600;color: #618396;font-family: 'Open Sans',Helvetica,Arial,sans-serif;font-size: .875em;letter-spacing: .0625em;line-height: 1.75em;">Get Word of the Day daily email!</p>
		        <form class="js-wod-subscribe-frm" action="/word-of-the-day" method="post">
                    <input type="text" class="wod-subscribe" name="wod-subscribe" placeholder="Your email address" style="width: 75%;margin-right: 29px;padding: 0px 5px;">
                    <input type="submit" class="wod-submit" name="wod-submit" value="SUBSCRIBE" style="background-image: url(https://merriam-webster.com/assets/mw/static/app-css-images/home/subscribe-caret.png);background-position: 17px 12px;background-repeat: no-repeat;text-indent: -9999px;width: 38px;margin-right: 00px;vertical-align: top;background-color: #d0c5c1;border: 0;border-radius: 6px;color: #fff;font-family: 'Lato',Helvetica,Arial,sans-serif;font-size: .75em;font-weight: 400;height: 38px;margin-top: 40.787;margin-top: 17.78700;margin-top: -10;margin-top: 33.893;margin-top: 0px;">
                </form>
		    </div>
		<?php
		echo "</div></div>";
	}
}