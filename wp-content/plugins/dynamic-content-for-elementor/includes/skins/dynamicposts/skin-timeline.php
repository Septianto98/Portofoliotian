<?php
namespace DynamicContentForElementor\Includes\Skins;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

use DynamicContentForElementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Skin_Timeline extends Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();

		add_action( 'elementor/element/dce-dynamicposts-v2/section_dynamicposts/after_section_end', [ $this, 'register_additional_timeline_controls' ] );
	}

	public function get_script_depends() {
		return [];
	}
	public function get_style_depends() {
		return [];
	}
	public function get_id() {
		return 'timeline';
	}

	public function get_title() {
		return __( 'Timeline', 'dynamic-content-for-elementor' );
	}

	public function register_additional_timeline_controls() {
		$this->start_controls_section(
			'section_timeline',
			[
				'label' => '<i class="dynicon eicon-time-line"></i> ' . __( 'Timeline', 'dynamic-content-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,

			]
		);
		$this->add_control(
			'timeline_use_description',
			[
				'label' => '<i class="fas fa-align-left"></i>&nbsp;&nbsp;' . __( 'Show Content', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		$this->add_control(
			'timeline_use_date',
			[
				'label' => '<i class="far fa-calendar-alt"></i>&nbsp;&nbsp;' . __( 'Show Date', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		$this->add_responsive_control(
			'timeline_imagesize',
			[
				'label' => '<i class="fas fa-image"></i>&nbsp;&nbsp;' . __( 'Image size', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'separator' => 'before',
				'default' => [
					'size' => '64',
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 400,
					],
				],

				'selectors' => [
					'{{WRAPPER}} .dce-timeline__img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',

				],
			]
		);
		$this->add_responsive_control(
			'timeline_verticalposition',
			[
				'label' => '<i class="fas fa-arrows-alt-v"></i>&nbsp;&nbsp;' . __( 'Vertical Position', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],

				'default' => [
					'size' => '32',
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 400,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dce-timeline__block .dce-timeline__content::before, {{WRAPPER}} .dce-timeline__block .dce-timeline__img, {{WRAPPER}} .dce-timeline__block .dce-timeline__date' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'timeline_width',
			[
				'label' => '<i class="fas fa-arrows-alt-h"></i>&nbsp;&nbsp;' . __( 'Timeline Width', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'separator' => 'before',
				'size_units' => [ 'px', '%', 'vw' ],
				'default' => [
					'size' => '',
				],
				'range' => [
					'px' => [
						'max' => 1200,
						'min' => 0,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dce-timeline-wrapper' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'timeline_space_content',
			[
				'label' => '<i class="fas fa-clone"></i>&nbsp;<i class="fas fa-exchange-alt"></i>&nbsp;&nbsp;' . __( 'Content Space', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'separator' => 'before',
				'size_units' => [ 'px', '%', 'vw' ],
				'default' => [
					'size' => '',
				],
				'range' => [
					'px' => [
						'max' => 1200,
						'min' => 0,
						'step' => 1,
					],
				],
				'selectors' => [
					'body[data-elementor-device-mode=desktop] {{WRAPPER}} .dce-timeline__content' => 'width: calc((100% / 2) - ({{SIZE}}{{UNIT}} / 2))',
					'body[data-elementor-device-mode=desktop] {{WRAPPER}} .dce-timeline__block:nth-child(odd) .dce-timeline__date' => 'left: calc(100% + {{SIZE}}{{UNIT}})',
					'body[data-elementor-device-mode=desktop] {{WRAPPER}} .dce-timeline__block:nth-child(even) .dce-timeline__date' => 'right: calc(100% + {{SIZE}}{{UNIT}})',
				],
			]
		);
		$this->add_responsive_control(
			'timeline_rowspace',
			[
				'label' => '<i class="fas fa-arrows-alt-v"></i>&nbsp;&nbsp;' . __( 'Row Space', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
					'unit' => 'px',
				],
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'render_type' => 'template',
				'frontend_available' => true,
				'selectors' => [
					'{{WRAPPER}} .dce-timeline__block' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'timeline_shift_date',
			[
				'label' => '<i class="far fa-calendar-alt">&nbsp;</i><i class="fas fa-exchange-alt"></i>&nbsp;&nbsp;' . __( 'Date shift', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SLIDER,

				'size_units' => [ 'px' ],
				'default' => [
					'size' => '',
				],
				'range' => [
					'px' => [
						'max' => 200,
						'min' => -200,
						'step' => 1,
					],
				],
				'selectors' => [
					'body[data-elementor-device-mode=desktop] {{WRAPPER}} .dce-timeline__block:nth-child(odd) .dce-timeline__date' => 'margin-left: {{SIZE}}{{UNIT}};',
					'body[data-elementor-device-mode=desktop] {{WRAPPER}} .dce-timeline__block:nth-child(even) .dce-timeline__date' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}
	protected function register_style_controls() {

		$this->start_controls_section(
			'section_style_timeline',
			[
				'label' => __( 'Timeline', 'dynamic-content-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// ------------------- LINE - progress
		$this->add_control(
			'timeline_heading_line',
			[
				'label' => __( 'Line', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'timeline_styles' );

		$this->start_controls_tab(
			'timeline_style_normal',
			[
				'label' => __( 'Normal', 'dynamic-content-for-elementor' ),
			]
		);

		$this->add_control(
			'timleline_line_color',
			[
				'label' => __( 'Line Color', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dce-timeline-wrapper::before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .dce-timeline__block .dce-timeline__img' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'timeline_line_size',
			[
				'label' => __( 'Line size', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dce-timeline-wrapper::before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'timeline_bg_color_content',
			[
				'label' => __( 'Panel Background Color', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dce-timeline__block .dce-timeline__content' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .dce-timeline__block:nth-child(odd) .dce-timeline__content::before' => 'border-left-color: {{VALUE}}; border-right-color: {{VALUE}};',
					'{{WRAPPER}} .dce-timeline__block:nth-child(even) .dce-timeline__content::before' => 'border-right-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'timeline_bg_color_image',
			[
				'label' => __( 'Image Background Color', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .dce-timeline__block .dce-timeline__img' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'timeline_borderimage_size',
			[
				'label' => __( 'Border image size', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dce-timeline__block .dce-timeline__img' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'timeline_style_active',
			[
				'label' => __( 'Active', 'dynamic-content-for-elementor' ),
			]
		);

		$this->add_control(
			'timleline_activeline_color',
			[
				'label' => __( 'Active Line Color', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dce-timeline-wrapper::after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .dce-timeline__block.dce-timeline__focus .dce-timeline__img' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'timeline_activeline_size',
			[
				'label' => __( 'Active Line size', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dce-timeline-wrapper::after' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'timeline_activebg_color_content',
			[
				'label' => __( 'Panel Background Color', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dce-timeline__block.dce-timeline__focus .dce-timeline__content' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .dce-timeline__block.dce-timeline__focus:nth-child(odd) .dce-timeline__content::before' => 'border-left-color: {{VALUE}}; border-right-color: {{VALUE}};',
					'{{WRAPPER}} .dce-timeline__block.dce-timeline__focus:nth-child(even) .dce-timeline__content::before' => 'border-right-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'timeline_activebg_color_image',
			[
				'label' => __( 'Image Background Color', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .dce-timeline__block.dce-timeline__focus .dce-timeline__img' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'timeline_activeborderimage_size',
			[
				'label' => __( 'Border image size', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dce-timeline__block.dce-timeline__focus .dce-timeline__img' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		// ------------------- TITLE
		//       $this->add_control(
		//           'timeline_heading_Title', [
		//            'label' => __('Title', 'dynamic-content-for-elementor'),
		//            'type' => Controls_Manager::HEADING,
		//            'separator' => 'before',

		//           ]
		//       //title color
		// $this->add_control(
		//           'timeline_title_color', [
		//               'label' => __('Color', 'dynamic-content-for-elementor'),
		//               'type' => Controls_Manager::COLOR,
		//               'selectors' => [

		//               ],
		//           ]
		//       //title typography
		//       $this->add_group_control(
		//           Group_Control_Typography::get_type(), [
		//               'name' => 'timeline_title_typography',
		//               'selector' => '{{WRAPPER}} .dce-timeline__block .dce-timeline__title',

		//           ]
		//       // ------------------- DATE
		//       $this->add_control(
		//           'timeline_heading_date', [
		//            'label' => __('Date', 'dynamic-content-for-elementor'),
		//            'type' => Controls_Manager::HEADING,
		//            'separator' => 'before',

		//           ]
		//       //date color
		// $this->add_control(
		//           'timeline_date_color', [
		//               'label' => __('Color', 'dynamic-content-for-elementor'),
		//               'type' => Controls_Manager::COLOR,
		//               'selectors' => [

		//               ],
		//           ]
		//       //date typography
		//       $this->add_group_control(
		//           Group_Control_Typography::get_type(), [
		//               'name' => 'timeline_date_typography',
		//               'selector' => '{{WRAPPER}} .dce-timeline__block .dce-timeline__date',

		//           ]
		// $this->add_responsive_control(
		//     'date_pos_x', [
		//      'label' => __('Date Position X', 'dynamic-content-for-elementor'),
		//      'type' => Controls_Manager::SLIDER,
		//      'default' => [
		//          'size' => 0,
		//          'unit' => '%',

		//      ],
		//      'size_units' => ['px', '%'],
		//      'range' => [
		//          '%' => [
		//              'min' => 0,
		//              'max' => 100,
		//              'step' => 1

		//          ],
		//          'px' => [
		//              'min' => 1,
		//              'max' => 800,

		//          ]
		//      ],
		//      'selectors' => [

		//      ],
		//     ]
		// ------------------- CONTENT PANEL
		$this->add_control(
			'timeline_heading_panelcontent',
			[
				'label' => __( 'Panel Content', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'timeline_content_padding',
			[
				'label' => '<i class="fas fa-arrows-alt"></i>&nbsp;&nbsp;' . __( 'Content Padding', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .dce-timeline__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'timeline_radius_content',
			[
				'label' => __( 'Content Border Radius', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
					'unit' => 'px',
				],
				'size_units' => [ 'px', '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 50,
					],
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dce-timeline__content' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'timeline_arrows_size',
			[
				'label' => __( 'Content arrows size', 'dynamic-content-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dce-timeline__content::before, {{WRAPPER}} .dce-timeline__content::before' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'timeline_content_boxshadow',
				'selector' => '{{WRAPPER}} .dce-post-item .dce-post-block',
			]
		);
		$this->end_controls_section();
	}

	protected function render_post() {
		$post_items = $this->parent->get_settings( 'list_items' );

		global $post;

		$separatorArray = '';
		if ( $this->counter ) {
			$separatorArray = ',';
		}

		// ID
		$p_id = $this->current_id;
		// title
		$p_title = get_the_title();
		// content
		// slug
		$p_slug = $post->post_name;
		// image
		$p_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
		$p_alt = $this->get_attachment_alt( get_post_thumbnail_id() );
		// author image
		$p_author = get_the_author_meta( 'display_name' );
		$p_authorimage = get_avatar_url( get_the_author_meta( 'ID' ) );
		// date
		// type base
		$p_type = get_post_type_object( get_post_type() )->rest_base;
		if ( empty( $p_type ) ) {
			$p_type = get_post_type();
		}
		// Terms of taxonomy
		$p_terms = '';
		$taxonomy = get_post_taxonomies( $this->current_id );
		$cont = 0;
		$taxonomy_filter = $this->get_instance_value( 'nextpost_taxonomy_filter' );

		foreach ( $taxonomy as $tax ) {
			if ( isset( $taxonomy_filter ) && ! empty( $taxonomy_filter ) ) {
				if ( ! in_array( $tax, $taxonomy_filter ) ) {
					continue;
				}
			}
			if ( $tax != 'post_format' ) {
				$term_list = Helper::get_the_terms_ordered( $this->current_id, $tax );
				if ( $term_list && is_array( $term_list ) && count( $term_list ) > 0 ) {
					foreach ( $term_list as $key => $term ) {
						$sep = $cont ? ',' : '';
						$p_terms .= $sep . $term->name;
						$cont ++;
					}
				}
			}
		}
		$p_link = $this->current_permalink; ?>
		<div class="dce-timeline__block">
			<div class="dce-timeline__img dce-timeline__img--picture">
				<?php
				if ( ! empty( $p_image[0] ) ) {
					?>
					<img src="<?php echo $p_image[0]; ?>" alt="<?php echo $p_alt; ?>">
					<?php
				} else {
				} ?>
			</div> <!-- dce-timeline__img -->

			<div class="dce-timeline__content">



			<?php
			foreach ( $post_items as $key => $item ) {
				$_id = $item['_id'];
				$show_item = $item['show_item']; ?>
				<?php if ( $_id == 'item_title' ) {
					?>
					<div class="dce-timeline__title item_title">
						<?php
						$this->render_repeateritem_start( $_id );
						$this->render_title( $item );
						$this->render_repeateritem_end( $_id ); ?>
					</div>
					<?php
				} ?>

				<?php if ( $this->get_instance_value( 'timeline_use_description' ) && $_id == 'item_content' ) {
					?>
				<div class="dce-timeline__description item_content"><?php $this->render_content( $item ); ?></div>
					<?php
				} ?>


				<?php if ( $this->get_instance_value( 'timeline_use_date' ) && $_id == 'item_date' ) {
					?>
				<div class="dce-timeline__date item_date">
					<?php
					$this->render_repeateritem_start( $_id );
					$this->render_date( $item );
					$this->render_repeateritem_end( $_id ); ?>
				</div>


					<?php
				} ?>
				<?php
				if ( $_id == 'item_readmore' && $show_item == 'check' ) {
					$this->render_repeateritem_start( $_id ); ?>
					<div class="dce-timeline__readmore item_readmore">
						<?php $this->render_readmore( $item ); ?>
					</div>
					<?php
					$this->render_repeateritem_end( $_id );
				}
			} ?>
			</div> <!-- dce-timeline__content -->

		  </div> <!-- dce-timeline__block -->


		<?php

		$this->counter ++;
	}

	protected function get_attachment_alt( $attachment_id ) {

		// Get ALT
		$thumb_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

		// // No ALT supplied get attachment info
		// if ( empty( $thumb_alt ) )

		// // Use caption if no ALT supplied
		// if ( empty( $thumb_alt ) )

		// // Use title if no caption supplied either
		// if ( empty( $thumb_alt ) )

		// Return ALT
		return esc_attr( trim( strip_tags( $thumb_alt ) ) );
	}
	// Classes ----------
	public function get_container_class() {
		return 'dce-timeline js-dce-timeline dce-timeline-container dce-skin-' . $this->get_id();
	}
	public function get_wrapper_class() {
		return 'dce-timeline-wrapper dce-wrapper-' . $this->get_id();
	}
	public function get_item_class() {
		return 'dce-timeline__block dce-timeline-item dce-item-' . $this->get_id();
	}
}
