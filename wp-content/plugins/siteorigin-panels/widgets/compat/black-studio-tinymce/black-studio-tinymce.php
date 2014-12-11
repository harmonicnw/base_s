<?php
/**
 *  This file adds compatibility with Black Studio TinyMCE widget.
 */

/**
 * Add all the required actions for the TinyMCE widget.
 */
function siteorigin_panels_black_studio_tinymce_admin_init() {
	global $pagenow;

	if (
		in_array($pagenow, array('post-new.php', 'post.php')) ||
		($pagenow == 'themes.php' && isset($_GET['page']) && $_GET['page'] == 'so_panels_home_page' )
	)  {

		if( function_exists('bstw') ) {
			add_filter( 'tiny_mce_before_init', array(bstw(), 'tiny_mce_before_init'), 20 );
			add_action( 'admin_head', array(bstw(), 'enqueue_media') );
			add_action( 'admin_print_scripts', array(bstw(), 'admin_print_scripts') );
			add_action( 'admin_print_styles', array(bstw(), 'admin_print_styles') );
			add_action( 'admin_print_footer_scripts', array(bstw(), 'admin_print_footer_scripts') );
		}
		else {
			add_filter( 'tiny_mce_before_init', 'black_studio_tinymce_init_editor', 20 );
			add_action( 'admin_head', 'black_studio_tinymce_load_tiny_mce' );
			add_action( 'admin_print_scripts', 'black_studio_tinymce_scripts' );
			add_action( 'admin_print_styles', 'black_studio_tinymce_styles' );
			add_action( 'admin_print_footer_scripts', 'black_studio_tinymce_footer_scripts' );
		}
	}

}
add_action('admin_init', 'siteorigin_panels_black_studio_tinymce_admin_init');

/**
 * Enqueue all the admin scripts for Black Studio TinyMCE compatibility with Page Builder.
 *
 * @param $page
 */
function siteorigin_panels_black_studio_tinymce_admin_enqueue($page) {
	$screen = get_current_screen();
	if ( ( $screen->base == 'post' && in_array( $screen->id, siteorigin_panels_setting('post-types') ) ) || $screen->base == 'appearance_page_so_panels_home_page') {

		global $black_studio_tinymce_widget_version;
		if( !isset($black_studio_tinymce_widget_version) && function_exists('black_studio_tinymce_get_version')) {
			$black_studio_tinymce_widget_version = black_studio_tinymce_get_version();
		}

		if( version_compare($black_studio_tinymce_widget_version, '1.3.3', '<=') ) {
			// Use the old compatibility file.
			wp_enqueue_script( 'black-studio-tinymce-widget-siteorigin-panels', plugin_dir_url( SITEORIGIN_PANELS_BASE_FILE ) . 'widgets/compat/black-studio-tinymce/black-studio-tinymce-widget-siteorigin-panels.old.min.js', array( 'jquery' ), SITEORIGIN_PANELS_VERSION );
		}
		else {
			// Use the new compatibility file
			wp_enqueue_script( 'black-studio-tinymce-widget-siteorigin-panels', plugin_dir_url( SITEORIGIN_PANELS_BASE_FILE ) . 'widgets/compat/black-studio-tinymce/black-studio-tinymce-widget-siteorigin-panels.min.js', array( 'jquery' ), SITEORIGIN_PANELS_VERSION );
		}

		wp_enqueue_style('black-studio-tinymce-widget-siteorigin-panels', plugin_dir_url(SITEORIGIN_PANELS_BASE_FILE).'widgets/compat/black-studio-tinymce/black-studio-tinymce-widget-siteorigin-panels.css', array(), SITEORIGIN_PANELS_VERSION);


		if(version_compare($black_studio_tinymce_widget_version, '1.2.0', '<=')) {
			// We also need a modified javascript for older versions of Black Studio TinyMCE
			wp_enqueue_script('black-studio-tinymce-widget', plugin_dir_url(SITEORIGIN_PANELS_BASE_FILE).'widgets/compat/black-studio-tinymce/black-studio-tinymce-widget.min.js', array('jquery'), SITEORIGIN_PANELS_VERSION);
		}
	}
}
add_action('admin_enqueue_scripts', 'siteorigin_panels_black_studio_tinymce_admin_enqueue', 15);

