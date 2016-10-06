<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

class WPLoveIt {

    public function __construct(){

        $this->plugin_name = 'wp-love-it';
        $this->version = '1.0.1';

        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
        add_action( 'wp_enqueue_scripts', array($this, 'pt_love_it_scripts'), 100 );
        add_action( 'wp_ajax_nopriv_pt_love_it', array($this, 'pt_love_it'));
        add_action( 'wp_ajax_pt_love_it', array($this, 'pt_love_it'));
        add_filter( 'the_content',array($this,'wpli_content_filter'));
        add_shortcode( 'wp_love_it', array($this,'wp_love_it_shortcode') );
    }

    /**
     * Load Text Domain
     *
     * Loads the textdomain for translations
     *
     * @author Leo
     * @since 1.0.0
     *
     */
    public function load_textdomain() {
        load_plugin_textdomain( $this->plugin_name, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    /**
     * Generate love it button HTML
     *
     *
     * @author Leo
     * @since 1.0.0
     *
     */
    private function love_it_button_html() {

        $button_html = '';

        if ( is_single() ) {
            $post_id = get_the_ID();
            $loves = get_post_meta( get_the_ID(), '_pt_loves', true );
            $loves = ( empty( $loves ) ) ? 0 : $loves;

            $ids = ! empty($_COOKIE['wp_love_it_ids']) ? explode(',', $_COOKIE['wp_love_it_ids']) : array();
            if ( in_array( get_the_ID(), $ids) ) {
                $rated = ' has_rated';
                $text  = __( 'You loved it', $this->plugin_name );
            } else {
                $rated = '';
                $text  = __( 'Love it', $this->plugin_name );
            }

            $nonce_field = wp_nonce_field( 'wpli-'.$post_id, '_wpnonce', true, false );

            $button_html = '
                        <div id="pt-love-it-'.$post_id.'" class="pt-love-it'.$rated.'">
                            <a class="love-button" data-id="' . $post_id . '">' . $text .
                            '</a>
                            <span id="love-count-'.get_the_ID().'" class="love-count">' . $loves . '</span>'
                            . $nonce_field .
                        '</div>';
        }
        return $button_html;
    }

    /**
     * Content filter to add (or not) add the Love it button to post
     * Use filter 'wpli/position' to choose the button position, three values accepted: top, bottom, none
     * Use filter 'wpli/autoadd' to choose whether the button to be automatically added to the post, 2 boolean values accepted: true, false
     *
     * @author Leo
     * @since 1.0.0
     *
     */
    public function wpli_content_filter( $content ){
        $positions = 'top';       
        // You can use below filter to choose where to display the Love it button
        $positions = apply_filters( 'wpli/position', $positions );
        $auto      = apply_filters( 'wpli/autoadd', true );
        
        $topBtn = $bottomBtn  = '';

        if ( $auto == true ) {
            if ( $positions == 'top' ) {
                $topBtn = $this->love_it_button_html();
            } elseif ( $positions == 'bottom' ) {
                $bottomBtn = $this->love_it_button_html();
            }
        }
        return $topBtn . $content . $bottomBtn;

    }

    /**
     * Add the support for shortcode of [wp_love_it]
     *
     * @author Leo
     * @since 1.0.0
     *
     */
    public function wp_love_it_shortcode() {
        return $this->love_it_button_html();
    }

    /**
     * Love it function
     *
     *
     * @author Leo
     * @since 1.0.0
     *
     */
    public function pt_love_it() {

        $data   = array(
            'status'    => false,
            'message'   => '',
        );

        $post_id        = $_POST['post_id'];
        $nonce_action   = 'wpli-'.$post_id;

        // Don’t use a nonce on the front end for non-logged in users
        // if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], $nonce_action ) ) {

            $loves = get_post_meta( $_POST['post_id'], '_pt_loves', true );
            $loves = ( empty( $loves ) ) ? 0 : $loves;
            $new_loves = $loves + 1;

            if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

                update_post_meta( $_POST['post_id'], '_pt_loves', $new_loves );
                $data['status'] = true;
                $data['message'] = $new_loves;

            } else {
                
                $data['status'] = false;
                $data['message'] = __( 'An error is found, please try again later.', $this->plugin_name );
            }

        /*} else {

            $data['status'] = false;
            $data['message'] = __( 'No naughty business please.', $this->plugin_name );
        }*/

        echo json_encode($data);
        die();
    }

    /**
     * Enqueue Assets
     *
     * Adds the scripts and styles needed for the plugin to work. wp_localize_script() is used to add translations to our
     * javascript and to pass the admin ajax url.
     *
     * @author Leo
     * @since 1.0.0
     *
     */
    public function pt_love_it_scripts() {

            wp_enqueue_style( 'love-it', trailingslashit( plugin_dir_url( __FILE__ ) ).'css/love-it.css' );
            
            if ( ! wp_script_is( 'jquery', 'enqueued' )) {
                wp_enqueue_script( 'jquery' ); // Comment this line if you theme has already loaded jQuery
            }
            wp_enqueue_script( 'jquery-cookie', trailingslashit( plugin_dir_url( __FILE__ ) ).'js/js.cookie.js', array('jquery'), '2.1.1', true);
            wp_enqueue_script( 'wp-love-it', trailingslashit( plugin_dir_url( __FILE__ ) ).'js/love-it.js', array('jquery'), $this->version, true );

            wp_localize_script( 'wp-love-it', 'loveit', array(
                'ajax_url'  => admin_url( 'admin-ajax.php' ),
                'lovedText' => __( 'You loved it', $this->plugin_name ),
                'loveText' => __( 'Love it', $this->plugin_name ),
            ));
    }
}