<?php
/**
 * Text Variable plugin for DokuWiki; Syntax component
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Satoshi Sahara <sahara.satoshi@gmail.com>
 */
// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class syntax_plugin_textvar extends DokuWiki_Syntax_Plugin {

    protected $special_pattern = '<!-- ?%[A-Z][A-Z_-]*?% ?-->';  // eg. <!--%REMOTE_ADDR%-->
    protected $pluginMode;

    function __construct() {
        $this->pluginMode = substr(get_class($this), 7); // drop 'syntax_' from class name
    }

    public function getType() { return 'substition'; }
    public function getPType(){ return 'normal'; }
    public function getSort() { return 990; }

    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern($this->special_pattern, $mode, $this->pluginMode);
    }

    public function handle($match, $state, $pos, Doku_Handler $handler) {
        return array($state, $match);
    }

    public function render($format, Doku_Renderer $renderer, $data) {
        list($state, $match) = $data;
        $content = trim(substr($match, 4, -3));
        $class = 'plugin_textvar '.substr($content, 1, -1);
        $renderer->doc .= '<span class="'.$class.'">'.$content.'</span>';
        return true;
    }

}
