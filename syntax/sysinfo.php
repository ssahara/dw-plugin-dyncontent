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

class syntax_plugin_textvar_sysinfo extends DokuWiki_Syntax_Plugin
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
    protected $pattern = '%SYSINFO:\w+%'; // eg. %SYSINFO:OS%

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
        return 155;
    }

    /**
     * Handle the match
     */
    public function handle($match, $state, $pos, Doku_Handler $handler)
    {
        $match = substr($match,9,-1); //strip %SYSINFO: from start and % from end
        return $data = array(strtoupper($match));
    }

    /**
     * Create output
     */
    public function render($format, Doku_Renderer $renderer, $data)
    {
        if ($format == 'xhtml'){

            //handle various info stuff
            switch ($data[0]){
                case 'OS':
                    $out = php_uname('s').' '.php_uname('r');
                    break;
                case 'PHP_VERSION':
                    $out = phpversion();
                    break;
                case 'GD_VERSION':
                    if (extension_loaded('gd')) {
                        $gdinfo = gd_info();
                        $out = $gdinfo['GD Version'];
                    } else {
                        $out = 'not supported';
                    }
                    break;
                case 'MB_INTERNAL_ENCODING':
                    if (extension_loaded('mbstring')) {
                        $out = mb_get_info('internal_encoding');
                    } else {
                        $out = '⯑no mbstring';
                    }
                    break;
                case 'INTL':
                    if (extension_loaded('intl')) {
                        $out = 'enabled';
                    } else {
                        $out = '⯑no ICU INTL extension';
                    }
                    break;
                case 'OPENSSL':
                    if (extension_loaded('openssl')) {
                        $out = OPENSSL_VERSION_TEXT;
                    } else {
                        $out = '⯑no openssl extension';
                    }
                    break;
                case 'OPCACHE':
                    if (extension_loaded('Zend OPcache')) {
                        $out = (empty(ini_get('opcache.enable'))) ? 'disabled' : 'effective';
                    } else {
                        $out = 'not available';
                    }
                    break;
                default:
                    $out = '<code style="color:darkred;">⯑%SYSINFO:';
                    $out.= htmlspecialchars($data[0]);
                    $out.= '%</code>';
            }
            $renderer->doc .= $out;
            return true;
        }
        return false;
    }

}
