<?php
/**
 * Text Variable plugin for DokuWiki; Syntax component
 * provides System information about host server
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Satoshi Sahara <sahara.satoshi@gmail.com>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class syntax_plugin_textvar_postprocess extends DokuWiki_Syntax_Plugin {

    protected $mode;
    protected $pattern = '%[A-Z][A-Z_0-9]+%';

    function getType() { return 'substition'; }
    function getPType(){ return 'normal'; }
    function getSort() { return 156; }

    function __construct() {
        $this->mode = substr(get_class($this), 7); // drop 'syntax_' from class name
    }

    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern($this->pattern, $mode, $this->mode);
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler) {
        return array($match);
    }

    /**
     * Create output
     */
    function render($format, Doku_Renderer $renderer, $data) {
        if ($format == 'xhtml'){
            $renderer->doc .= '<var title="textVariable">'.$data[0].'</var>';
            return true;
        }
        return false;
    }

}
