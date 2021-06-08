<?php

namespace DynamicContentForElementor\Extensions;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use DynamicContentForElementor\Helper;
use DynamicContentForElementor\Tokens;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function _dce_extension_form_amount( $field ) {
	switch ( $field ) {
		case 'docs':
			return 'https://www.dynamic.ooo/widget/amount-elementor-pro-form/';
		case 'description':
			return __( 'Add Amount Field to Elementor PRO Form', 'dynamic-content-for-elementor' );
	}
}

if ( ! Helper::is_elementorpro_active() ) {

	class DCE_Extension_Form_Amount extends DCE_Extension_Prototype {

		public $name = 'Amount Field for Elementor Pro Form';
		private $is_common = false;
		public static $depended_plugins = [ 'elementor-pro' ];

		public static function get_description() {
			return _dce_extension_form_amount( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_amount( 'docs' );
		}

	}

} else {

	class DCE_Extension_Form_Amount extends DCE_Extension_Prototype {

		public $name = 'Amount Field for Elementor Pro Form';
		public static $depended_plugins = [ 'elementor-pro' ];
		public static $docs = 'https://www.dynamic.ooo/widget/amount-elementor-pro-form/';
		private $is_common = false;
		public $has_action = false;

		public static function get_description() {
			return _dce_extension_form_amount( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_amount( 'docs' );
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
			return 'dce_form_amount';
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
			return __( 'Form Amount', 'dynamic-content-for-elementor' );
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
			add_action( 'elementor/element/form/section_form_style/after_section_end', [ $this, 'add_control_section_to_form' ], 10, 2 );
			add_action('elementor/widget/print_template', function( $template, $widget ) {
				if ( 'form' === $widget->get_name() ) {
					$template = false;
				}
				return $template;
			}, 10, 2);
		}

		public function add_control_section_to_form( $element, $args ) {

			$element->start_controls_section(
					'dce_amount_section_style',
					[
						'label' => __( 'Amount', 'dynamic-content-for-elementor' ),
						'tab' => \Elementor\Controls_Manager::TAB_STYLE,
					]
			);
			$element->add_control(
					'dce_amount_heading_input',
					[
						'label' => __( 'Input', 'dynamic-content-for-elementor' ),
						'type' => Controls_Manager::HEADING,
					]
			);
			$element->add_responsive_control(
					'dce_amount_align',
					[
						'label' => __( 'Alignment', 'dynamic-content-for-elementor' ),
						'type' => Controls_Manager::CHOOSE,
						'options' => [
							'left' => [
								'title' => __( 'Left', 'dynamic-content-for-elementor' ),
								'icon' => 'fa fa-align-left',
							],
							'center' => [
								'title' => __( 'Center', 'dynamic-content-for-elementor' ),
								'icon' => 'fa fa-align-center',
							],
							'right' => [
								'title' => __( 'Right', 'dynamic-content-for-elementor' ),
								'icon' => 'fa fa-align-right',
							],
						],
						'selectors' => [
							'{{WRAPPER}} .elementor-field-type-amount.elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper)' => 'text-align: {{VALUE}};',
						],
					]
			);
			$element->add_responsive_control(
					'dce_amount_opacity', [
						'label' => __( 'Opacity (%)', 'dynamic-content-for-elementor' ),
						'type' => Controls_Manager::SLIDER,
						'default' => [
							'size' => 1,
						],
						'range' => [
							'px' => [
								'max' => 1,
								'min' => 0.10,
								'step' => 0.01,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .elementor-field-type-amount.elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper)' => 'opacity: {{SIZE}};',
						],
					]
			);
			$element->add_responsive_control(
					'dce_amount_padding', [
						'label' => __( 'Padding', 'dynamic-content-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .elementor-field-type-amount.elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
			);
			$element->add_responsive_control(
					'dce_amount_margin', [
						'label' => __( 'Margin', 'dynamic-content-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .elementor-field-type-amount.elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
			);

			$element->add_control(
					'dce_amount_color',
					[
						'label' => __( 'Color', 'dynamic-content-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-field-type-amount.elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper)' => 'color: {{VALUE}};',
						],
					]
			);
			$element->add_group_control(
					Group_Control_Typography::get_type(), [
						'name' => 'dce_amount_typography',
						'label' => __( 'Typography', 'dynamic-content-for-elementor' ),
						'selector' => '{{WRAPPER}} .elementor-field-type-amount.elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper)',
					]
			);
			$element->add_responsive_control(
					'dce_amount_position',
					[
						'label' => __( 'Position', 'dynamic-content-for-elementor' ),
						'type' => Controls_Manager::CHOOSE,
						'options' => [
							'row-reverse' => [
								'title' => __( 'Left', 'dynamic-content-for-elementor' ),
								'icon' => 'fa fa-align-left',
							],
							'row' => [
								'title' => __( 'Right', 'dynamic-content-for-elementor' ),
								'icon' => 'fa fa-align-right',
							],
						],
						'default' => 'row',
						'selectors' => [
							'{{WRAPPER}} .elementor-field-group.elementor-field-type-amount' => 'flex-direction: {{VALUE}};',
						],
					]
			);

			$element->add_control(
					'dce_amount_space',
					[
						'label' => __( 'Width', 'dynamic-content-for-elementor' ),
						'type' => Controls_Manager::SLIDER,
						'default' => [
							'size' => 100,
						],
						'range' => [
							'%' => [
								'min' => 20,
								'max' => 100,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .elementor-field-type-amount.elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper)' => 'flex-basis: {{SIZE}}%; max-width: {{SIZE}}%;',
						],
					]
			);

			// Border ----------------
			$element->add_group_control(
					Group_Control_Border::get_type(), [
						'name' => 'dce_amount_border',
						'label' => __( 'Border', 'dynamic-content-for-elementor' ),
						'selector' => '{{WRAPPER}} .elementor-field-type-amount.elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper)',
					]
			);
			$element->add_control(
					'dce_amount_border_radius', [
						'label' => __( 'Border Radius', 'dynamic-content-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%' ],
						'selectors' => [
							'{{WRAPPER}} .elementor-field-type-amount.elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
			);

			// Background ----------------
			$element->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name' => 'dce_amount_background',
						'types' => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .elementor-field-type-amount.elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper)',
					]
			);

			// Title ----------------
			$element->add_control(
					'dce_amount_heading_title',
					[
						'label' => __( 'Label', 'dynamic-content-for-elementor' ),
						'type' => Controls_Manager::HEADING,
						'separator' => 'before',
					]
			);
			$element->add_responsive_control(
					'dce_amount_title_align',
					[
						'label' => __( 'Alignment', 'dynamic-content-for-elementor' ),
						'type' => Controls_Manager::CHOOSE,
						'options' => [
							'left' => [
								'title' => __( 'Left', 'dynamic-content-for-elementor' ),
								'icon' => 'fa fa-align-left',
							],
							'center' => [
								'title' => __( 'Center', 'dynamic-content-for-elementor' ),
								'icon' => 'fa fa-align-center',
							],
							'right' => [
								'title' => __( 'Right', 'dynamic-content-for-elementor' ),
								'icon' => 'fa fa-align-right',
							],
						],
						'selectors' => [
							'{{WRAPPER}} .elementor-field-group.elementor-field-type-amount > label.elementor-field-label' => 'width: 100%; text-align: {{VALUE}};',
						],
					]
			);
			$element->add_control(
					'dce_amount_title_color',
					[
						'label' => __( 'Color', 'dynamic-content-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-field-group.elementor-field-type-amount > label.elementor-field-label' => 'color: {{VALUE}};',
						],
					]
			);
			$element->add_group_control(
					Group_Control_Typography::get_type(), [
						'name' => 'dce_amount_title_typography',
						'label' => __( 'Typography', 'dynamic-content-for-elementor' ),
						'selector' => '{{WRAPPER}} .elementor-field-group.elementor-field-type-amount > label.elementor-field-label',
					]
			);
			$element->add_group_control(
					Group_Control_Text_Shadow::get_type(),
					[
						'name' => 'dce_amount_text_shadow',
						'selector' => '{{WRAPPER}} .elementor-field-group.elementor-field-type-amount > label.elementor-field-label',
					]
			);

			$element->end_controls_section();
		}

		public static function _add_to_form( Controls_Stack $element, $control_id, $control_data, $options = [] ) {
			if ( is_admin() && ! current_user_can( 'manage_options' ) ) {
				return $control_data;
			}
			if ( $element->get_name() == 'form' ) {

				if ( $control_id == 'form_fields' ) {
					$control_data['fields']['field_type']['options']['amount'] = __( 'Amount', 'dynamic-content-for-elementor' );

					if ( $control_id == 'form_fields' ) {
						$control_data['fields']['dce_amount_expression'] = array(
							'name' => 'dce_amount_expression',
							'label' => __( 'Amount Expression', 'dynamic-content-for-elementor' ),
							'type' => Controls_Manager::TEXT,
							'placeholder' => __( '[form:field_1] * [form:field_2] + 1.4', 'dynamic-content-for-elementor' ),
							'label_block' => true,
							'conditions' => [
								'terms' => [
									[
										'name' => 'field_type',
										'value' => 'amount',
									],
								],
							],
							'tabs_wrapper' => 'form_fields_tabs',
							'tab' => 'content',
							'inner_tab' => 'form_fields_content_tab',
						);

						$control_data['fields']['dce_amount_hide'] = array(
							'name' => 'dce_amount_hide',
							'label' => __( 'Hide Amount', 'dynamic-content-for-elementor' ),
							'type' => Controls_Manager::SWITCHER,
							'description' => __( 'Do not display Amount value in frontend form, use its value only in Actions (like Email)', 'dynamic-content-for-elementor' ),
							'conditions' => [
								'terms' => [
									[
										'name' => 'field_type',
										'value' => 'amount',
									],
								],
							],
							'tabs_wrapper' => 'form_fields_tabs',
							'tab' => 'content',
							'inner_tab' => 'form_fields_content_tab',
						);
					}
				}
				if ( $control_id == '' ) {

				}
			}

			return $control_data;
		}

		public function _render_form( $content, $widget ) {
			$new_content = $content;
			if ( $widget->get_name() == 'form' ) {
				$settings = $widget->get_settings_for_display();

				// FIELDS
				$fields = $form_fields = array();
				if ( ! empty( $settings['form_fields'] ) ) {
					foreach ( $settings['form_fields'] as $key => $afield ) {
						$form_fields[ $afield['custom_id'] ] = $afield;
						if ( $afield['field_type'] == 'amount' ) {
							$fields[] = $afield;
							$field_class = 'elementor-field-group-' . $afield['custom_id'];
							$pieces = explode( $field_class, $new_content, 2 );
							if ( count( $pieces ) > 1 ) {
								$tmp = explode( '</div>', end( $pieces ), 2 );
								if ( count( $tmp ) > 1 ) {
									$amount_field = '<input value="0" type="hidden" name="form_fields[' . $afield['custom_id'] . ']" id="dce-form-field-' . $afield['custom_id'] . '">';
									if ( empty( $afield['dce_amount_hide'] ) ) {
										$amount_field .= '<input class="elementor-field" value="0" type="text" name="form_fields[dce-' . $afield['custom_id'] . ']" id="form-field-' . $afield['custom_id'] . '" disabled>';
									}
									$new_content = reset( $pieces ) . $field_class . reset( $tmp ) . $amount_field . '</div>' . end( $tmp );
									if ( ! empty( $afield['dce_amount_hide'] ) ) {
										$new_content = str_replace( $field_class, $field_class . ' elementor-field-type-hidden', $new_content );
									}
								}
							}
						}
					}
				}

				if ( ! empty( $fields ) ) {
					$has_amount = false;
					// add custom js
					$fields = array();
					$jkey = 'dce_' . $widget->get_type() . '_form_' . $widget->get_id() . '_amount';
					ob_start();
					?>
					<script id="<?php echo $jkey; ?>">
						(function ($) {
					<?php if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
								var <?php echo $jkey; ?> = function ($scope, $) {
									if ($scope.hasClass("elementor-element-<?php echo $widget->get_id(); ?>")) {
						<?php
					}
					if ( ! empty( $settings['form_fields'] ) ) {
						foreach ( $settings['form_fields'] as $key => $afield ) {
							if ( $afield['field_type'] == 'amount' ) {
								$has_amount = true;
								$js_expression = $afield['dce_amount_expression'];
								$fields_name = array();

								$pieces = explode( '[field id=', $js_expression );
								foreach ( $pieces as $apiece ) {
									$tmp = explode( ']', $apiece, 2 );
									if ( count( $tmp ) > 1 ) {
										$field_name = reset( $tmp );
										$field_name = trim( str_replace( '"', '', $field_name ) );
										$js_expression = str_replace( '[field id=' . $field_name . ']', '[form:' . $field_name . ']', $js_expression );
										$js_expression = str_replace( '[field id="' . $field_name . '"]', '[form:' . $field_name . ']', $js_expression );
									}
								}

								$pieces = explode( '[form:', $js_expression );
								foreach ( $pieces as $apiece ) {
									$tmp = explode( ']', $apiece, 2 );
									if ( count( $tmp ) > 1 ) {
										$field_name = reset( $tmp );
										if ( isset( $form_fields[ $field_name ] ) ) {
											$field_input_name = '.elementor-element-' . $widget->get_id() . ' .elementor-field-group-' . $field_name . ' ';
											if ( $form_fields[ $field_name ]['field_type'] == 'select' ) {
												$field_input_name .= 'select';
											} else {
												$field_input_name .= 'input';
											}
											$fields_name[] = $exp_field_input_name = $field_input_name;
											if ( $form_fields[ $field_name ]['field_type'] == 'radio' ) {
												$exp_field_input_name .= ':checked';
											}
											switch ( $form_fields[ $field_name ]['field_type'] ) {
												case 'acceptance':
													$field_expression = '( (jQuery("' . $exp_field_input_name . '").prop("checked") && !jQuery("' . $exp_field_input_name . '").prop("disabled")) ? 1 : 0 )';
													break;
												case 'checkbox':
													$options = Helper::options_array( $form_fields[ $field_name ]['field_options'] );
													$field_expression = '';
													if ( empty( $options ) ) {
														$field_expression = '0';
													} else {
														foreach ( $options as $okey => $ovalue ) {
															if ( $okey ) {
																$field_expression .= '+';
															} else {
																$field_expression .= '(';
															}
															$field_expression .= '( ( jQuery("' . $exp_field_input_name . '[id=form-field-' . $form_fields[ $field_name ]['custom_id'] . '-' . $okey . ']").prop("checked") && !jQuery("' . $exp_field_input_name . '[id=form-field-' . $form_fields[ $field_name ]['custom_id'] . '-' . $okey . ']").prop("disabled") ) ? parseFloat(jQuery("' . $exp_field_input_name . '[id=form-field-' . $form_fields[ $field_name ]['custom_id'] . '-' . $okey . ']").val())||0 : 0 )';
														}
														$field_expression .= ')';
													}
													break;
												default:
													$field_expression = '( parseFloat(jQuery("' . $exp_field_input_name . '").val())||0 )';
													$field_expression = '( jQuery("' . $exp_field_input_name . '").prop("disabled") ? 0 : ' . $field_expression . ' )';
											}
										} else {
											$field_expression = '0';
										}
										$js_expression = str_replace( '[form:' . $field_name . ']', $field_expression, $js_expression );
										$js_expression = str_replace( '[field id=' . $field_name . ']', $field_expression, $js_expression );
										$js_expression = str_replace( '[field id="' . $field_name . '"]', $field_expression, $js_expression );
									}
								}
								if ( ! empty( $fields_name ) ) {
									?>
													jQuery('<?php echo implode( ', ', $fields_name ); ?>').on('change', function () {
														setTimeout(function () {
															jQuery('.elementor-element-<?php echo $widget->get_id(); ?> #form-field-<?php echo $afield['custom_id']; ?>, .elementor-element-<?php echo $widget->get_id(); ?> #dce-form-field-<?php echo $afield['custom_id']; ?>').val(<?php echo $js_expression; ?>);
															jQuery('.elementor-element-<?php echo $widget->get_id(); ?> #form-field-<?php echo $afield['custom_id']; ?>').trigger('change');
														}, 100);
													});
													jQuery('<?php echo reset( $fields_name ); ?>').trigger('change');




									<?php
								}
							}
						}
					}
					if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
						?>
									}
								};
								$(window).on("elementor/frontend/init", function () {
									elementorFrontend.hooks.addAction("frontend/element_ready/form.default", <?php echo $jkey; ?>);
								});
					<?php } ?>
						})(jQuery, window);
					</script>
					<?php
					$js = ob_get_clean();

					if ( $has_amount ) {
						$js = \DynamicContentForElementor\Assets::dce_enqueue_script( $jkey, $js );
						$new_content .= $js;
					}
				}
			}

			return $new_content;
		}

	}

}
