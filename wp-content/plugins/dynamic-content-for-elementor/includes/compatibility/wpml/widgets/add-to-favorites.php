<?php

if ( ! class_exists( 'WPML_AddToFavorites' ) ) {
	class WPML_AddToFavorites extends WPML_Elementor_Module_With_Items {

		public function get_items_field() {
			return 'dce_favorite_list';
		}

		public function get_fields() {
			return [
				'dce_favorite_title',
				'dce_favorite_title_add',
				'dce_favorite_title_remove',
			];
		}

		protected function get_title( $field ) {
			switch ( $field ) {
				case 'dce_favorite_title':
					return __( 'Add to Favorites - Title', 'dynamic-content-for-elementor' );
				case 'dce_favorite_title_add':
					return __( 'Add to Favorites - Add - Label', 'dynamic-content-for-elementor' );
				case 'dce_favorite_title_remove':
					return __( 'Add to Favorites - Remove - Label', 'dynamic-content-for-elementor' );
				default:
					return '';
			}
		}

		protected function get_editor_type( $field ) {
			switch ( $field ) {
				case 'dce_favorite_title':
				case 'dce_favorite_title_add':
				case 'dce_favorite_title_remove':
					return 'LINE';
				default:
					return '';
			}
		}
	}
}
