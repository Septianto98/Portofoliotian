<?php
namespace DynamicContentForElementor\Core\Upgrade;

use Elementor\Core\Upgrade\Manager as Upgrades_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Manager extends Upgrades_Manager {

	public function get_action() {
		return 'dce_updater';
	}

	public function get_plugin_name() {
		return 'dynamic-content-for-elementor';
	}

	public function get_plugin_label() {
		return __( 'Dynamic Content For Elementor', 'dynamic-content-for-elementor' );
	}

	public function get_new_version() {
		return DCE_VERSION;
	}

	public function get_version_option_name() {
		return 'dce_version';
	}

	public function get_upgrades_class() {
		return 'DynamicContentForElementor\Core\Upgrade\Upgrades';
	}
}
