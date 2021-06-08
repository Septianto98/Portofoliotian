<?php

namespace DynamicContentForElementor\Extensions;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use DynamicContentForElementor\Helper;
use DynamicContentForElementor\Tokens;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

function _dce_extension_custom_validation( $field ) {
	switch ( $field ) {
		case 'docs':
			return '';
		case 'description':
			return __( 'Add Custom PHP to validate a whole form.', 'dynamic-content-for-elementor' );
	}
}

if ( ! Helper::is_elementorpro_active() ) {
	class CustomValidation extends DCE_Extension_Prototype {
		public $name = 'Custom PHP Validation for Elementor Pro Form';
		private $is_common = false;
		public static $depended_plugins = [ 'elementor-pro' ];

		public static function get_description() {
			return _dce_extension_custom_validation( 'description' );
		}

		public function get_docs() {
			return _dce_extension_custom_validation( 'docs' );
		}
	}
} else {
	class CustomValidation extends DCE_Extension_Prototype {
		private static $actions_added = false;
		public $name = 'Custom PHP Validation for Elementor Pro Form';
		public static $depended_plugins = [ 'elementor-pro' ];
		private $is_common = false;
		public $has_action = false;

		public static function get_description() {
			return _dce_extension_custom_validation( 'description' );
		}

		public function get_docs() {
			return _dce_extension_custom_validation( 'docs' );
		}

		public static function get_docs_static() {
			return _dce_extension_custom_validation( 'docs' );
		}

		public static function get_plugin_depends() {
			return self::$depended_plugins;
		}

		public static function get_satisfy_dependencies( $ret = false ) {
			return true;
		}

		public function get_name() {
			return 'dce_custom_validation';
		}

		public function get_label() {
			return __( 'Custom PHP Validation', 'dynamic-content-for-elementor' );
		}

		protected function add_actions() {
			if ( self::$actions_added ) {
				return;
			}
			self::$actions_added = true;
			// low priority action because conditional fields reset the validation status:
			add_action( 'elementor_pro/forms/validation', array( $this, 'validate_form' ), 100, 2 );
			add_action( 'elementor/element/form/section_form_options/after_section_start', [ $this, 'add_controls_to_form' ] );
		}

		public function validate_form( $record, $ajax_handler ) {
			$enabled = $record->get_form_settings( 'dce_custom_php_validation_enabled' );
			if ( 'yes' === $enabled ) {
				$code = $record->get_form_settings( 'dce_custom_php_validation_code' );
				try {
					$raw_fields = $record->get_field( [] );
					$fields = [];
					foreach ( $raw_fields as $id => $content ) {
						$fields[ $id ] = $content['value'];
					}
					// phpcs:ignore Squiz.PHP.Eval.Discouraged
					$result = eval( $code );
					if ( is_string( $result ) ) {
						$fields['id'];
						$ajax_handler->add_error_message( $result );
					} elseif ( is_array( $result ) && count( $result ) === 2 ) {
						$ajax_handler->add_error( $result[0], $result[1] );
					} elseif ( $result ) {
						$ajax_handler->add_error_message( __( 'Generic Form Error', 'dynamic-content-for-elementor' ) );
					}
				} catch ( \ParseError $e ) {
					$ajax_handler->add_error_message( __( 'Parse error while evaluating Custom PHP validation', 'dynamic-content-for-elementor' ) );
				} catch ( \Throwable $e ) {
					if ( WP_DEBUG ) { // in debug mode to avoid leaks.
						$ajax_handler->add_error_message( __( 'Error while evaluating Custom PHP validation code:', 'dynamic-content-for-elementor' ) . $e->getMessage() );
					} else {
						$ajax_handler->add_error_message( __( 'Error while evaluating Custom PHP validation code.', 'dynamic-content-for-elementor' ) );
					}
				}
			}
		}

		public function add_controls_to_form( $widget ) {
			if ( ! current_user_can( 'manage_options' ) && is_admin() ) {
				return;
			}
			$widget->add_control(
				'dce_custom_php_validation_enabled',
				[
					'label'   => '<span class="color-dce icon icon-dyn-logo-dce"></span> ' . __( 'Enable Custom PHP Validation', 'dynamic-content-for-elementor' ),
					'type'    => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$widget->add_control(
				'dce_custom_php_validation_code',
				[
					'label'   => __( 'Custom Validation Code', 'dynamic-content-for-elementor' ),
					'type'    => Controls_Manager::CODE,
					'language' => 'php',
					'default' => '',
					'separator' => 'after',
					'description' => __( 'Use the variable $fields to access fields values (eg $fields["field_id"]). The validation succeeds only if the PHP code does not return or return false . If the code returns a string, then the string is returned as an error. If it returns [ $field_id, $error_message ], the error message will be reported for the specific field.', 'dynamic-content-for-elementor' ),
					'condition' => [
						'dce_custom_php_validation_enabled' => 'yes',
					],
				]
			);
		}
	}
}
