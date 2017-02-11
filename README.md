Text Variable plugin for DokuWiki
===================================

**Text variables** provide a way to insert text that can change depending on various factors, such as SERVER_ADDR and REMOTE_ADDR. They are replaced by JavaScript when the page loaded.
The name of text variable must consist only capital letters (A-Z) and '_'.

```
  <!--%TEXT_VAR%-->
```

You may define the replacement in the `conf/userscript.js` file. Please refer to DokuWiki development manual on [JavaScript](https://www.dokuwiki.org/devel:javascript).

```
jQuery(function() {
    jQuery('span.plugin_textvar:contains("%PLACE_HOLDER%")').replaceWith(
        'replaced HTML content by JavaScript'
    );
});

```

Predefined Place Holders
* `<!--%REMOTE_ADDR%-->` : replaced to `$_SERVER['REMOTE_ADDR']`
* `<!--%SERVER_ADDR%-->` : replaced to `$_SERVER['SERVER_ADDR']`

----
Licensed under the GNU Public License (GPL) version 2

(c) 2015-2017 Satoshi Sahara \<sahara.satoshi@gmail.com>
