<?php

namespace DynamicContentForElementor;

class Documents {

	public $documents = [];
	public static $registered_documents = [];
	public static $namespace = '\\DynamicContentForElementor\\Documents\\';

	public function __construct() {
		$this->init();
	}

	public function init() {
		$this->documents = self::get_documents();
	}

	public static function get_documents() {
		$documents['dce_document_scrolling'] = 'DCE_Document_Scrolling';

		return $documents;
	}

	/**
	 * On extensions Registered
	 *
	 * @since 0.0.1
	 *
	 * @access public
	 */
	public function on_documents_registered() {
		$this->register_documents();
	}

	/**
	 * On Controls Registered
	 *
	 * @since 1.0.4
	 *
	 * @access public
	 */
	public function register_documents() {
		if ( empty( self::$registered_documents ) ) {
			$excluded_documents = json_decode( get_option( DCE_PRODUCT_ID . '_excluded_documents', '[]' ), true );
			foreach ( $this->documents as $key => $name ) {
				if ( ! isset( $excluded_documents[ $name ] ) ) {
					$class = self::$namespace . $name;
					$document = new $class();
					self::$registered_documents[ $name ] = $document;
					Assets::add_depends( $document );
				}
			}
		}
	}

}
