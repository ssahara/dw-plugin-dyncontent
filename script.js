/*
 * script.js : Text Variable plugin for DokuWiki
 * replace predefined place holder "%REMOTE_ADDR%" and "%SERVER_ADDR%"
 *
 * @author Satoshi Sahara <sahara.satoshi@gmail.com>
 */

// Global variable, defined in conf/userscript.js
//  var TEXT_VARIABLES = { '%FOO%': 'bar' };
if (TEXT_VARIABLES == undefined) {
    var TEXT_VARIABLES = {};
}

jQuery(function() {
    jQuery.post(
        DOKU_BASE + 'lib/exe/ajax.php',
        {
            call: 'plugin_textvar',
            name: 'local'
        },
        function(data) {
            for (var key in data) {
                TEXT_VARIABLES[key] = data[key];
            }
            for (var key in TEXT_VARIABLES) {
                var selector = 'var.plugin_textvar:contains("' + key + '")';
                jQuery(selector).replaceWith(TEXT_VARIABLES[key]);
            }
        },
        'json'
    );
});

