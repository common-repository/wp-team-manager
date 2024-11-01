<?php
namespace DWL\Wtm\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use DWL\Wtm\Classes\Helper;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Plugin;
use \Elementor\Utils;
use \Elementor\Widget_Base;

/**
 * Elementor WTM Posts Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Team extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wtm-team-manager';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Team Manager', 'xevant' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-user-circle-o';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'dwl-items' ];
	}

	public function get_style_depends() {
		return [ 'wp-team-style', 'wp-team-font-awesome', 'wp-team-slick', 'wp-team-slick-theme'];
	}

	public function get_script_depends() {
		return [ 'wp-team-script','wp-team-slick', 'wp-team-script', 'wp-team-el-slider' ];
	}

	private function get_all_taxonomy( $taxonomy = 'category' ) {

		$options = array();

		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->term_id ) && isset( $term->name ) ) {
							$options[ $term->term_id ] = $term->name;
						}
					}
				}
			}
		}

		return $options;
	}
		/**
	 * Content Query Options.
	 */
	private function query_options() {

		$this->start_controls_section(
			'layout',
			[
				'label' => __( 'Layout', 'wp-team-manager' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'layout_type',
			[
				'label' => esc_html__( 'Layout Type', 'wp-team-manager' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid' => esc_html__( 'Grid', 'wp-team-manager' ),
					'list' => esc_html__( 'List', 'wp-team-manager' ),
					'slider' => esc_html__( 'Slider', 'wp-team-manager' ),
					'table' => esc_html__( 'Table', 'wp-team-manager' ),
					
				]
			]
		);

		//Layout Style
		$this->add_control(
			'grid_style_type',
			[
				'label' => __( 'Layout Style', 'wp-team-manager' ),
				'type' => 'wptm_image_selector',
				'options' => [
					'style-1' => [
						'title' => esc_html__('Style 1', 'wp-team-manager'),
						'url' => TM_ADMIN_ASSETS .'/icons/layout/Grid-1.svg',
					],
					'style-2' => [
						'title' => esc_html__('Style 2', 'wp-team-manager'),
						'url' => TM_ADMIN_ASSETS .'/icons/layout/Grid-2.svg',
					],
					'style-3' => [
						'title' => esc_html__('Style 3', 'wp-team-manager'),
						'url' => TM_ADMIN_ASSETS .'/icons/layout/grid-3.svg',
					],
					'style-4' => [
						'title' => esc_html__('Style 4', 'wp-team-manager'),
						'url' => TM_ADMIN_ASSETS .'/icons/layout/grid-4.svg',
					],
				],
				'default' => 'style-1',
				'condition' => [
					'layout_type' => 'grid',
				],
			]
		);
		
		$this->add_control(
			'list_style_type',
			[
				'label' => __( 'Layout Style', 'wp-team-manager' ),
				'type' => 'wptm_image_selector',
				'options' => [
					'style-1' => [
						'title' => esc_html__('Style 1', 'wp-team-manager'),
						'url' => TM_ADMIN_ASSETS .'/icons/layout/List-1.svg',
					],
					// 'style-2' => [
					// 	'title' => esc_html__('Style 2', 'wp-team-manager'),
					// 	'url' => TM_ADMIN_ASSETS .'/icons/layout/List-2.svg',
					// ],
				],
				'default' => 'style-1',
				'condition' => [
					'layout_type' => 'list',
				],
			]
		);

		$this->add_control(
			'slider_style_type',
			[
				'label' => __( 'Layout Style', 'wp-team-manager' ),
				'type' => 'wptm_image_selector',
				'options' => [
					'style-1' => [
						'title' => esc_html__('Style 1', 'wp-team-manager'),
						'url' => TM_ADMIN_ASSETS .'/icons/layout/Slider-1.svg',
					],
					'style-2' => [
						'title' => esc_html__('Style 2', 'wp-team-manager'),
						'url' => TM_ADMIN_ASSETS .'/icons/layout/Slider-2.svg',
					],
				],
				'default' => 'style-1',
				'condition' => [
					'layout_type' => 'slider',
				],
			]
		);
		
		$this->add_control(
			'table_style_type',
			[
				'label' => __( 'Layout Style', 'wp-team-manager' ),
				'type' => 'wptm_image_selector',
				'options' => [
					'style-1' => [
						'title' => esc_html__('Style 1', 'wp-team-manager'),
						'url' => TM_ADMIN_ASSETS .'/icons/layout/Table-1.svg',
					],
				],
				'default' => 'style-1',
				'condition' => [
					'layout_type' => 'table',
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'wp-team-manager' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'condition' => [
					'layout_type!' => 'list',
				],
			]
		);

		$this->add_control(
			'Autoplay_Speed',
			[
				'label' => esc_html__( 'Autoplay Speed', 'wc-pcd' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => esc_html__( '4000', 'wc-pcd' ),
				'placeholder' => esc_html__( 'Type your Autoplay Speed Number', 'wc-pcd' ),
				'condition' => [
					'layout_type' => 'slider',
				],
			]
		);

		$this->add_control(
			'enable_autoplay',
			[
				'label' => esc_html__( 'Enable Autoplay', 'wc-pcd' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'ON', 'wc-pcd' ),
				'label_off' => esc_html__( 'OFF', 'wc-pcd' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'layout_type' => 'slider',
				],
			]
		);

		$this->add_control(
			'show_arrow',
			[
				'label' => esc_html__( 'Show Arrow', 'wc-pcd' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'wc-pcd' ),
				'label_off' => esc_html__( 'Hide', 'wc-pcd' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'layout_type' => 'slider',
				],
			]
		);

		$this->add_control(
			'show_dot_navigation',
			[
				'label' => esc_html__( 'Show Dot navigation', 'wc-pcd' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'wc-pcd' ),
				'label_off' => esc_html__( 'Hide', 'wc-pcd' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'layout_type' => 'slider',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'wp-team-manager' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		//TODO: Common Filter
		$this->add_control(
			'common_filters_heading',
			[
				'label'     => esc_html__( 'Common Filters:', 'wp-team-manager' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'classes'   => '',
			]
		);

		$this->add_control(
			'include',
			[
				'label'       => esc_html__( 'Include only', 'wp-team-manager' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter the post IDs separated by comma for include', 'wp-team-manager' ),
				'placeholder' => 'Eg. 10, 15, 17',
			]
		);

		$this->add_control(
			'exclude',
			[
				'label'       => esc_html__( 'Exclude', 'the-post-grid' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter the post IDs separated by comma for exclude', 'wp-team-manager' ),
				'placeholder' => 'Eg. 12, 13',
			]
		);

		$this->add_control(
			'per_page',
			[
				'label'       => esc_html__( 'Limit', 'wp-team-manager' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'The number of posts to show. Enter -1 to show all found posts.', 'the-post-grid' ),
			]
		);

		$this->add_control(
			'advanced_filters_heading',
			[
				'label'     => esc_html__( 'Advanced Filters:', 'wp-team-manager' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'classes'   => 'tpg-control-type-heading',
			]
		);

		$this->add_control(
			'relation',
			[
				'label'   => esc_html__( 'Taxonomies Relation', 'wp-team-manager' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'OR',
				'options' => [
					'OR'  => __( 'OR', 'wp-team-manager' ),
					'AND' => __( 'AND', 'wp-team-manager' ),
				],
			]
		);

		$this->add_control(
			'post_keyword',
			[
				'label'       => esc_html__( 'By Keyword', 'wp-team-manager' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Search by keyword', 'wp-team-manager' ),
				'description' => esc_html__( 'Search by post title or content keyword', 'wp-team-manager' ),
			]
		);

		$this->add_control(
			'date_range',
			[
				'label'          => esc_html__( 'Date Range (Start to End)', 'wp-team-manager' ),
				'type'           => Controls_Manager::DATE_TIME,
				'placeholder'    => 'Choose date...',
				'description'    => esc_html__( 'NB: Enter DEL button for delete date range', 'wp-team-manager' ),
				'picker_options' => [
					'enableTime' => false,
					'mode'       => 'range',
					'dateFormat' => 'M j, Y',
				],
			]
		);

		$this->add_control(
			'ignore_sticky_posts',
			[
				'label'        => esc_html__( 'Ignore sticky posts at the top', 'wp-team-manager' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'wp-team-manager' ),
				'label_off'    => esc_html__( 'No', 'wp-team-manager' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'disabled'     => true,
			]
		);


		$this->add_control(
			'no_posts_found_text',
			[
				'label'       => esc_html__( 'No post found Text', 'the-post-grid' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'No posts found.', 'the-post-grid' ),
				'placeholder' => esc_html__( 'Enter No post found', 'the-post-grid' ),
				'separator'   => 'before',
			]
		);



		// Post categories
		$this->add_control(
			'team_groups',
			[
				'label'       => __( 'Group', 'wp-team-manager' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->get_all_taxonomy('team_groups'),

			]
		);

		// Post Tags
		$this->add_control(
			'team_department',
			[
				'label'       => __( 'Department', 'wp-team-manager' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => $this->get_all_taxonomy( 'team_department' ),

			]
		);

		$this->add_control(
			'advanced',
			[
				'label' => __( 'Advanced', 'wp-team-manager' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'wp-team-manager' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' 	  => Helper::getOrderBy(),
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'wp-team-manager' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => __( 'ASC', 'wp-team-manager' ),
					'desc' => __( 'DESC', 'wp-team-manager' ),
				],
			]
		);

		$this->end_controls_section();

	}

	private function style_options(){

		//Image
		$this->start_controls_section(
			'posts_image_section',
			[
				'label' => esc_html__( 'Image', 'wp-team-manager'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'show_image',
			[
				'label' => __( 'Show Image', 'wp-team-manager' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'wp-team-manager' ),
				'label_off' => __( 'Hide', 'wp-team-manager' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => esc_html__( 'Image Size', 'wp-team-manager' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => [
					'thumbnail' => esc_html__( 'Thumbnail', 'wp-team-manager' ),
					'medium' => esc_html__( 'Medium', 'wp-team-manager' ),
					'large' => esc_html__( 'Large', 'wp-team-manager' ),
					'full' => esc_html__( 'Full', 'wp-team-manager' ),
				],
			]
		);

		$this->add_control(
			'image_style',
			[
				'label' => esc_html__( 'Border Style', 'wp-team-manager' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'boxed',
				'options' => [
					'50%' => esc_html__( 'Circle', 'wp-team-manager' ),
					'15px' => esc_html__( 'Rounded', 'wp-team-manager' ),
					'0' => esc_html__( 'Boxed', 'wp-team-manager' ),
				],
				'selectors' => [
					'{{WRAPPER}} .team-member-info-content header img' => 'border-radius: {{VALUE}}',
					'{{WRAPPER}} .dwl-table-img-wraper a img' => 'border-radius: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'posts_image',
			[
				'label' => esc_html__( 'Margin', 'wp-team-manager'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .team-member-info-content header img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	
		//Title
		$this->start_controls_section(
			'posts_title',
			[
				'label' => esc_html__( 'Title', 'wp-team-manager'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Show Title', 'wp-team-manager' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'wp-team-manager' ),
				'label_off' => __( 'Hide', 'wp-team-manager' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'posts_title_color',
			[
				'label' => esc_html__( 'Title Color', 'wp-team-manager'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .team-member-title' => 'color: {{VALUE}};',
				],
			]
		);
  
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
			 'name' => 'posts_title_typography',
			 'selector' => '{{WRAPPER}} .team-member-title',
			]
		);
  
		$this->add_responsive_control(
			'posts_title_margin',
			[
				'label' => esc_html__( 'Margin', 'wp-team-manager'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .team-member-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		

		//Sub Title
		$this->start_controls_section(
			'posts_sub_title',
			[
				'label' => esc_html__( 'Job Title', 'wp-team-manager'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
		$this->add_control(
			'show_sub_title',
			[
				'label' => __( 'Show Job Title', 'wp-team-manager' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'wp-team-manager' ),
				'label_off' => __( 'Hide', 'wp-team-manager' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'posts_sub_title_color',
			[
				'label' => esc_html__( 'Job Title Color', 'wp-team-manager'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .team-position' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
			'name' => 'posts_sub_title_typography',
			'selector' => '{{WRAPPER}} .team-position',
			]
		);

		$this->add_responsive_control(
			'posts_sub_title_margin',
			[
				'label' => esc_html__( 'Margin', 'wp-team-manager'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .team-position' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		//Team Short Bio
		$this->start_controls_section(
			'team_short_bio',
			[
				'label' => esc_html__( 'Team Short Bio', 'wp-team-manager'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'team_show_short_bio',
			[
				'label' => __( 'Team Short Bio', 'wp-team-manager' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'wp-team-manager' ),
				'label_off' => __( 'Hide', 'wp-team-manager' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'team_short_bio_color',
			[
				'label' => esc_html__( 'Color', 'wp-team-manager'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .team-short-bio' => 'color: {{VALUE}};',
				],
			]
		);
  
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
			 'name' => 'posts_excerpt_typography',
			 'selector' => '{{WRAPPER}} .team-short-bio',
			]
		);
  
		$this->add_responsive_control(
			'posts_excerpt_margin',
			[
				'label' => esc_html__( 'Margin', 'wp-team-manager'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .team-short-bio' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		//Social info
		$this->start_controls_section(
			'social_icon_heading',
			[
				'label' => esc_html__( 'Social Icon', 'wp-team-manager'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'show_other_info',
			[
				'label' => __( 'Show Other Info', 'wp-team-manager' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'wp-team-manager' ),
				'label_off' => __( 'Hide', 'wp-team-manager' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_social',
			[
				'label' => __( 'Show Social Icon', 'wp-team-manager' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'wp-team-manager' ),
				'label_off' => __( 'Hide', 'wp-team-manager' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);


		$this->add_control(
			'show_social_icon_color',
			[
				'label' => esc_html__( 'Social Icon Color', 'wp-team-manager' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .fas' => 'color: {{VALUE}}',
					'{{WRAPPER}} .team-member-socials a' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'show_social_icon_hover_color',
			[
				'label' => esc_html__( 'Social Icon Hover Color', 'wp-team-manager' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .team-member-socials a:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		//Read More
		$this->start_controls_section(
			'wtm_read_more',
			[
				'label' => esc_html__( 'Read More', 'wp-team-manager'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'show_read_more',
			[
				'label' => __( 'Show Read More', 'wp-team-manager' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'wp-team-manager' ),
				'label_off' => __( 'Hide', 'wp-team-manager' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'wtm_read_more_color',
			[
				'label' => esc_html__( 'Title Color', 'wp-team-manager'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wtm-read-more' => 'color: {{VALUE}};',
				],
			]
		);
  
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
			 'name' => 'wtm_read_more_typography',
			 'selector' => '{{WRAPPER}} .wtm-read-more',
			]
		);
  
		$this->add_responsive_control(
			'wtm_read_more_margin',
			[
				'label' => esc_html__( 'Margin', 'wp-team-manager'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wtm-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Color, Typography & Spacing
		$this->start_controls_section(
			'posts_article_settings',
			[
				'label' => esc_html__( 'Container Settings', 'wp-team-manager'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'card_background_color',
			[
				'label' => esc_html__( 'Card Background Color', 'wp-team-manager' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .team-member-info-content' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'posts_article_margin',
			[
				'label' => esc_html__( 'Margin', 'wp-team-manager'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .team-member-info-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'posts_article_padding',
			[
				'label' => esc_html__( 'Padding', 'wp-team-manager'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .team-member-info-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
			 'name' => 'posts_article_border',
				'selector' => '{{WRAPPER}} .team-member-info-content',
			]
		);

		$this->end_controls_section();




	}

	private function pagination_options()
	{
		$this->start_controls_section(
			'section_pagination',
			[
				'label' => esc_html__( 'Pagination', 'wp-team-manager' ),
				'condition' => [
					'layout_type!' => 'slider',
				],
			]
		);

		$this->add_control(
			'pagination_type',
			[
				'label' => __( 'Pagination Type', 'wp-team-manager' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'None', 'wp-team-manager' ),
					'numbers' => esc_html__( 'Numbers', 'wp-team-manager' ),
				],
			]
		);	

		$this->end_controls_section();
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {


		$this->query_options();
		$this->pagination_options();
		$this->style_options();


	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		$offset_posts = [];
		$excluded_ids = [];
		$wrapper_calss = '';


		if( $settings['layout_type'] != 'slider' ){
		  $wrapper_calss = 'wtm-row g-2 g-lg-3';
		}

		$query_args = array(
			'posts_per_page' => $settings['per_page'],
			'post_type'   => 'team_manager',
			'paged' => $paged
		  );
		   
		// Order by.
		if ( ! empty( $settings['orderby'] ) ) {
			$query_args['orderby'] = $settings['orderby'];
		}

		// Order .
		if ( ! empty( $settings['order'] ) ) {
			$query_args['order'] = $settings['order'];
		}

		// Order .
		if ( ! empty( $settings['offset'] ) ) {
			$query_args['offset'] = absint( $settings['offset'] );
		}

		//relation
		if ( ! empty( $settings['relation'] ) ) {
			$query_args['tax_relation'] = $settings['relation'];
		}

		//category
		if(isset($settings['team_groups']) && !empty($settings['team_groups'])){

			$query_args['tax_query'][] = [
				'taxonomy' => 'team_groups',
				'field'    => 'term_id',
				'terms'    => $settings['team_groups'],
			];
		}	

		//Tags
		if(isset($settings['team_department']) && !empty($settings['team_department'])){
			
			$query_args['tax_query'][] = [
				'taxonomy' => 'team_department',
				'field'    => 'term_id',
				'terms'    => $settings['team_department'],
			];
		}

		// Date query.
		if ( isset( $settings['date_range'] ) ) {
			if ( strpos( $settings['date_range'], 'to' ) ) {
				$date_range         = explode( 'to', $settings['date_range'] );
				$query_args['date_query'] = [
					[
						'after'     => trim( $date_range[0] ),
						'before'    => trim( $date_range[1] ),
						'inclusive' => true,
					],
				];
			}
		}

		//keyword
		if ( isset($settings['post_keyword'] ) && !empty($settings['post_keyword'] )) {
			$query_args['s'] = $settings['post_keyword'];
		}

		if ( $settings['exclude'] ) {
			$excluded_ids = explode( ',', $settings['exclude'] );
			$excluded_ids = array_map( 'trim', $excluded_ids );
			$query_args['post__not_in'] = array_unique( $excluded_post_ids );
		}

		$style_type_name = $settings['layout_type'].'_'.'style_type';
		$style_type = !empty( $settings[$style_type_name] ) ? $settings[$style_type_name] : '';
		/**
		 * Slider settings
		 * 
		 */
		$arrows = isset($settings['show_arrow']) && $settings['show_arrow'] ? true : false;
		$dot_nav = isset($settings['show_dot_navigation']) && $settings['show_dot_navigation'] ? true : false;
		$autoplay = isset($settings['enable_autoplay']) && $settings['enable_autoplay'] ? true : false;
		$arrow_position = isset($all_settings['wc_pcd_arrow_position']) ? $all_settings['wc_pcd_arrow_position'][0] : 'side';
		$desktop = isset($settings['columns']) ? $settings['columns'] : '4';
		$tablet = isset($settings['columns_tablet']) ? $settings['columns_tablet'] : '3';
		$mobile = isset($settings['columns_mobile']) ? $settings['columns_mobile'] : '1';
		$speed  = isset($settings['Autoplay_Speed']) ? $settings['Autoplay_Speed'] : '4000';
		$team_data = Helper::get_team_data($query_args);
		?>
		<div class="dwl-team-list dwl-team-wrapper <?php echo esc_attr( $style_type )?>">
			<div 
			class="dwl-team-wrapper--main dwl-team-elementor-layout-<?php echo esc_attr( $settings['layout_type'] ) ?> <?php echo esc_attr( $wrapper_calss ); ?> dwl-team-layout-<?php echo esc_attr( $settings['layout_type'] ) ?>"
			<?php if($settings['layout_type'] == 'slider'): ?>
			data-arrows="<?php echo esc_attr($arrows); ?>" 
			data-dots="<?php echo esc_attr($dot_nav); ?>"  
			data-autoplay="<?php echo esc_attr($autoplay); ?>"
			data-desktop = "<?php echo esc_attr($desktop); ?>"
			data-tablet = "<?php echo esc_attr($tablet); ?>"
			data-mobile = "<?php echo esc_attr($mobile); ?>"
			data-speed = "<?php echo esc_attr($speed); ?>"
			<?php endif; ?>
			>
				<?php Helper::renderElementorLayout($settings['layout_type'],$team_data,$settings); ?>
			</div><!--.wp-team-manager-widget-->
		</div><!--.wp-team-manager-widget-->
		<?php

		if ( isset( $settings['pagination_type']) && 'none' !== $settings['pagination_type'] ) :
			echo wp_kses_post(  Helper::get_pagination_markup( new \WP_Query( $query_args ), $settings['per_page'] ) );
		endif;
	}
}