<?php
use Elementor\Controls_Manager;
require_once(PCEW_PATH."/widgets/CustomWidgetBase.php");
require_once("Icon_list_translation.php");

class Template extends CustomWidgetBase {

	public $name = "template";
	public $title = "Template";
	public $icon = "eicon-image-before-after";
	public $categories = [CUSTOM_WIDGETS_CATEGORY_KEY];
    
    // Integration class for translating repeater fields
    // https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
    // DON'T FORGET to require this class
	public $integrationClass = "Icon_list_translation";

    // Absoulute path to widget view file
	public $view = PCEW_PATH . '/widgets/Template/view.php';

	public $controls = [
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
				"prevent_empty" => false,
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
