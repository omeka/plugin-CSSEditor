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
        $config->set('Filter.ExtractStyleBlocks', TRUE);
        $config->set('CSS.AllowImportant', TRUE);
        $config->set('CSS.AllowTricky', TRUE);
        $config->set('CSS.Proprietary', TRUE);
        $config->set('CSS.Trusted', TRUE);

        $purifier = new HTMLPurifier($config);

        $purifier->purify('<style>' . $_POST['css'] . '</style>');

        $clean_css = $purifier->context->get('StyleBlocks');
        $clean_css = $clean_css[0];

        set_option('css_editor_css', $clean_css);
    }

    public function hookPublicHead($args) 
    {
        $css = get_option('css_editor_css');
        if ($css) {
            queue_css_string($css);
        }
    }
}
