<?php
/**
 * Plugin Name: KB - Import Export
 * Plugin URI: https://www.echoknowledgebase.com/wordpress-add-ons/
 * Description: Import and export KB content and configuration.
 * Version: 1.0.0
 * Author: Echo Plugins
 * Author URI: https://www.echoknowledgebase.com
 * Text Domain: echo-kb-import-export
 * Domain Path: languages
 * Copyright: (c) 2018 Echo Plugins
 *
 * KB - Import Export is distributed under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * KB - Import Export is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with KB - Import Export. If not, see <http://www.gnu.org/licenses/>.
 *
*/

if ( ! defined( 'ABSPATH' ) ) exit;

// plugin name; used in KB core
if ( ! defined( 'EPIE_PLUGIN_NAME' ) ) {
	define( 'EPIE_PLUGIN_NAME', 'KB - Import Export' );
}

/**
 * Main class to load the plugin.
 *
 * Singleton
 */
final class Echo_KB_Import_Export {

	/* @var Echo_KB_Import_Export */
	private static $instance;

	public static $version = '1.0.0';
	public static $plugin_dir;
	public static $plugin_url;
	public static $plugin_file = __FILE__;
	public static $needs_min_core_version = '6.8.0';

	/* @var EPIE_License_Handler */
	public $license_handler;

	public $is_dormant = false;

	/**
	 * Initialise the plugin
	 */
	private function __construct() {
		self::$plugin_dir = plugin_dir_path(  __FILE__ );
		self::$plugin_url = plugin_dir_url( __FILE__ );
	}

	/**
	 * Retrieve or create a new instance of this main class (avoid global vars)
	 *
	 * @param bool $dormant
	 * @return Echo_KB_Import_Export
	 */
	public static function instance( $dormant=false ) {

		if ( isset( self::$instance ) || self::$instance instanceof Echo_KB_Import_Export  ) {
			return self::$instance;
		}

		self::$instance = new Echo_KB_Import_Export();

		// if the plugin is not active, still show update messages and license to enter/save
		if ( $dormant === true ) {
			self::$instance->setup_dormant_system();
			return '';
		}

		self::$instance->setup_system();
		self::$instance->setup_plugin();

		add_action( 'plugins_loaded', array( self::$instance, 'load_text_domain' ), 11 );

		return self::$instance;
	}

	/**
	 * If add-on is not active because it was de-activated or is not matching with core then run only
	 * license related functions
	 */
	private function setup_dormant_system() {
		$this->is_dormant = true;
		require_once self::$plugin_dir . 'includes/system/class-epie-autoloader.php';
		new EPIE_Add_Ons_Page();
		require_once self::$plugin_dir . 'includes/system/scripts-registration.php';
		add_action( 'admin_enqueue_scripts', 'epie_load_admin_plugin_pages_resources' );
		self::instance()->license_handler = new EPIE_License_Handler( self::$plugin_file, self::$version );
	}

	/**
	 * Setup class auto-loading and other support functions. Setup custom core features.
	 */
	private function setup_system() {

		// autoload classes ONLY when needed by executed code rather than on every page request
		require_once self::$plugin_dir . 'includes/system/class-epie-autoloader.php';

		// load non-classes
		require_once self::$plugin_dir . 'includes/system/scripts-registration.php';
		require_once self::$plugin_dir . 'includes/system/plugin-links.php';

		new EPIE_Upgrades();

		// invoke last
		self::instance()->license_handler = new EPIE_License_Handler( self::$plugin_file, self::$version );
	}

	/**
	 * Setup plugin before it runs. Include functions and instantiate classes based on user action
	 */
	private function setup_plugin() {

		$action = EPIE_Utilities::get('action');

		// process action request if any
		if ( ! empty($action) ) {
			$this->handle_action_request( $action );
		}

		// handle AJAX front & back-end requests (no admin, no admin bar)
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			$this->handle_ajax_requests( $action );
			return;
		}

		// ADMIN or CLI
		if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
			$this->setup_backend_classes();
			return;
		}

		// FRONT-END with admin-bar

		// FRONT-END (no ajax, possibly admin bar)
	}

	/**
	 * Handle plugin actions here such as saving settings
	 * @param $action
	 */
	private function handle_action_request( $action ) {
		if ( in_array( $action, array('epie_kb_export_data' ) ) ) {
			new EPIE_KB_Export_Ctrl();
		}
	}

	/**
	 * Handle AJAX requests coming from front-end and back-end
	 * @param $action
	 */
	private function handle_ajax_requests( $action ) {

        if ( empty($action) ) {
            return;
        }

		if ( $action == 'epie_handle_license_request' ) {
			new EPIE_Add_Ons_Page();
			return;
		}
		
		/* if ( $action == 'epie_kb_get_article_ids' ||
			 $action == 'epie_kb_export_article_pack' ||
			 $action == 'epie_kb_export_get_json' ||
			 $action == 'epie_kb_export_get_csv' ||
			 $action == 'epie_get_export_data' ||
			 $action == 'epie_make_step' || 
			) {
			new EPIE_KB_Export_Ctrl();
			return;
		} */

		// import articles
		if ( $action == 'epie_import_kb_content' || $action == 'epie_import_steps' ) {
			new EPIE_KB_Import_Processor();
			return;
		}
	}

	/**
	 * Setup up classes when on ADMIN pages
	 */
	private function setup_backend_classes() {
		global $pagenow, $post;
		
		
		$request_page = EPIE_Utilities::post('page');

		// only process KB pages
		if ( $pagenow == 'post.php' ) {
			$post_id = EPIE_Utilities::get('post');
			$post_id = empty($post_id) ? EPIE_Utilities::post('post_ID', false) : $post_id;
			$post = EPIE_Utilities::get_kb_post_secure( $post_id, false );
			$is_kb_request = ! empty( $post );
		} else {
			$is_kb_request = EPIE_KB_Handler::is_kb_request();
		}

		if ( empty($is_kb_request) ) {
			return;
		}

		add_action( 'admin_enqueue_scripts', 'epie_load_admin_plugin_pages_resources' );
		new EPIE_Admin_Notices();

		// admin core classes
		new EPIE_KB_Export_Ctrl();

		// admin page classes
		new EPIE_KB_Import_Export_Page();

		// admin other classes
		$classes = array(
			// class name, backend/admin-bar, pages, admin_action, KB post type required
			array( 'EPIE_Add_Ons_Page', array('backend'), array('edit.php', EPIE_KB_Core::EPIE_KB_ADD_ONS_PAGE), array(''), true ),
			array( 'EPIE_Settings_Page', array('backend'), array(EPIE_KB_Core::EPIE_KB_DEBUG_PAGE), array(''), true ),
		);

		$current_page = empty($request_page) ? $pagenow : $request_page;
		$action = EPIE_Utilities::get('action');
		foreach( $classes as $class_info ) {

			if ( $class_info[4] && ! $is_kb_request ) {
				continue;
			}

			// INDIVIDUAL PAGES: if feature available on a specific page then ensure the page is being loaded
			if ( ( ! in_array($current_page, $class_info[2]) ) &&
			     ( empty($class_info[3]) || empty($action) || ! in_array($action, $class_info[3]) ) ) {
				continue;
			}

			$new_class = $class_info[0];
			if ( class_exists($new_class) ) {
				new $new_class();
			}
		}
	}

	/**
	 * Loads the plugin language files from ./languages directory.
	 */
	public function load_text_domain() {
		load_plugin_textdomain( 'echo-kb-import-export', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	// Don't allow this singleton to be cloned.
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, 'Invalid (#1)', '4.0' );
	}

	// Don't allow un-serializing of the class except when testing
	public function __wakeup() {
		if ( strpos($GLOBALS['argv'][0], 'phpunit') === false ) {
			_doing_it_wrong( __FUNCTION__, 'Invalid (#1)', '4.0' );
		}
	}
}

// for add-on we need to register installation scripts now
require_once Echo_KB_Import_Export::$plugin_dir . 'includes/system/plugin-setup.php';

/**
 * Returns the single instance of this class
 *
 * @return Echo_KB_Import_Export - this class instance
 */
function epie_get_instance() {

	$plugins_check = epie_check_plugins_versions();

	// if KB Core plugin is not active then do not run
	if ( $plugins_check == 'core_missing' ) {
		add_action( 'admin_notices', 'epie_display_version_error' );
		return '';
	}

	// we need core Knowledge Base plugin in order to run this plugin
	if ( $plugins_check != 'core_too_old' && $plugins_check != 'core_too_new' ) {
		return Echo_KB_Import_Export::instance();
	}

	// Show admin screen top notification
	add_action( 'admin_notices', 'epie_display_version_error' );

	// load instance but in 'dormant' state
	return Echo_KB_Import_Export::instance( true );
}
// ensure this happens after main KB plugin is loaded
add_action( 'plugins_loaded', 'epie_get_instance' );

/**
 * Show admin screen top notification
 */
function epie_display_version_error() {

	$kb_post_prefix = 'ep' . 'kb_post_type';
	$kb_plugin_name = defined( 'AMAG_PLUGIN_NAME' ) ? AMAG_PLUGIN_NAME : 'Knowledge Base for Documents and FAQs';

	$plugins_check = epie_check_plugins_versions();

	// if KB Core plugin is not installed or active then let user know
	if ( $plugins_check == 'core_missing' ) {
		echo '<div class="error"><p>KB - Import Export requires <a href="https://wordpress.org/plugins/echo-knowledge-base/"
		                title="' . $kb_plugin_name . '" target="_blank">' . $kb_plugin_name . '</a>. Please install it to continue.</p></div>';
		return;
	}

	// only show messages on KB pages
	if ( ! isset($_REQUEST['post_type']) || strncmp($_REQUEST['post_type'] , $kb_post_prefix, strlen($kb_post_prefix)) !== 0 ) {
		return;
	}

	// compare core and add-on versions
	if ( $plugins_check == 'core_too_old' ) {
		echo '<div class="error">KB Import Export plugin requires at least ' . Echo_KB_Import_Export::$needs_min_core_version .
		     ' version of the ' . $kb_plugin_name . ' plugin.	To continue please update ' . $kb_plugin_name . '.</p></div>';

    } else if ( $plugins_check == 'core_too_new' ) {
		$add_on_url = admin_url('edit.php?post_type=' . $kb_post_prefix . '_1&page=ep'.'kb-add-ons&ep'.'kb-tab=licenses');
		echo '<div class="error">' . $kb_plugin_name . ' plugin requires the most recent version of the KB Import Export plugin. The old version of KB Import Export stays
			<strong>disabled</strong> until updated. <a href="' . $add_on_url .'" target="_blank">Check its status here.</a></p></div>';
	} else {
		// should not happen
		echo '<div class="error">KB Import Export: unknown add-on version conflict.</div>';
	}
}

/**
 * Check version of this add-on against core plugin and report differences.
 *
 * @return string
 */
function epie_check_plugins_versions() {

	// if KB Core plugin is not active then do not run
	if ( ! class_exists( 'Echo_' . 'Knowledge_Base', false ) ) {
		return 'core_missing';
	}

    $min_add_on_version = isset(Echo_Knowledge_Base::$needs_min_add_on_version) && isset(Echo_Knowledge_Base::$needs_min_add_on_version['PIE'])
										? Echo_Knowledge_Base::$needs_min_add_on_version['PIE'] : '1.0.0';

    if ( version_compare(Echo_Knowledge_Base::$version, Echo_KB_Import_Export::$needs_min_core_version, '<' ) ) {
		return 'core_too_old';
    } else if ( version_compare(Echo_KB_Import_Export::$version, $min_add_on_version, '<' ) ) {
		return 'core_too_new';
	}

	return '';
}
