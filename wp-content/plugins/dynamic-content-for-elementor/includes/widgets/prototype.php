<?php
namespace DynamicContentForElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Utils;
use Elementor\Repeater;

use DynamicContentForElementor\Widgets;
use DynamicContentForElementor\Helper;
use DynamicContentForElementor\Group_Control_Outline;
use DynamicContentForElementor\Controls\DCE_Group_Control_Filters_CSS;
use DynamicContentForElementor\Controls\DCE_Group_Control_Transform_Element;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * DCE_Widget_Prototype Base widget class
 *
 * Base class for Dynamic Content for Elementor
 *
 * @since 0.4.0
 */

class DCE_Widget_Prototype extends Widget_Base {


	/**
	 * Settings.
	 *
	 * Holds the object settings.
	 *
	 * @access public
	 *
	 * @var array
	 */
	public $settings;

	/**
	 * Raw Data.
	 *
	 * Holds all the raw data including the element type, the child elements,
	 * the user data.
	 *
	 * @access public
	 *
	 * @var null|array
	 */
	public $data;

	public $docs = 'https://www.dynamic.ooo';

	public function get_name() {
		return 'dce-prototype';
	}

	public function get_title() {
		return __( 'Prototype', 'dynamic-content-for-elementor' );
	}

	public function get_description() {
		return __( 'Another Dynamic Widget', 'dynamic-content-for-elementor' );
	}

	public function get_docs() {
		return $this->docs;
	}

	public function get_help_url() {
		return 'https://help.dynamic.ooo';
	}

	public function get_custom_help_url() {
		return $this->get_docs();
	}

	public function get_icon() {
		return 'eicon-animation';
	}

	public function is_reload_preview_required() {
		return false;
	}

	public function get_categories() {
		$grouped_widgets = Widgets::get_widgets_by_group();
		$fullname = basename( get_class( $this ) );
		$pieces = explode( '\\', $fullname );
		$name = end( $pieces );
		foreach ( $grouped_widgets as $gkey => $group ) {
			foreach ( $group as $wkey => $widget ) {
				if ( $widget == $name ) {
					return [ 'dynamic-content-for-elementor-' . strtolower( $gkey ) ];
				}
			}
		}
		return [ 'dynamic-content-for-elementor' ];
	}

	public static function get_position() {
		return 666;
	}

	public static function get_satisfy_dependencies( $ret = false ) {
		$widgetClass = get_called_class();
		$myWdgt = new $widgetClass();
		return $myWdgt->satisfy_dependencies( $ret );
	}

	public function get_plugin_depends() {
		return [];
	}

	public function satisfy_dependencies( $ret = false, $deps = [] ) {
		if ( empty( $deps ) ) {
			$deps = $this->get_plugin_depends();
		}
		$depsDisabled = [];
		if ( ! empty( $deps ) ) {
			$isActive = true;
			foreach ( $deps as $pkey => $plugin ) {
				if ( ! is_numeric( $pkey ) ) {
					if ( ! Helper::is_plugin_active( $pkey ) ) {
						$isActive = false;
					}
				} else {
					if ( ! Helper::is_plugin_active( $plugin ) ) {
						$isActive = false;
					}
				}
				if ( ! $isActive ) {
					if ( ! $ret ) {
						return false;
					}
					if ( is_numeric( $pkey ) ) {
						$depsDisabled[] = $plugin;
					} else {
						$depsDisabled[] = $pkey;
					}
				}
			}
		}
		if ( $ret ) {
			return $depsDisabled;
		}
		return true;
	}

	protected function _register_controls() {
	}

	protected function register_controls_non_admin_notice() {
		$this->start_controls_section(
			'section_dce_non_admin',
			[
				'label' => $this->get_title() . __( ' - Notice', 'dynamic-content-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'html_notice',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __( 'You will need administrator capabilities to edit this widget.', 'dynamic-content-for-elementor' ),
				'content_classes' => 'dce-notice',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
	}

	protected function render_non_admin_notice() {
		echo '<span>' . __( 'You will need administrator capabilities to edit this widget.', 'dynamic-content-for-elementor' ) . '</span>';
	}

	protected function _content_template() {
	}

	final public function update_settings( $key, $value = null ) {
		$widget_id = $this->get_id();
		Helper::set_settings_by_id( $widget_id, $key, $value );

		$this->set_settings( $key, $value );
	}
}
