<?php
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Kranjska_gora_hero extends Widget_Base {

	public function get_name() {
		return WIDGETS_CATEGORY_KEY.'hero';
	}

	public function get_title() {
		return 'Hero';
	}

	public function get_icon() {
		return 'eicon-image-before-after';
	}

	public function get_categories() {

		return [ WIDGETS_CATEGORY_KEY ];
	}

	protected function _register_controls() {

		$controls = [
			"content_tab" => [
				"type" => "tab",
				"label" => "Content",
				"tab" => Controls_Manager::TAB_CONTENT,
			],

			"title" => [
				'label' => 'Title',
		        'type'  => Controls_Manager::TEXTAREA,
			],

			"subtitle" => [
				'label' => 'Subtitle',
		        'type'  => Controls_Manager::TEXTAREA,
			],

			'hr' => [
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			],

			'images' => [
				'label' => "Background images",
				'type' => Controls_Manager::GALLERY,
			],

			"end_tab" => [
				"type" => "end_tab"
			]
		];

		foreach ($controls as $key => $control) {
			switch ($control["type"]) {
				case 'tab':
					$this->start_controls_section($key, $control);
					break;
				case 'end_tab':
					$this->end_controls_section();
					break;
				default:
					$this->add_control($key, $control);
					break;
			}
		}
	}

	public function translatable()
	{

		$arr = [
	         'conditions' => [ 'widgetType' => $this->get_name() ],
	         'fields'     => [
	            [
	               'field'       => 'title',
	               'type'        => __( 'Hero title', 'parsek-elements' ),
	               'editor_type' => 'AREA'
	            ],
	            [
	               'field'       => 'subtitle',
	               'type'        => __( 'Hero subtitle', 'parsek-elements' ),
	               'editor_type' => 'AREA'
	            ]
	         ]
	      ];
	    return $arr;
	}

	protected function render() {
		require PCEW_PATH . '/elements/hero/view.php';
	}
}
