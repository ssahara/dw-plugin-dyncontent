Dynamic Content plugin for DokuWiki
===================================

Set a `%PLACE_HOLDER%` in the page to identify HTML element to be replaced by JavaScript when the page loaded. The name of place holder must consist only capital letters (A-Z) and '_'.

```
  <!--%PLACE_HOLDER%-->
```

You may define the replacement in the `conf/userscript.js` file. Please refer to DokuWiki development manual on [JavaScript](https://www.dokuwiki.org/devel:javascript).

```
jQuery(function() {
    jQuery('span.plugin_dyncontent:contains("%PLACE_HOLDER%")').replaceWith(
        'replaced HTML content by JavaScript'
    );
});

```

Predefined Place Holders
* `<!--%REMOTE_ADDR%-->` : replaced to `$_SERVER['REMOTE_ADDR']`
* `<!--%SERVER_ADDR%-->` : replaced to `$_SERVER['SERVER_ADDR']`

----
Licensed under the GNU Public License (GPL) version 2

(c) 2015 Satoshi Sahara \<sahara.satoshi@gmail.com>
