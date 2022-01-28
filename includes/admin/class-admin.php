<?php

namespace CubeBuilder;

/**
 * 
 * 
 * 
 */

class Admin {

    public static $widget_prefix;
    public static $widget;

    public static function widget_dashboard_controller() {
        if( !isset( $_GET['page'] ) || $_GET['page'] != 'cb_widget_dashboard' || !isset( $_GET['widget-prefix'] ) )  {
            return;
        }

        self::$widget_prefix  = $_GET['widget-prefix'];
        self::$widget         = CubeBuilder::instance()->widgets_manager->get_widget_by_prefix(self::$widget_prefix);
        
        self::action_controller();
        self::render_widget_dashboard();
    }

    private static function action_controller() {
        if( isset( $_POST['add_new_instance'] ) ) {
            self::$widget->add_instance();
        }

        if( isset( $_POST['remove_instance'] ) ) {
            
            $instance_id = $_POST['remove_instance'];
            self::$widget->remove_instance( $instance_id );
        }
    }


    public static function render_widget_dashboard() {
        $widget_instances = self::$widget->get_all_instances();
        
        require_once WN_CUBE_BUILDER_DIR . '/templates/widget-dashboard.php';
    }
}
