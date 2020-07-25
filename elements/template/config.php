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
		return 'hero';
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

	public function get_repeater_fields_translation_class()
	{
		return false;
	}

	public function widget_controls()
	{
		return [
			"content_tab" => [
				"type" => "tab",
				"label" => "Content",
				"tab" => Controls_Manager::TAB_CONTENT,
			],

			"title" => [
				'label' => 'Title',
				'type'  => Controls_Manager::TEXTAREA,
				'translatable' => [
					'type' => "Hero title",
					'editor_type' => 'AREA' // LINE, AREA or VISUAL
				]
			],

			"subtitle" => [
				'label' => 'Subtitle',
				'type'  => Controls_Manager::TEXTAREA,
				'translatable' => [
					'type' => 'Hero subtitle',
	            	'editor_type' => 'AREA'
				]
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
	}

	protected function _register_controls() {

		foreach ($this->widget_controls() as $key => $control) {
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
		$controls = $this->widget_controls();
		$translatable_fields = [];

		foreach ($controls as $key => $control) {
			if (isset($control["translatable"])) {
				$translatable_field = [
					"field" => $key,
					"type" => $control["translatable"]["type"],
					"editor_type" => $control["translatable"]["editor_type"],
				];
				array_push($translatable_fields, $translatable_field);
			}
		}

		$translatable_array = [
			'conditions' => [ 'widgetType' => $this->get_name() ],
			'fields' => $translatable_fields
		];

		$intergation_class = $this->get_repeater_fields_translation_class();
		if ($intergation_class) $translatable_array["integration-class"] = $intergation_class;

	    return $translatable_array;
	}

	protected function render() {
		require PCEW_PATH . '/elements/'.$this->get_name().'/view.php';
	}
}
