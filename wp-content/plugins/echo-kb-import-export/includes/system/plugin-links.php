<?php

/**
 * Setup links and information on Plugins WordPress page
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */


/**
 * Adds various links for plugin on the Plugins page displayed on the left
 *
 * @param   array $links contains current links for this plugin
 * @return  array returns an array of links
 */
function epie_add_plugin_action_links ( $links ) {
	$my_links = array(
		__( 'Configuration', 'echo-knowledge-base' )      => '<a href="' . admin_url(EPIE_KB_Core::EPIE_KB_CONFIGURATION_URL) . '">' . esc_html__( 'Configuration', 'echo-knowledge-base' ) . '</a>',
		__( 'Documentation', 'echo-knowledge-base' )      => '<a href="https://www.echoknowledgebase.com/documentation/?top-category=add-ons" target="_blank">' . esc_html__( 'Docs', 'echo-knowledge-base' ) . '</a>',
		__( 'Support', 'echo-knowledge-base' )            => '<a href="https://www.echoknowledgebase.com/contact-us/?inquiry-type=technical">' . esc_html__( 'Support', 'echo-knowledge-base' ) . '</a>'
	);

	return array_merge( $my_links, $links );
}
add_filter( 'plugin_action_links_' . plugin_basename(Echo_KB_Import_Export::$plugin_file), 'epie_add_plugin_action_links' , 10, 2 );

/**
 * Add info about plugin on the Plugins page displayed on the right.
 *
 * @param $links
 * @param $file
 * @return array
 */
function epie_add_plugin_row_meta($links, $file) {
	if ( $file != 'echo-kb-import-export/echo-kb-import-export.php' ) {
		return $links;
	}

	//TODO $links[] = '<a href="https://www.echoknowledgebase.com/kb-updates-for-access-manager-search/" target="_blank">' . esc_html__( "What's New", 'echo-knowledge-base' ) . '</a>';

	return $links;
}
add_filter( 'plugin_row_meta', 'epie_add_plugin_row_meta', 10, 2 );
