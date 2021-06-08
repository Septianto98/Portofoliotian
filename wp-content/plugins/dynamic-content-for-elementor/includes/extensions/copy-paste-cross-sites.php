<?php

namespace DynamicContentForElementor\Extensions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class DCE_Extension_CopyPaste extends DCE_Extension_Prototype {

	public $name = 'Copy&Paste Cross Sites';

	private $is_common = false;

	public static function get_description() {
		return __( 'Copy and Paste any element from a site to another', 'dynamic-content-for-elementor' );
	}

	public function get_docs() {
		return 'https://www.dynamic.ooo/widget/copy-paste-cross-site/';
	}

	protected function add_actions() {

		add_action('elementor/editor/after_enqueue_scripts', function() {
			wp_register_script(
				'dce-copy-paste-cross-sites', plugins_url( '/assets/js/copy-paste-cross-sites.js', DCE__FILE__ ), [], DCE_VERSION
			);
			wp_enqueue_script( 'dce-copy-paste-cross-sites' );

			wp_register_script(
				'dce-clipboard-js', plugins_url( '/assets/lib/clipboard.js/clipboard.min.js', DCE__FILE__ ), [], DCE_VERSION
			);
			wp_enqueue_script( 'dce-clipboard-js' );
		});

	}


}
