<?php
namespace DynamicContentForElementor\Widgets;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class DCE_Widget_ThreesixtySlider extends DCE_Widget_Prototype {

	public function get_name() {
		return 'dyncontel-threesixtyslider';
	}

	public function get_title() {
		return __( 'Threesixty 360', 'dynamic-content-for-elementor' );
	}
	public function get_description() {
		return __( 'Generate a rotation through a series of images', 'dynamic-content-for-elementor' );
	}
	public function get_docs() {
		return 'https://www.dynamic.ooo/widget/threesixty-360/';
	}
	public function get_icon() {
		return 'icon-dyn-360';
	}
	public function get_script_depends() {
		return [ 'dce-threesixtyslider-lib', 'dce-threesixtyslider' ];
	}
	public function get_style_depends() {
		return [ 'dce-threesixtySlider' ];
	}
	public static function get_position() {
		return 3;
	}

	public function show_in_panel() {
		if ( ! current_user_can( 'manage_options' ) ) {
				return false;
		}
			return true;
	}

	protected function _register_controls() {
		if ( current_user_can( 'manage_options' ) || ! is_admin() ) {
				$this->_register_controls_content();
		} elseif ( ! current_user_can( 'manage_options' ) && is_admin() ) {
			$this->register_controls_non_admin_notice();
		}
	}

	protected function _register_controls_content() {
		$this->start_controls_section(
			'section_threesixtyslider', [
				'label' => __( 'ThreesixtySlider', 'dynamic-content-for-elementor' ),
			]
		);
		$this->add_responsive_control(
			'width', [
				'label' => __( 'Width', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 400,
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .dce-threesixty' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'frontend_available' => true,
			]
		);
		$pathimg = plugins_url( '/assets/lib/threesixty-slider/imagesCube/', DCE__FILE__ );
		$pathimg = str_replace( get_home_url(), '', $pathimg );
		$this->add_control(
			'pathimages', [
				'label' => __( 'Path images', 'dynamic-content-for-elementor' ),
				'label_block' => true,
				'description' => __( 'The absolute path from root folder of the images for the 360.<br>The images in the folder must be called with the sequential number (e.g.:1.png, or 1.svg or 1.jpg.So 2.jpg, 3.jpg, 4.jpg etc.)', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => $pathimg,
				'placeholder' => '/wp-content/uploads/360/',
				'frontend_available' => true,
			]
		);
		$this->add_control(
			'navigation', [
				'label' => __( 'Navigation', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'frontend_available' => true,
			]
		);
		$this->add_control(
			'responsive', [
				'label' => __( 'Responsive', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'yes',
				'return_value' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$settings = $this->get_settings_for_display();

		$pathimages = $settings['pathimages'];
		if ( strpos( $settings['pathimages'], get_home_url() ) === false ) {
			$settings['pathimages'] = get_home_url() . $settings['pathimages'];
		} else {
			$pathimages = str_replace( get_home_url(), '', $pathimages );
		}
		if ( substr( $pathimages, 0, 1 ) === '/' ) {
			$pathimages = substr( $pathimages, 1 );
		}
		$path = ABSPATH . $pathimages;
		$images = glob( $path . '*.*' );
		$settings['total_frame'] = 0;
		foreach ( $images as $image ) {
			$pieces = explode( '.', $image );
			$ext = strtolower( array_pop( $pieces ) );
			if ( in_array( $ext, array( 'svg', 'jpg', 'png' ) ) ) {
				$settings['total_frame']++;
				$settings['format_file'] = $ext;
			}
		}
		$settings['end_frame'] = $settings['total_frame'];
		?>
		<div class="threesixty dce-threesixty"
			data-pathimages="<?php echo $settings['pathimages']; ?>"
			data-format_file="<?php echo $settings['format_file']; ?>"
			data-total_frame="<?php echo $settings['total_frame']; ?>"
			data-end_frame="<?php echo $settings['end_frame']; ?>"
			>
			<div class="spinner">
				<span>0%</span>
			</div>
			<ol class="threesixty_images"></ol>
		</div>
		<?php
	}
}
