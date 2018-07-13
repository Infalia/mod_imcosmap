<?php

/**
 * @version     3.0.0
 * @package     com_imc
 * @subpackage  mod_imc
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE
 * @author      Ioannis Tsampoulatidis <tsampoulatidis@gmail.com> - https://github.com/itsam
 */
defined('_JEXEC') or die;

// Check for component
if (!JComponentHelper::getComponent('com_imc', true)->enabled)
{
	echo '<div class="alert alert-danger">Improve My City component is not enabled</div>';
	return;
}

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';
//JHtml::_('jquery.framework');
$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::base() . '/modules/mod_imcosmap/assets/css/style.css');
$doc->addStyleSheet(JURI::root(true).'/components/com_imc/assets/libs/leaflet/leaflet.css');

//get parameters
$com_imc_params = JComponentHelper::getParams('com_imc');	
$api_key 	= $com_imc_params->get('api_key');
$lat        = $com_imc_params->get('latitude');
$lng        = $com_imc_params->get('longitude');
$zoom 	    = $com_imc_params->get('zoom');
$language   = $com_imc_params->get('maplanguage');
$boundaries = $com_imc_params->get('boundaries', null);
$clusterer 	= ($com_imc_params->get('clusterer') == 1 ? true : false);
$markerImg = JURI::base().'modules/mod_imcosmap/assets/images/marker.png';


$doc->addScript(JURI::root(true).'/components/com_imc/assets/libs/leaflet/leaflet.js');
?>


<?php
// Check if we allow to display the module on details (issue) page
$jinput = JFactory::getApplication()->input;
$option = $jinput->get('option', null);
$view = $jinput->get('view', null);

//Show module only on issues list view
if ($option == 'com_imc' && $view != 'issues') {
	
	$s = "
	    jQuery(document).ready(function() {
	 		//mod_imcosmap advanced settings
	 		".
	 		stripcslashes($params->get('execute_js'))
	 		."
	    });
	";
	JFactory::getDocument()->addScriptDeclaration($s);

	$module->showtitle = false;
	return;
}
?>




<?php
// //initialize and load map
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
require JModuleHelper::getLayoutPath('mod_imcosmap', $params->get('layout', 'default'));
