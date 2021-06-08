<?php

if ( ! class_exists( 'DynamicPostsv2' ) ) {
	class WPML_DynamicPostsv2 extends WPML_Elementor_Module_With_Items {

		public function get_items_field() {
			return 'list_items';
		}

		public function get_fields() {
			return [
				'readmore_text',
			];
		}

		protected function get_title( $field ) {
			switch ( $field ) {
				case 'readmore_text':
					return __( 'Read more', 'dynamic-content-for-elementor' );
				default:
					return '';
			}
		}

		protected function get_editor_type( $field ) {
			switch ( $field ) {
				case 'readmore_text':
					return 'LINE';
				default:
					return '';
			}
		}
	}
}
