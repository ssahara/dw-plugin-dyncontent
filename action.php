<?php
/**
 * DokuWiki plugin DynContent; Action component
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Sahara Satoshi <sahara.satoshi@gmail.com>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class action_plugin_dyncontent extends DokuWiki_Action_Plugin {

    // register hook
    public function register(Doku_Event_Handler $controller) {
        $controller->register_hook('DOKUWIKI_STARTED', 'BEFORE', $this, '_exportToJSINFO');
    }

    /**
     * export $_SERVER to JSINFO
     */
    public function _exportToJSINFO(Doku_Event $event, $param) {
        global $JSINFO;
        //$JSINFO['server'] = $_SERVER;
        $JSINFO['server'] = array(
            'SERVER_NAME' => $_SERVER['SERVER_NAME'],
            'SERVER_ADDR' => $_SERVER['SERVER_ADDR'],
            'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
            'REMOTE_USER' => $_SERVER['REMOTE_USER'],
        );
    }

}
