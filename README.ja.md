[EN](./README.md) | JA

Text Variable plugin for DokuWiki
===================================

DokuWiki のプラグイン。ソーステキスト中の変数 `%VARIABLES%` を別途定義した内容に置換する仕組みを実現します。	置換は、 DokuWiki サーバがキャッシュされた (X)HTML をクライアントにを送る直前のステージで行われます。 

テキスト変数の名前は、英字大文字とアンダースコアを使用し、両端を`%`で囲みます。テキスト変数の内容は conf/text_variables.conf で設定します。未定義の変数は、そのまま表示されます。



##定義済のテキスト変数

    %SERVER_ADDR% Wiki サーバの IP アドレス (= $_SERVER['REMOTE_ADDR'])
    %REMOTE_ADDR% ページを閲覧しているユーザ側の IP アドレス (= $_SERVER['REMOTE_ADDR'])

##使用例

ページ内で 閲覧者の IP アドレスを表示させる場合には、以下のように記述します。

```
    Welcome from IP %REMOTE_ADDR%
```

sidebar で使用する場合には、 上の例では置換されません。 jQuery で置換させるため、以下のように記述します。

```
  <!--%REMOTE_ADDR%-->
```

## 応用編

You may define the replacement in the `conf/userscript.js` file. Please refer to DokuWiki development manual on [JavaScript](https://www.dokuwiki.org/devel:javascript).

```
jQuery(function() {
    jQuery('span.plugin_textvar:contains("%PLACE_HOLDER%")').replaceWith(
        'replaced HTML content by JavaScript'
    );
});

```


----
Licensed under the GNU Public License (GPL) version 2

(c) 2015-2017 Satoshi Sahara \<sahara.satoshi@gmail.com>
