<?php
/**
 * Этот файл инициализирует этот плагин, как аддон для плагина Clearfy.
 *
 * Файл будет подключен только в плагине Clearfy, используя особый вариант загрузки. Это более простое решение
 * пришло на смену встроенной системы подключения аддонов в фреймворке.
 *
 * @author        Alex Kovalev <alex.kovalevv@gmail.com>, Github: https://github.com/alexkovalevv
 * @copyright (c) 2018 Webraftic Ltd
 */

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

if( !defined('WHTM_PLUGIN_ACTIVE') ) {
	define('WHTM_PLUGIN_VERSION', '1.1.3');
	define('WHTM_TEXT_DOMAIN', 'html-minify');
	define('WHTM_PLUGIN_ACTIVE', true);

	// Этот плагин загружен, как аддон для плагина Clearfy
	define('LOADING_HTML_MINIFY_AS_ADDON', true);

	if( !defined('WHTM_PLUGIN_DIR') ) {
		define('WHTM_PLUGIN_DIR', dirname(__FILE__));
	}

	if( !defined('WHTM_PLUGIN_BASE') ) {
		define('WHTM_PLUGIN_BASE', plugin_basename(__FILE__));
	}

	if( !defined('WHTM_PLUGIN_URL') ) {
		define('WHTM_PLUGIN_URL', plugins_url('', __FILE__));
	}

	try {
		// Global scripts
		require_once(WHTM_PLUGIN_DIR . '/includes/3rd-party/class-clearfy-plugin.php');
		new WHTM_Plugin();
	} catch( Exception $e ) {
		$whtml_plugin_error_func = function () use ($e) {
			$error = sprintf("The %s plugin has stopped. <b>Error:</b> %s Code: %s", 'Webcraftic Html minify', $e->getMessage(), $e->getCode());
			echo '<div class="notice notice-error"><p>' . $error . '</p></div>';
		};

		add_action('admin_notices', $whtml_plugin_error_func);
		add_action('network_admin_notices', $whtml_plugin_error_func);
	}
}


