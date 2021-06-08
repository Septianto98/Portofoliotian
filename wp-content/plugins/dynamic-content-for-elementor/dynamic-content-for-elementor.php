<?php
/**
 *
 * @copyright Copyright (C) 2018-2021, Ovation S.r.l. - support@dynamic.ooo
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 or higher
 *
 * @wordpress-plugin
 * Plugin Name: Dynamic Content for Elementor
 * Plugin URI: https://www.dynamic.ooo/
 * Description: The most unique toolkit for Elementor for creating powerful websites and professional content.
 * Version: 1.13.5
 * Requires at least: 5.2
 * Requires PHP: 5.6
 * Author: Dynamic.ooo
 * Author URI: https://www.dynamic.ooo/
 * Text Domain: dynamic-content-for-elementor
 * Domain Path: /languages
 * License: GPL-3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Elementor tested up to: 3.1.4
 * Elementor Pro tested up to: 3.2.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Dynamic Content for Elementor incorporates code from:
 * - A-Frame, Copyright (c) 2015-2017 A-Frame authors, License: MIT, https://aframe.io
 * - Animate.css, Copyright (c) 2019 Daniel Eden, License: MIT, https://daneden.github.io/animate.css/
 * - anime.js, Copyright (c) 2019 Julian Garnier, License: MIT, https://github.com/juliangarnier/anime
 * - Animsition, Copyright (c) 2013-2015 blivesta, License: MIT, http://git.blivesta.com/animsition/
 * - Clipboard.js, Copyright (c) 2019 Zeno Rocha, License: MIT, https://zenorocha.mit-license.org/
 * - CodeMirror, License: GPL v3, https://www.codemirror.net
 * - Codrops.com, Copyright (c) 2019, License: MIT, https://www.codrops.com
 * - Composer, Copyright (c) Nils Adermann, Jordi Boggiano, License: MIT, https://getcomposer.org
 * - Creative WebGL Image Transitions, Copyright (c) 2019 Yuriy Artyukh, License: MIT, https://github.com/akella/webGLImageTransitions
 * - CSSSelector Component, Copyright (c) Symfony, License: MIT, https://github.com/symfony/css-selector
 * - CSSToInlineStyles, Copyright (c) Tijs Verkoyen, License: BSD, https://github.com/tijsverkoyen/CssToInlineStyles
 * - DataTables, Copyright (c) 2007-2020 SpryMedia Ltd., License: MIT, https://datatables.net
 * - Diamonds.js, Copyright (c) 2013 mqchen, License: MIT, https://github.com/mqchen/jquery.diamonds.js/
 * - DomCrawler, Copyright (c) Symfony, License: MIT, https://github.com/symfony/dom-crawler
 * - Dompdf, License: GPL v2, https://github.com/dompdf/dompdf
 * - eos, Copyright Jon Lawrence, License: GPL v2, https://github.com/jlawrence11/eos/
 * - Flatpickr, Copyright (c) 2017 Gregory Petrosyan, License: MIT, https://flatpickr.js.org
 * - GSAP, GreenSock files are subject to their own license (https://greensock.com/standard-license) and you can ONLY use the bonus files as a part of Dynamic Content for Elementor
 * - HeadRoom js, Copyright (c) 2020 Nick Nilliams, License: MIT, https://wicky.nillia.ms/headroom.js/
 * - HoneyCombs, License: GPL v3, https://github.com/nasirkhan/honeycombs
 * - Html2Canvas, Copyright (c) 2012 Niklas von Hertzen, License: MIT, https://html2canvas.hertzen.com/
 * - imagesLoaded, Copyright (c) Dave DeSandro, License: MIT, https://imagesloaded.desandro.com
 * - InfiniteScroll, License: GPL v3, https://infinite-scroll.com/
 * - Isotope, GPL v3, http://isotope.metafizzy.co
 * - jQuery Easing, Copyright (c) 2008 George McGinley Smith, License: BSD, http://gsgd.co.uk/sandbox/jquery/easing/
 * - jQuery inertiaScroll, Copyright(c) 2017 Go Nishiduka, License: MIT
 * - jsPDF, Copyright (c) 2010-2020 James Hall,  License: MIT, https://github.com/MrRio/jsPDF (c) 2015-2020 yWorks GmbH, https://www.yworks.com/
 * - justifiedGallery, Copyright (c) 2019 Miro Mannino, License: MIT, http://miromannino.github.io/Justified-Gallery/
 * - lax.js, Copyright (c) 2019 Alex Fox, License: MIT, https://github.com/alexfoxy/lax.js
 * - Parallax.js, Copyright (c) 2014 Matthew Wagerfield - @wagerfield, License: MIT, https://github.com/wagerfield/parallax
 * - PathConverter, Copyright (c) 2015 Matthias Mullie, License: MIT, https://github.com/matthiasmullie/path-converter
 * - Payum\ISO4217, License: MIT, https://github.com/Payum/iso4217
 * - Perlin Noise, by Stefan Gustavson, https://github.com/stegu/perlin-noise
 * - Plugin Update Checker, Copyright (c) 2017 Jānis Elsts, License: MIT, https://github.com/YahnisElsts/plugin-update-checker
 * - Plyr, Copyright (c) 2017 Sam Potts, License: MIT, https://plyr.io
 * - PhotoSwipe, Copyright (c) 2014-2019 Dmitry Semenov, http://dimsemenov.com, License: MIT, http://photoswipe.com
 * - PHP Font Lib, Copyright (c) Fabien Ménager, License: GPL v2, https://github.com/PhenX/php-font-lib
 * - PHP SVG Lib, Copyright (c) Fabien Ménager, License: GPL v2, https://github.com/PhenX/php-svg-lib
 * - PHP Html Parser, Copyright (c) 2014 Gilles Paquette, License: MIT, https://github.com/paquettg/php-html-parser
 * - PHP Simple HTML Dom Parser, https://github.com/sunra/php-simple-html-dom-parser
 * - Polyfill Ctype, Copyright (c) Symfony, License: MIT, https://github.com/symfony/polyfill-ctype
 * - Polyfill Mbstring, Copyright (c) Symfony, License: MIT, https://github.com/symfony/polyfill-mbstring
 * - Rellax, Copyright (c) 2016 Dixon & Moe, License: MIT, https://dixonandmoe.com/rellax/
 * - Revealjs.com, Copyright (c) 2018 Hakim El Hattab (http://hakim.se) and reveal.js contributors, License: MIT, https://revealjs.com
 * - Sabberworm PHP CSS Parser, Copyright (c) 2011 Raphael Schweikert, License: Mit, https://github.com/sabberworm/PHP-CSS-Parser
 * - Scrollify.js, Copyright (c) 2017 Luke Haas, License: MIT, https://projects.lukehaas.me/scrollify/examples/pagination
 * - Slick, Copyright (c) 2013-2016, License: MIT, http://kenwheeler.github.io/slick/
 * - String Encode, https://github.com/paquettg/string-encoder/
 * - Swiper.js, 2019 (c) Swiper by Vladimir Kharlampidi from iDangero.us, License: MIT, https://idangero.us/swiper/
 * - Telegram Bot, Copyright (c) 2015 Ilya Gusev, License: MIT, https://github.com/TelegramBot/Api
 * - Three Sixty Image slider, Copyright 2013 Gaurav Jassal, License: MIT, http://github.com/vml-webdev/threesixty-slider.git
 * - Tilt.js, Copyright (c) 2017 Gijs Rogé, License: MIT, https://gijsroge.github.io/tilt.js/
 * - TCPDF, Copyright (c) 2004-2020 – Nicola Asuni - Tecnick.com, License: GPL v3, https://tcpdf.org
 * - Signature Pad, Copyright (c) 2018 Szymon Nowak, License: MIT, https://github.com/szimek/signature_pad
 * - Slick, Copyright (c) 2013-2016, License: MIT, http://kenwheeler.github.io
 * - Stripe PHP, https://github.com/stripe/stripe-php
 * - SVG File Icons, Copyright (c) 2018 Daniel M. Hendricks, License: MIT, https://fileicons.org/
 * - THREEJS, Copyright (c) 2010-2019 three.js authors, License: MIT, https://github.com/mrdoob/three.js/blob/dev/LICENSE
 * - TGM Plugin Activation, Copyright (c) 2011 Thomas Griffin, License: GPL v2, http://tgmpluginactivation.com
 * - TwentyTwenty, Copyright 2018 zurb, License: MIT, https://zurb.com/playground/twentytwenty
 * - Velocity.js, Copyright (c) 2014 Julian Shapiro, License: MIT, http://velocityjs.org
 * - Vertical Timeline, Copyright (c) Codyhouse, License: MIT, https://codyhouse.co/gem/vertical-timeline/
 * - WOW.js, Copyright (c) 2016 Thomas Grainger, License: MIT, https://wowjs.uk/
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
update_option('WP-DCE-1_license_activated', 1);
update_option('WP-DCE-1_license_key', '4308eedb-1add-43a9-bbba-6f5d5aa6b8ee');
update_option('WP-DCE-1_license_expiration', '2030.06.01');
require_once __DIR__ . '/constants.php';
require_once DCE_PATH . 'vendor/autoload.php';

add_action( 'plugins_loaded', 'dce_load' );
register_activation_hook( DCE__FILE__, 'dce_activate' );

/**
 * Load Dynamic Content for Elementor
 *
 * Load the plugin after Elementor (and other plugins) are loaded.
 *
 * @since 0.1.0
 */
function dce_load() {
	// Load localization file
	load_plugin_textdomain( 'dynamic-content-for-elementor' );

	// Notice if the Elementor is not active
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'dce_fail_load' );
		return;
	}

	if ( version_compare( phpversion(), 'DCE_PHP_VERSION_SUGGESTED', '<' ) ) {
		add_action( 'admin_notices', 'dce_old_php_version' );
	}

	new \DynamicContentForElementor\Plugin();

	\DynamicContentForElementor\License::do_rollback();
	\DynamicContentForElementor\License::check_for_updates( __FILE__ );
}

/**
 * Handles admin notice for non-active
 * Elementor plugin situations
 *
 * @since 0.1.0
 */
function dce_fail_load() {
	$class = 'notice notice-error';
	$message = sprintf( __( 'You need %1$s"Elementor"%2$s for the %1$s"Dynamic Content for Elementor"%2$s plugin to work and updated.', 'dynamic-content-for-elementor' ), '<strong>', '</strong>' );

	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
}

function dce_old_php_version() {
	\DynamicContentForElementor\Notice::dce_admin_notice__warning( sprintf( __( 'You are using PHP version %1$s. It\'s suggested to use PHP version %2$s+.', 'dynamic-content-for-elementor' ), phpversion(), DCE_PHP_VERSION_SUGGESTED ) );
}

/**
 * Runs code upon activation
 *
 * @since 0.1.0
 */
function dce_activate() {
	add_option( 'dce_do_activation_redirect', true );
}

/**
 * Check errors upon activation
 *
 * @since 1.5.2
 */
function dce_save_activation_error() {
	update_option( 'dce_plugin_error', ob_get_contents() );
}

if ( WP_DEBUG ) {
	add_action( 'activated_plugin', 'dce_save_activation_error' );
	/* Then to display the error message: */
	echo get_option( 'dce_plugin_error' );
	delete_option( 'dce_plugin_error' );
}
