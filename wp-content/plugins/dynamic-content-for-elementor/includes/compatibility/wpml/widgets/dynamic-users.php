<?php

if ( ! class_exists( 'WPML_Dynamic_Users' ) ) {
	class WPML_Dynamic_Users extends WPML_Elementor_Module_With_Items {

		public function get_items_field() {
			return 'user_meta_items';
		}

		public function get_fields() {
			return [
				'text_before',
			];
		}

		protected function get_title( $field ) {
			switch ( $field ) {
				case 'text_before':
					return __( 'Text before', 'dynamic-content-for-elementor' );
				default:
					return '';
			}
		}

		protected function get_editor_type( $field ) {
			switch ( $field ) {
				case 'text_before':
					return 'LINE';
				default:
					return '';
			}
		}
	}
}
