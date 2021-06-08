<?php
/** Loads the WordPress Environment and Template */
define( 'WP_USE_THEMES', false );
require '../../../../wp-blog-header.php';

status_header( 200 );
global $wp_query;
$wp_query->is_singular = true;
$wp_query->is_page = $wp_query->is_singular;
$wp_query->is_404 = false;

// Escapes a string of characters
function escape_string( $string ) {
	return preg_replace( '/([\,;])/', '\\\$1', $string );
}

// Cut it
function shorter_version( $string, $lenght ) {
	if ( strlen( $string ) >= $lenght ) {
		return substr( $string, 0, $lenght );
	} else {
		return $string;
	}
}

if ( isset( $_GET['element_id'] ) ) {
	$element_id = sanitize_text_field( $_GET['element_id'] );
} else {
	$element_id = 0;
}

if ( ! empty( $_GET['post_id'] ) ) {
	$ics_post_id = intval( $_GET['post_id'] );
} else {
	$ics_post_id = 0;
}

if ( $element_id && $ics_post_id ) {

	// static settings
	$widget = \DynamicContentForElementor\Helper::get_elementor_element_by_id( $element_id, $ics_post_id );

	// dynamic settings
	// populate post for dynamic data
	global $post;
	$post = get_post( $ics_post_id );
	if ( $post ) {
		$wp_query->queried_object = $post;
		$wp_query->queried_object_id = $ics_post_id;
	}

	$created_date = get_post_time( 'Ymd\THis\Z', true, $ics_post_id );
	// create an instance of widget to get his dynamic data
	$settings = $widget->get_settings_for_display();

	$title = escape_string( ! empty( $settings['dce_calendar_title'] ) ? $settings['dce_calendar_title'] : get_the_title( $ics_post_id ) );
	$description = escape_string( ! empty( $settings['dce_calendar_description'] ) ? strip_tags( nl2br( $settings['dce_calendar_description'] ) ) : '' );
	$location = escape_string( ! empty( $settings['dce_calendar_location'] ) ? $settings['dce_calendar_location'] : '' );
	$organiser = get_bloginfo( 'name' );

	// FORMAT
	$date_format = $settings['dce_calendar_datetime_string_format'];
	if ( empty( $date_format ) ) {
		$date_format = 'Y-m-d H:i';
	}
	// START
	$start = ( 'string' !== $settings['dce_calendar_datetime_format'] ) ? $settings['dce_calendar_datetime_start'] : $settings['dce_calendar_datetime_start_string'];
	if ( empty( $start ) ) {
		$start = new \DateTime();
	} else {
		$start = \DateTime::createFromFormat( $date_format, $start );
	}
	if ( $start ) {
		$start_field = get_gmt_from_date( $start->format( 'Y-m-d H:i' ), 'Ymd\\THi00\\Z' );
	}
	// END
	$end = ( 'string' !== $settings['dce_calendar_datetime_format'] ) ? $settings['dce_calendar_datetime_end'] : $settings['dce_calendar_datetime_end_string'];
	if ( empty( $end ) && $start ) {
		$end = new \DateTime( $start->format( 'Y-m-d H:i' ) );
		$end = $end->modify( '+ 1 day' );
	} elseif ( empty( $end ) && ! $start ) {
		$end = new \DateTime();
	} else {
		$end = \DateTime::createFromFormat( $date_format, $end );
	}
	if ( $end ) {
		$end_field = get_gmt_from_date( $end->format( 'Y-m-d H:i' ), 'Ymd\\THi00\\Z' );
	}

	$filename = urlencode( $title . '.ics' );

	ob_start();

	// Set the correct headers for this file
	header( 'Content-Type: text/calendar; charset=utf-8' );
	header( 'Content-Transfer-Encoding: Binary' );
	header( 'Content-Description: File Transfer' );
	header( 'Expires: 0' );
	header( 'Cache-Control: must-revalidate' );
	header( 'Pragma: public' );
	header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
	define( 'ICS_EOL', "\r\n" );
	?>BEGIN:VCALENDAR<?php echo ICS_EOL; ?>
VERSION:2.0<?php echo ICS_EOL; ?>
PRODID:-//Dynamic.ooo //NONSGML DCE Calendar //EN<?php echo ICS_EOL; ?>
CALSCALE:GREGORIAN<?php echo ICS_EOL; ?>
METHOD:PUBLISH<?php echo ICS_EOL; ?>
X-WR-TIMEZONE:<?php echo get_option( 'timezone_string' );
echo ICS_EOL; ?>
BEGIN:VEVENT<?php echo ICS_EOL; ?>
ORGANIZER:<?php echo escape_string( $organiser );
echo ICS_EOL; ?>
CREATED:<?php echo $created_date;
echo ICS_EOL; ?>
URL;VALUE=URI:<?php echo get_permalink( $ics_post_id );
echo ICS_EOL; ?>
DTSTART;VALUE=DATE:<?php echo $start_field;
echo ICS_EOL; ?>
DTEND;VALUE=DATE:<?php echo $end_field;
echo ICS_EOL; ?>
DTSTAMP:<?php echo date_i18n( 'Ymd\THis\Z', time(), true );
echo ICS_EOL; ?>
SUMMARY:<?php echo $title;
echo ICS_EOL; ?>
DESCRIPTION:<?php echo $description;
echo ICS_EOL; ?>
LOCATION:<?php echo $location;
echo ICS_EOL; ?>
TRANSP:OPAQUE<?php echo ICS_EOL; ?>
UID:<?php echo md5( $settings['dce_calendar_title'] . '-' . $element_id . '-' . $ics_post_id );
echo ICS_EOL; ?>
BEGIN:VALARM<?php echo ICS_EOL; ?>
ACTION:DISPLAY<?php echo ICS_EOL; ?>
TRIGGER;VALUE=DATE-TIME:<?php echo $start_field;
echo ICS_EOL; ?>
DESCRIPTION:<?php echo $title;
echo ICS_EOL; ?>
END:VALARM<?php echo ICS_EOL; ?>
END:VEVENT<?php echo ICS_EOL; ?>
END:VCALENDAR<?php
	//Collect output and echo
	$eventsical = ob_get_contents();
	ob_end_clean();
	echo $eventsical;
	exit();
} else {
	echo 'ERROR';
}
