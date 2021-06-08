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

function _dce_extension_form_method( $field ) {
	switch ( $field ) {
		case 'docs':
			return 'https://www.dynamic.ooo/widget/method-for-elementor-pro-form/';
		case 'description':
			return __( 'Add a different method attribute on your forms that specifies how to send form-data.', 'dynamic-content-for-elementor' );
	}
}

if ( ! Helper::is_elementorpro_active() ) {

	class DCE_Extension_Form_Method extends DCE_Extension_Prototype {

		public $name = 'Method for Elementor Pro Form';
		private $is_common = false;
		public static $depended_plugins = [ 'elementor-pro' ];

		public static function get_description() {
			return _dce_extension_form_method( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_method( 'docs' );
		}

	}

} else {

	class DCE_Extension_Form_Method extends DCE_Extension_Prototype {

		public $name = 'Method for Elementor Pro Form';
		public static $depended_plugins = [ 'elementor-pro' ];
		public static $docs = 'https://www.dynamic.ooo/';
		private $is_common = false;
		public $has_action = false;

		public static function get_description() {
			return _dce_extension_form_method( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_method( 'docs' );
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
			return 'dce_form_method';
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
			return __( 'Method', 'dynamic-content-for-elementor' );
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

				if ( ! empty( $settings['form_method'] ) && $settings['form_method'] != 'ajax' ) {

					foreach ( $settings['form_fields'] as $key => $afield ) {
						$content = str_replace( 'form_fields[' . $afield['custom_id'] . ']', $afield['custom_id'], $content );
					}

					if ( $settings['form_method'] == 'get' ) {
						$content = str_replace( 'method="post"', 'method="' . $settings['form_method'] . '"', $content );
					}
					if ( ! empty( $settings['form_action']['url'] ) ) {
						$content = str_replace( '<form ', '<form action="' . $settings['form_action']['url'] . '" ', $content );
					} else {
						$content = str_replace( '<form ', '<form action="" ', $content ); // current page
					}

					if ( $settings['form_action']['custom_attributes'] ) {
						$attr_str = '';
						$attrs = Helper::str_to_array( ',', $settings['form_action']['custom_attributes'] );
						if ( ! empty( $attrs ) ) {
							foreach ( $attrs as $anattr ) {
								list($attr, $value) = explode( '|', $anattr, 2 );
								$attr_str .= $attr . '="' . $value . '" ';
							}
						}
						if ( $attr_str ) {
							$content = str_replace( '<form ', '<form ' . $attr_str, $content );
						}
					}

					if ( ! empty( $settings['form_action']['is_external'] ) ) {
						$content = str_replace( '<form ', '<form target="_blank" ', $content );
					}
					if ( ! empty( $settings['form_action']['nofollow'] ) ) {
						$content = str_replace( '<form ', '<form rel="nofollow" ', $content );
					}

					$jkey = 'dce_' . $widget->get_type() . '_form_' . $widget->get_id() . '_action';
					ob_start();
					?>
				  <script id="<?php echo $jkey; ?>">
					  (function ($) {
					<?php if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
							  var <?php echo $jkey; ?> = function ($scope, $) {
								  if ($scope.hasClass("elementor-element-<?php echo $widget->get_id(); ?>")) {
				  <?php } ?>
								  jQuery('.elementor-element-<?php echo $widget->get_id(); ?> .elementor-form').off();
					<?php if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
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

					$add_js = \DynamicContentForElementor\Assets::dce_enqueue_script( $jkey, $add_js );
					return $content . $add_js;
				}
			}
			return $content;
		}

		public static function _add_to_form( Controls_Stack $element, $control_id, $control_data, $options = [] ) {

			if ( $element->get_name() == 'form' && $control_id == 'form_id' ) {
				$element->add_control(
				'form_method',
				  [
					  'label' => '<span class="color-dce icon icon-dyn-logo-dce"></span> ' . __( 'Method', 'dynamic-content-for-elementor' ),
					  'type' => Controls_Manager::CHOOSE,
					  'options' => [
						  'ajax' => [
							  'title' => __( 'AJAX (Default)', 'dynamic-content-for-elementor' ),
							  'icon' => 'fa fa-retweet',
						  ],
						  'post' => [
							  'title' => 'POST',
							  'icon' => 'fa fa-cog',
						  ],
						  'get' => [
							  'title' => 'GET',
							  'icon' => 'fa fa-link',
						  ],
					  ],
					  'toggle' => false,
					  'default' => 'ajax',
				  ]
				);
				$element->add_control(
				'form_action',
				[
					'label' => __( 'Action', 'elementor-pro' ),
					'type' => Controls_Manager::URL,
					'condition' => [
						'form_method!' => 'ajax',
					],
				]
				);
				$element->add_control(
				'form_action_hide',
				[
					'type' => Controls_Manager::RAW_HTML,
					'label' => __( 'WARNING', 'dynamic-content-for-elementor' ),
					'raw' => __( 'All configured Ajax "Actions After Submit" here above will not works!', 'dynamic-content-for-elementor' ),
					'condition' => [
						'form_method!' => 'ajax',
					],
				]
				);

				$control_data['separator'] = 'before';
			}

			return $control_data;
		}

	}

}
