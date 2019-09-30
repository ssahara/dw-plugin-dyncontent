<?php
/**
 * Text Variable plugin for DokuWiki; Syntax component
 * provides System information about host server
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Satoshi Sahara <sahara.satoshi@gmail.com>
 */
// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class syntax_plugin_textvar_postprocess extends DokuWiki_Syntax_Plugin
{
    public function getType()
    {   // Syntax Type
        return 'substition';
    }

    public function getPType()
    {   // Paragraph Type
        return 'normal';
    }

    /**
     * Connect pattern to lexer
     */
    protected $mode;
    protected $pattern = '%[A-Z][A-Z_0-9]*%';

    public function preConnect()
    {
        // drop 'syntax_' from class name
        $this->mode = substr(get_class($this), 7);
    }

    public function connectTo($mode)
    {
        $this->Lexer->addSpecialPattern($this->pattern, $mode, $this->mode);
    }

    public function getSort()
    {   // sort number used to determine priority of this mode
        return 156;
    }

    /**
     * Handle the match
     */
    public function handle($match, $state, $pos, Doku_Handler $handler)
    {
        $variable = $match;
        return $data = array($state, $variable);
    }

    /**
     * Create output
     */
    public function render($format, Doku_Renderer $renderer, $data)
    {
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
