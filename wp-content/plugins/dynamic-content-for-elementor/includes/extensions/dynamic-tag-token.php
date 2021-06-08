<?php

namespace DynamicContentForElementor\Extensions;

use DynamicContentForElementor\Tokens;
use Elementor\Controls_Manager;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class DCE_Extension_Token extends DCE_Extension_Prototype {

	public $name = 'Tokens';

	private $is_common = true;

	public static function get_description() {
		return __( 'Add support for Tokens in Dynamic Tag for Text, Number and Textarea settings', 'dynamic-content-for-elementor' );
	}

	public function get_docs() {
		return 'https://www.dynamic.ooo/widget/dynamic-tag-token/';
	}

	public function init( $param = null ) {

		parent::init();

		$this->add_dynamic_tags();

		// activate Token Shorcode
		add_shortcode( 'dce-token', [ $this, 'do_shortcode' ] );

		// add token to
		add_filter( 'widget_text', [ $this, 'add_dce_to_widget' ] );
	}

	public function add_dce_to_widget( $text ) {
		$new_content = Tokens::do_tokens( $text );
		return $new_content;
	}

	public function do_shortcode( $params = array() ) {
		if ( empty( $params['value'] ) ) {
			return '';
		}
		$override_id = '';
		if ( ! empty( $params['id'] ) ) {
			$override_id = '|' . intval( $params['id'] );
		}
		return Tokens::do_tokens( '[' . $params['value'] . $override_id . ']' );
	}

}
