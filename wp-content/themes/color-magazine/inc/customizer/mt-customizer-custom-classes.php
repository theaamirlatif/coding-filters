<?php
/**
 * Color Magazine include the Customizer custom classes of customizer fields.
 *
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'customize_register', 'color_magazine_register_custom_controls' );

if ( ! function_exists( 'color_magazine_register_custom_controls' ) ) :

    /**
     * Register Custom Controls
     * 
     * @since 1.0.0
    */
    function color_magazine_register_custom_controls( $wp_customize ) {

    /*--------------------------------------- Toggle Control ------------------------------------------------- */

        if ( ! class_exists( 'Color_Magazine_Control_Toggle' ) ) {

			/**
			 * Toggle control (modified checkbox)
			 */
			class Color_Magazine_Control_Toggle extends WP_Customize_Control {
				
				/**
				 * The control type.
				 *
				 * @access public
				 * @var string
				 */
				public $type = 'mt-toggle';
				
				public $tooltip = '';
				
				public function to_json() {
					parent::to_json();
					
					if ( isset( $this->default ) ) {
						$this->json['default'] = $this->default;
					} else{
						$this->json['default'] = $this->setting->default;
					}
					
					$this->json['value']   = $this->value();
					$this->json['link']    = $this->get_link();
					$this->json['id']      = $this->id;
					$this->json['tooltip'] = $this->tooltip;
								
					$this->json['inputAttrs'] = '';
					foreach ( $this->input_attrs as $attr => $value ) {
						$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
					}
				}
				
				protected function content_template() {
					?>
					<# if ( data.tooltip ) { #>
						<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
					<# } #>
					<label for="toggle_{{ data.id }}">
						<span class="customize-control-title">
							{{{ data.label }}}
						</span>
						<# if ( data.description ) { #>
							<span class="description customize-control-description">{{{ data.description }}}</span>
						<# } #>
						<input {{{ data.inputAttrs }}} name="toggle_{{ data.id }}" id="toggle_{{ data.id }}" type="checkbox" value="{{ data.value }}" {{{ data.link }}}<# if ( '1' == data.value ) { #> checked<# } #> hidden />
						<span class="switch"></span>
					</label>
					<?php
				}
			}

		} //Ends Color_Magazine_Control_Toggle
		
	/*--------------------------------------- Radio Image Control -------------------------------------------- */

		if ( ! class_exists( 'Color_Magazine_Control_Radio_Image' ) ) {
			
			/**
			 * Radio Image control (modified radio).
			*/
			class Color_Magazine_Control_Radio_Image extends WP_Customize_Control {

				/**
				 * The control type.
				 *
				 * @access public
				 * @var string
				 */
				public $type = 'mt-radio-image';
				
				public $tooltip = '';
				
				/**
				 * Refresh the parameters passed to the JavaScript via JSON.
				 *
				 * @see WP_Customize_Control::to_json()
				 */
				public function to_json() {
					parent::to_json();
					
					if ( isset( $this->default ) ) {
						$this->json['default'] = $this->default;
					} else {
						$this->json['default'] = $this->setting->default;
					}
					
					$this->json['value']   = $this->value();
					$this->json['link']    = $this->get_link();
					$this->json['id']      = $this->id;
					$this->json['tooltip'] = $this->tooltip;
					$this->json['choices'] = $this->choices;
								
					$this->json['inputAttrs'] = '';
					foreach ( $this->input_attrs as $attr => $value ) {
						$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
						if ( $attr == 'column' ) {
		                    $this->json['column'] = $value;
		                } else {
		                	$this->json['column'] = 3;
		                }
					}
				}
	
				protected function content_template() {
					?>

					<# if ( data.tooltip ) { #>
						<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
					<# } #>
					<label class="customizer-text">
						<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
						<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
					</label>
					<div id="input_{{ data.id }}" class="image mt-img-col-{{ data.column }}">
						<# for ( key in data.choices ) { #>
							<# dataAlt = ( _.isObject( data.choices[ key ] ) && ! _.isUndefined( data.choices[ key ].alt ) ) ? data.choices[ key ].alt : '' #>
							<input {{{ data.inputAttrs }}} class="image-select" type="radio" value="{{ key }}" name="_customize-radio-{{ data.id }}" id="{{ data.id }}{{ key }}" {{{ data.link }}}<# if ( data.value === key ) { #> checked="checked"<# } #> data-alt="{{ dataAlt }}">
								<label for="{{ data.id }}{{ key }}" {{{ data.labelStyle }}} class="{{{ data.id + key }}}">
									<# if ( _.isObject( data.choices[ key ] ) ) { #>
										<img src="{{ data.choices[ key ].src }}" alt="{{ data.choices[ key ].alt }}">
										<span class="image-label"><span class="inner">{{ data.choices[ key ].alt }}</span></span>
									<# } else { #>
										<img src="{{ data.choices[ key ] }}">
									<# } #>
									<span class="image-clickable"></span>
								</label>
							</input>
						<# } #>
					</div>
					<?php
				}
			}
		} // end Color_Magazine_Control_Radio_Image

	/*--------------------------------------- Range Control -------------------------------------------------- */
		
		if ( ! class_exists( 'Color_Magazine_Control_Range' ) ) {
			
			/**
			 *  Range Control
			 */ 
			class Color_Magazine_Control_Range extends WP_Customize_Control {

				/**
				 * The control type.
				 *
				 * @access public
				 * @var string
				 */
				public $type = 'mt-range';

				/**
		         * Refresh the parameters passed to the JavaScript via JSON.
		         *
		         * @see WP_Customize_Control::to_json()
		         */
		        public function to_json() {
		            parent::to_json();

		            if ( isset( $this->default ) ) {
		                $this->json['default'] = $this->default;
		            } else {
		                $this->json['default'] = $this->setting->default;
		            }
		            $this->json['value']       = $this->value();
		            $this->json['choices']     = $this->choices;
		            $this->json['link']        = $this->get_link();
		            $this->json['id']          = $this->id;

		            $this->json['inputAttrs'] = '';
		            foreach ( $this->input_attrs as $attr => $value ) {
		                $this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		            }

		        }

		        /**
		         * An Underscore (JS) template for this control's content (but not its container).
		         *
		         * Class variables for this control class are available in the `data` JS object;
		         * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
		         *
		         * @see WP_Customize_Control::print_template()
		         *
		         * @access protected
		         */
		        protected function content_template() {
		            ?>
		            <label>
		                <# if ( data.label ) { #>
		                    <span class="customize-control-title">{{{ data.label }}}</span>
		                <# } #>
		                <# if ( data.description ) { #>
                            <span class="description customize-control-description">{{{ data.description }}}</span>
                        <# } #>
		                <div class="control-wrap">
		                    <input type="range" {{{ data.inputAttrs }}} value="{{ data.value }}" {{{ data.link }}} data-reset_value="{{ data.default }}" />
		                    <input type="number" {{{ data.inputAttrs }}} class="mt-range-input" value="{{ data.value }}" />
		                    <span class="mt-reset-slider"><span class="dashicons dashicons-image-rotate"></span></span>
		                </div>
		            </label>
		            <?php
		        }
		    }
		} // end Color_Magazine_Control_Range

	/*--------------------------------------- Repeater Control ----------------------------------------------- */

		if ( ! class_exists( 'Color_Magazine_Control_Repeater' ) ) {
    
			/**
			 * Repeater control
			*/
			class Color_Magazine_Control_Repeater extends WP_Customize_Control {
		
				/**
				 * The control type.
				 *
				 * @access public
				 * @var string
				 */
				public $type = 'mt-repeater';
		
				public $color_magazine_box_label = '';
		
				public $color_magazine_box_add_control = '';
		
				/**
				 * The fields that each container row will contain.
				 *
				 * @access public
				 * @var array
				 */
				public $fields = array();
		
				/**
				 * Repeater drag and drop controller
				 *
				 * @since  1.0.0
				 */
				public function __construct( $manager, $id, $args = array(), $fields = array() ) {
					
					$this->fields = $fields;
					$this->color_magazine_box_label = $args['color_magazine_box_label_text'] ;
					$this->color_magazine_box_add_control = $args['color_magazine_box_add_control_text'];
					parent::__construct( $manager, $id, $args );
				}
		
				protected function render_content() {
		
					$values = json_decode( $this->value() );
					$repeater_id = $this->id;
					$field_count = count( $values );
				?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		
					<?php if ( $this->description ) { ?>
						<span class="description customize-control-description">
							<?php echo wp_kses_post( $this->description ); ?>
						</span>
					<?php } ?>
		
					<ul class="mt-repeater-field-control-wrap">
						<?php $this->color_magazine_get_fields(); ?>
					</ul>
		
					<input type="hidden" <?php $this->link(); ?> class="mt-repeater-collector" value="<?php echo esc_attr( $this->value() ); ?>" />
					<input type="hidden" name="<?php echo esc_attr( $repeater_id ).'_count'; ?>" class="field-count" value="<?php echo absint( $field_count ); ?>">
					<input type="hidden" name="field_limit" class="field-limit" value="4">
					<button type="button" class="button mt-repeater-add-control-field"><?php echo esc_html( $this->color_magazine_box_add_control ); ?></button>
			<?php
				}

				private function color_magazine_get_fields() {
					$fields = $this->fields;
					$values = json_decode( $this->value() );
		
					if ( is_array( $values ) ) {
						foreach( $values as $value ) {
				?>
						<li class="mt-repeater-field-control">
						<h3 class="mt-repeater-field-title"><?php echo esc_html( $this->color_magazine_box_label ); ?></h3>						
						<div class="mt-repeater-fields">
						<?php
							foreach ( $fields as $key => $field ) {
							$class = isset( $field['class'] ) ? $field['class'] : '';
						?>
							<div class="mt-repeater-field mt-repeater-type-<?php echo esc_attr( $field['type'] ).' '.esc_attr( $class ); ?>">
		
							<?php 
								$label = isset( $field['label'] ) ? $field['label'] : '';
								$description = isset( $field['description'] ) ? $field['description'] : '';
								if ( $field['type'] != 'checkbox' ) { 
							?>
									<span class="customize-control-title"><?php echo esc_html( $label ); ?></span>
									<span class="description customize-control-description"><?php echo esc_html( $description ); ?></span>
							<?php 
								}
		
								$new_value = isset( $value->$key ) ? $value->$key : '';
								$default = isset( $field['default'] ) ? $field['default'] : '';
		
								switch ( $field['type'] ) {
										
									/**
									 * URL field
									 */
									case 'url':
										echo '<input data-default="'.esc_attr( $default ).'" data-name="'.esc_attr( $key ).'" type="text" value="'.esc_url( $new_value ).'"/>';
										break;
		
									/**
									 * Social Icon field
									 */
									case 'social_icon':
										$color_magazine_social_icons_array = color_magazine_social_icons_array();
										echo '<div class="mt-repeater-selected-icon"><i class="'.esc_attr( $new_value ).'"></i><span><i class="bx bx-chevron-down"></i></span></div><ul class="mt-repeater-icon-list mt-clearfix">';
										foreach ( $color_magazine_social_icons_array as $color_magazine_social_icon ) {
											$icon_class = $new_value == $color_magazine_social_icon ? 'icon-active' : '';
											echo '<li class='.esc_attr( $icon_class ).'><i class="'.esc_attr( $color_magazine_social_icon ).'"></i></li>';
										}
										echo '</ul><input data-default="'.esc_attr( $default ).'" type="hidden" value="'.esc_attr( $new_value ).'" data-name="'.esc_attr( $key ).'"/>';
										break;
										
									default:
										break;
								}
							?>
							</div>
					<?php
						}
					?>
							<div class="mt-clearfix mt-repeater-footer">
								<div class="alignright">
								<a class="mt-repeater-field-remove" href="#remove"><?php esc_html_e( 'Delete', 'color-magazine' ) ?></a> |
								<a class="mt-repeater-field-close" href="#close"><?php esc_html_e( 'Close', 'color-magazine' ) ?></a>
								</div>
							</div><!-- .mt-repeater-footer -->
						</div><!-- .mt-repeater-fields-->
						</li>
				<?php   
						}
					}
				}
			}
		}// Ends Color_Magazine_Control_Repeater

	/*--------------------------------------- Upgrade Control ------------------------------------------------ */

		if ( ! class_exists( 'Color_Magazine_Control_Upgrade' ) ) {

			/**
			 * Upgrade control
			 */
			class Color_Magazine_Control_Upgrade extends WP_Customize_Control {
				
				/**
				 * The control type.
				 *
				 * @access public
				 * @var string
				 */
				public $type = 'mt-upgrade';
				
				/**
				 * Custom links for this control.
				 *
				 * @access public
				 * @var array
				 */
				public $url = '';
				
				/**
				 * Refresh the parameters passed to the JavaScript via JSON.
				 *
				 * @see WP_Customize_Control::to_json()
				 */
				public function to_json() {
					parent::to_json();
					
					if ( isset( $this->default ) ) {
						$this->json['default'] = $this->default;
					} else{
						$this->json['default'] = $this->setting->default;
					}
					
					$this->json['url'] = esc_url( $this->url );
				}
				
				protected function content_template() {
					?>
						<# if ( data.label ) { #>
		                    <span class="customize-control-title upgrade-title"><i class="dashicons dashicons-info"></i>{{{ data.label }}}</span>
		                <# } #>
		                <# if ( data.description ) { #>
                            <span class="description customize-control-description upgrade-description">{{{ data.description }}}</span>
                        <# } #>
		                <# if ( data.url ) { #>
		                	<a class="mt-upgrade-btn" href="{{{ data.url }}}" target="_blank"><?php esc_html_e( 'upgrade to pro', 'color-magazine' ); ?></a>
		                <# } #>
					<?php
				}
			}

		} //Ends Color_Magazine_Control_Upgrade
    
    }

endif;

/*------------------------------------------- Upsell section ---------------------------------------------------*/	

	if ( class_exists( 'WP_Customize_Section' ) ) {

		/**
	     * Upsell customizer section.
	     *
	     * @since  1.0.6
	     * @access public
	     */
	    class Color_Magazine_Section_Upsell extends WP_Customize_Section {

	        /**
	         * The type of customize section being rendered.
	         *
	         * @since  1.0.0
	         * @access public
	         * @var    string
	         */
	        public $type = 'mt-upsell';

	        /**
	         * Custom button text to output.
	         *
	         * @since  1.0.0
	         * @access public
	         * @var    string
	         */
	        public $pro_text = '';

	        /**
	         * Custom pro button URL.
	         *
	         * @since  1.0.0
	         * @access public
	         * @var    string
	         */
	        public $pro_url = '';

	        

	        /**
	         * Add custom parameters to pass to the JS via JSON.
	         *
	         * @since  1.0.0
	         * @access public
	         * @return void
	         */
	        public function json() {
	            $json = parent::json();
	            
	            $json['pro_text'] = $this->pro_text;
	            $json['pro_url']  = esc_url( $this->pro_url );
	            

	            return $json;
	        }

	        /**
	         * Outputs the Underscore.js template.
	         *
	         * @since  1.0.0
	         * @access public
	         * @return void
	         */
	        protected function render_template() { ?>

	            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
	                <h3 class="accordion-section-title">
	                    {{ data.title }}

	                    <# if ( data.pro_text && data.pro_url ) { #>
	                        <a href="{{ data.pro_url }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text }}</a>
	                    <# } #>
	                </h3>
	            </li>
	        <?php }

	    }// end Color_Magazine_Section_Upsell

	}