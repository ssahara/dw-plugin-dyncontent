<?php
/**
 * Text Variable plugin for DokuWiki; Syntax component
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Satoshi Sahara <sahara.satoshi@gmail.com>
 */
// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class syntax_plugin_textvar_deferred extends DokuWiki_Syntax_Plugin {

    protected $mode;
    protected $pattern = '<!-- ?%[A-Z][A-Z_-]*?% ?-->';  // eg. <!--%REMOTE_ADDR%-->

    function __construct() {
        $this->mode = substr(get_class($this), 7); // drop 'syntax_' from class name
    }

    public function getType() { return 'substition'; }
    public function getPType(){ return 'normal'; }
    public function getSort() { return 990; }

    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern($this->pattern, $mode, $this->mode);
    }

    public function handle($match, $state, $pos, Doku_Handler $handler) {
        return array($state, $match);
    }

    public function render($format, Doku_Renderer $renderer, $data) {
        if ($format == 'xhtml') {
            list($state, $match) = $data;
            $renderer->doc .= '<var class="plugin_textvar" title="textVariable">';
            $renderer->doc .= trim(substr($match, 4, -3));
            $renderer->doc .= '</var>';
            return true;
        }
        return false;
    }

}
