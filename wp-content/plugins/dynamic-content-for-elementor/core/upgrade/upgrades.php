<?php
namespace DynamicContentForElementor\Core\Upgrade;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Upgrades {

	public static function _v_1_12_4_remove_option_api_array( $updater ) {
		 $dce_apis = get_option( 'WP-DCE-1_apis', [] );
		if ( isset( $dce_apis['dce_api_gmaps'] ) ) {
			update_option( 'dce_google_maps_api', $dce_apis['dce_api_gmaps'] );
		}
		if ( ! empty( $dce_apis['dce_api_gmaps_acf'] ) ) {
			update_option( 'dce_google_maps_api_acf', 'yes' );
		}
	}

	public static function _v_1_12_4_dce_tokens_html_tag_default( $updater ) {
		$changes = [
			[
				'callback' => [ 'DynamicContentForElementor\Core\Upgrade\Upgrades', '_widget_settings_save_old_default' ],
				'control_ids' => [
					'dce_html_tag' => 'span',
				],
			],
		];
		return self::_update_widget_settings( 'dce-tokens', $updater, $changes );
	}

	/**
	 * We want to change setting default values for the converters of the form
	 * pdf action and pdf widget.
	 */
	public static function _v_1_10_0_pdf_button_default( $updater ) {
		$changes = [
			[
				'callback' => [ 'DynamicContentForElementor\Core\Upgrade\Upgrades', '_widget_settings_save_old_default' ],
				'control_ids' => [
					'dce_pdf_button_converter' => 'dompdf',
				],
			],
		];
		return self::_update_widget_settings( 'dce_pdf_button', $updater, $changes );
	}

	public static function _v_1_10_0_form_pdf_default( $updater ) {
		$changes = [
			[
				'callback' => [ 'DynamicContentForElementor\Core\Upgrade\Upgrades', '_save_old_default_conv_form_pdf' ],
				'control_ids' => [],
			],
		];
		return self::_update_widget_settings( 'form', $updater, $changes );
	}

	/** Form pdf SVG has now a repeater for multiple pages. */
	public static function _v_1_10_0_form_pdf_svg_repeater( $updater ) {
		$changes = [
			[
				'callback' => [ 'DynamicContentForElementor\Core\Upgrade\Upgrades', '_pdf_form_new_svg_repeater' ],
				'control_ids' => [],
			],
		];
		return self::_update_widget_settings( 'form', $updater, $changes );
	}

	/**
	 * This is so we can distinguish old installations from new ones, old
	 * installations use the old acfrepeater version.
	 */
	public static function _v_1_11_0_acfrepeater_version_olddefault() {
		$version = get_option( 'dce_acfrepeater_newversion' );
		if ( ! $version ) {
			update_option( 'dce_acfrepeater_newversion', 'no' );
		} else {
			// We used 1 before, change it to 'yes'.
			update_option( 'dce_acfrepeater_newversion', 'yes' );
		}
		return false;
	}

	public static function _pdf_form_new_svg_repeater( $element, $args ) {
		$widget_id = $args['widget_id'];
		if ( empty( $element['widgetType'] ) || $widget_id !== $element['widgetType'] ) {
			return $element;
		}
		if ( isset( $element['settings']['dce_form_pdf_svg_code'] ) ) {
			$code = $element['settings']['dce_form_pdf_svg_code'];
			unset( $element['settings']['dce_form_pdf_svg_code'] );
			$repeater = [
				[
					'_id' => wp_unique_id(),
					'text' => $code,
				],
			];
			$element['settings']['dce_form_pdf_svg_code_repeater'] = $repeater;
			$args['do_update'] = true;
		}
		return $element;
	}

	public static function _save_old_default_conv_form_pdf( $element, $args ) {
		$widget_id = $args['widget_id'];

		if ( empty( $element['widgetType'] ) || $widget_id !== $element['widgetType'] ) {
			return $element;
		}

		// if the pdf action was registered in the form:
		if ( isset( $element['settings']['submit_actions'] ) &&
			in_array( 'dce_form_pdf', $element['settings']['submit_actions'] ) ) {
			if ( empty( $element['settings']['dce_form_pdf_converter'] ) ) {
				$element['settings']['dce_form_pdf_converter'] = 'dompdf';
				$args['do_update'] = true;
			};
		}
		return $element;
	}

	/**
	 * $changes is an array of arrays in the following format:
	 * [
	 *   'control_ids' => array of control ids
	 *   'callback' => user callback to manipulate the control_ids
	 * ]
	 *
	 * @param       $widget_id
	 * @param       $updater
	 * @param array $changes
	 *
	 * @return bool
	 */
	public static function _update_widget_settings( $widget_id, $updater, $changes ) {
		global $wpdb;

		$post_ids = $updater->query_col(
			'SELECT `post_id`
					FROM `' . $wpdb->postmeta . '`
					WHERE `meta_key` = "_elementor_data"
					AND `meta_value` LIKE \'%"widgetType":"' . $widget_id . '"%\';'
		);

		if ( empty( $post_ids ) ) {
			return false;
		}

		foreach ( $post_ids as $post_id ) {
			$do_update = false;

			$document = \Elementor\Plugin::instance()->documents->get( $post_id );

			if ( ! $document ) {
				continue;
			}

			$data = $document->get_elements_data();

			if ( empty( $data ) ) {
				continue;
			}

			// loop thru callbacks & array
			foreach ( $changes as $change ) {
				$args = [
					'do_update' => &$do_update,
					'widget_id' => $widget_id,
					'control_ids' => $change['control_ids'],
				];
				if ( isset( $change['prefix'] ) ) {
					$args['prefix'] = $change['prefix'];
					$args['new_id'] = $change['new_id'];
				}
				$data = \Elementor\Plugin::instance()->db->iterate_data( $data, $change['callback'], $args );
				if ( ! $do_update ) {
					continue;
				}

				// We need the `wp_slash` in order to avoid the unslashing during the `update_metadata`
				$json_value = wp_slash( wp_json_encode( $data ) );

				update_metadata( 'post', $post_id, '_elementor_data', $json_value );
			}
		} // End foreach().

		return $updater->should_run_again( $post_ids );
	}

	/**
	 * @param $element
	 * @param $args
	 *
	 * @return mixed
	 */
	public static function _rename_widget_settings( $element, $args ) {
		$widget_id = $args['widget_id'];
		$changes = $args['control_ids'];

		if ( empty( $element['widgetType'] ) || $widget_id !== $element['widgetType'] ) {
			return $element;
		}

		foreach ( $changes as $old => $new ) {
			if ( ! empty( $element['settings'][ $old ] ) && ! isset( $element['settings'][ $new ] ) ) {
				$element['settings'][ $new ] = $element['settings'][ $old ];
				$args['do_update'] = true;
			}
		}

		return $element;
	}

	/**
	 * Useful when we want to change a setting default value: Finds all the
	 * instances where the setting value is unset and set it to the old
	 * default value.
	 */
	public static function _widget_settings_save_old_default( $element, $args ) {
		$widget_id = $args['widget_id'];
		$changes = $args['control_ids'];

		if ( empty( $element['widgetType'] ) || $widget_id !== $element['widgetType'] ) {
			return $element;
		}

		foreach ( $changes as $setting_name => $old_default ) {
			if ( empty( $element['settings'][ $setting_name ] ) ) {
				$element['settings'][ $setting_name ] = $old_default;
				$args['do_update'] = true;
			};
		}

		return $element;
	}
}
