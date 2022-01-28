<?php

namespace CubeBuilder;

use Exception;

/**
 * 
 * 
 * 
 */

class EditorPanel {
    
    public $is_listening_to_controls_input  = false;
    public $sections                        = [];

    public function __construct() {
       
    }

    public function start_new_section( $section_name, $section_args ) {
        $this->is_listening_to_controls_input = $section_name;
        $this->sections[$section_name] = [ 
            'section_info' => $section_args,
            'section_controls' => [],
        ];
    }

    public function end_controls_section() {
        $this->is_listening_to_controls_input = false;
    }

    public function get_sections() {
        return $this->sections;
    }

    public function add_control( $control_name, $control_args ) {
        if( !$this->is_listening_to_controls_input ) {
            throw new Exception( 'Can\'t add a control if there is no section open' );
        }

        if( !isset( $this->sections[$this->is_listening_to_controls_input]['section_controls'][$control_name] ) ) {
            $this->sections[$this->is_listening_to_controls_input]['section_controls'][$control_name] = [];
        }

        $this->sections[$this->is_listening_to_controls_input]['section_controls'][$control_name] = $control_args;
    }
}