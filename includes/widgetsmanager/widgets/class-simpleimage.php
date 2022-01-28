<?php

namespace CubeBuilder;

class SimpleImage extends WidgetsBase {

    /**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */

    public function get_name() {
        return 'cb-image';
    }

    	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return 'Simple Image';
	}

    /**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
        $this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Title Image', 'cube-builder' ),
                'content' => 'Lorem for the main section',
			]
		);

        $this->add_control(
			'IMAGEtitle_1_section',
			[
				'label' => esc_html__( 'Title', 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title', 'elementor' ),
				'default' => esc_html__( 'Add Your Heading Text Here', 'elementor' ),
			]
		);
        $this->add_control(
			'IMAGEtitle_2_1_section',
			[
				'label' => esc_html__( 'Title', 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title', 'elementor' ),
				'default' => esc_html__( 'Add Your Heading Text Here', 'elementor' ),
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Style', 'cube-builder' ),
                'content' => 'Lorem for the style section',
			]
		);

        $this->add_control(
			'IMAGEtitle',
			[
				'label' => esc_html__( 'Title', 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title', 'elementor' ),
				'default' => esc_html__( 'Add Your Heading Text Here', 'elementor' ),
			]
		);

        $this->add_control(
			'IMAGEtitle_2',
			[
				'label' => esc_html__( 'Second Title', 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title', 'elementor' ),
				'default' => esc_html__( 'Add Your Heading Text Here', 'elementor' ),
			]
		);

        $this->add_control(
			'IMAGEtitle_3',
			[
				'label' => esc_html__( 'Third Title', 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title', 'elementor' ),
				'default' => esc_html__( 'Add Your Heading Text Here', 'elementor' ),
			]
		);

        $this->end_controls_section();



		// $this->start_controls_section(
		// 	'section_title_style',
		// 	[
		// 		'label' => esc_html__( 'Title', 'elementor' ),
		// 		'tab' => Controls_Manager::TAB_STYLE,
		// 	]
		// );

        // $this->end_controls_section();
    }


    public function render( $instance_id ) {
        echo $instance_id . ' Echo from Image :)';
    }
}
