<?php

use Elementor\Group_Control_Border;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

class CustomWidgetBase extends Widget_Base {

	public function get_name() {
		return $this->name;
	}

	public function get_title() {
		return $this->title;
	}

	public function get_icon() {
		return isset($this->icon) ? $this->icon : "fa fa-puzzle";
	}

	public function get_categories() {
		return isset($this->categories) ? $this->categories : [CUSTOM_WIDGETS_CATEGORY_KEY];
	}

	public function get_repeater_fields_translation_class()
	{
        return isset($this->integrationClass) && $this->integrationClass ? $this->integrationClass : false;
	}

	protected function _register_controls() {

		foreach ($this->controls as $key => $control) {
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
						'prevent_empty' => $control["prevent_empty"]
					]);

					break;
				default:
					$this->add_control($key, $control);
					break;
			}
		}
	}

	protected function translatable()
	{
		$controls = $this->controls;
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

	public function render() {
		require $this->view;
	}
}
