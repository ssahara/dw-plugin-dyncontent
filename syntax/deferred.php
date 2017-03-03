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
    protected $pattern = '<!-- ?%[A-Z][A-Z_0-9-]*?% ?-->';  // eg. <!--%REMOTE_ADDR%-->

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

        // load replacement rules
        $map = $this->loadHelper($this->getPluginName());

        $variable = trim(substr($match, 4, -3));
        if ($map->TextVariables[$variable]) {
            return array($state, $variable);
        } else {
            return false;
        }
    }

    public function render($format, Doku_Renderer $renderer, $data) {
        if ($format == 'xhtml') {
            list($state, $variable) = $data;
            $renderer->doc .= '<var class="plugin_textvar" title="textVariable">';
            $renderer->doc .= $variable;
            $renderer->doc .= '</var>';
            return true;
        }
        return false;
    }

}
