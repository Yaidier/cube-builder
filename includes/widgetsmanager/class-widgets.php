<?php

namespace CubeBuilder;

class Widgets {

    private $all_widgets = null;

    public function register() {
        if (is_null($this->all_widgets)) {
            $this->all_widgets = [];
            $this->register_new_widget(new Headline);
            $this->register_new_widget(new SimpleImage);
        }
    }

    public function register_new_widget(WidgetsBase $new_widget) {
        $widget_name                        = $new_widget->get_name();
        $this->all_widgets[$widget_name]    = $new_widget;
    }

    public function get_all_widgets() {
        return $this->all_widgets;
    }

    public function get_widget_by_prefix($shortcode_prefix) {
        foreach ($this->all_widgets as $widget) {
            if ($widget->get_instance_prefix() == $shortcode_prefix) {
                return $widget;
            }
        }
    }
    
}
