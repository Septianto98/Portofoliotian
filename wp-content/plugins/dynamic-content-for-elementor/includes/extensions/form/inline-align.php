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

function _dce_extension_form_inline_align( $field ) {
	switch ( $field ) {
		case 'docs':
			return 'https://www.dynamic.ooo/widget/inline-align-for-elementor-pro-form/';
		case 'description':
			return __( 'Choose the inline align type for checkbox and radio fields.', 'dynamic-content-for-elementor' );
	}
}

if ( ! Helper::is_elementorpro_active() ) {

	class DCE_Extension_Form_Inline_Align extends DCE_Extension_Prototype {

		public $name = 'Inline Align for Elementor Pro Form';
		private $is_common = false;
		public static $depended_plugins = [ 'elementor-pro' ];

		public static function get_description() {
			return _dce_extension_form_inline_align( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_inline_align( 'docs' );
		}

	}

} else {

	class DCE_Extension_Form_Inline_Align extends DCE_Extension_Prototype {

		public $name = 'Inline Align for Elementor Pro Form';
		public static $depended_plugins = [ 'elementor-pro' ];
		public static $docs = 'https://www.dynamic.ooo/';
		private $is_common = false;
		public $has_action = false;

		public static function get_description() {
			return _dce_extension_form_inline_align( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_inline_align( 'docs' );
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
			return 'dce_form_inline_align';
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
			return __( 'Inline align', 'dynamic-content-for-elementor' );
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
				$add_css = $add_js = '';
				$has_js = false;
				foreach ( $settings['form_fields'] as $key => $afield ) {
					if ( $afield['field_type'] == 'radio' || $afield['field_type'] == 'checkbox' ) {
						if ( ! empty( $afield['inline_align'] ) ) {
							$has_js = true;
							$add_js .= "jQuery('.elementor-field-group-" . $afield['custom_id'] . "').addClass('elementor-repeater-item-" . $afield['_id'] . "');";
							$add_css .= '.elementor-field-group-' . $afield['custom_id'] . '.elementor-repeater-item-' . $afield['_id'] . ' .elementor-subgroup-inline{width: 100%; justify-content: ' . $afield['inline_align'] . ';}';
						}
					}
				}
				if ( $has_js ) {
					$add_js = '<script>jQuery(function(){' . $add_js . '});</script>';
					$add_css = '<style>' . $add_css . '</style>';
					$add_js = \DynamicContentForElementor\Assets::dce_enqueue_script( $this->get_name() . '-' . $widget->get_id() . '-inline', $add_js );
					$add_css = \DynamicContentForElementor\Assets::dce_enqueue_style( $this->get_name() . '-' . $widget->get_id() . '-inline', $add_css );
					return $content . $add_js . $add_css;
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
				$control_data['fields']['inline_align'] = array(
					'name' => 'inline_align',
					'label' => __( 'Inline align', 'dynamic-content-for-elementor' ),
					'type' => Controls_Manager::CHOOSE,
					'separator' => 'before',
					'options' => [
						'flex-start' => [
							'title' => __( 'Left', 'elementor-pro' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'elementor-pro' ),
							'icon' => 'eicon-text-align-center',
						],
						'flex-end' => [
							'title' => __( 'Right', 'elementor-pro' ),
							'icon' => 'eicon-text-align-right',
						],
						'space-around' => [
							'title' => __( 'Around', 'elementor-pro' ),
							'icon' => 'eicon-text-align-justify',
						],
						'space-evenly' => [
							'title' => __( 'Evenly', 'elementor-pro' ),
							'icon' => 'eicon-text-align-justify',
						],
						'space-between' => [
							'title' => __( 'Between', 'elementor-pro' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-subgroup-inline' => 'width: 100%; justify-content: {{VALUE}};',
					],
					'render_type' => 'ui',
					'condition' => [
						'field_type' => [ 'checkbox', 'radio' ],
						'inline_list!' => '',
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
