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

function _dce_extension_form_submit_on_change( $field ) {
	switch ( $field ) {
		case 'docs':
			return 'https://www.dynamic.ooo/widget/submit-on-change-for-elementor-pro-form/';
		case 'description':
			return __( 'Submit the form automatically when your user choose a radiobutton or a select field.', 'dynamic-content-for-elementor' );
	}
}

if ( ! Helper::is_elementorpro_active() ) {

	class DCE_Extension_Form_Submit_On_Change extends DCE_Extension_Prototype {

		public $name = 'Submit On Change for Elementor Pro Form';
		private $is_common = false;
		public static $depended_plugins = [ 'elementor-pro' ];

		public static function get_description() {
			return _dce_extension_form_submit_on_change( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_submit_on_change( 'docs' );
		}

	}

} else {

	class DCE_Extension_Form_Submit_On_Change extends DCE_Extension_Prototype {

		public $name = 'Submit On Change for Elementor Pro Form';
		public static $depended_plugins = [ 'elementor-pro' ];
		public static $docs = 'https://www.dynamic.ooo/';
		private $is_common = false;
		public $has_action = false;

		public static function get_description() {
			return _dce_extension_form_submit_on_change( 'description' );
		}

		public function get_docs() {
			return _dce_extension_form_submit_on_change( 'docs' );
		}

		public static function get_plugin_depends() {
			return self::$depended_plugins;
		}

		public static function get_satisfy_dependencies( $ret = false ) {
			return true;
		}

		public function get_name() {
			return 'dce_form_onchange';
		}

		public function get_label() {
			return __( 'Onchange', 'dynamic-content-for-elementor' );
		}

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

				$jkey = 'dce_' . $widget->get_type() . '_form_' . $widget->get_id() . '_onchange';
				ob_start();
				?>
			  <script id="<?php echo $jkey; ?>">
				  (function ($) {
				<?php if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
						  var <?php echo $jkey; ?> = function ($scope, $) {
							  if ($scope.hasClass("elementor-element-<?php echo $widget->get_id(); ?>")) {
					<?php
				}
				$has_onchange = false;
				foreach ( $settings['form_fields'] as $key => $afield ) {
					if ( ! empty( $afield['field_onchange'] ) ) {
						$has_onchange = true;
						?>
					  jQuery('.elementor-element-<?php echo $widget->get_id(); ?> .elementor-field-group-<?php echo $afield['custom_id']; ?> input, .elementor-element-<?php echo $widget->get_id(); ?> .elementor-field-group-<?php echo $afield['custom_id']; ?> select').on('change', function () {
						  var field = jQuery(this).closest('.elementor-field-group');
						  if (field.siblings('.dce-form-step-bnt-next').length) {
							  // step
							  field.siblings('.dce-form-step-bnt-next').find('button').trigger('click');
						  } else {
							  // submit
							  jQuery(this).closest('form').find('.elementor-field-type-submit button').trigger('click');
						  }
					  });
						<?php
					}
				}
				?>
							  jQuery('.elementor-element-<?php echo $widget->get_id(); ?> .select2-selection__arrow').remove();
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
				if ( $has_onchange ) {

					$add_js = \DynamicContentForElementor\Assets::dce_enqueue_script( $jkey, $add_js );

					return $content . $add_js;
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
				$control_data['fields']['field_onchange'] = array(
					'name' => 'field_onchange',
					'label' => __( 'Submit on Change', 'dynamic-content-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'separator' => 'before',
					'condition' => [
						'field_type' => [ 'radio', 'select' ],
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
