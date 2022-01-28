<?php

/**
 * @package WN Cube Builder
 */
/*
Plugin Name: Products Builder
Plugin URI: https://wirenomads.com
Description: 
Author: Yaidier Perez
Version: 0.1
Author URI: 
License: GPLv2 or later
*/
/*
Copyright ( C ) 2021  Yaidier Perez
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or ( at your option ) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

namespace CubeBuilder;

if (!defined('ABSPATH')) {

    exit;
}

define('WN_CUBE_BUILDER_DIR', __DIR__);
define('WN_CUBE_BUILDER_URL', plugin_dir_url(__FILE__));
define('WN_CUBE_BUILDER_VERSION', 0.1);

class CubeBuilder {

    public $plugin_name;

    public static $instance = null;
    public $widgets_manager = null;

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function register_autoloader() {
        include_once WN_CUBE_BUILDER_DIR . '/includes/autoloader.php';

        Autoloader::run();
    }

    private function __construct() {
        $this->register_autoloader();
        $this->plugin_name = plugin_basename(__FILE__);

        $this->widgets_manager = new Widgets();
        $this->widgets_manager->register();

        // $this->controls_manager = new Controls_Manager();

        $this->register();
    }

    function register() {

        add_action('admin_enqueue_scripts', array($this, 'wn_pb_admin_scripts'));
        add_action( 'wp_enqueue_scripts', array( $this, 'editor_scripts_and_styles' ));

        //Admin Ajax Call
        add_action('wp_ajax_manage_products', array('CubeBuilder\AjaxHandler', 'manage_products_requests'));
        // add_action('wp_ajax_wn_pb_editor', array( 'AjaxHandler', 'editor_requests') );


        add_action('admin_menu', array($this, 'add_admin_pages'));
        add_filter("plugin_action_links_{$this->plugin_name}", array($this, 'settings_link'));

        add_shortcode('cubebuilder', array($this, 'includeme_call'));
    }

    public function editor_scripts_and_styles() {
        wp_register_script( 
            'cb-editor-main-script', 
            WN_CUBE_BUILDER_URL . 'assets/js/cb-editor-main.js', 
            array(),
            date('ymd-Gis', filemtime(WN_CUBE_BUILDER_DIR . '/assets/js/cb-editor-main.js')),
            true, 
        );
        wp_register_style( 
            'cb-editor-main-style', 
            WN_CUBE_BUILDER_URL . 'assets/css/cb-editor-main.css', 
            array(),
            date('ymd-Gis', filemtime(WN_CUBE_BUILDER_DIR . '/assets/css/cb-editor-main.css')),
        );
    }

    public function wn_pb_admin_scripts($hook) {

        //Enqueing scripts for the Table Products page
        if ('cube-builder_page_widget_dashboard' === $hook || 'toplevel_page_wn_cube_builder' == $hook) {

            wp_enqueue_style('wn_cb_admin_style', WN_CUBE_BUILDER_URL . 'admin/assets/css/wn-pb-admin.css', array(), time());
            wp_enqueue_script('wn_cb_admin_script', WN_CUBE_BUILDER_URL . 'admin/assets/js/wn-pb-admin.js', array('jquery'), time());

            wp_localize_script('wn_cb_admin_script', 'wp_ajax_tets_vars', array(

                'ajax_url'    => admin_url('admin-ajax.php'),

            ));
        }
        
    }

    function includeme_call($atts = array(), $content = null) {
        $shortcode = $atts['id'];

        ob_start();

        echo '<h1>Hola</h1>';

        $buffer = ob_get_clean();

        $options = get_option('includeme', array());

        if (isset($options['shortcode'])) {

            $buffer = do_shortcode($buffer);
        }

        return $buffer;
    }

    public function settings_link($links) {

        $settings_link = '<a href="admin.php?page=wn_cube_builder"> Sticky Footer</a>';
        array_push($links, $settings_link);

        return $links;
    }

    public function add_admin_pages() {

        add_menu_page(
            'Cube Builder',
            'Cube Builder',
            'manage_options',
            'wn_cube_builder',
            array($this, 'all_widgets'),
            'dashicons-align-full-width',
            110
        );

        add_submenu_page(
            'wn_cube_builder',
            'mainpage',
            "Main Page",
            'manage_options',
            'cb_widget_dashboard',
            array($this, 'widget_dashboard')
        );
    }

    public function all_widgets() {
        include_once plugin_dir_path(__FILE__) . '/templates/all-widgets.php';
    }

    public function widget_dashboard() {
        Admin::widget_dashboard_controller();
        // include_once plugin_dir_path(__FILE__) . '/templates/admin-dashboard.php';
    }

    public function products_editor() {
    }

    public function activate() {
    }

    public function deactivate() {
    }
}

if (class_exists('CubeBuilder\CubeBuilder')) {
    CubeBuilder::instance();

    do_action('cubebuilder_loaded');
} else {
    // CubeBuilder::instance();
    echo 'NO exisite :(';
}

//activation
register_activation_hook(__FILE__,  array(CubeBuilder::instance(), 'activate'));

//deactivation
register_deactivation_hook(__FILE__, array(CubeBuilder::instance(), 'deactivate'));
