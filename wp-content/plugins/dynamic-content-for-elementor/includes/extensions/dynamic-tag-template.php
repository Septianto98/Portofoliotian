<?php

namespace DynamicContentForElementor\Extensions;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class DCE_Extension_Template extends DCE_Extension_Prototype {

	public $name = 'Template';

	private $is_common = true;

	public static function get_description() {
		return __( 'Add support for Template in Dynamic Tag for Text, HTML and Textarea settings', 'dynamic-content-for-elementor' );
	}

	public function get_docs() {
		return 'https://www.dynamic.ooo/widget/dynamic-tag-token/';
	}

	public function init( $param = null ) {

		parent::init();

		$this->add_dynamic_tags();

	}

}
