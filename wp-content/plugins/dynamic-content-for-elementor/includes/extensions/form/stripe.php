<?php

namespace DynamicContentForElementor\Extensions;

use Elementor\Group_Control_Border;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use DynamicContentForElementor\Helper;
use ElementorPro\Modules\Forms\Fields;
use ElementorPro\Modules\Forms\Classes;
use ElementorPro\Modules\Forms\Widgets\Form;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function _dce_extension_form_stripe( $field ) {
	switch ( $field ) {
		case 'docs':
			return 'https://www.dynamic.ooo/widgets/stripe-elementor-pro-form';
		case 'description':
			return __( 'Add a Stripe field for simple payments to Elementor Pro Form.', 'dynamic-content-for-elementor' );
	}
}

if ( ! Helper::is_plugin_active( 'elementor-pro' ) ) {
	class DCE_Extension_Form_Stripe extends DCE_Extension_Prototype {
		public function get_name() {
			return 'Stripe Form Field';
		}
		private $is_common = false;
		public static $depended_plugins = [ 'elementor-pro' ];

		public static function get_description() {
			return _dce_extension_form_stripe( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_stripe( 'docs' );
		}

	}

} else {
	class DCE_Extension_Form_Stripe extends \ElementorPro\Modules\Forms\Fields\Field_Base {
		public $name = 'Stripe Field for Elementor Pro Form';
		public static $depended_plugins = [ 'elementor-pro' ];
		public static $docs = 'https://www.dynamic.ooo/';
		private $is_common = false;
		public $has_action = false;
		public $depended_scripts = [ 'dce-stripe' ];
		private static $validated_intents = [];

		public function __construct() {
			if ( get_option( 'dce_stripe_api_mode' ) === 'live' ) {
				\Stripe\Stripe::setApiKey( get_option( 'dce_stripe_api_secret_key_live' ) );
			} else {
				\Stripe\Stripe::setApiKey( get_option( 'dce_stripe_api_secret_key_test' ) );
			}
			add_action('elementor/widget/print_template', function( $template, $widget ) {
				if ( 'form' === $widget->get_name() ) {
					$template = false;
				}
				return $template;
			}, 10, 2);
			parent::__construct();
		}

		public static function get_description() {
			return _dce_extension_form_stripe( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_stripe( 'docs' );
		}

		public static function get_plugin_depends() {
			return self::$depended_plugins;
		}

		public static function get_satisfy_dependencies() {
			return true;
		}

		public function get_script_depends() {
			return $this->depended_scripts;
		}

		public function get_name() {
			return 'Stripe';
		}

		public function get_label() {
			return __( 'Stripe', 'dynamic-content-for-elementor' );
		}

		public function get_type() {
			return 'dce_form_stripe';
		}

		public function get_style_depends() {
			return $this->depended_styles;
		}

		public function update_controls( $widget ) {
			$elementor = Plugin::elementor();
			$control_data = $elementor->controls_manager->get_control_from_stack( $widget->get_unique_name(), 'form_fields' );
			if ( is_wp_error( $control_data ) ) {
				return;
			}
			$currencies = [ 'USD', 'AUD', 'BRL', 'GBP', 'CAD', 'CHF', 'CNY', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF', 'ILS', 'INR', 'JPY', 'MYR', 'MXN', 'TWD', 'NZD', 'NOK', 'PHP', 'PLN', 'RUB', 'SGD', 'SEK', 'CHF', 'THB' ];
			$currencies_options = [];
			foreach ( $currencies as $curr ) {
				$currencies_options[ $curr ] = $curr;
			}
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode()
				&& ! current_user_can( 'manage_options' ) ) {
				$field_controls = [
					'admin_notice' => [
						'name' => 'admin_notice',
						'type' => Controls_Manager::RAW_HTML,
						'raw' => '<div class="dce-notice dce-error dce-notice-error">' . __( 'You will need administrator capabilities to edit this form field.', 'dynamic-content-for-elementor' ) . '</div>',
						'tab' => 'content',
						'inner_tab' => 'form_fields_content_tab',
						'tabs_wrapper' => 'form_fields_tabs',
						'condition' => [
							'field_type' => $this->get_type(),
						],
					],
				];
			} else {
				$cache_warning = __( 'Please notice that if you have a caching plugin or system you have to disable caching on the page containing the Stripe Field.', 'dynamic-content-for-elementor' );
				$cache_warning = "<div class='dce-notice dce-error dce-notice-error'>$cache_warning</div>";
				$field_controls = [
					'dce_form_stripe_cache_warning' => [
						'name' => 'dce_form_stripe_cache_warning',
						'type' => \Elementor\Controls_Manager::RAW_HTML,
						'raw' => $cache_warning,
						'separator' => 'before',
						'condition' => [
							'field_type' => $this->get_type(),
						],
					],
					'dce_form_stripe_currency' => [
						'name' => 'dce_form_stripe_currency',
						'label' => __( 'Transaction Currency', 'dynamic-content-for-elementor' ),
						'description' => __( 'The currency of this transaction.', 'dynamic-content-for-elementor' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => $currencies_options,
						'default' => 'USD',
						'label_block' => 'true',
						'tab' => 'content',
						'inner_tab' => 'form_fields_content_tab',
						'tabs_wrapper' => 'form_fields_tabs',
						'condition' => [
							'field_type' => $this->get_type(),
						],
					],

					'dce_form_stripe_item_value' => [
						'name' => 'dce_form_stripe_item_value',
						'label' => __( 'Transaction Amount', 'dynamic-content-for-elementor' ),
						'description' => __( 'Amount intended to be collected by this transaction in the currency unit.', 'dynamic-content-for-elementor' ),
						'label_block' => true,
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => '10.99',
						'tab' => 'content',
						'inner_tab' => 'form_fields_content_tab',
						'tabs_wrapper' => 'form_fields_tabs',
						'dynamic' => [
							'active' => true,
						],
						'condition' => [
							'field_type' => $this->get_type(),
						],
					],

					'dce_form_stripe_item_description' => [
						'name' => 'dce_form_stripe_item_description',
						'label' => __( 'Item Description', 'dynamic-content-for-elementor' ),
						'type' => \Elementor\Controls_Manager::TEXTAREA,
						'placeholder' => __( 'Item Description', 'dynamic-content-for-elementor' ),
						'label_block' => 'true',
						'default' => '',
						'tab' => 'content',
						'inner_tab' => 'form_fields_content_tab',
						'tabs_wrapper' => 'form_fields_tabs',
						'dynamic' => [
							'active' => 1,
						],
						'condition' => [
							'field_type' => $this->get_type(),
						],
					],

					'dce_form_stripe_item_sku' => [
						'name' => 'dce_form_stripe_item_sku',
						'label' => __( 'Item SKU', 'dynamic-content-for-elementor' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( 'Item SKU', 'dynamic-content-for-elementor' ),
						'label_block' => 'true',
						'default' => '',
						'tab' => 'content',
						'inner_tab' => 'form_fields_content_tab',
						'tabs_wrapper' => 'form_fields_tabs',
						'dynamic' => [
							'active' => 1,
						],
						'condition' => [
							'field_type' => $this->get_type(),
						],
					],
				];
			}
			$control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );
			$widget->update_control( 'form_fields', $control_data );
		}


		/** Example: 10, USD will return 1000. 10, YEN will return 10. */
		private static function get_amount_in_currency_smallest_unit( float $amount, string $currency_code ) {
			$iso4217 = new \Payum\ISO4217\ISO4217();
			$currency = $iso4217->findByAlpha3( $currency_code );
			$exponent = $currency->getExp();
			return intval( $amount * pow( 10, $exponent ) );
		}

		public function render( $item, $item_index, $form ) {
			if ( get_option( 'dce_stripe_api_mode' ) === 'live' ) {
				$stripe_key = get_option( 'dce_stripe_api_publishable_key_live' );
			} else {
				$stripe_key = get_option( 'dce_stripe_api_publishable_key_test' );
			}
			wp_add_inline_script( 'dce-stripe', 'dceStripePublishableKey = "' . addslashes( $stripe_key ) . '";', 'before' );
			$form->add_render_attribute( 'input' . $item_index, 'type', 'hidden', true );
			$amount = self::get_amount_in_currency_smallest_unit( $item['dce_form_stripe_item_value'], $item['dce_form_stripe_currency'] );
			try {
				$intent = \Stripe\PaymentIntent::create([
					'amount' => $amount,
					'currency' => $item['dce_form_stripe_currency'],
					'confirmation_method' => 'automatic',
					'confirm' => false,
					'capture_method' => 'manual',
					'description' => $item['dce_form_stripe_item_description'],
					'metadata' => [
						'dce_id' => $form->get_id() . '-' . $item['custom_id'],
						'sku' => $item['dce_form_stripe_item_sku'],
					],
				]);
			} catch ( \Stripe\Exception\AuthenticationException $e ) {
				echo '<span class="error">' . __( 'Stripe authethication error. Did you provide the right keys?', 'dynamic-content-for-elementor' ) . '</span>';
				return;
			}
			$form->add_render_attribute( 'dce_stripe' . $item_index, 'data-cs', esc_attr( $intent->client_secret ), true );
			$form->add_render_attribute( 'dce_stripe' . $item_index, 'data-required', $item['required'] ? 'true' : 'false', true );
			$form->add_render_attribute( 'dce_stripe' . $item_index, 'style', 'padding-top: 10px;', true );
			$form->add_render_attribute( 'dce_stripe' . $item_index, 'class', 'elementor-field elementor-field-textual dce-stripe-elements', true );
			echo '<input ' . $form->get_render_attribute_string( 'input' . $item_index ) . '>';
			echo '<span class="stripe-error elementor-message elementor-message-danger elementor-help-inline elementor-form-help-inline" role="alert" style="display: none;"></span>';
			echo '<div ' . $form->get_render_attribute_string( 'dce_stripe' . $item_index ) . '></div>';
		}

		public function process_field( $field, Classes\Form_Record $record, Classes\Ajax_Handler $ajax_handler ) {
			$error_msg = __( 'There was an error while completing the payment, please try again later or contact the merchant directly.', 'dynamic-content-for-elementor' );
			$id = $field['id'];
			$intent_id = $field['value'];
			if ( empty( $intent_id ) ) {
				// Value is not allowed to be empty when field is required. So
				// if empty then the field is not required and no validation is
				// needed.
				return;
			}
			if ( isset( self::$validated_intents[ $intent_id ] ) ) {
				return; // good, already validated.
			}
			try {
				$intent = \Stripe\PaymentIntent::retrieve( $intent_id );
				$dce_id_expected = $record->get_form_settings( 'id' ) . '-' . $id;
				// we make sure the payment intent was created by this stripe
				// field and not elsewhere:
				if ( $intent->metadata['dce_id'] !== $dce_id_expected ) {
					$ajax_handler->add_error( $id, $error_msg );
					return;
				}
				$intent->capture();
				if ( 'succeeded' !== $intent->status ) {
					$ajax_handler->add_error( $id, $error_msg );
				} else {
					self::$validated_intents[ $intent_id ] = true;
				}
			} catch ( \Stripe\Exception\InvalidRequestException $e ) {
				$ajax_handler->add_error( $id, $error_msg );
			}
		}
	}
}
