<?php

/**
 * Class WPML_Elementor_Accordion
 */
class Boxes_fields extends WPML_Elementor_Module_With_Items  {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'list';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'title', 'content' );
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {
			case 'title':
				return esc_html__( 'Title', 'parsek-elements' );

			case 'content':
				return esc_html__( 'Content', 'parsek-elements' );

			default:
				return '';
		}
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_editor_type( $field ) {
		switch( $field ) {
			case 'title':
				return 'LINE';

			case 'content':
				return 'VISUAL';

			default:
				return '';
		}
	}

}
