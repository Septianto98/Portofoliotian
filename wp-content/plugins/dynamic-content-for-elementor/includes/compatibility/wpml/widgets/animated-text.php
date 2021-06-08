<?php

if ( ! class_exists( 'WPML_AnimatedText' ) ) {
	class WPML_AnimatedText extends WPML_Elementor_Module_With_Items {

		public function get_items_field() {
			return 'words';
		}

		public function get_fields() {
			return [
				'text_word',
			];
		}

		protected function get_title( $field ) {
			switch ( $field ) {
				case 'text_word':
					return __( 'Word', 'dynamic-content-for-elementor' );

				default:
					return '';
			}
		}

		protected function get_editor_type( $field ) {
			switch ( $field ) {
				case 'text_word':
					return 'LINE';

				default:
					return '';
			}
		}
	}
}
