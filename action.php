<?php
/**
 * Text Variable plugin for DokuWiki; Action component
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Sahara Satoshi <sahara.satoshi@gmail.com>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class action_plugin_textvar extends DokuWiki_Action_Plugin {

    // register hook
    function register(Doku_Event_Handler $controller) {
        $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this, '_ajax_call');

        //$controller->register_hook('RENDERER_CONTENT_POSTPROCESS', 'AFTER', $this, '_handlePageContent');
        $controller->register_hook('TPL_CONTENT_DISPLAY', 'BEFORE', $this, '_handleDisplayContent');
    }

    /**
     * Ajax handler
     */
    function _ajax_call(Doku_Event $event, $param) {
        // must be called as 'plugin_textvar'
        if ($event->data !== substr(get_class($this), 7)) return;
        $event->stopPropagation();
        $event->preventDefault();

        $json = new JSON();

        $map = $this->loadHelper($this->getPluginName());

        // append non-static variables
        $map->TextVariables += array(
            '%SERVER_ADDR%' => $_SERVER['SERVER_ADDR'],
            '%REMOTE_ADDR%' => $_SERVER['REMOTE_ADDR'],
            '%PHP_VERSION%' => phpversion(),
        );

        header('Content-Type: application/json');
        echo $json->encode($map->TextVariables);

    }

    /**
     * Replace text variables in renderer post process stage
     * in RENDERER_CONTENT_POSTPROCESS event (before page xhtml cached)
     */
    function _handlePageContent(Doku_Event $event, $param) {

        if ($event->data[0] != 'xhtml') return;

        // load replacement rules
        $map = $this->loadHelper($this->getPluginName());

        foreach ($map->TextVariables as $variable => $replace) {
            $search = '<var class="plugin_textvar" title="textVariable">'.$variable.'</var>';

            $event->data[1] = str_replace($search, $replace, $event->data[1]);
        }
    }

    /**
     * Replace text variables in XHTML display stage
     * in TPL_CONTENT_DISPLAY event (after the page xhtml cached)
     * NOTE: NO EFFECTIVE in sidebar !!
     */
    function _handleDisplayContent(Doku_Event $event, $param) {

        // load replacement rules
        $map = $this->loadHelper($this->getPluginName());

        foreach ($map->TextVariables as $variable => $replace) {
            $search = '<var class="plugin_textvar" title="textVariable">'.$variable.'</var>';

            $event->data = str_replace($search, $replace, $event->data);
        }
    }

}
