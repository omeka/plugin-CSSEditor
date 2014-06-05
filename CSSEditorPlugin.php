<?php 
/**
* CSS Editor
* @copyright  Copyright 2014 Roy Rosenzweig Center for History and New Media
* @license   [description]http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
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
		set_option('css_editor_css', $_POST['css']);
	}

	public function hookPublicHead($args) 
	{
		$css = get_option('css_editor_css');
		queue_css_string($css);
	}
}


 ?>