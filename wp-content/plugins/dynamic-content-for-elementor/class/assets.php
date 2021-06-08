<?php namespace DynamicContentForElementor;

use Elementor\Core\Files\CSS;

class Assets {

	public static $dce_styles = [];
	public static $dce_scripts = [];
	public static $styles = array(
		'dce-globalsettings' => 'assets/css/global-settings.css',
		'dce-style' => '/assets/css/style.css',
		'dce-animations' => '/assets/css/animations.css',
		'dce-preview' => '/assets/css/preview.css',
		'dce-acf' => '/assets/css/acf-fields.css',
		'dce-acfRelationship' => '/assets/css/acf-relationship.css',
		'dce-acfslider' => '/assets/css/acf-slider.css',
		'dce-acfGallery' => '/assets/css/acf-gallery.css',
		'dce-acfRepeater' => '/assets/css/acf-repeater.css',
		'dce-google-maps' => '/assets/css/dynamic-google-maps.css',
		'dce-pods' => '/assets/css/pods-fields.css',
		'dce-pods-gallery' => '/assets/css/pods-gallery.css',
		'dce-toolset' => '/assets/css/toolset-fields.css',
		//DYNAMICPOSTS v1
		'dce-dynamicPosts' => '/assets/css/dynamic-posts.css',
		'dce-dynamicPosts_slick' => '/assets/css/dynamic-posts-slick.css',
		'dce-dynamicPosts_swiper' => '/assets/css/dynamic-posts-swiper.css',
		'dce-dynamicPosts_timeline' => '/assets/css/dynamic-posts-timeline.css',
		//DYNAMIC POSTS v2
		'dce-dynamicPosts-grid' => '/assets/css/dynamic-posts-v2-skin-grid.css',
		'dce-dynamicPosts-carousel' => '/assets/css/dynamic-posts-v2-skin-carousel.css',
		'dce-dynamicPosts-dualcarousel' => '/assets/css/dynamic-posts-v2-skin-dual-carousel.css',
		'dce-dynamicPosts-timeline' => '/assets/css/dynamic-posts-v2-skin-timeline.css',
		'dce-dynamicPosts-smoothscroll' => '/assets/css/dynamic-posts-v2-skin-smoothscroll.css',
		'dce-dynamicPosts-gridtofullscreen3d' => '/assets/css/dynamic-posts-v2-skin-grid-to-fullscreen-3d.css',
		'dce-dynamicPosts-crossroadsslideshow' => '/assets/css/dynamic-posts-v2-skin-crossroads-slideshow.css',
		'dce-dynamicPosts-nextpost' => '/assets/css/dynamic-posts-v2-skin-next-post.css',
		'dce-dynamicPosts-3d' => '/assets/css/dynamic-posts-v2-skin-3d.css',
		'dce-dynamicUsers' => '/assets/css/dynamic-users.css',
		'dce-iconFormat' => '/assets/css/icon-format.css',
		'dce-nextPrev' => '/assets/css/prev-next.css',
		'dce-list' => '/assets/css/taxonomy-terms-list.css',
		'dce-featuredImage' => '/assets/css/featured-image.css',
		'dce-modalWindow' => '/assets/css/fire-modal-window.css',
		'dce-modal' => '/assets/css/modals.css',
		'dce-pageScroll' => '/assets/css/page-scroll.css',
		'dce-reveal' => '/assets/css/reveal.css',
		'dce-threesixtySlider' => '/assets/css/threesixty-360.css',
		'dce-twentytwenty' => '/assets/css/before-after.css',
		'dce-parallax' => '/assets/css/parallax.css',
		'dce-filebrowser' => '/assets/css/file-browser.css',
		'dce-animatetext' => '/assets/css/animated-text.css',
		'dce-imagesDistortion' => '/assets/css/distortion-image.css',
		'dce-animatedOffcanvasMenu' => '/assets/css/animated-off-canvas-menu.css',
		'dce-cursorTracker' => '/assets/css/cursor-tracker.css',
		'dce-title' => '/assets/css/title.css',
		'dce-breadcrumbs' => '/assets/css/breadcrumbs.css',
		'dce-date' => '/assets/css/date.css',
		'dce-addtofavorites' => '/assets/css/add-to-favorites.css',
		'dce-terms' => '/assets/css/terms-and-taxonomy.css',
		'dce-content' => '/assets/css/content.css',
		'dce-excerpt' => '/assets/css/excerpt.css',
		'dce-readmore' => '/assets/css/read-more.css',
		'dce-bgCanvas' => '/assets/css/bg-canvas.css',
		'dce-svg' => '/assets/css/svg.css',
	);
	public static $vendor_css = array(
		'dce-photoSwipe_default' => '/assets/lib/photoSwipe/photoswipe.min.css',
		'dce-photoSwipe_skin' => '/assets/lib/photoSwipe/default-skin/default-skin.min.css',
		'dce-justifiedGallery' => '/assets/lib/justifiedGallery/css/justifiedGallery.min.css',
		'dce-file-icon' => '/assets/lib/file-icon/file-icon-vivid.min.css',
		'animatecss' => '/assets/lib/animate/animate.min.css',
		'datatables' => '/assets/lib/datatables/datatables.min.css',
		'plyr' => '/assets/lib/plyr/plyr.css',
		'dce-swiper' => '/assets/lib/swiper/css/swiper.min.css',
	);

	public static $vendor_js;

	private static function init_vendor_js() {
		$google_maps_api = get_option( 'dce_google_maps_api' );
		$locale2 = substr( get_locale(), 0, 2 );

		if ( get_option( 'dce_paypal_api_mode', 'sandbox' ) === 'sandbox' ) {
			$paypal_client_id = get_option( 'dce_paypal_api_client_id_sandbox' );
		} else {
			$paypal_client_id = get_option( 'dce_paypal_api_client_id_live' );
		}
		$paypal_currency = get_option( 'dce_paypal_api_currency', 'USD' );
		self::$vendor_js = [
			'dce-html2canvas' => '/assets/lib/html2canvas/html2canvas.min.js',
			'dce-jspdf' => 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.1.1/jspdf.umd.min.js',
			'dce-aframe' => 'https://cdnjs.cloudflare.com/ajax/libs/aframe/1.0.4/aframe.min.js',
			'dce-datatables' => '/assets/lib/datatables/datatables.min.js',
			'dce-plyr-js' => '/assets/lib/plyr/plyr.min.js',
			'dce-wow' => '/assets/lib/wow/wow.min.js',
			'isotope' => '/assets/lib/isotope/isotope.pkgd.min.js',
			'dce-infinitescroll' => '/assets/lib/infiniteScroll/infinite-scroll.pkgd.min.js',
			'jquery-slick-deprecated' => '/assets/lib/slick/slick.min.js',
			'velocity' => '/assets/lib/velocity/velocity.min.js',
			'velocity-ui' => '/assets/lib/velocity/velocity.ui.min.js',
			'diamonds' => '/assets/lib/diamonds/jquery.diamonds.js',
			'homeycombs' => '/assets/lib/homeycombs/jquery.homeycombs.js',
			'photoswipe' => '/assets/lib/photoSwipe/photoswipe.min.js',
			'photoswipe-ui' => '/assets/lib/photoSwipe/photoswipe-ui-default.min.js',
			'tilt-lib' => '/assets/lib/tilt/tilt.jquery.min.js',
			'dce-jquery-visible' => '/assets/lib/visible/jquery-visible.min.js',
			'jquery-easing' => '/assets/lib/jquery-easing/jquery-easing.min.js',
			'justifiedGallery-lib' => '/assets/lib/justifiedGallery/js/jquery.justifiedGallery.min.js',
			'dce-parallaxjs-lib' => '/assets/lib/parallaxjs/parallax.min.js',
			'dce-threesixtyslider-lib' => '/assets/lib/threesixty-slider/threesixty.min.js',
			'dce-jqueryeventmove-lib' => '/assets/lib/twentytwenty/jquery.event.move.js',
			'dce-twentytwenty-lib' => '/assets/lib/twentytwenty/jquery.twentytwenty.js',
			'dce-anime-lib' => '/assets/lib/anime/anime.min.js',
			'dce-signature-lib' => 'https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js',
			'dce-distortion-lib' => '/assets/lib/distortion/distortion-lib.js',
			'dce-threejs-lib' => '/assets/lib/threejs/three.min.js',
			'dce-threejs-figure' => '/assets/lib/threejs/figure.js',
			'dce-threejs-EffectComposer' => '/assets/lib/threejs/postprocessing/EffectComposer.js',
			'dce-threejs-RenderPass' => '/assets/lib/threejs/postprocessing/RenderPass.js',
			'dce-threejs-ShaderPass' => '/assets/lib/threejs/postprocessing/ShaderPass.js',
			'dce-threejs-BloomPass' => '/assets/lib/threejs/postprocessing/BloomPass.js',
			'dce-threejs-FilmPass' => '/assets/lib/threejs/postprocessing/FilmPass.js',
			'dce-threejs-HalftonePass' => '/assets/lib/threejs/postprocessing/HalftonePass.js',
			'dce-threejs-DotScreenPass' => '/assets/lib/threejs/postprocessing/DotScreenPass.js',
			'dce-threejs-GlitchPass' => '/assets/lib/threejs/postprocessing/GlitchPass.js',
			'dce-threejs-CopyShader' => '/assets/lib/threejs/shaders/CopyShader.js',
			'dce-threejs-HalftoneShader' => '/assets/lib/threejs/shaders/HalftoneShader.js',
			'dce-threejs-RGBShiftShader' => '/assets/lib/threejs/shaders/RGBShiftShader.js',
			'dce-threejs-DotScreenShader' => '/assets/lib/threejs/shaders/DotScreenShader.js',
			'dce-threejs-ConvolutionShader' => '/assets/lib/threejs/shaders/ConvolutionShader.js',
			'dce-threejs-FilmShader' => '/assets/lib/threejs/shaders/FilmShader.js',
			'dce-threejs-ColorifyShader' => '/assets/lib/threejs/shaders/ColorifyShader.js',
			'dce-threejs-VignetteShader' => '/assets/lib/threejs/shaders/VignetteShader.js',
			'dce-threejs-DigitalGlitch' => '/assets/lib/threejs/shaders/DigitalGlitch.js',
			'dce-threejs-PixelShader' => '/assets/lib/threejs/shaders/PixelShader.js',
			'dce-threejs-LuminosityShader' => '/assets/lib/threejs/shaders/LuminosityShader.js',
			'dce-threejs-SobelOperatorShader' => '/assets/lib/threejs/shaders/SobelOperatorShader.js',
			'dce-threejs-AsciiEffect' => '/assets/lib/threejs/effects/AsciiEffect.js',
			// WebGL Distortion
			'dce-data-gui' => '/assets/lib/threejs/libs/dat.gui.min.js',
			'dce-displacement-sketch' => '/assets/lib/threejs/sketch.js',
			// Dynamic Posts v2
			'dce-threejs-gridtofullscreeneffect' => '/assets/lib/threejs/GridToFullscreenEffect.js',
			'dce-threejs-TweenModule' => '/assets/lib/threejs/libs/tween.module.min.js',
			'dce-threejs-TrackballControls' => '/assets/lib/threejs/controls/TrackballControls.js',
			'dce-threejs-OrbitControls' => '/assets/lib/threejs/controls/OrbitControls.js',
			'dce-threejs-CameraControls' => '/assets/lib/threejs/controls/camera-controls.min.js',
			'dce-threejs-CSS3DRenderer' => '/assets/lib/threejs/renderers/CSS3DRenderer.js',
			// GSAP
			'dce-tweenMax-lib' => '/assets/lib/greensock/TweenMax.min.js',
			'dce-tweenLite-lib' => '/assets/lib/greensock/TweenLite.min.js',
			'dce-timelineLite-lib' => '/assets/lib/greensock/TimelineLite.min.js',
			'dce-timelineMax-lib' => '/assets/lib/greensock/TimelineMax.min.js',
			'dce-morphSVG-lib' => '/assets/lib/greensock/plugins/MorphSVGPlugin.min.js',
			'dce-splitText-lib' => '/assets/lib/greensock/utils/SplitText.min.js',
			'dce-textPlugin-lib' => '/assets/lib/greensock/plugins/TextPlugin.min.js',
			'dce-svgdraw-lib' => '/assets/lib/greensock/plugins/DrawSVGPlugin.min.js',
			'dce-gsap-lib' => '/assets/lib/greensock/gsap.min.js',
			'dce-ScrollToPlugin-lib' => '/assets/lib/greensock/plugins/ScrollToPlugin.min.js',
			'dce-ScrollTrigger-lib' => '/assets/lib/greensock/plugins/ScrollTrigger.min.js',
			// CANVAS
			'dce-bgcanvas-js' => '/assets/js/bg-canvas.js',
			'dce-rellaxjs-lib' => '/assets/lib/rellax/rellax.min.js',
			'dce-clipboard-js' => '/assets/lib/clipboard.js/clipboard.min.js',
			'dce-revealFx' => '/assets/lib/reveal/revealFx.js',
			'dce-scrollify' => '/assets/lib/scrollify/jquery.scrollify.js',
			'dce-inertia-scroll' => '/assets/lib/inertiaScroll/jquery-inertiaScroll.js',
			'dce-lax-lib' => '/assets/lib/lax/lax.min.js',
			'dce-scrolling' => '/assets/js/scrolling.js',
			'dce-google-maps-api' => "https://maps.googleapis.com/maps/api/js?key=${google_maps_api}&language=${locale2}",
			'dce-google-maps-markerclusterer' => 'https://unpkg.com/@googlemaps/markerclustererplus/dist/index.min.js',
			'dce-google-maps' => '/assets/js/dynamic-google-maps.js',
			'dce-stripe-js' => 'https://js.stripe.com/v3',
		];
		if ( ! empty( $paypal_client_id ) ) {
			self::$vendor_js['dce-paypal-sdk'] = "https://www.paypal.com/sdk/js?client-id=${paypal_client_id}&currency=${paypal_currency}";
		}
	}

	public static $scripts = array(

		'dce-stripe' => [
			'path' => '/assets/js/stripe.js',
			'deps' => [ 'dce-stripe-js' ],
		],
		'dce-paypal' => [
			'path' => '/assets/js/paypal.js',
			'deps' => [ 'dce-paypal-sdk' ],
		],
		'dce-pdf-jsconv' => [
			'path' => '/assets/js/pdf-button-js-converter.js',
			'deps' => [ 'dce-jspdf', 'dce-html2canvas' ],
		],
		'dce-main' => '/assets/js/main.js',
		'dce-admin-js' => 'assets/js/admin.js',
		'dce-globalsettings-js' => [
			'path' => 'assets/js/global-settings.js',
			'deps' => [ 'jquery' ],
		],
		'dce-script-editor-visibility' => [
			'path' => '/assets/js/visibility.js',
			'deps' => [ 'dce-script-editor' ],
		],
		'dce-ajaxmodal' => '/assets/js/ajax-modal.js',
		'dce-cookie' => '/assets/js/cookie.js',
		'dce-settings' => '/assets/js/settings.js',
		'dce-animatetext' => '/assets/js/animated-text.js',
		'dce-modals' => '/assets/js/modals.js',
		'dce-acfgallery' => '/assets/js/acf-gallery.js',
		'dce-acfslider-js' => '/assets/js/acf-slider.js',
		'dce-parallax-js' => '/assets/js/parallax.js',
		'dce-threesixtyslider' => '/assets/js/threesixty-slider.js',
		'dce-twentytwenty' => '/assets/js/after-before.js',
		'dce-tilt' => '/assets/js/tilt.js',
		'dce-acf_posts' => '/assets/js/dynamic-posts.js',
		// Dynamic Posts v2
		'dce-dynamicPosts-base' => '/assets/js/dynamic-posts-v2-base.js',
		'dce-dynamicPosts-grid' => '/assets/js/dynamic-posts-v2-skin-grid.js',
		'dce-dynamicPosts-carousel' => '/assets/js/dynamic-posts-v2-skin-carousel.js',
		'dce-dynamicPosts-dualcarousel' => '/assets/js/dynamic-posts-v2-skin-dual-carousel.js',
		'dce-dynamicPosts-timeline' => '/assets/js/dynamic-posts-v2-skin-timeline.js',
		'dce-dynamicPosts-smoothscroll' => '/assets/js/dynamic-posts-v2-skin-smoothscroll.js',
		'dce-dynamicPosts-gridtofullscreen3d' => '/assets/js/dynamic-posts-v2-skin-grid-to-fullscreen-3d.js',
		'dce-dynamicPosts-crossroadsslideshow' => '/assets/js/dynamic-posts-v2-skin-crossroads-slideshow.js',
		'dce-dynamicPosts-nextpost' => '/assets/js/dynamic-posts-v2-skin-next-post.js',
		'dce-dynamicPosts-3d' => '/assets/js/dynamic-posts-v2-skin-3d.js',
		'dce-acf_repeater' => '/assets/js/acf-repeater.js',
		'dce-content-js' => '/assets/js/content.js',
		'dce-dynamic_users' => '/assets/js/dynamic-users.js',
		'dce-acf_fields' => '/assets/js/acf-fields.js',
		'dce-modalwindow' => '/assets/js/fire-modal-window.js',
		'dce-nextPrev' => '/assets/js/next-prev.js',
		'dce-rellax' => '/assets/js/rellax.js',
		'dce-reveal' => '/assets/js/reveal.js',
		'dce-svgmorph' => '/assets/js/svg-morphing.js',
		'dce-svgdistortion' => '/assets/js/svg-distortion.js',
		'dce-svgfe' => '/assets/js/svg-filter-effects.js',
		'dce-svgblob' => '/assets/js/svg-blob.js',
		'dce-imagesdistortion-js' => '/assets/js/distortion-image.js',
		'dce-scrolling' => '/assets/js/scrolling.js',
		'dce-animatedoffcanvasmenu-js' => '/assets/js/animated-off-canvas-menu.js',
		'dce-cursorTracker-js' => '/assets/js/cursor-tracker.js',
		'dce-advancedvideo' => '/assets/js/advanced-video.js',
		'dce-form-summary' => '/assets/js/multi-step-summary.js',
		'dce-signature' => '/assets/js/signature.js',
	);

	public function __construct() {
		self::init_vendor_js();
		$this->init();
	}

	public function init() {

		// Custom CSS and JS
		add_action( 'wp_head', [ $this, 'dce_head' ] );
		add_action( 'wp_footer', [ $this, 'dce_footer' ], 100 );

		// add custom body class
		add_filter('body_class', function ( $classes ) {
			$classes[] = 'elementor-dce';
			return $classes;
		});

		// force jquery in head
		add_action('wp_enqueue_scripts', function () {
			wp_enqueue_script( 'jquery' );
		});

		// Admin Style
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );

		// OCEANWP SCRIPT
		add_action('elementor/frontend/after_enqueue_scripts', function () {
			$theme = wp_get_theme();
			if ( 'OceanWP' == $theme->name || 'oceanwp' == $theme->template ) {
				$dir = OCEANWP_JS_DIR_URI;
				$theme_version = OCEANWP_THEME_VERSION;
				wp_enqueue_script( 'oceanwp-main', $dir . 'main.min.js', array( 'jquery' ), $theme_version, true );
			}
		});

		// Scripts
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'dce_frontend_enqueue_scripts' ] );

		// Styles
		add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_vendor_styles' ) );
		add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'dce_frontend_enqueue_style' ) );

		// Editor
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'dce_editor' ) );
		add_action( 'elementor/preview/enqueue_styles', array( $this, 'dce_preview' ) );

		// Global enqueue Script and Style
		add_action( 'wp_enqueue_scripts', array( $this, 'dce_globals_stylescript' ) );
	}

	public static function dce_globals_stylescript() {
		$is_in_editor = \DynamicContentForElementor\Helper::is_edit_mode();

		// Global
		if ( get_option( 'enable_smoothtransition' ) || $is_in_editor ) {
			// Global Settings CSS LIB
			wp_enqueue_style( 'animsition-base', DCE_URL . 'assets/lib/animsition/css/animsition.css' );
			wp_enqueue_style( 'dce-animations' );
			// Global Settings JS LIB
			wp_enqueue_script( 'dce-animsition-lib', DCE_URL . 'assets/lib/animsition/js/animsition.min.js', array( 'jquery' ), DCE_VERSION, true );
		}
		if ( get_option( 'enable_trackerheader' ) || $is_in_editor ) {
			// Global Settings JS LIB
			wp_enqueue_script( 'dce-trackerheader-lib', DCE_URL . 'assets/lib/headroom/headroom.min.js', array( 'jquery' ), DCE_VERSION, true );
		}
		if ( get_option( 'enable_trackerheader' ) || get_option( 'enable_smoothtransition' ) || $is_in_editor ) {
			wp_enqueue_script( 'dce-globalsettings-js' );
			wp_enqueue_style( 'dce-globalsettings' );

			$settings_controls = ( new \DynamicContentForElementor\Includes\Settings\Settings_Manager() )->dce_settings();
			wp_localize_script( 'dce-globalsettings-js', 'dceGlobalSettings', $settings_controls );
		}
	}

	public static function dce_frontend_enqueue_style() {
		wp_enqueue_style( 'dce-style' );
		wp_enqueue_style( 'dashicons' );
	}

	public static function get_enabled_css() {
		$widget_manager = new Widgets();
		$widget_manager->on_widgets_registered();

		$extension_manager = new Extensions();
		$extension_manager->on_extensions_registered();

		$document_manager = new Documents();
		$document_manager->on_documents_registered();

		self::$dce_styles[] = 'dce-style';

		return self::$dce_styles;
	}

	public static function get_enabled_js() {
		$widget_manager = new Widgets();
		$widget_manager->on_widgets_registered();

		$extension_manager = new Extensions();
		$extension_manager->on_extensions_registered();

		$document_manager = new Documents();
		$document_manager->on_documents_registered();

		self::$dce_scripts[] = 'dce-settings';
		self::$dce_scripts[] = 'dce-main';

		return self::$dce_scripts;
	}

	public static function add_depends( $element ) {
		$w_styles = $element->get_style_depends();
		if ( ! empty( $w_styles ) ) {
			self::$dce_styles = array_merge( self::$dce_styles, $w_styles );
		}
		$w_scripts = $element->get_script_depends();
		if ( ! empty( $w_scripts ) ) {
			self::$dce_scripts = array_merge( self::$dce_scripts, $w_scripts );
		}
	}

	public function register_styles() {
		foreach ( self::$styles as $name => $path ) {
			// if the styles specifies dependencies:
			if ( is_array( $path ) ) {
				$deps = $path['deps'];
				$path = $path['path'];
			} else {
				$deps = [];
			}
			if ( 'http' !== substr( $path, 0, 4 ) ) {
				if ( ! WP_DEBUG ) {
					$path = str_replace( '.css', '.min.css', $path );
				}
				$path = plugins_url( $path, DCE__FILE__ );
			}
			wp_register_style( $name, $path, $deps, DCE_VERSION );
		}
	}

	public function register_vendor_styles() {
		foreach ( self::$vendor_css as $name => $path ) {
			// if the styles specifies dependencies:
			if ( is_array( $path ) ) {
				$deps = $path['deps'];
				$path = $path['path'];
			} else {
				$deps = [];
			}
			if ( 'http' !== substr( $path, 0, 4 ) ) {
				$path = plugins_url( $path, DCE__FILE__ );
			}
			wp_register_style( $name, $path, $deps, DCE_VERSION );
		}
	}

	public static function register_dce_scripts() {
		foreach ( self::$scripts as $name => $path ) {
			// if the script specifies dependencies:
			if ( is_array( $path ) ) {
				$deps = $path['deps'];
				$path = $path['path'];
			} else {
				$deps = [];
			}
			if ( 'http' !== substr( $path, 0, 4 ) ) {
				if ( ! WP_DEBUG ) {
					$path = str_replace( '.js', '.min.js', $path );
				}
				$path = plugins_url( $path, DCE__FILE__ );
			}
			wp_register_script( $name, $path, $deps, DCE_VERSION );
		}
	}

	public static function register_vendor_scripts() {
		foreach ( self::$vendor_js as $name => $path ) {
			// if the script specifies dependencies:
			if ( is_array( $path ) ) {
				$deps = $path['deps'];
				$path = $path['path'];
			} else {
				$deps = [];
			}
			if ( substr( $path, 0, 4 ) != 'http' ) {
				$path = plugins_url( $path, DCE__FILE__ );
				wp_register_script( $name, $path, $deps, DCE_VERSION );
			} else {
				wp_register_script( $name, $path, $deps, null );
			}
		}
	}

	public function register_scripts() {
		self::register_dce_scripts();
		self::register_vendor_scripts();
	}

	//
	public function dce_frontend_enqueue_scripts() {
		wp_enqueue_script( 'dce-settings' );
	}

	public function dce_head() {
		self::add_head_frontend_js();
	}

	public static function add_head_frontend_js() {
		$template_id = Elements::get_main_template_id();
		if ( $template_id ) {
			$widgets = get_post_meta( $template_id, 'dce_widgets', true );
			if ( ! empty( $widgets ) ) {
				if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
					if ( isset( $widgets['dyncontel-panorama'] ) ) {
						echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/aframe/1.0.4/aframe.min.js" integrity="sha512-C5o7nqPhPwvfu3ZXTzTXJMyDMdxu65TtMd+GNHUrxtxhK9TdYS56W4QCtIIL+dvE9jXRsH3HmIkM0sfcfPyjug==" crossorigin="anonymous"></script>';
					}
				}
			}
		}
	}

	public function dce_footer() {
		if ( ! empty( Elements::$elements['widget'] ) ) {
			$template_id = Elements::get_main_template_id();
			if ( $template_id ) {
				$widgets = get_post_meta( $template_id, 'dce_widgets', true );
				if ( empty( $widgets ) ) {
					$widgets = Elements::$elements['widget'];
				} else {
					foreach ( Elements::$elements['widget'] as $wkey => $awidget ) {
						$widgets[ $wkey ] = $awidget;
					}
				}
				update_post_meta( $template_id, 'dce_widgets', Elements::$elements['widget'] );
			}
		}
		self::add_footer_frontend_css();
		self::add_footer_frontend_js();
	}

	public static function dce_enqueue_script( $handle, $js = '', $element_id = false ) {
		if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			self::$dce_scripts[ $handle ] = $js;
			return '';
		} else {
			if ( is_array( $js ) ) {
				$js = $js['script'];
			}
		}

		return $js;
	}

	public static function dce_enqueue_style( $handle, $css = '', $element_id = false ) {
		if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			if ( empty( self::$dce_styles[ $handle ] ) ) {
				self::$dce_styles[ $handle ] = $css;
			} else {
				self::$dce_styles[ $handle ] .= $css;
			}
			return '';
		}
		return $css;
	}

	public static function add_footer_frontend_js( $inline = true ) {
		$js = '';
		if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$script_keys = array_keys( self::$scripts );
			$vendor_keys = array_keys( self::$vendor_js );
			foreach ( self::$dce_scripts as $skey => $ascript ) {
				if ( is_numeric( $skey ) || in_array( $ascript, $script_keys ) || in_array( $ascript, $vendor_keys ) ) {
					unset( self::$dce_scripts[ $skey ] );
				}
			}
			if ( ! empty( self::$dce_scripts ) ) {
				if ( $inline ) {
					foreach ( self::$dce_scripts as $jkey => $jscript ) {
						$tmp = explode( '-', $jkey );
						$element_id = array_pop( $tmp );
						$element_type = implode( '-', $tmp );
						$fnc = str_replace( '-', '_', $jkey );
						$element_hook = $element_type . '.default';

						if ( is_array( $jscript ) ) {
							$fnc = $jscript['type'] . '_' . $jscript['name'] . '_' . $jscript['id'];
							if ( ! empty( $jscript['sub'] ) ) {
								$fnc .= '_' . $jscript['sub'];
							}
							$js .= '<script id="dce-' . $jkey . '">
                                ( function( $ ) {
                                    var dce_' . $fnc . ' = function( $scope, $ ) {
                                        ' . self::remove_script_wrapper( $jscript['script'] ) . '
                                    };
                                    $( window ).on( \'elementor/frontend/init\', function() {
                                        elementorFrontend.hooks.addAction( \'frontend/element_ready/' . $jscript['name'] . '.default\', dce_' . $fnc . ' );
                                    } );
                                } )( jQuery, window );
                                </script>';
						} else {
							if ( ! empty( strip_tags( $jscript ) ) ) {
								if ( strpos( $jscript, '<script' ) !== false ) {
									if ( strpos( $jscript, '<script>' ) !== false ) {
										$js .= str_replace( '<script', '<script id="dce-' . $jkey . '"', $jscript );
									} else {
										$js .= $jscript;
									}
								} else {
									$js .= '<script id="' . $jkey . '">' . $jscript . '</script>';
								}
							}
						}
					}
				} else {
					$post_id = Elements::get_main_template_id();
					$upload_dir = wp_get_upload_dir();
					$js_file = 'post-' . $post_id . '.js';
					$js_dir = $upload_dir['basedir'] . '/elementor/js/';
					$js_baseurl = $upload_dir['baseurl'] . '/elementor/js/';
					$js_path = $js_dir . $js_file;
					if ( is_file( $js_path ) ) {
						$file_modified_date = filemtime( $js_path );
						if ( get_the_modified_date( 'U', $post_id ) > $file_modified_date ) {
							unlink( $js_path );
						}
					}
					if ( ! is_file( $js_path ) ) {
						// create folder (if not exist)
						if ( ! is_dir( $js_dir ) ) {
							mkdir( $js_dir, 0755, true );
						}
						// create the file
						$js_file_content = '';
						foreach ( self::$dce_scripts as $jkey => $jscript ) {
							if ( strpos( $jscript, '<script' ) !== false ) {
								$jscript = str_replace( '<script>', '', $jscript );
								$jscript = str_replace( '</script>', '', $jscript );
							}
							if ( ! empty( $jscript ) ) {
								$js_file_content .= '// ' . $jkey . PHP_EOL . $jscript;
							}
						}
						if ( ! empty( $js_file_content ) ) {
							file_put_contents( $js_path, $js_file_content );
						}
					}
					if ( is_file( $js_path ) ) {
						$js_url = $js_baseurl . $js_file;
						echo '<script type="text/javascript" src="' . $js_url . '"></script>';
					}
				}
			}
		}
		echo $js;
	}

	public static function add_footer_frontend_css( $inline = true ) {
		$css = '';
		if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$style_keys = array_keys( self::$styles );
			$vendor_keys = array_keys( self::$vendor_css );
			foreach ( self::$dce_styles as $skey => $astyle ) {
				if ( is_numeric( $skey ) || in_array( $astyle, $style_keys ) || in_array( $astyle, $vendor_keys ) ) {
					unset( self::$dce_styles[ $skey ] );
				}
			}
			if ( ! empty( self::$dce_styles ) ) {
				if ( $inline ) {
					foreach ( self::$dce_styles as $ckey => $cstyle ) {
						if ( $cstyle ) {
							$css .= '<style id="dce-' . $ckey . '">' . self::remove_style_wrapper( $cstyle ) . '</style>';
						}
					}
				}
			}
		}
		echo $css;
	}

	public static function remove_script_wrapper( $script ) {
		$script = str_replace( '<script>', '', $script );
		$script = str_replace( '</script>', '', $script );

		$script = str_replace( 'jQuery(', 'setTimeout(', $script );
		return $script;
	}

	public static function remove_style_wrapper( $style ) {
		$style = str_replace( '<style>', '', $style );
		$style = str_replace( '</style>', '', $style );
		return $style;
	}

	// Woocommerce script
	public function dce_wc_enqueue_scripts() {
		// In preview mode it's not a real Product page - enqueue manually.

		if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
			wp_enqueue_script( 'zoom' );
		}
		if ( current_theme_supports( 'wc-product-gallery-slider' ) ) {
			wp_enqueue_script( 'flexslider' );
		}
		if ( current_theme_supports( 'wc-product-gallery-lightbox' ) ) {
			wp_enqueue_script( 'photoswipe-ui-default' );
			wp_enqueue_style( 'photoswipe-default-skin' );
		}
		wp_enqueue_script( 'wc-single-product' );
		wp_enqueue_script( 'woocommerce' );

		wp_enqueue_style( 'photoswipe' );
		wp_enqueue_style( 'photoswipe-default-skin' );
		wp_enqueue_style( 'photoswipe-default-skin' );
		wp_enqueue_style( 'woocommerce_prettyPhoto_css' );
	}

	/**
	 * Enqueue admin styles
	 *
	 * @since 0.0.3
	 *
	 * @access public
	 */
	public function enqueue_admin_styles() {
		// Register Admin style
		wp_register_style( 'dce-admin-css', DCE_URL . 'assets/css/admin.css', [], DCE_VERSION );

		// select2
		wp_enqueue_style( 'dce-select2', DCE_URL . 'assets/lib/select2/select2.min.css', [], DCE_VERSION );
		wp_enqueue_script( 'dce-select2', DCE_URL . 'assets/lib/select2/select2.full.min.js', array( 'jquery' ), DCE_VERSION, true );

		// Enqueue Admin Style
		wp_enqueue_style( 'dce-admin-css' );
		// Enqueue Admin Script
		wp_enqueue_script( 'dce-admin-js', DCE_URL . 'assets/js/admin.js', [], DCE_VERSION );
	}

	/**
	 * The following scripts and styles are registered here because when
	 * loading the elementor editor the wp actions used for the registrations
	 * are not run.
	 */
	public function dce_editor() {
		// Register styles
		wp_register_style(
			'dce-style-icons',
			plugins_url( '/assets/css/icons.css', DCE__FILE__ ),
			[],
			DCE_VERSION
		);
		// Enqueue styles Icons
		wp_enqueue_style( 'dce-style-icons' );

		// Register styles
		wp_register_style(
			'dce-style-editor',
			plugins_url( '/assets/css/editor.css', DCE__FILE__ ),
			[],
			DCE_VERSION
		);
		// Enqueue styles Editor
		wp_enqueue_style( 'dce-style-editor' );

		wp_register_script(
			'dce-script-editor',
			plugins_url( '/assets/js/editor.js', DCE__FILE__ ),
			[],
			DCE_VERSION
		);
		wp_enqueue_script( 'dce-script-editor' );

	}

	/**
	 * Enqueue admin styles
	 *
	 * @since 1.0.3
	 *
	 * @access public
	 */
	public function dce_preview() {
		// Enqueue DCE Elementor Style
		wp_enqueue_style( 'dce-preview' );
	}

	public static function dce_icon() {
		// Enqueue styles Icons
		wp_enqueue_style( 'dce-style-icons' );
	}

	public static function wp_print_styles( $handle = false, $print = true ) {
		$styles = '';
		if ( $handle ) {
			if ( ! empty( self::$styles[ $handle ] ) ) {
				$styles .= '<link rel="stylesheet" id="' . $handle . '" href="' . DCE_URL . self::$styles[ $handle ] . '" type="text/css" media="all" />';
			}
		}
		if ( $print ) {
			echo $styles;
		}
		return $styles;
	}
}
