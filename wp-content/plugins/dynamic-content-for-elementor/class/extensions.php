<?php

namespace DynamicContentForElementor;

use Elementor\Controls_Manager;

class Extensions {

	public $extensions = [];
	public static $registered_extensions = [];
	public static $registered_form_extensions = [];
	public static $namespace = '\\DynamicContentForElementor\\Extensions\\';

	public function __construct() {
		$this->init();
	}

	public function init() {
		$this->extensions = self::get_extensions();
	}

	public static function get_extensions() {
		$extensions['dce_extension_animations'] = 'DCE_Extension_Animations';
		$extensions['dce_extension_copypaste'] = 'DCE_Extension_CopyPaste';
		$extensions['dce_extension_editor'] = 'DCE_Extension_Editor';
		$extensions['dce_extension_masking'] = 'DCE_Extension_Masking';
		$extensions['dce_extension_rellax'] = 'DCE_Extension_Rellax';
		$extensions['dce_extension_reveal'] = 'DCE_Extension_Reveal';
		$extensions['dce_extension_template'] = 'DCE_Extension_Template';
		$extensions['dce_extension_token'] = 'DCE_Extension_Token';
		$extensions['dce_extension_transforms'] = 'DCE_Extension_Transforms';
		$extensions['dce_extension_unwrap'] = 'DCE_Extension_Unwrap';
		$extensions['dce_extension_video'] = 'DCE_Extension_Video';
		$extensions['dce_extension_visibility'] = 'DCE_Extension_Visibility';

		return $extensions;
	}

	public static function get_form_extensions() {
		$extensions['dce_extension_form_address_autocomplete'] = 'DCE_Extension_Form_Address_Autocomplete';
		$extensions['dce_extension_form_amount'] = 'DCE_Extension_Form_Amount';
		$extensions['dce_extension_form_description'] = 'DCE_Extension_Form_Description';
		$extensions['dce_extension_form_email'] = 'DCE_Extension_Form_Email';
		$extensions['dce_extension_form_export'] = 'DCE_Extension_Form_Export';
		$extensions['dce_extension_form_icons'] = 'DCE_Extension_Form_Icons';
		$extensions['dce_extension_form_inline_align'] = 'DCE_Extension_Form_Inline_Align';
		$extensions['dce_extension_form_length'] = 'DCE_Extension_Form_Length';
		$extensions['dce_extension_form_message'] = 'DCE_Extension_Form_Message';
		$extensions['dce_extension_form_method'] = 'DCE_Extension_Form_Method';
		$extensions['dce_extension_form_password_visibility'] = 'DCE_Extension_Form_Password_Visibility';
		$extensions['dce_extension_form_pdf'] = 'DCE_Extension_Form_PDF';
		$extensions['dce_extension_form_redirect'] = 'DCE_Extension_Form_Redirect';
		$extensions['dce_extension_form_regex'] = 'DCE_Extension_Form_Regex';
		$extensions['dce_extension_form_reset'] = 'DCE_Extension_Form_Reset';
		$extensions['dce_extension_form_save'] = 'DCE_Extension_Form_Save';
		$extensions['dce_extension_form_select2'] = 'DCE_Extension_Form_Select2';
		$extensions['dce_extension_form_signature'] = 'DCE_Extension_Form_Signature';
		$extensions['dce_extension_form_step'] = 'DCE_Extension_Form_Step';
		$extensions['dce_extension_form_submit_on_change'] = 'DCE_Extension_Form_Submit_On_Change';
		$extensions['dce_extension_form_submit'] = 'DCE_Extension_Form_Submit';
		$extensions['dce_extension_form_telegram'] = 'DCE_Extension_Form_Telegram';
		$extensions['dce_extension_form_visibility'] = 'DCE_Extension_Form_Visibility';
		$extensions['dce_extension_form_wysiwyg'] = 'DCE_Extension_Form_WYSIWYG';
		$extensions['dce_extension_form_paypal'] = 'DCE_Extension_Form_PayPal';
		$extensions['dce_extension_form_stripe'] = 'DCE_Extension_Form_Stripe';
		$extensions['custom_validation'] = 'CustomValidation';
		return $extensions;
	}

	public static function get_active_form_extensions() {
		$tmpExtensions = self::get_form_extensions();
		$option_excluded_extensions = self::get_option_excluded_extensions();
		$activeExtensions = array();
		foreach ( $tmpExtensions as $key => $name ) {
			if ( ! isset( $option_excluded_extensions[ $name ] ) ) {
				$activeExtensions[ $key ] = $name;
			}
		}
		return $activeExtensions;
	}

	public static function get_all_extensions() {
		return self::get_extensions() + self::get_form_extensions();
	}

	/**
	 * On extensions Registered
	 *
	 * @since 0.0.1
	 *
	 * @access public
	 */
	public function on_extensions_registered() {
		$this->register_extensions();
		$this->register_form_extensions();
	}

	/**
	 * On Controls Registered
	 *
	 * @since 1.0.4
	 *
	 * @access public
	 */
	public function register_extensions() {
		if ( empty( self::$registered_extensions ) ) {
			$excluded_extensions = self::get_option_excluded_extensions();

			foreach ( $this->extensions as $key => $name ) {
				if ( ! isset( $excluded_extensions[ $name ] ) ) {
					$class = self::$namespace . $name;
					if ( $class::get_satisfy_dependencies() ) {
						$extension = new $class();
						self::$registered_extensions[ $name ] = $extension;
						Assets::add_depends( $extension );
					}
				}
			}
		}
	}

	/**
	 * On Controls Registered
	 *
	 * @since 1.0.4
	 *
	 * @access public
	 */
	public function register_form_extensions() {
		if ( empty( self::$registered_form_extensions ) ) {

			if ( Helper::is_elementorpro_active() ) {
				add_action('elementor_pro/init', function() {
					$excluded_extensions = Extensions::get_option_excluded_extensions();
					$DCE_Extension_Form_Message = $DCE_Extension_Form_Email = false;
					$form_extensions = Extensions::get_form_extensions();

					$akey = 'dce_extension_form_save';
					if ( isset( $form_extensions[ $akey ] ) ) {
						$exc_ext = ! isset( $excluded_extensions[ $form_extensions[ $akey ] ] );
						if ( $exc_ext ) {
							$a_form_ext_class = Extensions::$namespace . $form_extensions[ $akey ];
							self::$registered_form_extensions[ $akey ] = $extension = new $a_form_ext_class();
							Assets::add_depends( $extension );
							\ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' )->add_form_action( self::$registered_form_extensions[ $akey ]->get_name(), self::$registered_form_extensions[ $akey ] );
						}
					}

					foreach ( $form_extensions as $akey => $a_form_ext ) {
						$a_form_ext_class = Extensions::$namespace . $a_form_ext;
						$exc_ext = ! isset( $excluded_extensions[ $a_form_ext ] );
						if ( $exc_ext && empty( self::$registered_form_extensions[ $akey ] ) ) {
							// Instantiate the action class
							self::$registered_form_extensions[ $akey ] = $extension = new $a_form_ext_class();
							Assets::add_depends( $extension );

							if ( ! self::$registered_form_extensions[ $akey ]->has_action ) {
								continue;
							}
							if ( $a_form_ext == 'DCE_Extension_Form_Email' ) {
								$DCE_Extension_Form_Email = true;
								continue;
							}
							if ( $a_form_ext == 'DCE_Extension_Form_Message' ) {
								$DCE_Extension_Form_Message = true;
								continue;
							}
							// Register the action with form widget
							\ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' )->add_form_action( self::$registered_form_extensions[ $akey ]->get_name(), self::$registered_form_extensions[ $akey ] );
						}
					}

					if ( $DCE_Extension_Form_Email ) {
						$akey = 'dce_extension_form_email';
						if ( isset( self::$registered_form_extensions[ $akey ] ) ) {
							$extension = self::$registered_form_extensions[ $akey ];
							\ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' )->add_form_action( self::$registered_form_extensions[ $akey ]->get_name(), self::$registered_form_extensions[ $akey ] );
							$extension::add_dce_email_template_type(); // Add specific Template Type
						}
					}
					// Warning! As of version 1.9.7 the Form Message Extension
					// is implemented using die(). Its form action must be the
					// last action to be added!
					if ( $DCE_Extension_Form_Message ) {
						$akey = 'dce_extension_form_message';
						if ( isset( self::$registered_form_extensions[ $akey ] ) ) {
							$extension = self::$registered_form_extensions[ $akey ];
							\ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' )->add_form_action( self::$registered_form_extensions[ $akey ]->get_name(), self::$registered_form_extensions[ $akey ] );
						}
					}
				});
			}
		}
	}

	public static function get_option_excluded_extensions() {
		return json_decode( get_option( DCE_PRODUCT_ID . '_excluded_extensions', '[]' ), true );
	}

	public static function get_option_active_extensions() {
		return json_decode( get_option( DCE_PRODUCT_ID . '_active_extensions', '[]' ), true );
	}

}
