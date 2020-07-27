<?php

class Icon_list_translation extends WPML_Elementor_Module_With_Items  {

	public function get_items_field() {
		return 'icon_list';
	}

	public function get_fields() {
		return ["icon_label"];
	}

	protected function get_title( $field ) {
		switch( $field ) {
			case 'icon_label':
				return 'Icon label';

			default:
				return $field;
		}
	}

	protected function get_editor_type( $field ) {
		switch( $field ) {
			case 'icon_label':
				return 'LINE';

			default:
				return 'AREA';
		}
	}

}
