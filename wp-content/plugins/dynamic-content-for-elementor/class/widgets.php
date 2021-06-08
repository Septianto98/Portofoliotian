<?php

namespace DynamicContentForElementor;

/**
 * Widgets Class
 *
 * Register new elementor widget.
 *
 * @since 0.0.1
 */
class Widgets {

	public $widgets = [];
	public static $registered_widgets = [];
	public $grouped_widgets = [];
	public static $group;
	public static $namespace = '\\DynamicContentForElementor\\Widgets\\';

	public function __construct() {
		$this->init();
	}

	public function init() {
		$this->widgets = $this->get_widgets();
		$this->grouped_widgets = $this->get_widgets_by_group();
		add_action( 'elementor/elements/categories_registered', array( $this, 'add_elementor_widget_category' ), 20 );
	}

	public static function init_group() {
		self::$group = [
			'ARCHIVE' => __( 'Archive', 'dynamic-content-for-elementor' ),
			'ACF' => 'ACF',
			'CONTENT' => __( 'Content', 'dynamic-content-for-elementor' ),
			'CREATIVE' => __( 'Creative', 'dynamic-content-for-elementor' ),
			'DEV' => __( 'Developer', 'dynamic-content-for-elementor' ),
			'DYNAMIC' => __( 'Dynamic', 'dynamic-content-for-elementor' ),
			'INTERFACE' => __( 'Interface', 'dynamic-content-for-elementor' ),
			'LIST' => __( 'List', 'dynamic-content-for-elementor' ),
			'PODS' => 'Pods',
			'POST' => __( 'Post', 'dynamic-content-for-elementor' ),
			'SVG' => 'SVG',
			'TOOLSET' => 'Toolset',
			'WEBGL' => 'WEBGL',
		];
	}

	public static function get_widgets() {

		$widgets['ACF'][] = 'DCE_Widget_Acf';
		$widgets['ACF'][] = 'DCE_Widget_Gallery';
		$widgets['ACF'][] = 'DCE_Widget_Relationship';
		$widgets['ACF'][] = 'DCE_Widget_Repeater';
		$widgets['ACF'][] = 'DCE_Widget_Slider';

		$widgets['ARCHIVE'][] = 'DCE_Widget_TitleTaxonomy';

		$widgets['CONTENT'][] = 'DCE_Widget_BarCode';
		$widgets['CONTENT'][] = 'DCE_Widget_Calendar';
		$widgets['CONTENT'][] = 'DCE_Widget_Clipboard';
		$widgets['CONTENT'][] = 'DCE_Widget_DynamicCookie';
		$widgets['CONTENT'][] = 'DCE_Widget_Favorites';
		$widgets['CONTENT'][] = 'DCE_Widget_ModalWindow';
		$widgets['CONTENT'][] = 'DCE_Widget_Pdf';
		$widgets['CONTENT'][] = 'DCE_Widget_PopUp';
		$widgets['CONTENT'][] = 'DCE_Widget_Template';
		$widgets['CONTENT'][] = 'DCE_Widget_Tokens';

		$widgets['CREATIVE'][] = 'DCE_Widget_AnimateText';
		$widgets['CREATIVE'][] = 'DCE_Widget_Parallax';
		$widgets['CREATIVE'][] = 'DCE_Widget_ThreesixtySlider';
		$widgets['CREATIVE'][] = 'DCE_Widget_Tilt';
		$widgets['CREATIVE'][] = 'DCE_Widget_TwentyTwenty';

		$widgets['DEV'][] = 'DCE_Widget_DoShortcode';
		$widgets['DEV'][] = 'DCE_Widget_IncludeFile';
		$widgets['DEV'][] = 'DCE_Widget_RawPhp';
		$widgets['DEV'][] = 'DCE_Widget_RemoteContent';

		$widgets['DYNAMIC'][] = 'DCE_Widget_DynamicPosts';
		$widgets['DYNAMIC'][] = 'DCE_Widget_DynamicPosts_v2';
		$widgets['DYNAMIC'][] = 'DCE_Widget_GoogleMaps';
		$widgets['DYNAMIC'][] = 'DCE_Widget_DynamicUsers';

		$widgets['INTERFACE'][] = 'DCE_Widget_AnimatedOffcanvasMenu';
		$widgets['INTERFACE'][] = 'DCE_Widget_CursorTracker';

		$widgets['LIST'][] = 'DCE_Widget_FileBrowser';
		$widgets['LIST'][] = 'DCE_Widget_ParentChildMenu';
		$widgets['LIST'][] = 'DCE_Widget_SearchFilter';
		$widgets['LIST'][] = 'DCE_Widget_SinglePostsMenu';
		$widgets['LIST'][] = 'DCE_Widget_TaxonomyTermsMenu';
		$widgets['LIST'][] = 'DCE_Widget_Views';

		$widgets['PODS'][] = 'DCE_Widget_Pods';
		$widgets['PODS'][] = 'DCE_Widget_PodsGallery';
		$widgets['PODS'][] = 'DCE_Widget_PodsRelationship';

		$widgets['POST'][] = 'DCE_Widget_Breadcrumbs';
		$widgets['POST'][] = 'DCE_Widget_Content';
		$widgets['POST'][] = 'DCE_Widget_Date';
		$widgets['POST'][] = 'DCE_Widget_Excerpt';
		$widgets['POST'][] = 'DCE_Widget_FeaturedImage';
		$widgets['POST'][] = 'DCE_Widget_IconFormat';
		$widgets['POST'][] = 'DCE_Widget_Meta';
		$widgets['POST'][] = 'DCE_Widget_NextPrev';
		$widgets['POST'][] = 'DCE_Widget_ReadMore';
		$widgets['POST'][] = 'DCE_Widget_Terms';
		$widgets['POST'][] = 'DCE_Widget_Title';
		$widgets['POST'][] = 'DCE_Widget_TitleType';
		$widgets['POST'][] = 'DCE_Widget_User';

		$widgets['SVG'][] = 'DCE_Widget_SvgBlob';
		$widgets['SVG'][] = 'DCE_Widget_SvgDistortion';
		$widgets['SVG'][] = 'DCE_Widget_SvgFilterEffects';
		$widgets['SVG'][] = 'DCE_Widget_SvgImagemask';
		$widgets['SVG'][] = 'DCE_Widget_SvgMorphing';
		$widgets['SVG'][] = 'DCE_Widget_Svg_PathText';

		$widgets['TOOLSET'][] = 'DCE_Widget_Toolset';
		$widgets['TOOLSET'][] = 'DCE_Widget_ToolsetRelationship';

		$widgets['WEBGL'][] = 'DCE_Widget_BgCanvas';
		$widgets['WEBGL'][] = 'DCE_Widget_DistortionImage';
		$widgets['WEBGL'][] = 'DCE_Widget_Panorama';

		return $widgets;
	}

	public static function get_widgets_by_group() {
		$grouped_widgets = self::get_widgets();

		$tmp = array();
		foreach ( $grouped_widgets as $gkey => $values ) {
			foreach ( $values as $wkey => $value ) {
				$tmp[ $gkey ][ $wkey ] = $value;
			}
		}
		$grouped_widgets = $tmp;

		return $grouped_widgets;
	}

	/**
	 * On Widgets Registered
	 *
	 * @since 0.0.1
	 *
	 * @access public
	 */
	public function on_widgets_registered() {
		$this->register_widget();
	}

	/**
	 * Register Widget
	 *
	 * @since 0.5.0
	 *
	 * @access private
	 */
	public function register_widget() {
		if ( empty( self::$registered_widgets ) ) {
			$excluded_widgets = json_decode( get_option( DCE_PRODUCT_ID . '_excluded_widgets' ), true );
			$grouped_widgets = self::get_widgets_by_group();
			foreach ( $grouped_widgets as $aType ) {
				usort($aType, function( $a, $b ) {
					$aw = self::$namespace . $a;
					$bw = self::$namespace . $b;
					if ( $aw::get_position() == $bw::get_position() ) {
						return 0;
					}
					return ( $aw::get_position() < $bw::get_position() ) ? -1 : 1;
				}); // ordered by key (position)
				$aOrderedType = array();
				foreach ( $aType as $myWdgtClass ) {
					if ( ! isset( self::$registered_widgets[ $myWdgtClass ] ) ) {
						if ( ! $excluded_widgets || ! isset( $excluded_widgets[ $myWdgtClass ] ) ) {
							$aWidgetObjname = self::$namespace . $myWdgtClass;
							$aWidgetObj = new $aWidgetObjname();
							if ( $aWidgetObj->satisfy_dependencies() ) {
								\Elementor\Plugin::instance()->widgets_manager->register_widget_type( $aWidgetObj );
								self::$registered_widgets[ $myWdgtClass ] = $aWidgetObj;
							}
						}
					}
				}
			}
		}

		if ( ! empty( self::$registered_widgets ) ) {
			foreach ( self::$registered_widgets as $aWidgetObj ) {
				Assets::add_depends( $aWidgetObj );
			}
		}
	}

	public static function get_excluded_widgets() {
		return json_decode( get_option( DCE_PRODUCT_ID . '_excluded_widgets', '[]' ), true );
	}

	/**
	 * Add category of Elementor
	 *
	 * @since 0.0.1
	 *
	 * @access public
	 */
	public function add_elementor_widget_category( $elements ) {
		$i = 0;

		// Default category for widgets without a category
		$elements->add_category('dynamic-content-for-elementor', array(
			'title' => __( 'Dynamic Content', 'dynamic-content-for-elementor' ),
		));

		self::init_group();

		// Add categories
		foreach ( self::$group as $gkey => $agroup ) {
			$elements->add_category('dynamic-content-for-elementor-' . strtolower( $gkey ), array(
				'title' => __( 'Dynamic Content', 'dynamic-content-for-elementor' ) . ' - ' . $agroup,
			));
		}

	}

}
