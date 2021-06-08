<?php

if ( ! class_exists( 'WPML_Views_Where_Filter' ) ) {
	class WPML_Views_Where_Filter extends WPML_Elementor_Module_With_Items {

		public function get_items_field() {
			return 'dce_views_where';
		}

		public function get_fields() {
			return [
				'dce_views_where_value',
			];
		}

		protected function get_title( $field ) {
			switch ( $field ) {
				case 'dce_views_where_value':
					return __( 'Value', 'dynamic-content-for-elementor' );
				default:
					return '';
			}
		}

		protected function get_editor_type( $field ) {
			switch ( $field ) {
				case 'dce_views_where_value':
					return 'LINE';
				default:
					return '';
			}
		}
	}
}
