// utils
var deepMerge = require('../utils/deepMerge');

/**
 * BrowserSync
 * configuration
 * object
 *
 */

// set server
var browsersync_proxy = 'localhost:8888/imperia';

module.exports = deepMerge({
	proxy: browsersync_proxy,
	notify: false,
	open: false,
	snippetOptions: {
	  whitelist: ['/wp-admin/admin-ajax.php'],
	  blacklist: ['/wp-admin/**']
	}
});
