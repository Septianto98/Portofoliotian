<?php

namespace DynamicContentForElementor;

/**
 * Main Helper Class
 *
 * @since 0.1.0
 */
class Helper {

	use Trait_Plugin;
	use Trait_FileSystem;
	use Trait_WP;
	use Trait_Meta;
	use Trait_Elementor;
	use Trait_Form;
	use Trait_String;
	use Trait_Image;
	use Navigation;
	use Trait_Notice;
	use Trait_Static;

	public static function get_datatables_language( ) {
		$locale2 = substr(get_locale(), 0, 2);

		$languages_whitelist = [ 'en', 'af', 'sq', 'am', 'ar', 'hy', 'az', 'bn', 'eu', 'be', 'bs', 'bg', 'ca', 'zh', 'co', 'hr', 'cs', 'da', 'nl', 'eo', 'et', 'fil', 'fu', 'fr', 'gl', 'ka', 'de', 'it', 'ja', 'kn', 'kk', 'km', 'ko', 'ku', 'ky', 'lo', 'lv', 'lt', 'mk', 'ms', 'mn', 'no', 'ps', 'fa', 'pl', 'pt', 'pa', 'ro', 'rm', 'ru', 'sr', 'snd', 'si', 'sk', 'sl', 'sw', 'sv', 'tg', 'ta', 'te', 'th', 'tr', 'uk', 'ur', 'uz', 'vi', 'cy' ];

		if( in_array( $locale2, $languages_whitelist ) ) {
			return $locale2;
		}
		return 'en';
	}

}
