<?php
namespace DynamicContentForElementor;

use \Elementor\Widgets_Manager as Elementor_Widgets_Manager;

class Widgets_Manager extends Elementor_Widgets_Manager {

	/**
		* Widget types.
		*
		* Holds the list of all the widget types.
		*
		* @since 1.0.0
		* @access private
		*
		* @var Widget_Base[]
		*/
		private $widget_types = null;

	/**
	 * Widgets manager constructor.
	 *
	 * Initializing Elementor widgets manager.
	 *
	 * @since 1.0.0
	 * @access public
	*/
	public function __construct( $widget_types = null ) {
		$this->widget_types = $widget_types;
	}

	/**
	 * Register widget type.
	 *
	 * Add a new widget type to the list of registered widget types.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param Widget_Base $widget Elementor widget.
	 *
	 * @return true True if the widget was registered.
	*/
	public function register_widget_type( \Elementor\Widget_Base $widget ) {
		if ( is_null( $this->widget_types ) ) {
			$this->init_widgets();
		}
		$this->widget_types[ $widget->get_name() ] = $widget;

		return true;
	}
}
