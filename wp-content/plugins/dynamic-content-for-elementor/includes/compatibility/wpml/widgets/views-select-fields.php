<?php

if ( ! class_exists( 'WPML_views' ) ) {
	class WPML_Views_Select_Fields extends WPML_Elementor_Module_With_Items {

		public function get_items_field() {
			return 'dce_views_select_fields';
		}

		public function get_fields() {
			return [
				'dce_views_select_label',
				'dce_views_select_description',
				'dce_views_select_no_results',
			];
		}

		protected function get_title( $field ) {
			switch ( $field ) {
				case 'dce_views_select_label':
					return __( 'Label', 'dynamic-content-for-elementor' );
				case 'dce_views_select_description':
					return __( 'Description', 'dynamic-content-for-elementor' );
				case 'dce_views_select_no_results':
					return __( 'Fallback', 'dynamic-content-for-elementor' );
				default:
					return '';
			}
		}

		protected function get_editor_type( $field ) {
			switch ( $field ) {
				case 'dce_views_select_label':
				case 'dce_views_select_description':
				case 'dce_views_select_no_results':
					return 'LINE';
				default:
					return '';
			}
		}
	}
}
