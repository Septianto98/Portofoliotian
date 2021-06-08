<?php
namespace DynamicContentForElementor\Compatibility;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * WPML Compatibility
 *
 * Registers translatable widgets
 *
 * @since 1.5.4
 */
if ( ! class_exists( 'WPML' ) ) {
	class WPML {


		/**
		 * @since 1.5.4
		 * @var Object
		 */
		public static $instance = null;

		/**
		 * Returns the class instance
		 *
		 * @since 1.0.16
		 *
		 * @return Object
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor for the class
		 *
		 * @since 1.5.4
		 *
		 * @return void
		 */
		public function __construct() {
			// WPML String Translation plugin exist check
			add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'wpml_widgets_to_translate_filter' ] );
		}

		/**
		 * Adds additional translatable nodes to WPML
		 *
		 * @since 1.5.4
		 *
		 * @param  array   $nodes_to_translate WPML nodes to translate
		 * @return array   $nodes_to_translate Updated nodes
		 */
		public function wpml_widgets_to_translate_filter( $widgets ) {
			$widgets['dyncontel-animateText'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-animateText' ],
				'fields'     => [],
				'integration-class' => [ 'WPML_animateText' ],
			];

			$widgets['dyncontel-acf'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-acf' ],
				'fields'     => [
					[
						'field'       => 'acf_text_before',
						'type'        => __( 'Text before', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'acf_text_after',
						'type'        => __( 'Text after', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dce-copy-to-clipboard'] = [
				'conditions' => [ 'widgetType' => 'dce-copy-to-clipboard' ],
				'fields'     => [
					[
						'field'       => 'text',
						'type'        => __( 'Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'change_text',
						'type'        => __( 'Change text to', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dyncontel-acf-google-maps'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-acf-google-maps' ],
				'fields'     => [
					[
						'field'       => 'custom_infoWindow_wysiwig',
						'type'        => __( 'InfoWindow Custom text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'AREA',
					],
					[
						'field'       => 'geolocation_button_text',
						'type'        => __( 'Geolocation Button Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'fallback_text',
						'type'        => __( 'Fallback Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dyncontel-acf-relation'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-acf-relation' ],
				'fields'     => [
					[
						'field'       => 'acf_relation_text',
						'type'        => __( 'Post HTML', 'dynamic-content-for-elementor' ),
						'editor_type' => 'AREA',
					],
				],
			];

			$widgets['dyncontel-acf-repeater'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-acf-repeater' ],
				'fields'     => [
					[
						'field'       => 'dce_views_select_field_label',
						'type'        => __( 'Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dce-animatedoffcanvasmenu'] = [
				'conditions' => [ 'widgetType' => 'dce-animatedoffcanvasmenu' ],
				'fields'     => [
					[
						'field'       => 'close_text',
						'type'        => __( 'Close Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dce_add_to_calendar'] = [
				'conditions' => [ 'widgetType' => 'dce_add_to_calendar' ],
				'fields'     => [
					[
						'field'       => 'text',
						'type'        => __( 'Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_calendar_title',
						'type'        => __( 'Title', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_calendar_datetime_start',
						'type'        => __( 'DateTime Start', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_calendar_datetime_end',
						'type'        => __( 'DateTime End', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_calendar_datetime_string_format',
						'type'        => __( 'DateTime Format', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_calendar_datetime_start_string',
						'type'        => __( 'DateTime Start', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_calendar_datetime_end_string',
						'type'        => __( 'DateTime End', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_calendar_description',
						'type'        => __( 'Description', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_calendar_location',
						'type'        => __( 'Location', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dce-views'] = [
				'conditions' => [ 'widgetType' => 'dce-views' ],
				'fields'     => [
					[
						'field'       => 'dce_views_count_text',
						'type'        => __( 'Count Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'AREA',
					],
					[
						'field'       => 'dce_views_style_form_text',
						'type'        => __( 'Form Title', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_views_style_form_submit_text',
						'type'        => __( 'Submit Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_views_order_label',
						'type'        => __( 'Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_views_order_by_default',
						'type'        => __( 'Default Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_views_fallback_text',
						'type'        => __( 'Text - Fallback', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
				'integration-class' => [ 'WPML_Views_Where_Filter', 'WPML_Views_Select_Fields' ],
			];

			$widgets['dyncontel-dynamicusers'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-dynamicusers' ],
				'fields'     => [
					[
						'field'       => 'pagination_prev_label',
						'type'        => __( 'Pagination Previous Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'pagination_next_label',
						'type'        => __( 'Pagination Next Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'pagination_first_label',
						'type'        => __( 'Pagination First Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'pagination_last_label',
						'type'        => __( 'Pagination Last Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
				'integration-class' => [ 'WPML_DynamicUsers' ],
			];

			$widgets['dce-filebrowser'] = [
				'conditions' => [ 'widgetType' => 'dce-filebrowser' ],
				'fields'     => [
					[
						'field'       => 'search_text',
						'type'        => __( 'Search Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'search_notice',
						'type'        => __( 'Search Notice', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'search_find_text',
						'type'        => __( 'Find', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'Reset Text',
						'type'        => __( 'Reset Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dce-breadcrumbs'] = [
				'conditions' => [ 'widgetType' => 'dce-breadcrumbs' ],
				'fields'     => [
					[
						'field'       => 'home-text',
						'type'        => __( 'Home Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['single-posts-menu'] = [
				'conditions' => [ 'widgetType' => 'single-posts-menu' ],
				'fields'     => [
					[
						'field'       => 'title_text',
						'type'        => __( 'Title Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['taxonomy-terms-menu'] = [
				'conditions' => [ 'widgetType' => 'taxonomy-terms-menu' ],
				'fields'     => [
					[
						'field'       => 'tax_text',
						'type'        => __( 'Custom Taxonomy Name', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dce-meta'] = [
				'conditions' => [ 'widgetType' => 'dce-meta' ],
				'fields'     => [
					[
						'field'       => 'dce_meta_button_text',
						'type'        => __( 'Button Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_meta_fallback_text',
						'type'        => __( 'Text Fallback', 'dynamic-content-for-elementor' ),
						'editor_type' => 'AREA',
					],
					[
						'field'       => 'dce_meta_date_format_source',
						'type'        => __( 'Data Source Format', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_meta_date_format_display',
						'type'        => __( 'Date Display Format', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_meta_custom',
						'type'        => __( 'Custom HTML', 'dynamic-content-for-elementor' ),
						'editor_type' => 'AREA',
					],
				],
			];

			$widgets['dyncontel-terms'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-terms' ],
				'fields'     => [
					[
						'field'       => 'text_before',
						'type'        => __( 'Text before', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'text_after',
						'type'        => __( 'Text after', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dyncontel-date'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-date' ],
				'fields'     => [
					[
						'field'       => 'format',
						'type'        => __( 'Format date', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'format2',
						'type'        => __( '2 - Format date', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'format3',
						'type'        => __( '3- Format date', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'date_text_before',
						'type'        => __( 'Text before', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dyncontel-titleType'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-titleType' ],
				'fields'     => [
					[
						'field'       => 'titleType_text_before',
						'type'        => __( 'Text Before', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'titleType_text_after',
						'type'        => __( 'Text After', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dyncontel-modalwindow'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-modalwindow' ],
				'fields'     => [
					[
						'field'       => 'text_btn',
						'type'        => __( 'Text Button', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],

				],
			];

			$widgets['dce_pdf_button'] = [
				'conditions' => [ 'widgetType' => 'dce_pdf_button' ],
				'fields'     => [
					[
						'field'       => 'text',
						'type'        => __( 'Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_pdf_button_title',
						'type'        => __( 'Title', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],

				],
			];

			$widgets['dce-tokens'] = [
				'conditions' => [ 'widgetType' => 'dce-tokens' ],
				'fields'     => [
					[
						'field'       => 'text_w_tokens',
						'type'        => __( 'Text Editor with Tokens', 'dynamic-content-for-elementor' ),
						'editor_type' => 'AREA',
					],
				],
			];

			$widgets['dyncontel-popup'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-popup' ],
				'fields'     => [
					[
						'field'       => 'modal_content',
						'type'        => __( 'PopUp Content', 'dynamic-content-for-elementor' ),
						'editor_type' => 'AREA',
					],
				],
			];

			$widgets['dyncontel-twentytwenty'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-twentytwenty' ],
				'fields'     => [
					[
						'field'       => 'before_label',
						'type'        => __( 'Before Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'after_label',
						'type'        => __( 'After Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dyncontel-post-nextprev'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-post-nextprev' ],
				'fields'     => [
					[
						'field'       => 'prev_label',
						'type'        => __( 'Previous Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'next_label',
						'type'        => __( 'Next Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dyncontel-readmore'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-readmore' ],
				'fields'     => [
					[
						'field'       => 'button_html',
						'type'        => __( 'Button HTML', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'button_text',
						'type'        => __( 'Button Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dyncontel-excerpt'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-excerpt' ],
				'fields'     => [
					[
						'field'       => 'excerpt_ellipsis',
						'type'        => __( 'Excerpt Ellipsis', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dyncontel-svgpathText'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-svgpathText' ],
				'fields'     => [
					[
						'field'       => 'svgpathtext_text',
						'type'        => __( 'Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dce-user-fields'] = [
				'conditions' => [ 'widgetType' => 'dce-user-fields' ],
				'fields'     => [
					[
						'field'       => 'user_text_before',
						'type'        => __( 'Text after', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],

					[
						'field'       => 'dce_user_custom',
						'type'        => __( 'Custom HTML', 'dynamic-content-for-elementor' ),
						'editor_type' => 'AREA',
					],

					[
						'field'       => 'dce_user_section_fallback',
						'type'        => __( 'Empty field behaviour', 'dynamic-content-for-elementor' ),
						'editor_type' => 'AREA',
					],
				],
			];

			$widgets['dce-add-to-favorites'] = [
				'conditions' => [ 'widgetType' => 'dce-add-to-favorites' ],
				'fields'     => [
					[
						'field'       => 'dce_favorite_msg_add',
						'type'        => __( 'Add success Message', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_favorite_msg_remove',
						'type'        => __( 'Remove success message', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_favorite_title',
						'type'        => __( 'Add to Favorites - Title', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_favorite_title_add',
						'type'        => __( 'Add to Favorites - Add - Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'dce_favorite_title_remove',
						'type'        => __( 'Add to Favorites - Remove - Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
				'integration-class'   => 'WPML_AddToFavorites',
			];

			$widgets['dyncontel-acfposts'] = [
				'conditions' => [ 'widgetType' => 'dyncontel-acfposts' ],
				'fields'     => [
					[
						'field'       => 'pagination_prev_label',
						'type'        => __( 'Pagination Previous Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'pagination_next_label',
						'type'        => __( 'Pagination Next Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'pagination_first_label',
						'type'        => __( 'Pagination First Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'pagination_last_label',
						'type'        => __( 'Pagination Last Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'alltext_filter',
						'type'        => __( 'Filter - All element text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'querydate_field_meta_format',
						'type'        => __( 'Meta Date Format', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'querydate_field_meta_future_format',
						'type'        => __( 'Meta Date Format', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'readmore_text',
						'type'        => __( 'Read More', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
			];

			$widgets['dce-dynamicposts-v2'] = [
				'conditions' => [ 'widgetType' => 'dce-dynamicposts-v2' ],
				'fields'     => [
					[
						'field'       => 'pagination_prev_label',
						'type'        => __( 'Pagination Previous Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'pagination_next_label',
						'type'        => __( 'Pagination Next Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'pagination_first_label',
						'type'        => __( 'Pagination First Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'pagination_last_label',
						'type'        => __( 'Pagination Last Label', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'querydate_field_meta_format',
						'type'        => __( 'Meta Date Format', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'querydate_field_meta_future_format',
						'type'        => __( 'Meta Date Format', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'slideshow_caption_date_format',
						'type'        => __( 'Caption Date Format', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
					[
						'field'       => 'fallback_text',
						'type'        => __( 'Fallback Text', 'dynamic-content-for-elementor' ),
						'editor_type' => 'LINE',
					],
				],
				'integration-class'   => 'WPML_DynamicPostsv2',
			];

			return $widgets;
		}

		/**
		 * Returns the class instance.
		 *
		 * @since 1.5.4
		 *
		 * @return Object
		 */
		public static function get_instance() {
			if ( null == self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
}
