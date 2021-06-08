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

function _dce_extension_form_icons( $field ) {
	switch ( $field ) {
		case 'docs':
			return 'https://www.dynamic.ooo/widget/icons-for-elementor-pro-form/';
		case 'description':
			return __( 'Add icons on the label or inside the input of form fields.', 'dynamic-content-for-elementor' );
	}
}

if ( ! Helper::is_elementorpro_active() ) {

	class DCE_Extension_Form_Icons extends DCE_Extension_Prototype {

		public $name = 'Icons for Elementor Pro Form';
		private $is_common = false;
		public static $depended_plugins = [ 'elementor-pro' ];

		public static function get_description() {
			return _dce_extension_form_icons( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_icons( 'docs' );
		}

	}

} else {

	class DCE_Extension_Form_Icons extends DCE_Extension_Prototype {

		public $name = 'Icons for Elementor Pro Form';
		public static $depended_plugins = [ 'elementor-pro' ];
		public static $docs = 'https://www.dynamic.ooo/';
		private $is_common = false;
		public $has_action = false;

		public static function get_description() {
			return _dce_extension_form_icons( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_icons( 'docs' );
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
			return 'dce_form_icons';
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
			return __( 'icons', 'dynamic-content-for-elementor' );
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

				// Using the reader to dynamically get the icons array. It's resource intensive and you must cache the result.
				$css_path = ELEMENTOR_ASSETS_PATH . 'lib/font-awesome/css/fontawesome.css';
				$icons_fa = new \Awps\FontAwesomeReader( $css_path );

				$add_css = '<style>';
				$jkey = 'dce_' . $widget->get_type() . '_form_' . $widget->get_id() . '_icon';
				ob_start();
				?>
				<script id="<?php echo $jkey; ?>">
					(function ($) {
				<?php if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
							var <?php echo $jkey; ?> = function ($scope, $) {
								if ($scope.hasClass("elementor-element-<?php echo $widget->get_id(); ?>")) {
					<?php
				}
				$has_icon = false;
				foreach ( $settings['form_fields'] as $key => $afield ) {
					if ( ! empty( $afield['field_icon'] ) ) {
						wp_enqueue_style( 'fontawesome' );
						$fa_classes = explode( ' ', $afield['field_icon']['value'] );
						$fa_family = reset( $fa_classes );
						$fa_class = end( $fa_classes );
						$fa_family_name = 'Font Awesome 5 Free';
						$fa_weight = 400;
						$fa_unicode = $icons_fa->getIconUnicode( $fa_class );
						switch ( $fa_family ) {
							case 'far':
								break;
							case 'fas':
								$fa_weight = 900;
								break;
							case 'fab':
								$fa_family_name = 'Font Awesome 5 Brands';
								break;
							default:
								$fa_unicode = $icons_fa->getIconUnicode( $fa_class );
						}
						$has_icon = true;
						if ( $afield['field_icon_position'] == 'elementor-field-label' ) {
							$add_css .= '.elementor-element-' . $widget->get_id() . ' .elementor-field-group-' . $afield['custom_id'] . " .elementor-field-label:before { content: '" . $fa_unicode . "'; font-family: FontAwesome, \"" . $fa_family_name . '"; font-weight: ' . $fa_weight . '; margin-right: 5px; }';
						}
						if ( $afield['field_icon_position'] == 'elementor-field' ) {
							echo "jQuery('.elementor-element-" . $widget->get_id() . ' #form-field-' . $afield['custom_id'] . "').wrap('<div class=\"elementor-field-input-wrapper elementor-field-input-wrapper-" . $afield['custom_id'] . "\"></div>');";
							switch ( $afield['field_type'] ) {
								case 'textarea':
									$add_css .= '.elementor-element-' . $widget->get_id() . ' .elementor-field-input-wrapper-' . $afield['custom_id'] . ":after { content: '" . $fa_unicode . "'; font-family: FontAwesome, \"" . $fa_family_name . '"; font-weight: ' . $fa_weight . '; position: absolute; top: 5px; left: 16px; }';
									break;
								default:
									$add_css .= '.elementor-element-' . $widget->get_id() . ' .elementor-field-input-wrapper-' . $afield['custom_id'] . ":after { content: '" . $fa_unicode . "'; font-family: FontAwesome, \"" . $fa_family_name . '"; font-weight: ' . $fa_weight . '; position: absolute; top: 50%; transform: translateY(-50%); left: 16px; }';
							}
							$add_css .= '.elementor-element-' . $widget->get_id() . ' #form-field-' . $afield['custom_id'] . ', .elementor-element-' . $widget->get_id() . ' .elementor-field-group-' . $afield['custom_id'] . ' .elementor-field-textual { padding-left: 42px; }';
						}
					}
				}
				$add_css .= '</style>';
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
				$add_js = ob_get_clean();
				if ( $has_icon ) {
					$add_js = \DynamicContentForElementor\Assets::dce_enqueue_script( $jkey, $add_js );
					return $content . $add_css . $add_js;
				}
			}
			return $content;
		}


		public static function _add_to_form( Controls_Stack $element, $control_id, $control_data, $options = [] ) {

			if ( $element->get_name() == 'form' ) {

				if ( $control_id == 'form_fields' ) {
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
					$control_data['fields']['field_icon_position'] = array(
						'name' => 'field_icon_position',
						'label' => __( 'Icon', 'dynamic-content-for-elementor' ),
						'separator' => 'before',
						'type' => Controls_Manager::CHOOSE,
						'options' => [
							'no-icon' => [
								'title' => __( 'No Icon', 'dynamic-content-for-elementor' ),
								'icon' => 'fa fa-times',
							],
							'elementor-field-label' => [
								'title' => __( 'On Label', 'dynamic-content-for-elementor' ),
								'icon' => 'fa fa-tag',
							],
							'elementor-field' => [
								'title' => __( 'On Input', 'dynamic-content-for-elementor' ),
								'icon' => 'fa fa-square-o',
							],
						],
						'toggle' => false,
						'default' => 'no-icon',
						'tabs_wrapper' => 'form_fields_tabs',
						'inner_tab' => 'form_fields_enchanted_tab',
						'tab' => 'enchanted',
					);
					$control_data['fields']['field_icon'] = array(
						'name' => 'field_icon',
						'label' => __( 'Select Icon', 'elementor' ),
						'type' => Controls_Manager::ICONS,
						'label_block' => true,
						'condition' => [
							'field_icon_position!' => 'no-icon',
						],
						'tabs_wrapper' => 'form_fields_tabs',
						'inner_tab' => 'form_fields_enchanted_tab',
						'tab' => 'enchanted',
					);
				}

				if ( $control_id == 'field_background_color' ) {
					$element->add_control(
					  'field_icon_color',
					  [
						  'label' => __( 'Icon Color', 'elementor-pro' ),
						  'type' => Controls_Manager::COLOR,
						  'selectors' => [
							  '{{WRAPPER}} .elementor-field-input-wrapper:after' => 'color: {{VALUE}};',
						  ],
						  'separator' => 'before',
					  ]
					);
				}
				if ( $control_id == 'mark_required_color' ) {
					$element->add_control(
					  'label_icon_color',
					  [
						  'label' => __( 'Icon Color', 'elementor-pro' ),
						  'type' => Controls_Manager::COLOR,
						  'selectors' => [
							  '{{WRAPPER}} .elementor-field-label:before' => 'color: {{VALUE}};',
						  ],
					  ]
					);
				}
			}

			return $control_data;
		}

	}

}
