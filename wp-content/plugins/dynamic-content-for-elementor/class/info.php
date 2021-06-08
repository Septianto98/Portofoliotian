<?php

namespace DynamicContentForElementor;

class Info {

	public function __construct() {
		$this->init();
	}

	public function init() {
		add_action( 'admin_init', [ $this, 'dce_redirect_information' ] );
	}

	public function dce_information_plugin() {
		include_once DCE_PATH . 'template/plugin-info.php';
	}

	/**
	* Redirects to information
	*
	* @since 0.1.0
	*/
	function dce_redirect_information() {
		if ( get_option( 'dce_do_activation_redirect', false ) ) {
			delete_option( 'dce_do_activation_redirect' );
			if ( ! is_multisite() ) {
				exit( wp_safe_redirect( 'admin.php?page=dce_info' ) );
			}
		}
	}
}
