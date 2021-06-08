<?php
namespace DynamicContentForElementor;

trait Trait_Notice {

	public static function notice( $title = '', $content = '' ) { ?>
	<div class="elementor-alert elementor-alert-info" role="alert">
		<?php if ( $title ) { ?>
		 <span class="elementor-alert-title"><?php echo $title; ?></span>
	 <?php }
		if ( $content ) { ?>
		 <span class="elementor-alert-description"><?php echo $content; ?></span>
		 <?php } ?>
	</div>
	<?php }
} ?>
