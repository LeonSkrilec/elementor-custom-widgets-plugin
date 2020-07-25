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
		require_once("Icon_list_translation.php");
		return "Icon_list_translation";
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

			"search_placeholder" => [
				'label' => 'Search text',
				'type'  => Controls_Manager::TEXTAREA,
				'translatable' => [
					'type' => 'Hero search text',
	            	'editor_type' => 'AREA'
				]
			],

			'images' => [
				'label' => "Background images",
				'type' => Controls_Manager::GALLERY,
			],

			"icon_list" => [
				"label" => "Icons",
				"type" => "repeater",
				"field_title" => "icon_label",
				"translation_class" => "Icon_list_translation",
				"fields" => [
					"icon_image" => [
						"label" => "Icon image",
						"type" => Controls_Manager::MEDIA
					],
					"icon_label" => [
						"label" => "Icon label",
						"type" => Controls_Manager::TEXT
					]
				]
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
				case 'repeater':
					$repeater = new Repeater();
					foreach ($control["fields"] as $key => $field_control) {
						$repeater->add_control($key, $field_control);
						if (isset($field_control["translatable"]) && $field_control["translatable"]) {
							if (!$this->get_repeater_fields_translation_class()) {
								echo "<div style='position:fixed; z-index:55; top:0; color:white; padding:5px; background-color:red;'>You should provide integration class for all repeater fields in <strong>".$this->get_name()."</strong> widget.</div>";
							}
						}
					}
					$this->add_control($key, [
						"label" => $control["label"],
						"type" => Controls_Manager::REPEATER,
						"fields" => $repeater->get_controls(),
						'title_field' => '{{{ '.$control["field_title"].' }}}',
					]);

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
