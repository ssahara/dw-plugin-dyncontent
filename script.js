/*
 * script.js : DynContent plugin for DokuWiki
 * replace predefined place holder "%REMOTE_ADDR%" and "%SERVER_ADDR%"
 *
 * @author Satoshi Sahara <sahara.satoshi@gmail.com>
 */

jQuery(function() {
    if (typeof JSINFO.server == 'undefined') return;

    var objReplacement = {
        "%REMOTE_ADDR%" : JSINFO.server.REMOTE_ADDR,
        "%SERVER_ADDR%" : JSINFO.server.SERVER_ADDR
    };
    for(var key in objReplacement) {
        var selector = 'span.plugin_dyncontent:contains("' + key + '")';
        jQuery(selector).replaceWith(objReplacement[key]);
    }

/*
    jQuery('span.plugin_placeholder:contains("%REMOTE_ADDR%")').replaceWith(
        JSINFO.server.REMOTE_ADDR
    );
    jQuery('span.plugin_placeholder:contains("%SERVER_ADDR%")').replaceWith(
        JSINFO.server.SERVER_ADDR
    );
*/
});



