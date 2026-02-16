<?php
class Widget_Social_Networks extends WP_Widget {
	public function __construct() {
		parent::__construct( 'Widget_Social_Networks', 'Social Networks', array( 'description' => 'manage social networks' ) );
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

// This is where you run the code and display the output
		?>
        <div class="social_networks d-flex  mt-2 mt-md-0">
			<?php
			if ( ! empty( $instance['facebook'] ) ) {
				?><a target="_blank" class="nav-link" href="<?=$instance['facebook']?>" title="facebook"><img class="img-fluid" src="<?= esc_url(get_template_directory_uri()); ?>/assets/img/facebook.svg" alt="facebook" width="25"></a>
            <?php
			}
//			if ( ! empty( $instance['WhatsApp'] ) ) {
//				?><!--<a class="nav-link" href="--><?//=$instance['WhatsApp']?><!--" title="WhatsApp"><img class="img-fluid" src="--><?//= esc_url(get_template_directory_uri()); ?><!--/assets/img/whatsApp.svg" alt="WhatsApp" width="25"></a>-->
<!--            --><?php
//			}
			if ( ! empty( $instance['twitter'] ) ) {
				?><a target="_blank" class="nav-link" href="<?= $instance['twitter'] ?>" title="twitter"><img class="img-fluid" src="<?= esc_url(get_template_directory_uri()); ?>/assets/img/twitter.svg" alt="twitter" width="25"></a>
            <?php
			}
			if ( ! empty( $instance['instagram'] ) ) {
				?>
                <a target="_blank" class="nav-link" href="<?= $instance['instagram'] ?>" title="instagram"><img class="img-fluid" src="<?= esc_url(get_template_directory_uri()); ?>/assets/img/instagram.svg" alt="instagram" width="25"></a>
            <?php
			}
			if ( ! empty( $instance['telegram'] ) ) {
				?><a target="_blank" class="nav-link" href="<?=$instance['telegram']?>" title="telegram"><img class="img-fluid" src="<?= esc_url(get_template_directory_uri()); ?>/assets/img/telegram.svg" alt="telegram" width="25"></a>
            <?php
			}
			if ( ! empty( $instance['youtube'] ) ) {
				?><a target="_blank" class="nav-link" href="<?=$instance['youtube']?>" title="youtube"><img class="img-fluid" src="<?= esc_url(get_template_directory_uri()); ?>/assets/img/youtube.svg" alt="youtube" width="25"></a>
            <?php
			}
			if ( ! empty( $instance['pinterest'] ) ) {
				?><a target="_blank" class="nav-link" href="<?=$instance['pinterest']?>" title="pinterest"><img class="img-fluid" src="<?= esc_url(get_template_directory_uri()); ?>/assets/img/pinterest.svg" alt="pinterest" width="25"></a><?php
			}
            if ( ! empty( $instance['linkedin'] ) ) {
                ?><a target="_blank" class="nav-link" href="<?=$instance['linkedin']?>" title="linkedin"><img class="img-fluid" src="<?= esc_url(get_template_directory_uri()); ?>/assets/img/linkedin-square-icon.svg" alt="linkedin" width="25"></a><?php
            }
			?>


        </div>
		<?php
		echo $args['after_widget'];
	}

	// Widget Backend
	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = 'Widget Title';
		}
		if ( isset( $instance['telegram'] ) ) {
			$telegram = $instance['telegram'];
		} else {
			$telegram = 'https://telegram.org/';
		}
		if ( isset( $instance['youtube'] ) ) {
			$youtube = $instance['youtube'];
		} else {
			$youtube = 'https://www.youtube.com/';
		}

//		if ( isset( $instance['WhatsApp'] ) ) {
//			$WhatsApp = $instance['WhatsApp'];
//		} else {
//			$WhatsApp = 'https://www.whatsapp.com/';
//		}
		if ( isset( $instance['facebook'] ) ) {
			$facebook = $instance['facebook'];
		} else {
			$facebook = 'https://www.facebook.com/';
		}
		if ( isset( $instance['instagram'] ) ) {
			$instagram = $instance['instagram'];
		} else {
			$instagram = 'https://www.instagram.com/';
		}
		if ( isset( $instance['twitter'] ) ) {
			$twitter = $instance['twitter'];
		} else {
			$twitter = 'https://www.twitter.com/';
		}
		if ( isset( $instance['pinterest'] ) ) {
			$pinterest = $instance['pinterest'];
		} else {
			$pinterest = 'https://www.pinterest.com/';
		}
        if ( isset( $instance['linkedin'] ) ) {
            $linkedin = $instance['linkedin'];
        } else {
            $linkedin = 'https://www.linkedin.com/';
        }

// Widget admin form
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>"/>
        </p>
        <br>
        <p>
            <label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'youtube:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>"
                   name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text"
                   value="<?php echo esc_attr( $youtube ); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'telegram' ); ?>"><?php _e( 'telegram :' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'telegram' ); ?>"
                   name="<?php echo $this->get_field_name( 'telegram' ); ?>" type="text"
                   value="<?php echo esc_attr( $telegram ); ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e( 'instagram:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>"
                   name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text"
                   value="<?php echo esc_attr( $instagram ); ?>"/>
        </p>
<!--        <p>-->
<!--            <label for="--><?php //echo $this->get_field_id( 'WhatsApp' ); ?><!--">--><?php //_e( 'WhatsApp:' ); ?><!--</label>-->
<!--            <input class="widefat" id="--><?php //echo $this->get_field_id( 'WhatsApp' ); ?><!--"-->
<!--                   name="--><?php //echo $this->get_field_name( 'WhatsApp' ); ?><!--" type="text"-->
<!--                   value="--><?php //echo esc_attr( $WhatsApp ); ?><!--"/>-->
<!--        </p>-->
        <p>
            <label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'facebook:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>"
                   name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text"
                   value="<?php echo esc_attr( $facebook ); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'twitter:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>"
                   name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text"
                   value="<?php echo esc_attr( $twitter ); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e( 'pinterest:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'pinterest' ); ?>"
                   name="<?php echo $this->get_field_name( 'pinterest' ); ?>" type="text"
                   value="<?php echo esc_attr( $pinterest ); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e( 'linkedin:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>"
                   name="<?php echo $this->get_field_name( 'linkedin' ); ?>" type="text"
                   value="<?php echo esc_attr( $linkedin ); ?>"/>
        </p>

		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance              = array();
		$instance['title']     = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['youtube']   = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';
		$instance['telegram']  = ( ! empty( $new_instance['telegram'] ) ) ? strip_tags( $new_instance['telegram'] ) : '';
		$instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? strip_tags( $new_instance['instagram'] ) : '';
		$instance['twitter']   = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
		$instance['WhatsApp']  = ( ! empty( $new_instance['WhatsApp'] ) ) ? strip_tags( $new_instance['WhatsApp'] ) : '';
		$instance['facebook']  = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
		$instance['pinterest']  = ( ! empty( $new_instance['pinterest'] ) ) ? strip_tags( $new_instance['pinterest'] ) : '';
		$instance['linkedin']  = ( ! empty( $new_instance['linkedin'] ) ) ? strip_tags( $new_instance['linkedin'] ) : '';

		return $instance;
	}
}

add_action( 'widgets_init', function () {
	register_widget( 'Widget_Social_Networks' );
} );