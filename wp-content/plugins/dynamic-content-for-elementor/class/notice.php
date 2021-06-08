<?php
namespace DynamicContentForElementor;

class Notice {

	public function __construct() {

	}

	public static function dce_admin_notice__license() {
		if ( did_action( 'elementor/loaded' ) ) { ?>
		<div class="error notice-error notice dce-generic-notice">
			<div class="img-responsive pull-left" style="float: left; margin-right: 20px;"><img src="<?php echo DCE_URL; ?>/assets/media/dce.png" title="Dynamic Content for Elementor" height="36" width="36"></div>
			<p><strong><?php _e( 'Welcome to Dynamic Content for Elementor!', 'dynamic-content-for-elementor' ); ?></strong><br />
			<?php _e( 'It seems that your copy is not activated, please <a href="' . admin_url() . 'admin.php?page=dce_opt&tab=license">activate it</a> or <a href="https://www.dynamic.ooo/pricing" target="blank">buy a new license</a>.', 'dynamic-content-for-elementor' ); ?></p>
		</div>
	<?php }
	}

	public static function dce_admin_notice__server_error( $msg = '' ) { ?>
		<div class="error notice-error notice dce-generic-notice is-dismissible">
			<div class="img-responsive pull-left" style="float: left; margin-right: 20px;"><img src="<?php echo DCE_URL; ?>/assets/media/dce.png" title="Dynamic Content for Elementor" height="36" width="36"></div>
			<p><strong>Dynamic Content for Elementor</strong><br />
			<?php if ( $msg ) {
				echo wp_kses_post( $msg );
			} else {
				_e( 'There was a problem establishing a connection to the API server', 'dynamic-content-for-elementor' ); } ?></p>
		</div>
	<?php }

	public static function dce_admin_notice__success( $msg = '' ) { ?>
		<div class="success notice-success notice dce-generic-notice is-dismissible updated">
			<div class="img-responsive pull-left" style="float: left; margin-right: 20px;"><img src="<?php echo DCE_URL; ?>/assets/media/dce.png" title="Dynamic Content for Elementor" height="36" width="36"></div>
			<p><strong>Dynamic Content for Elementor</strong><br />
			<?php if ( $msg ) {
				echo wp_kses_post( $msg );
			} else {
				_e( get_option( 'dce_notice' ), 'dynamic-content-for-elementor' ); } ?></p>
		</div>
	<?php }

	public static function dce_admin_notice__warning( $msg = '' ) { ?>
		<div class="warning notice-warning notice dce-generic-notice is-dismissible update-nag">
			<div class="img-responsive pull-left" style="float: left; margin-right: 20px;"><img src="<?php echo DCE_URL; ?>/assets/media/dce.png" title="Dynamic Content for Elementor" height="36" width="36"></div>
			<p><strong>Dynamic Content for Elementor</strong><br />
			<?php if ( $msg ) {
				echo wp_kses_post( $msg );
			} else {
				_e( get_option( 'dce_notice' ), 'dynamic-content-for-elementor' ); } ?></p>
		</div>
	<?php }

	public static function dce_admin_notice__danger( $msg = '' ) { ?>
		<div class="warning notice-danger notice dce-generic-notice is-dismissible error">
			<div class="img-responsive pull-left" style="float: left; margin-right: 20px;"><img src="<?php echo DCE_URL; ?>/assets/media/dce.png" title="Dynamic Content for Elementor" height="36" width="36"></div>
			<p><strong>Dynamic Content for Elementor</strong><br />
			<?php if ( $msg ) {
				echo wp_kses_post( $msg );
			} else {
				_e( get_option( 'dce_notice' ), 'dynamic-content-for-elementor' ); } ?></p>
		</div>
	<?php }

}
