<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*----------------------------------------- Custom body classes ----------------------------------------------------*/
	
	if ( ! function_exists( 'color_magazine_body_classes' ) ) :

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 * @return array
		 */
		function color_magazine_body_classes( $classes ) {
			global $post;

			// Adds a class of hfeed to non-singular pages.
			if ( ! is_singular() ) {
				$classes[] = 'hfeed';
			}

			// Adds a class of no-sidebar when there is no sidebar present.
			if ( ! is_active_sidebar( 'sidebar-1' ) ) {
				$classes[] = 'no-sidebar';
			}

			$color_magazine_site_layout = get_theme_mod( 'color_magazine_site_layout', 'site-layout--wide' );
			$classes[] = esc_attr( $color_magazine_site_layout );

			/**
			 * Add classes about style and sidebar layout for archive, post and page
			 */
			if ( is_archive() || is_home() || is_search()) {
				$archive_sidebar_layout = get_theme_mod( 'color_magazine_archive_sidebar_layout', 'no-sidebar' );
				$archive_style          = get_theme_mod( 'color_magazine_archive_style', 'mt-archive--masonry-style' );
				$classes[] = esc_attr( $archive_sidebar_layout );
				$classes[] = esc_attr( $archive_style );
			} elseif ( is_single() ) {
				$single_post_sidebar_layout = get_post_meta( $post->ID, 'color_magazine_post_sidebar_layout', true );
				if ( 'layout--default-sidebar' !== $single_post_sidebar_layout && !empty( $single_post_sidebar_layout ) ) {
					$classes[] = esc_attr( $single_post_sidebar_layout );
				} else {
					$posts_sidebar_layout = get_theme_mod( 'color_magazine_posts_sidebar_layout', 'right-sidebar' );
					$classes[] = esc_attr( $posts_sidebar_layout );
				}
			} elseif ( is_page() ) {
				$single_page_sidebar_layout = get_post_meta( $post->ID, 'color_magazine_post_sidebar_layout', true );
				if ( 'layout--default-sidebar' !== $single_page_sidebar_layout && !empty( $single_page_sidebar_layout ) ) {
					$classes[] = esc_attr( $single_page_sidebar_layout );
				} else {
					$pages_sidebar_layout = get_theme_mod( 'color_magazine_pages_sidebar_layout', 'right-sidebar' );
					$classes[] = esc_attr( $pages_sidebar_layout );
				}
			}

			/**
			 * site mode toggle
			 */ 
			$color_magazine_enable_dark_mode = get_theme_mod( 'color_magazine_enable_dark_mode', false );
			if ( false !== $color_magazine_enable_dark_mode ) {
				$classes[] = 'mt-site-dark-mode';
			}

			return $classes;
		}

	endif;

	add_filter( 'body_class', 'color_magazine_body_classes' );

/*----------------------------------------- Header ping back -------------------------------------------------------*/
	
	if ( ! function_exists( 'color_magazine_pingback_header' ) ) :

		/**
		 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
		 */
		function color_magazine_pingback_header() {

			if ( is_singular() && pings_open() ) {
				echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
			}

		}

	endif;

	add_action( 'wp_head', 'color_magazine_pingback_header' );

/*----------------------------------------- Theme font -------------------------------------------------------------*/

	if ( ! function_exists( 'color_magazine_fonts_url' ) ) :

		/**
		 * Register Google fonts for Color Magazine.
		 *
		 * @return string Google fonts URL for the theme.
		 * @since 1.0.0
		 */
	    function color_magazine_fonts_url() {
	        $fonts_url = '';
	        $font_families = array();

	        /*
	         * Translators: If there are characters in your language that are not supported
	         * byJosefin Sans  translate this to 'off'. Do not translate into your own language.
	         */
	        if ( 'off' !== _x( 'on', 'Josefin Sans font: on or off', 'color-magazine' ) ) {
	            $font_families[] = 'Josefin Sans:400,700';
	        }

	        /*
	         * Translators: If there are characters in your language that are not supported
	         * by Poppins, translate this to 'off'. Do not translate into your own language.
	         */
	        if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'color-magazine' ) ) {
	            $font_families[] = 'Poppins:300,400,400i,500,700';
	        }   

	        if ( $font_families ) {
	            $query_args = array(
	                'family' => urlencode( implode( '|', $font_families ) ),
	                'subset' => urlencode( 'latin,latin-ext' ),
	            );
	            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	        }
	        return $fonts_url;
	    }

	endif;

/*----------------------------------------- Enqueue scripts --------------------------------------------------------*/
	
	if ( ! function_exists( 'color_magazine_admin_scripts' ) ) :

		/**
		 * Enqueue scripts and styles for only admin
		 *
		 * @since 1.0.0
		 */
		function color_magazine_admin_scripts( $hook ) {
		    global $color_magazine_theme_version;

		    if ( 'widgets.php' != $hook && 'customize.php' != $hook && 'edit.php' != $hook && 'post.php' != $hook && 'post-new.php' != $hook ) {
		        return;
		    }
		    wp_enqueue_script( 'jquery-ui-button' );
		    wp_enqueue_script( 'color-magazine--admin-script', get_template_directory_uri() .'/assets/js/mt-admin-scripts.js', array( 'jquery' ), esc_attr( $color_magazine_theme_version ), true );
		    wp_enqueue_style( 'color-magazine--admin-style', get_template_directory_uri() . '/assets/css/mt-admin-styles.css', array(), esc_attr( $color_magazine_theme_version ) );
		}

	endif;

	add_action( 'admin_enqueue_scripts', 'color_magazine_admin_scripts' );

	if ( ! function_exists( 'color_magazine_scripts' ) ) :

		/**
		 * Enqueue scripts and styles.
		 */
		function color_magazine_scripts() {

			global $color_magazine_theme_version;

			wp_enqueue_style( 'color-magazine-fonts', color_magazine_fonts_url(), array(), null );

			wp_enqueue_style( 'box-icons', get_template_directory_uri() . '/assets/library/box-icons/css/boxicons.min.css', array(), '2.1.4' );

			wp_enqueue_style( 'lightslider-style', get_template_directory_uri() .'/assets/library/lightslider/css/lightslider.min.css', array(), '' );

			wp_enqueue_style( 'preloader', get_template_directory_uri() .'/assets/css/min/mt-preloader.min.css', array(), esc_attr( $color_magazine_theme_version ) );

			wp_enqueue_style( 'color-magazine-style', get_stylesheet_uri(), array(), esc_attr( $color_magazine_theme_version) );

			wp_enqueue_style( 'color-magazine-responsive-style', get_template_directory_uri(). '/assets/css/min/mt-responsive.min.css', array(), esc_attr( $color_magazine_theme_version ) );

			$color_magazine_dark_mod_option = get_theme_mod( 'color_magazine_enable_dark_mode', false );
			if ( true === $color_magazine_dark_mod_option ) {
				wp_enqueue_style( 'color-magazine-dark-mod', get_template_directory_uri() . '/assets/css/min/mt-dark-styles.min.css', array(), esc_attr( $color_magazine_theme_version ) );
			}

			wp_enqueue_script( 'color-magazine-combine-scripts', get_template_directory_uri() .'/assets/js/mt-combine-scripts.js', array('jquery'), esc_attr( $color_magazine_theme_version ), true );

			wp_enqueue_script( 'color-magazine-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), esc_attr( $color_magazine_theme_version ), true );

			wp_enqueue_script( 'color-magazine-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), esc_attr( $color_magazine_theme_version ), true );

			wp_enqueue_script( 'color-magazine-custom-scripts', get_template_directory_uri() .'/assets/js/min/mt-custom-scripts.min.js', array('jquery'), esc_attr( $color_magazine_theme_version ), true );

			$color_magazine_enable_sticky_menu = get_theme_mod( 'color_magazine_enable_sticky_menu', true );
			if ( true === $color_magazine_enable_sticky_menu ) {
				$sticky_value = 'on';
			} else {
				$sticky_value = 'off';
			}

			wp_localize_script( 'color-magazine-custom-scripts', 'color_magazineObject', array(
		        'menu_sticky' => $sticky_value,
		    ) );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

	endif;

	add_action( 'wp_enqueue_scripts', 'color_magazine_scripts' );

/*----------------------------------------- Social icon content ----------------------------------------------------*/

	if ( ! function_exists( 'color_magazine_social_icons_array' ) ) :

	    /**
	     * List of box icons
	     *
	     * @return array();
	     * @since 1.0.0
	     */
	    function color_magazine_social_icons_array() {
	        return array(
	            "bx bxl-facebook", "bx bxl-twitter", "bx bxl-google", "bx bxl-instagram", "bx bxl-skype", "bx bxl-whatsapp", "bx bxl-tiktok", "bx bxl-linkedin", "bx bxl-pinterest", "bx bxl-tumblr", "bx bxl-slack", "bx bxl-reddit", "bx bxl-messenger", "bx bxl-wordpress", "bx bxl-yahoo", "bx bxl-snapchat", "bx bxl-wix", "bx bxl-meta", "bx bxl-vk", "bx bxl-trip-advisor","mt mt-x-twitter","mt mt-square-x-twitter","mt mt-threads","mt mt-square-threads",
	        );
	    }

	endif;

	if ( ! function_exists( 'color_magazine_social_media_content' ) ) :

		/**
		 * function to display the social icons
		 */
		function color_magazine_social_media_content() {
			$defaults_icons = json_encode( array(
					array(
						'social_icon' => 'bx bxl-twitter',
						'social_url'  => '#',
					),
					array(
						'social_icon' => 'bx bxl-pinterest',
						'social_url'  => '#',
					)
				)
			);
			$color_magazine_social_icons = get_theme_mod( 'color_magazine_social_icons', $defaults_icons );
			$social_icons = json_decode( $color_magazine_social_icons );

			if ( ! empty( $social_icons ) ) {
	?>
				<ul class="mt-social-icon-wrap">
					<?php
						foreach ( $social_icons as $social_icon ) {
							if ( ! empty( $social_icon->social_url ) ) {
					?>
								<li class="mt-social-icon">
									<a href="<?php echo esc_url( $social_icon->social_url ); ?>" target="_blank">
										<i class="<?php echo esc_attr( $social_icon->social_icon ); ?>"></i>
									</a>
								</li>
					<?php
							}
						}
					?>
				</ul>
	<?php 
			}
		}

	endif;

/*----------------------------------------- Categories content -----------------------------------------------------*/

	if ( ! function_exists( 'color_magazine_select_categories_list' ) ) :

		/**
		 * function to return category lists
		 *
		 * @return $color_magazine_categories_list in array
		 */
		function color_magazine_select_categories_list() {
			$color_magazine_get_categories = get_categories( array( 'hide_empty' => 0 ) );
			$color_magazine_categories_list[''] = __( 'Select Category', 'color-magazine' );
	        foreach ( $color_magazine_get_categories as $category ) {
	    	    $color_magazine_categories_list[esc_attr( $category->slug )] = esc_html( $category->cat_name );
	        }
	        return $color_magazine_categories_list;
		}

	endif;

/*----------------------------------------- Header content ---------------------------------------------------------*/

	if ( ! function_exists( 'color_magazine_header_bg_image' ) ) :

	    /**
	     * Background image for page header
	     *
	     * @since 1.0.0
	     */
	    function color_magazine_header_bg_image( $input ) {

	        $image_attr = array();

	        if ( empty( $image_attr ) ) {

	            // Fetch from Custom Header Image.
	            $image = get_header_image();
	            if ( ! empty( $image ) ) {
	                $image_attr['url']    = $image;
	                $image_attr['width']  = get_custom_header()->width;
	                $image_attr['height'] = get_custom_header()->height;
	            }
	        }

	        if ( ! empty( $image_attr ) ) {
	            $input .= 'background-image:url(' . esc_url( $image_attr['url'] ) . ');';
	            $input .= 'background-size:cover; background-position:center center;';
	        }

	      return $input;
	    }

	endif;

	add_filter( 'color_blog_header_bg_style_attribute', 'color_magazine_header_bg_image' );

	if ( ! function_exists( 'color_magazine_post_id' ) ) {

		/**
		 * Store current post ID
		 *
		 * @since 1.0.0
		 */
		function color_magazine_post_id() {

			wp_reset_postdata();

			// Default value.
			$id = '';

			if ( is_singular() ) {
				$id = get_the_ID();
			} elseif ( is_home() && $page_for_posts = get_option( 'page_for_posts' ) ) {
				$id = $page_for_posts;
			}

			// Sanitize.
			$id = $id ? $id : '';

			// Return ID.
			return $id;

		}
	}

	if ( ! function_exists( 'color_magazine_get_the_title' ) ) {

	    /**
	     * function to return page title
	     *
	     * @since 1.0.0
	     */
	    function color_magazine_get_the_title() {

	    	// Default title is null
			$title = null;

	        $post_id = color_magazine_post_id();

	        if ( is_front_page() && ! is_singular( 'page' ) ) {
	            $title = get_bloginfo( 'description' );
	        } elseif ( is_home() && ! is_singular( 'page' ) ) {
	            $page_for_posts_id = get_option( 'page_for_posts', true );
	            $title = get_the_title( $page_for_posts_id );
	        } elseif ( is_archive() ) {
	        	$title = get_the_archive_title();
	        } else {
	            $title = get_the_title();
	        }

	        $get_the_title = $title ? $title : get_the_title();

	        return $get_the_title;

	    }

	}

/*----------------------------------------- Custom css content -----------------------------------------------------*/

	if ( ! function_exists( 'color_magazine_css_strip_whitespace' ) ) :

		/**
		 * Get minified css and removed space
		 *
		 * @since 1.0.0
		 */

	    function color_magazine_css_strip_whitespace( $css ) {
	        $replace = array(
	            "#/\*.*?\*/#s" => "",  // Strip C style comments.
	            "#\s\s+#"      => " ", // Strip excess whitespace.
	        );
	        $search = array_keys( $replace );
	        $css = preg_replace( $search, $replace, $css );

	        $replace = array(
	            ": "  => ":",
	            "; "  => ";",
	            " {"  => "{",
	            " }"  => "}",
	            ", "  => ",",
	            "{ "  => "{",
	            ";}"  => "}", // Strip optional semicolons.
	            ",\n" => ",", // Don't wrap multiple selectors.
	            "\n}" => "}", // Don't wrap closing braces.
	            "} "  => "}\n", // Put each rule on it's own line.
	        );
	        $search = array_keys( $replace );
	        $css = str_replace( $search, $replace, $css );

	        return trim( $css );
	    }

	endif;

	if ( ! function_exists( 'color_magazine_hover_color' ) ) :

	    /**
	     * Generate darker color
	     * Source: http://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
	     *
	     * @since 1.0.0
	     */
	    function color_magazine_hover_color( $hex, $steps ) {
	        // Steps should be between -255 and 255. Negative = darker, positive = lighter
	        $steps = max( -255, min( 255, $steps ) );

	        // Normalize into a six character long hex string
	        $hex = str_replace( '#', '', $hex );
	        if ( strlen( $hex ) == 3) {
	            $hex = str_repeat( substr( $hex,0,1 ), 2 ).str_repeat( substr( $hex, 1, 1 ), 2 ).str_repeat( substr( $hex,2,1 ), 2 );
	        }

	        // Split into three parts: R, G and B
	        $color_parts = str_split( $hex, 2 );
	        $return = '#';

	        foreach ( $color_parts as $color ) {
	            $color   = hexdec( $color ); // Convert to decimal
	            $color   = max( 0, min( 255, $color + $steps ) ); // Adjust color
	            $return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code
	        }
	        return $return;
	    }

	endif;