/*
 * script.js : DynContent plugin for DokuWiki
 * replace predefined place holder "%REMOTE_ADDR%" and "%SERVER_ADDR%"
 *
 * @author Satoshi Sahara <sahara.satoshi@gmail.com>
 */

// Global variable, defined in conf/userscript.js
//  var DYN_CONTENTS ={ '%FOO%': 'bar' };
if (DYN_CONTENTS == undefined) {
    var DYN_CONTENTS = {};
}

jQuery(function() {
    jQuery.post(
        DOKU_BASE + 'lib/exe/ajax.php',
        {
            call: 'plugin_dyncontent',
            name: 'local'
        },
        function(data) {
            for (var key in data) {
                DYN_CONTENTS[key] = data[key];
            }
            for (var key in DYN_CONTENTS) {
                var selector = 'span.plugin_dyncontent:contains("' + key + '")';
                jQuery(selector).replaceWith(DYN_CONTENTS[key]);
            }
        },
        'json'
    );
});

