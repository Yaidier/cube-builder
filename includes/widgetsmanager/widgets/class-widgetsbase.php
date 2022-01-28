<?php

namespace CubeBuilder;

abstract class WidgetsBase {

    protected $widget_name;
    protected $widget_instances;
    protected $instance_prefix;
    public $editor;

    public function __construct( ) {
        $this->editor           = new EditorPanel();
        $this->instance_prefix  = str_replace( ' ', '-', strtolower( $this->get_name() ) );
        $this->widget_instances = get_option( $this->instance_prefix ) ? get_option( $this->instance_prefix ) : [];

        $this->register_controls();
        $this->register_wp_shortcodes();
        return $this;
    }

    public function start_controls_section( $section_name, $section_args ) {
        $this->editor->start_new_section( $section_name, $section_args );
    }

    public function end_controls_section(){
        $this->editor->end_controls_section();
    }

    public function add_control( $control_title, $control_args ){
        $this->editor->add_control( $control_title, $control_title );
    }


    public function get_instance_prefix() {
        return $this->instance_prefix;
    }

    private static function generate_radom_id( $sc_prefix ) {
        do {
            $random_number  = rand( 0, 100000 );
            $instance_id    = $sc_prefix . '-' . $random_number;
        } while ( isset( self::$widget_instances[$instance_id] ) );

        return $instance_id ;
    }

    public function add_instance() {
        $instance_id = self::generate_radom_id( $this->instance_prefix );
        $this->widget_instances[$instance_id] = [
            'id' => $instance_id,
        ];

        update_option( $this->instance_prefix, $this->widget_instances );
    }

    public function remove_instance( $instance_id ) {
        unset( $this->widget_instances[$instance_id] );

        update_option( $this->instance_prefix, $this->widget_instances );
    }

    public function get_all_instances() {
        return $this->widget_instances;
    }

    public function register_wp_shortcodes() {
        foreach( $this->widget_instances as $instance ) {
            $args        = [
                'instance_id'   => $instance['id'],
                'instance_name' => $this->get_name(),
                'editor'        => $this->editor,
            ];

            add_shortcode( $instance['id'], function() use ( $args ) {
                $instance_id = $args['instance_id'];
                $widget_name = $args['instance_name'];
                
                if( current_user_can('editor') || current_user_can('administrator') ) {
                    wp_enqueue_script('cb-editor-main-script');
                    wp_enqueue_style('cb-editor-main-style');

                    $editor         = $args['editor'];
                    $sections       = $editor->get_sections();

                    ob_start();

                    require WN_CUBE_BUILDER_DIR . '/templates/editor-panel.php';

                    echo '<div class="cb-widget" cube-id="' . esc_attr( $instance_id ) . '">';
                    $this->render( $instance_id );
                    echo '<div class="cb-widget_editor_buttons"><button class="cb-widget_edit_button" >Edit</button></div>';
                    echo '</div>';
                    $buffer = ob_get_clean();

                    return $buffer;
                }
                else {
                    ob_start();
                    echo '<div class="cb-widget" cube-id="' . esc_attr( $instance_id ) . '">';
                    $this->render( $instance_id );
                    echo '</div>';
                    $buffer = ob_get_clean();

                    return $buffer;
                }
            } ); 
        }
    }

    abstract function get_name();
    abstract function render( $instance_id );

}
