<?php
/**
 * Text Variable plugin for DokuWiki; Action component
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Sahara Satoshi <sahara.satoshi@gmail.com>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class action_plugin_textvar_deferred extends DokuWiki_Action_Plugin {

    // register hook
    public function register(Doku_Event_Handler $controller) {
        $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this, '_ajax_call');
    }

    /**
     * Ajax handler
     */
    function _ajax_call(Doku_Event $event, $param) {
        if ($event->data !== 'plugin_textvar') return;
        $event->stopPropagation();
        $event->preventDefault();

        $json = new JSON();

        $data = array(
            '%SERVER_ADDR%' => $_SERVER['SERVER_ADDR'],
            '%REMOTE_ADDR%' => $_SERVER['REMOTE_ADDR'],
        );

        header('Content-Type: application/json');
        echo $json->encode($data);
    }
}
