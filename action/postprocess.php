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
     * Replace text variables in renderer post process stage
     * in RENDERER_CONTENT_POSTPROCESS event (before page xhtml cached)
     */
    function _handlePageContent(Doku_Event $event, $param) {

        if ($event->data[0] != 'xhtml') return;

        // load replacement rules
        $map = $this->loadHelper($this->getPluginName());

        foreach ($map->TextVariables as $variable => $replace) {
            $search = '<var title="textVariable">'.$variable.'</var>';

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
            $search = '<var title="textVariable">'.$variable.'</var>';

            $event->data = str_replace($search, $replace, $event->data);
        }
    }

}
