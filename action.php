<?php
/**
 * Text Variable plugin for DokuWiki; Action component
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Sahara Satoshi <sahara.satoshi@gmail.com>
 */
// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class action_plugin_textvar extends DokuWiki_Action_Plugin
{
    // register hook
    public function register(Doku_Event_Handler $controller)
    {
        $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this, 'ajax_call');

        //$controller->register_hook('RENDERER_CONTENT_POSTPROCESS', 'AFTER', $this, 'handlePageContent');
        $controller->register_hook('TPL_CONTENT_DISPLAY', 'BEFORE', $this, 'handleDisplayContent');
    }

    /**
     * Ajax handler
     */
    public function ajax_call(Doku_Event $event, $param)
    {
        // must be called as 'plugin_textvar'
        if ($event->data !== substr(get_class($this), 7)) return;
        $event->stopPropagation();
        $event->preventDefault();

        $map = $this->loadHelper($this->getPluginName());

        // append non-static variables
        $map->TextVariables += array(
            '%SERVER_ADDR%' => $_SERVER['SERVER_ADDR'],
            '%REMOTE_ADDR%' => $_SERVER['REMOTE_ADDR'],
            '%PHP_VERSION%' => phpversion(),
        );

        header('Content-Type: application/json');
        if (function_exists('json_encode') {
            echo json_encode($map->TextVariables);
        } else {
            $json = new JSON();
            echo $json->encode($map->TextVariables);
        }

    }

    /**
     * RENDERER_CONTENT_POSTPROCESS
     *
     * Replace text variables in renderer post process stage
     * in RENDERER_CONTENT_POSTPROCESS event (before page xhtml cached)
     */
    public function handlePageContent(Doku_Event $event, $param)
    {
        if ($event->data[0] != 'xhtml') return;

        // load replacement rules
        $map = $this->loadHelper($this->getPluginName());

        foreach ($map->TextVariables as $variable => $replace) {
            $search = '<var class="plugin_textvar" title="textVariable">'.$variable.'</var>';

            $event->data[1] = str_replace($search, $replace, $event->data[1]);
        }
    }

    /**
     * TPL_CONTENT_DISPLAY
     *
     * Replace text variables in XHTML display stage
     * in TPL_CONTENT_DISPLAY event (after the page xhtml cached)
     * NOTE: NO EFFECTIVE in sidebar !!
     */
    public function handleDisplayContent(Doku_Event $event, $param)
    {
        // load replacement rules
        $map = $this->loadHelper($this->getPluginName());

        foreach ($map->TextVariables as $variable => $replace) {
            $search = '<var class="plugin_textvar" title="textVariable">'.$variable.'</var>';

            $event->data = str_replace($search, $replace, $event->data);
        }
    }

}
