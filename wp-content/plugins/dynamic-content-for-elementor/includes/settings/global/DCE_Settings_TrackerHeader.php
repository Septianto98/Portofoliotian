<?php

namespace DynamicContentForElementor\Includes\Settings;

use Elementor\Controls_Manager;
use Elementor\Utils;
use DynamicContentForElementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DCE_Settings_TrackerHeader extends DCE_Settings_Prototype {

	public static $name = 'Tracker Header';

	public function __construct() {
		if ( get_option( 'enable_trackerheader' ) ) {
			add_filter( 'body_class', array( $this, 'dce_add_class' ), 10 );
		}
	}

	public function get_name() {
		return 'dce-settings_trackerheader';
	}

	public function get_css_wrapper_selector() {
		return 'body.dce-trackerheader';
	}

	public static function dce_add_class( $classes ) {
		$classes[] = 'dce-trackerheader';
		return $classes;
	}

	public static function get_controls() {
		$wrapper = 'body.dce-trackerheader';
		$target_trackerheader = ' header';
		$selector_header = get_option( 'selector_header' );
		$listselectors = Helper::str_to_array( ',', $selector_header );
		if ( count( $listselectors ) > 1 ) {
			$selector_header = '#trackerheader-wrap';
		}

		if ( $selector_header ) {
			$target_trackerheader = ' ' . $selector_header;
		}

		return [
			'label' => __( 'Tracker Header', 'dynamic-content-for-elementor' ),
			'controls' => [
				'enable_trackerheader' => [
					'label' => __( 'Enable Tracker Header', 'dynamic-content-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'frontend_available' => true,
					'separator' => 'before',
					'default' => '',
				],
				'selector_header' => [
					'label' => __( 'Selector Header', 'dynamic-content-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => 'Write CSS selector (e.g.:#header)',
					'frontend_available' => true,
					'label_block' => true,
					'dynamic' => [
						'active' => false,
					],
					'condition' => [
						'enable_trackerheader' => 'yes',
					],
				],
				'dce_trackerheader_class_debug' => [
					'type' => Controls_Manager::RAW_HTML,
					'raw' => __( '<div class="dce-class-debug">...</div>', 'dynamic-content-for-elementor' ),
					'content_classes' => 'dce_class_debug',
					'condition' => [
						'enable_trackerheader' => 'yes',
					],
				],
				'dce_trackerheader_class_controller' => [
					'label' => __( 'Controller', 'dynamic-content-for-elementor' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => '',
					'render_type' => 'ui',
					'frontend_available' => true,
					'selectors' => [
						$wrapper . $target_trackerheader  => '
                            z-index: 999;
                            right: 0;
                            left: 0;
                            top: 0;
                            position: fixed;
                            -webkit-transition: background-color .8s ease-in-out, transform .5s ease-in-out;
                            -moz-transition: background-color .8s ease-in-out, transform .5s ease-in-out;
                              -o-transition: background-color .8s ease-in-out, transform .5s ease-in-out;
                                 transition: background-color .8s ease-in-out, transform .5s ease-in-out;',
					],
					'condition' => [
						'enable_trackerheader' => 'yes',
						'selector_header!' => '',
					],
				],
				//
				'dce_trackerheader_settings_note' => [
					'type' => Controls_Manager::RAW_HTML,
					'raw' => __( '<span style="font-size: 11px; font-weight: 400; font-style: italic;"><i class="fa fa-life-ring" aria-hidden="true"></i> The selector wrapper is very important for the proper functioning of the transitions. indicates the part of the page that needs to be transformed. <a href="https://help.dynamic.ooo/en/articles/4952536-html-structure-of-themes" target="_blank">This article can help you.</a></span>', 'dynamic-content-for-elementor' ),
					'content_classes' => '',
					'condition' => [
						'enable_trackerheader' => 'yes',
						'dce_trackerheader_class_controller!' => '',
						'selector_header!' => '',
					],
				],

				// STYLE ???
				// Tabs. top |  no-top
				// Background
				// Menu style Color: Normal, Hover, Active
				// Size logo

				// EFFECT
				// Mode: Slide to top, Opacity, none

				// Position: Fixed in overlay | Normal
				/*'trackerheader_header_fullwidth' => [
					'label' => __('Full-Width Header', 'dynamic-content-for-elementor'),
					'type' => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'frontend_available' => true,
					'separator' => 'before',
					'default' => '',
					'condition' => [
						'enable_trackerheader' => 'yes',
						'dce_trackerheader_class_controller!' => '',
						'selector_header!' => '',
					],
					'selectors' => [
						$wrapper.$target_trackerheader => 'width: 100%;',
					]
				],*/
				/*'trackerheader_header_size' => [
					'label'     => __( 'Header Size', 'dynamic-content-for-elementor' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size'  => '',
					],
					'separator' => 'before',
					'size_units' => [ 'px', '%','vw' ],
					'range'   => [
						'px'  => [
							'min'   => 360,
							'max'   => 1920,
							'step'  => 1,
						],

						'vw'  => [
							'min'   => 20,
							'max'   => 100,
							'step'  => 1,
						],
						'%'  => [
							'min'   => 20,
							'max'   => 100,
							'step'  => 1,
						],
					],
					'condition' => [
						'enable_trackerheader' => 'yes',
						'dce_trackerheader_class_controller!' => '',
						'selector_header!' => '',
					],
					'selectors' => [
						$wrapper.$target_trackerheader => 'max-width: {{SIZE}}{{UNIT}}; margin: 0 auto;',
					]
				],*/
				/*'dce_trackerheader_padding' => [
					'label' => __('Header Padding', 'dynamic-content-for-elementor'),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors' => [
						$wrapper.$target_trackerheader => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'enable_trackerheader' => 'yes',
						'dce_trackerheader_class_controller!' => '',
						'selector_header!' => '',
					],
				],*/
				/*'dce_trackerheader_background_heading' => [
					'label' => __('Background', 'dynamic-content-for-elementor'),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'enable_trackerheader' => 'yes',
						'dce_trackerheader_class_controller!' => '',
						'selector_header!' => '',
					],
				],
				'dce_trackerheader_background_top' => [
					'label' => __('Background Top', 'dynamic-content-for-elementor'),
					'type' => Controls_Manager::COLOR,

					'condition' => [
						'enable_trackerheader' => 'yes',
						'dce_trackerheader_class_controller!' => '',
						'selector_header!' => '',
					],
					'selectors' => [
						$wrapper.$target_trackerheader.'.trackerheader.trackerheader--top' => 'background-color: {{VALUE}};',
					]
				],
				'dce_trackerheader_background_pinned' => [
					'label' => __('Background Pinned', 'dynamic-content-for-elementor'),
					'type' => Controls_Manager::COLOR,

					'condition' => [
						'enable_trackerheader' => 'yes',
						'dce_trackerheader_class_controller!' => '',
						'selector_header!' => '',
					],
					'selectors' => [
						$wrapper.$target_trackerheader.'.trackerheader--pinned' => 'background-color: {{VALUE}};',
					]

				],
				*/

				'dce_trackerheader_options' => [
					'label' => __( 'Options', 'dynamic-content-for-elementor' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'enable_trackerheader' => 'yes',
						'dce_trackerheader_class_controller!' => '',
						'selector_header!' => '',
					],
				],
				'trackerheader_overlay' => [
					'label' => __( 'Is Overlay', 'dynamic-content-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'frontend_available' => true,
					'condition' => [
						'enable_trackerheader' => 'yes',
						'dce_trackerheader_class_controller!' => '',
						'selector_header!' => '',
					],
				],
				'dce_trackerheader_zindex' => [
					'label'   => __( 'Z-Index', 'dynamic-content-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 999,
					'min'     => 0,
					'max'     => 10000,
					'step'    => 1,
					'selectors' => [
						$wrapper . $target_trackerheader  => 'z-index: {{VALUE}};',
					],
					'condition' => [
						'enable_trackerheader' => 'yes',
						'dce_trackerheader_class_controller!' => '',
						'selector_header!' => '',
						'trackerheader_overlay!' => '',
					],
				],
				/*'trackerheader_show_mode' => [
					'label' => __('Show mode', 'dynamic-content-for-elementor'),

					'type' => Controls_Manager::SELECT,
					'default' => 'slide',
					'options' => [
						'slide' => 'Slide',
						'fade' => 'Fade',
						'' => 'None',
					],
					'condition' => [
						'enable_trackerheader' => 'yes',
						'dce_trackerheader_class_controller!' => '',
						'selector_header!' => '',
					],
					'frontend_available' => true
				],*/
				'dce_trackerheader_css_note' => [
					'type' => Controls_Manager::RAW_HTML,
					'raw' => __( 'During the course of the tracker-header, classes will be applied to the wrapper that you can use to change the appearance of the elements from css: <ul><li>.trackerheader-top</li> <li>.trackerheader-pinned </li > <li>.trackerheader-unpinned </li> <li>.trackerheader-bottom </li> </ul> <a href="https://help.dynamic.ooo/en/articles/4952557-tracker-header" target="_blank">This article can help you.</a>', 'dynamic-content-for-elementor' ),
					'content_classes' => 'dce-notice',
					'separator' => 'before',
					'condition' => [
						'enable_trackerheader' => 'yes',
						'dce_trackerheader_class_controller!' => '',
						'selector_header!' => '',
					],
				],
				'responsive_trackerheader' => [
					'label' => __( 'Apply trackerHeader on:', 'dynamic-content-for-elementor' ),
					'description' => __( 'Responsive mode will take place on preview or live pages only, not while editing in Elementor.', 'dynamic-content-for-elementor' ),
					'type' => Controls_Manager::SELECT2,
					'multiple' => true,
					'separator' => 'before',
					'label_block' => true,
					'options' => [
						'desktop' => __( 'Desktop', 'dynamic-content-for-elementor' ),
						'tablet' => __( 'Tablet', 'dynamic-content-for-elementor' ),
						'mobile' => __( 'Mobile', 'dynamic-content-for-elementor' ),
					],
					'default' => [ 'desktop', 'tablet', 'mobile' ],
					'frontend_available' => true,
					'condition' => [
						'enable_trackerheader' => 'yes',
						'dce_trackerheader_class_controller!' => '',
						'selector_header!' => '',
					],
				],
			],
		];
	}

}
