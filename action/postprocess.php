<?php
/**
 * Text Variable plugin for DokuWiki; Action component
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Sahara Satoshi <sahara.satoshi@gmail.com>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class action_plugin_textvar_postprocess extends DokuWiki_Action_Plugin {

    // store Text Variables definition map
    protected $TextVariables = null;

    // register hook
    public function register(Doku_Event_Handler $controller) {
        //$controller->register_hook('RENDERER_CONTENT_POSTPROCESS', 'AFTER', $this, '_handlePageContent');
        $controller->register_hook('TPL_CONTENT_DISPLAY', 'BEFORE', $this, '_handleDisplayContent');
    }

    /**
     * 置換ルールを読み込む
     */
    protected function load_TextVariables() {

        if ($this->TextVariables === null) {
            $this->TextVariables = array();

            // use set_TextVariables() in lib/preload.php
            if (function_exists(set_TextVariables)) {
                $this->TextVariables += set_TextVariables();
            }

            $mapfile = DOKU_CONF.'text_variables.conf';
            if (is_readable($mapfile)) {
                $this->TextVariables += confToHash($mapfile);
            } else {
                // test only
                $this->TextVariables += array(
                    '%THE_DATE%'  => '2000-01-01',
                    '%THE_PLACE%' => 'Tokyo',
                );
            }
            //error_log('text variables map ='.var_export($this->TextVariables, 1));
        }

        return !empty($this->TextVariables);
    }



    /**
     * Replace text variables in renderer post process stage
     * in RENDERER_CONTENT_POSTPROCESS event
     * 置換してからキャッシュするアプローチ xhtml cache は置換済となる
     * syntaxコンポーネント内の render() で処理するのと実質的に同じ
     */
    function _handlePageContent(Doku_Event $event, $param) {

        if ($event->data[0] != 'xhtml') return;
        if (!$this->load_TextVariables()) return;

        foreach ($this->TextVariables as $variable => $replace) {
            $search = '<span title="textVariable">'.$variable.'</span>';

            $event->data[1] = str_replace($search, $replace, $event->data[1]);
        }
    }

    /**
     * Replace text variables in XHTML display stage
     * in TPL_CONTENT_DISPLAY event
     * キャッシュ後に置換するアプローチ xhtml cache は置換なし
     * sidebar 内は置換対象にならない
     */
    function _handleDisplayContent(Doku_Event $event, $param) {

        if (!$this->load_TextVariables()) return;

        foreach ($this->TextVariables as $variable => $replace) {
            $search = '<span title="textVariable">'.$variable.'</span>';

            $event->data = str_replace($search, $replace, $event->data);
        }
    }

}
