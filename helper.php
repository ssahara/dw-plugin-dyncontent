<?php
/**
 * Text Variable plugin for DokuWiki; Helper component
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Sahara Satoshi <sahara.satoshi@gmail.com>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class helper_plugin_textvar extends DokuWiki_Plugin {

    // store Text Variables definition
    public $TextVariables = NULL;
    public $mapfile;


    function __construct() {

        $this->mapfile = DOKU_CONF.'text_variables.conf';

        $cache = new cache('##text_variavles##','.conf');
        $depends = array('files' => array($this->mapfile));

        if ($cache->useCache($depends)) {
            $this->TextVariables = unserialize($cache->retrieveCache(false));
        } else {
            if ($this->load_TextVariables()) {
                $cache->storeCache(serialize($this->TextVariables));
            } else {
                $this->TextVariables = array();
            }
        }

        $this->TextVariables += array(
            '%SERVER_ADDR%' => $_SERVER['SERVER_ADDR'],
            '%REMOTE_ADDR%' => $_SERVER['REMOTE_ADDR'],
            '%PHP_VERSION%' => phpversion(),
        );

    }

    function __destruct() {
        $this->TextVariables = NULL;
    }

    /**
     * load Text Variables definition map
     */
    protected function load_TextVariables() {

        if (file_exists($this->mapfile) && is_readable($this->mapfile)) {
            $this->TextVariables = confToHash($this->mapfile);
            return true;
        } else {
            return false;
        }
    }

}
