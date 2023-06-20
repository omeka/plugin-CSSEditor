<?php 
/**
* CSS Editor
* @copyright  Copyright 2014 Roy Rosenzweig Center for History and New Media
* @license    http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
*/

/**
 * The CSS Editor plugin
 *
 * @package  CSS Editor
 */

class CSSEditorPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_hooks = array (
        'public_head',
        'config_form',
        'config',
        );

    public function hookConfigForm()
    {
        include 'config_form.php';
    }

    public function hookConfig($args)
    {
        // Require the HTMLPurifier autoloader in case we haven't loaded it
        // elsewhere yet
        require_once 'htmlpurifier/HTMLPurifier.auto.php';

        require_once dirname(__FILE__) . '/libraries/CSSTidy/class.csstidy.php';

        $config = HTMLPurifier_Config::createDefault();
        $config->set('CSS.AllowImportant', TRUE);
        $config->set('CSS.AllowTricky', TRUE);
        $config->set('CSS.Proprietary', TRUE);
        $config->set('CSS.Trusted', TRUE);
        $config->set('Cache.DefinitionImpl', null);

        $filter = new CSSEditor_Filter_ExtractStyleBlocks;
        $context = new HTMLPurifier_Context; // unused but required by signature
        $clean_css = $filter->cleanCss($_POST['css'], $config, $context);

        set_option('css_editor_css', $clean_css);
    }

    public function hookPublicHead($args) 
    {
        $css = get_option('css_editor_css');
        if ($css) {
            // HTML Purifier's escaping code (minus the >).
            // Do it here to avoid round-trip issues with the form entry,
            // and omit > to allow child selector usage
            $css = str_replace(
                array('<', '&'),
                array('\3C ', '\26 '),
                $css
            );
            queue_css_string($css);
        }
    }
}
