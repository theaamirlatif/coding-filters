<?php
/**
 * Color Magazine main admin class
 *
 * @package Color Magazine
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Color_Magazine_Admin_Dashboard' ) ) :
    
    /**
     * Class Color_Magazine_Admin_Main
     */
    class Color_Magazine_Admin_Main {

        function color_magazine_install_demo_importer_plugin() {

            if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'color_magazine_plugin_install_nonce' ) ) {
                die( 'This action was stopped for security purposes.' );
            }

            if ( ! current_user_can( 'install_plugins' ) ) {
                $status['message'] = __( 'Sorry, you are not allowed to install plugins on this site.', 'color-magazine' );
                wp_send_json_error( $status );
            }

            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            

            $api = $this->color_magazine_plugin_api_status( 'mysterythemes-demo-importer' );

            if ( is_wp_error( $api ) ) {
                $status['message'] = $api->get_error_message();
                wp_send_json_error( $status );
            }

            $status['pluginName']   = $api->name;
            $skin                   = new WP_Ajax_Upgrader_Skin();
            $upgrader               = new Plugin_Upgrader( $skin );
            $result                 = $upgrader->install( $api->download_link );

            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                $status['debug'] = $skin->get_upgrade_messages();
            }

            if ( is_wp_error( $result ) ) {
                $status['errorCode']    = $result->get_error_code();
                $status['message']      = $result->get_error_message();
                wp_send_json_error( $status );
            } elseif ( is_wp_error( $skin->result ) ) {
                $status['errorCode']    = $skin->result->get_error_code();
                $status['message']      = $skin->result->get_error_message();
                wp_send_json_error( $status );
            } elseif ( $skin->get_errors()->get_error_code() ) {
                $status['message']      = $skin->get_error_messages();
                wp_send_json_error( $status );
            } elseif ( is_null( $result ) ) {
                global $wp_filesystem;

                $status['errorCode']    = 'unable_to_connect_to_filesystem';
                $status['message']      = __( 'Unable to connect to the filesystem. Please confirm your credentials.', 'color-magazine' );

                // Pass through the error from WP_Filesystem if one was raised.
                if ( $wp_filesystem instanceof WP_Filesystem_Base && is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->get_error_code() ) {
                    $status['message'] = esc_html( $wp_filesystem->errors->get_error_message() );
                }

                wp_send_json_error( $status );
            }

            if ( current_user_can( 'activate_plugin' ) ) {
                $result = activate_plugin( '/mysterythemes-demo-importer/mysterythemes-demo-importer.php' );
                if ( is_wp_error( $result ) ) {
                    $status['errorCode']    = $result->get_error_code();
                    $status['message']      = $result->get_error_message();
                    wp_send_json_error( $status );
                }
            }
            $status['message'] = esc_html__( 'Plugin installed successfully', 'color-magazine' );
            wp_send_json_success( $status );
        }

        /**
         * Activate Demo Importer Plugins Ajax Method
         */

        public function color_magazine_activate_demo_importer_plugin() {
            if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'color_magazine_plugin_install_nonce' ) ) {
                die( 'This action was stopped for security purposes.' );
            }

            $result = activate_plugin( '/mysterythemes-demo-importer/mysterythemes-demo-importer.php' );
            if ( is_wp_error( $result ) ) {
                // Process Error
                wp_send_json_error(
                    array(
                        'success' => false,
                        'message' => $result->get_error_message(),
                    )
                );
            } else {
                wp_send_json_success(
                    array(
                        'success' => true,
                        'message' => __( 'Plugin Successfully Activated.', 'color-magazine' ),
                    )
                );
            }
        }

        function color_magazine_install_free_plugin() {

            $plugin_slug = $_POST['plugin_slug'];

            if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'color_magazine_plugin_install_nonce' ) ) {
                die( 'This action was stopped for security purposes.' );
            }

            if ( ! current_user_can( 'install_plugins' ) ) {
                $status['message'] = __( 'Sorry, you are not allowed to install plugins on this site.', 'color-magazine' );
                wp_send_json_error( $status );
            }

            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

            $api = $this->color_magazine_plugin_api_status( $plugin_slug );

            if ( is_wp_error( $api ) ) {
                $status['message'] = $api->get_error_message();
                wp_send_json_error( $status );
            }

            $status['pluginName']   = $api->name;
            $skin                   = new WP_Ajax_Upgrader_Skin();
            $upgrader               = new Plugin_Upgrader( $skin );
            $result                 = $upgrader->install( $api->download_link );

            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                $status['debug'] = $skin->get_upgrade_messages();
            }

            if ( is_wp_error( $result ) ) {
                $status['errorCode']    = $result->get_error_code();
                $status['message']      = $result->get_error_message();
                wp_send_json_error( $status );
            } elseif ( is_wp_error( $skin->result ) ) {
                $status['errorCode']    = $skin->result->get_error_code();
                $status['message']      = $skin->result->get_error_message();
                wp_send_json_error( $status );
            } elseif ( $skin->get_errors()->get_error_code() ) {
                $status['message']      = $skin->get_error_messages();
                wp_send_json_error( $status );
            } elseif ( is_null( $result ) ) {
                global $wp_filesystem;

                $status['errorCode']    = 'unable_to_connect_to_filesystem';
                $status['message']      = __( 'Unable to connect to the filesystem. Please confirm your credentials.', 'color-magazine' );

                // Pass through the error from WP_Filesystem if one was raised.
                if ( $wp_filesystem instanceof WP_Filesystem_Base && is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->get_error_code() ) {
                    $status['message'] = esc_html( $wp_filesystem->errors->get_error_message() );
                }

                wp_send_json_error( $status );
            }

            if ( current_user_can( 'activate_plugin' ) ) {
                $plugin_path = '/'.esc_attr( $plugin_slug ).'/'.esc_attr( $plugin_slug ).'.php';
                $result = activate_plugin( $plugin_path );
                if ( is_wp_error( $result ) ) {
                    $status['errorCode']    = $result->get_error_code();
                    $status['message']      = $result->get_error_message();
                    wp_send_json_error( $status );
                }
            }
            $status['message'] = esc_html__( 'Plugin installed successfully', 'color-magazine' );
            wp_send_json_success( $status );
        }

       function color_magazine_activate_free_plugin() {

            $plugin_slug = $_POST['plugin_slug'];

            if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'color_magazine_plugin_install_nonce' ) ) {
                die( 'This action was stopped for security purposes.' );
            }

            if ( ! current_user_can( 'activate_plugin' ) ) {
                $status['message'] = __( 'Sorry, you are not allowed to activate plugins on this site.', 'color-magazine' );
                wp_send_json_error( $status );
            }

            $plugin_path = '/'.esc_attr( $plugin_slug ).'/'.esc_attr( $plugin_slug ).'.php';

            $result = activate_plugin( $plugin_path );

            if ( is_wp_error( $result ) ) {
                $status['errorCode'] = $result->get_error_code();
                $status['message'] = $result->get_error_message();
                wp_send_json_error( $status );
            }

            $status['message'] = esc_html__( 'Plugin activated successfully', 'color-magazine' );
            wp_send_json_success( $status );
        }

        /**
         * Complete info about lists of free plugins
         */
        public function color_magazine_free_plugins_lists() {
            $free_plugins = array(
                'wp-blog-post-layouts' => array(
                    'slug'      => 'wp-blog-post-layouts',
                    'filename'  => 'wp-blog-post-layouts.php'
                ),
                'wp-magazine-modules-lite' => array(
                    'slug'      => 'wp-magazine-modules-lite',
                    'filename'  => 'wp-magazine-modules-lite.php'
                ),
                'maintenance-notice' => array(
                    'slug'      => 'maintenance-notice',
                    'filename'  => 'maintenance-notice.php'
                )

            );

            $plugin_info = array();

            foreach( $free_plugins as $plugin ) {

                $api_status     = $this->color_magazine_plugin_api_status( $plugin['slug'] );
                if ( ! is_wp_error( $api_status ) ) {
                $action_status  = $this->color_magazine_check_plugin_status( $plugin );
                $icon_url       = $this->color_magazine_get_plugin_icon_url( $api_status->icons );
                $button_url     = $this->color_magazine_generate_plugin_action_url( $action_status, $plugin );

                $plugins_info[] = array(
                    'name'          => $api_status->name,
                    'slug'          => $plugin['slug'],
                    'version'       => $api_status->version,
                    'author'        => $api_status->author,
                    'action'        => $action_status,
                    'icon_url'      => $icon_url,
                    'button_url'    => $button_url,
                    'description'   => $api_status->short_description
                );
                }
            }
            
            return $plugins_info;
        }

        /**
         * get icon for requested plugin
         */
        public function color_magazine_get_plugin_icon_url( $arr ) {

            $plugin_icon_url = '';
            if ( ! empty( $arr['svg'] ) ) {
                $plugin_icon_url = $arr['svg'];
            } elseif ( ! empty( $arr['2x'] ) ) {
                $plugin_icon_url = $arr['2x'];
            } elseif ( ! empty( $arr['1x'] ) ) {
                $plugin_icon_url = $arr['1x'];
            } else {
                $plugin_icon_url = $arr['default'];
            }

            return $plugin_icon_url;
        }

        /**
         * Get requested plugin API
         */
        public function color_magazine_plugin_api_status( $plugin ) {
            include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

            $plugin_info_api = plugins_api( 'plugin_information', array(
                'slug'   => $plugin,
                'fields' => array(
                    'sections'          => false,
                    'icons'             => true,
                    'short_description' => true,
                    'banners'           => true,
                )
            ) );

            return $plugin_info_api;
        }

        /**
         * Check if Plugin is active or not
         */
        public function color_magazine_check_plugin_status( $plugin ) {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
            $folder_name    = $plugin['slug'];
            $file_name      = $plugin['filename'];
            $status         = 'install';
            $path           = WP_PLUGIN_DIR.'/'.esc_attr( $folder_name ).'/'.esc_attr( $file_name );

            if ( file_exists( $path ) ) {
                $status = is_plugin_active( esc_attr( $folder_name ).'/'.esc_attr( $file_name ) ) ? 'inactive' : 'active';
            }

            return $status;
        }

        /**
         * Get plugin path based on plugin slug.
         *
         * @param string $slug - plugin slug.
         *
         * @return string
         */
        public function color_magazine_get_plugin_path( $slug ) {
            switch ( $slug ) {
                case 'wp-blog-post-layouts':
                    return $slug . '/wp-blog-post-layouts.php';
                case 'wp-magazine-modules-lite':
                    return $slug . '/wp-magazine-modules-lite.php';
                default:
                    return $slug . '/' . $slug . '.php';
            }
        }

        /**
         * Generate Url for the Plugin Button
         */
        public function color_magazine_generate_plugin_action_url( $status, $plugin ) {

            $plugin_slug    = $plugin['slug'];

            switch ( $status ) {
                case 'install':
                    return wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'install-plugin',
                                'plugin' => $plugin_slug,
                            ),
                            esc_url( network_admin_url( 'update.php' ) )
                        ),
                        'install-plugin_' . $plugin_slug
                    );
                    break;

                case 'inactive':
                    return add_query_arg(
                        array(
                            'action'        => 'deactivate',
                            'plugin'        => rawurlencode( $this->color_magazine_get_plugin_path( $plugin_slug ) ),
                            'plugin_status' => 'all',
                            'paged'         => '1',
                            '_wpnonce'      => wp_create_nonce( 'deactivate-plugin_' . $this->color_magazine_get_plugin_path( $plugin_slug ) ),
                        ),
                        esc_url( network_admin_url( 'plugins.php' ) )
                    );
                    break;

                case 'active':
                    return add_query_arg(
                        array(
                            'action'        => 'activate',
                            'plugin'        => rawurlencode( $this->color_magazine_get_plugin_path( $plugin_slug ) ),
                            'plugin_status' => 'all',
                            'paged'         => '1',
                            '_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $this->color_magazine_get_plugin_path( $plugin_slug ) ),
                        ),
                        esc_url( network_admin_url( 'plugins.php' ) )
                    );
                    break;
            }
        }

     /**
         * Get the parsed changelog.
         *
         * @param string $changelog_path the changelog path.
         *
         * @return array
         */
        public function get_changelog( $changelog_path ) {

            if ( ! is_file( $changelog_path ) ) {
                return [];
            }

            if ( ! WP_Filesystem() ) {
                return [];
            }

            return $this->parse_changelog( $changelog_path );
        }

        /**
         * Return the releases changes array.
         *
         * @param string $changelog_path the changelog path.
         *
         * @return array $releases - changelog.
         */
        private function parse_changelog( $changelog_path ) {
            WP_Filesystem();
            global $wp_filesystem;
            $changelog = $wp_filesystem->get_contents( $changelog_path );
            if ( is_wp_error( $changelog ) ) {
                $changelog = '';
            }
            $changelog     = explode( PHP_EOL, $changelog );
            $releases      = [];
            $release_count = 0;   

            foreach ( $changelog as $changelog_line ) {
                
                if ( empty( $changelog_line ) ) {
                    continue;
                }

                if ( substr( ltrim( $changelog_line ), 0, 2 ) === '==' ) {
                    $release_count ++;
                    preg_match( '/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/', $changelog_line, $found_v );
                    preg_match( '/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}/', $changelog_line, $found_d );
                    $releases[ $release_count ] = array(
                        'version' => $found_v[0],
                        'date'    => $found_d[0],
                    );

                    continue;
                }

                if ( preg_match( '/[*|-]?\s?(\NEW|\New|new)[:]?\s?(\b|(?=\[))/', $changelog_line ) ) {
                    $changelog_line = preg_replace( '/[*|-]?\s?(\NEW|\New|new)[:]?\s?(\b|(?=\[))/', '', $changelog_line );
                    $releases[ $release_count ]['new'][] = $this->color_magazine_parse_md_and_clean( $changelog_line );
                    continue;
                }

                if ( preg_match( '/[*|-]?\s?(IMP|Imp|imp)[:]?\s?(\b|(?=\[))/', $changelog_line ) ) {
                    $changelog_line = preg_replace( '/[*|-]?\s?(IMP|Imp|imp)[:]?\s?(\b|(?=\[))/', '', $changelog_line );
                    $releases[ $release_count ]['imp'][] = $this->color_magazine_parse_md_and_clean( $changelog_line );
                    continue;
                }

                if ( preg_match( '/[*|-]?\s?(FIX|Fix|fix)[:]?\s?(\b|(?=\[))/', $changelog_line ) ) {
                    $changelog_line = preg_replace( '/[*|-]?\s?(FIX|Fix|fix)[:]?\s?(\b|(?=\[))/', '', $changelog_line );
                    $releases[ $release_count ]['fix'][] = $this->color_magazine_parse_md_and_clean( $changelog_line );
                    continue;
                }


                $changelog_line = $this->color_magazine_parse_md_and_clean( $changelog_line );

                if ( empty( $changelog_line ) ) {
                    continue;
                }

                $releases[ $release_count ]['tweak'][] = $changelog_line;
            }

            return array_values( $releases );
        }

        /**
         * Parse markdown links and cleanup string.
         *
         * @param string $string changelog line.
         *
         * @return string
         */
        private function color_magazine_parse_md_and_clean( $string ) {

            // Drop spaces, starting lines | asterisks.
            $string = trim( $string );
            $string = ltrim( $string, '*' );
            $string = ltrim( $string, '-' );

            // Replace markdown links with <a> tags.
            $string = preg_replace_callback(
                '/\[(.*?)]\((.*?)\)/',
                function ( $matches ) {
                    return '<a href="' . $matches[2] . '" target="_blank" rel="noopener"><i class="dashicons dashicons-external"></i>' . $matches[1] . '</a>';
                },
                htmlspecialchars( $string )
            );

            return $string;
        }

        /**
         * Popup alert for mystery themes demo importer plugin install.
         *
         * @since 1.0.0
         */
        public function color_magazine_install_demo_import_plugin_popup() {
            $demo_importer_plugin = WP_PLUGIN_DIR . '/mysterythemes-demo-importer/mysterythemes-demo-importer.php';
        ?>
                <div id="color-magazine-demo-import-plugin-popup">
                    <div class="color-magazine-popup-inner-wrap">
                        <?php
                            if ( is_plugin_active( 'mysterythemes-demo-importer/mysterythemes-demo-importer.php' ) ) {
                                echo '<span class="color-magazine-plugin-message">'.esc_html__( 'You can import available demos now!', 'color-magazine' ).'</span>';
                            } else {
                                if ( ! file_exists( $demo_importer_plugin ) ) {
                        ?>
                                    <span class="color-magazine-plugin-message"><?php esc_html_e( 'Mystery Themes Demo Importer Plugin is not installed!', 'color-magazine' ); ?></span>
                                    <a href="javascript:void(0)" class="color-magazine-install-demo-import-plugin" data-process="<?php esc_attr_e( 'Installing & Activating', 'color-magazine' ); ?>" data-done="<?php esc_attr_e( 'Installed & Activated', 'color-magazine' ); ?>" data-redirect="<?php echo esc_url( wp_nonce_url( add_query_arg( 'color-magazine-hide-welcome-notice', 'welcome', admin_url( 'themes.php' ).'?page=color-magazine-dashboard&tab=color_magazine_starter' ) , 'color_magazine_hide_welcome_notices_nonce', '_color_magazine_welcome_notice_nonce' ) ); ?>">
                                        <?php esc_html_e( 'Install and Activate', 'color-magazine' ); ?>
                                    </a>
                        <?php
                                } else {
                        ?>
                                    <span class="color-magazine-plugin-message"><?php esc_html_e( 'Mystery Themes Demo Importer Plugin is installed but not activated!', 'color-magazine' ); ?></span>
                                    <a href="javascript:void(0)" class="color-magazine-activate-demo-import-plugin" data-process="<?php esc_attr_e( 'Activating', 'color-magazine' ); ?>" data-done="<?php esc_attr_e( 'Activated', 'color-magazine' ); ?>" data-redirect="<?php echo esc_url( wp_nonce_url( add_query_arg( 'color-magazine-hide-welcome-notice', 'welcome', admin_url( 'themes.php' ).'?page=color-magazine-dashboard&tab=color_magazine_starter' ) , 'color_magazine_hide_welcome_notices_nonce', '_color_magazine_welcome_notice_nonce' ) ); ?>">
                                        <?php esc_html_e( 'Activate Now', 'color-magazine' ); ?>
                                    </a>
                        <?php
                                }
                            }
                        ?>
                    </div><!-- .color-magazine-popup-inner-wrap -->
                </div><!-- .color-magazine-demo-import-plugin-popup -->
            <?php
        }
    }

    $admin_main_class =new Color_Magazine_Admin_Main();

endif;