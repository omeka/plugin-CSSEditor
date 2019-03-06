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
        $config->set('HTML.DefinitionID', 'html5-definitions'); // unqiue id
        $config->set('HTML.DefinitionRev', 1);

        if ($def = $config->maybeGetRawHTMLDefinition())
        {
        $def->addElement('body', 'Block', 'Flow', 'Common');
        $def->addElement('section', 'Block', 'Flow', 'Common');
        $def->addElement('nav',     'Block', 'Flow', 'Common');
        $def->addElement('article', 'Block', 'Flow', 'Common');
        $def->addElement('aside',   'Block', 'Flow', 'Common');
        $def->addElement('header',  'Block', 'Flow', 'Common');
        $def->addElement('footer',  'Block', 'Flow', 'Common');
        $def->addElement('address', 'Block', 'Flow', 'Common');
        $def->addElement('hgroup', 'Block', 'Required: h1 | h2 | h3 | h4 | h5 | h6', 'Common');
        $def->addElement('figure', 'Block', 'Optional: (figcaption, Flow) | (Flow, figcaption) | Flow', 'Common');
        $def->addElement('figcaption', 'Inline', 'Flow', 'Common');
        $def->addElement('video', 'Block', 'Optional: (source, Flow) | (Flow, source) | Flow', 'Common');
        $def->addElement('source', 'Block', 'Flow', 'Common');
        $def->addElement('s',    'Inline', 'Inline', 'Common');
        $def->addElement('var',  'Inline', 'Inline', 'Common');
        $def->addElement('sub',  'Inline', 'Inline', 'Common');
        $def->addElement('sup',  'Inline', 'Inline', 'Common');
        $def->addElement('mark', 'Inline', 'Inline', 'Common');
        $def->addElement('wbr',  'Inline', 'Empty', 'Core');
        $def->addElement('ins', 'Block', 'Flow', 'Common');
        $def->addElement('del', 'Block', 'Flow', 'Common');
        }

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
