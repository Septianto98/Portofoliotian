<?php

namespace DynamicContentForElementor\Extensions;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use DynamicContentForElementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function _dce_extension_form_length( $field ) {
	switch ( $field ) {
		case 'docs':
			return 'https://www.dynamic.ooo/widget/length-fields-for-elementor-pro-form/';
		case 'description':
			return __( 'Choose a minimum and maximum characters length for your text and textarea fields.', 'dynamic-content-for-elementor' );
	}
}

if ( ! Helper::is_elementorpro_active() ) {

	class DCE_Extension_Form_Length extends DCE_Extension_Prototype {

		public $name = 'Field Length for Elementor Pro Form';
		private $is_common = false;
		public static $depended_plugins = [ 'elementor-pro' ];

		public static function get_description() {
			return _dce_extension_form_length( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_length( 'docs' );
		}

	}

} else {

	class DCE_Extension_Form_Length extends DCE_Extension_Prototype {

		public $name = 'Field Length for Elementor Pro Form';
		public static $depended_plugins = [ 'elementor-pro' ];
		public static $docs = 'https://www.dynamic.ooo/';
		private $is_common = false;
		public $has_action = false;

		public static function get_description() {
			return _dce_extension_form_length( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_length( 'docs' );
		}

		public static function get_plugin_depends() {
			return self::$depended_plugins;
		}

		public static function get_satisfy_dependencies( $ret = false ) {
			return true;
		}

		/**
		 * Get Name
		 *
		 * Return the action name
		 *
		 * @access public
		 * @return string
		 */
		public function get_name() {
			return 'dce_form_length';
		}

		/**
		 * Get Label
		 *
		 * Returns the action label
		 *
		 * @access public
		 * @return string
		 */
		public function get_label() {
			return __( 'Length', 'dynamic-content-for-elementor' );
		}

		/**
		 * Add Actions
		 *
		 * @since 0.5.5
		 *
		 * @access private
		 */
		protected function add_actions() {
			add_action( 'elementor/widget/render_content', array( $this, '_render_form' ), 10, 2 );

			add_action('elementor/widget/print_template', function( $template, $widget ) {
				if ( 'form' === $widget->get_name() ) {
					$template = false;
				}
				return $template;
			}, 10, 2);
		}

		public function _render_form( $content, $widget ) {
			if ( $widget->get_name() == 'form' ) {
				$settings = $widget->get_settings_for_display();
				foreach ( $settings['form_fields'] as $key => $afield ) {
					if ( $afield['field_type'] == 'text' || $afield['field_type'] == 'textarea' ) {
						if ( ! empty( $afield['field_maxlength'] ) ) {
							$content = str_replace( 'id="form-field-' . $afield['custom_id'] . '"', 'id="form-field-' . $afield['custom_id'] . '" maxlength="' . $afield['field_maxlength'] . '"', $content );
						}
						if ( ! empty( $afield['field_minlength'] ) ) {
							$content = str_replace( 'id="form-field-' . $afield['custom_id'] . '"', 'id="form-field-' . $afield['custom_id'] . '" minlength="' . $afield['field_minlength'] . '"', $content );
						}
					}
				}
			}
			return $content;
		}

		public static function _add_to_form( Controls_Stack $element, $control_id, $control_data, $options = [] ) {

			if ( $element->get_name() == 'form' && $control_id == 'form_fields' ) {
				$control_data['fields']['form_fields_enchanted_tab'] = array(
					'type' => 'tab',
					'tab' => 'enchanted',
					'label' => '<i class="dynicon icon-dyn-logo-dce" aria-hidden="true"></i>',
					'tabs_wrapper' => 'form_fields_tabs',
					'name' => 'form_fields_enchanted_tab',
					'condition' => [
						'field_type!' => 'step',
					],
				);
				$control_data['fields']['field_maxlength'] = array(
					'name' => 'field_maxlength',
					'label' => __( 'Max character length', 'dynamic-content-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
					'separator' => 'before',
					'min' => 0,
					'conditions' => [
						'terms' => [
							[
								'name' => 'field_type',
								'operator' => 'in',
								'value' => [ 'text', 'textarea' ],
							],
						],
					],
					'tabs_wrapper' => 'form_fields_tabs',
					'inner_tab' => 'form_fields_enchanted_tab',
					'tab' => 'enchanted',
				);
				$control_data['fields']['field_minlength'] = array(
					'name' => 'field_minlength',
					'label' => __( 'Min character length', 'dynamic-content-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
					'min' => 0,
					'conditions' => [
						'terms' => [
							[
								'name' => 'field_type',
								'operator' => 'in',
								'value' => [ 'text', 'textarea' ],
							],
						],
					],
					'tabs_wrapper' => 'form_fields_tabs',
					'inner_tab' => 'form_fields_enchanted_tab',
					'tab' => 'enchanted',
				);
			}

			return $control_data;
		}

	}

}
