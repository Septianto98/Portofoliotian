<?php

namespace DynamicContentForElementor\Extensions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class DCE_Extension_Editor extends DCE_Extension_Prototype {

	public $name = 'Select2 for Elementor Editor';

	private $is_common = false;

	public static function get_description() {
		return __( 'Select2 gives you a select box with support for searching in Elementor Backend Editor', 'dynamic-content-for-elementor' );
	}

	public function get_docs() {
		return 'https://www.dynamic.ooo/widget/select2-elementor-editor/';
	}

	protected function add_actions() {

		add_action('elementor/editor/after_enqueue_scripts', function() {
			wp_register_script(
					'dce-select2-for-elementor-editor', plugins_url( '/assets/js/select2-for-elementor-editor.js', DCE__FILE__ ), [], DCE_VERSION
			);
			wp_enqueue_script( 'dce-select2-for-elementor-editor' );
		});

	}


}
