<?php
/**
 * @package    ExecSQL
 * @author     Yves Hoppe <yves@compojoom.com>
 * @date       28.11.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

// ACL Check
if (!JFactory::getUser()->authorise('core.manage', 'com_conepage'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

$input = JFactory::getApplication()->input;

JLoader::register('COnePageHelperSettings', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/settings.php');
JLoader::register('COnePageHelperBasic', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/basic.php');

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');

// Toolbar
require_once JPATH_COMPONENT_ADMINISTRATOR . "/toolbar.conepage.php";

$jlang = JFactory::getLanguage();
$jlang->load('com_conepage', JPATH_SITE, 'en-GB', true);
$jlang->load('com_conepage', JPATH_SITE, $jlang->getDefault(), true);
$jlang->load('com_conepage', JPATH_SITE, null, true);
$jlang->load('com_conepage', JPATH_ADMINISTRATOR, 'en-GB', true);
$jlang->load('com_conepage', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
$jlang->load('com_conepage', JPATH_ADMINISTRATOR, null, true);

if ($input->get('view', '') == 'liveupdate')
{
	require_once JPATH_COMPONENT_ADMINISTRATOR . '/liveupdate/liveupdate.php';
	JToolBarHelper::preferences('com_conepage');
	LiveUpdate::handleRequest();

	return;
}

if ($input->get('view', '') == 'controlcenter')
{
	require_once JPATH_COMPONENT_ADMINISTRATOR . '/controlcenter/controlcenter.php';
	JToolBarHelper::preferences('com_conepage');
	CompojoomControlCenter::handleRequest();

	return;
}

if ($input->get('view', '') == 'information')
{
	require_once JPATH_COMPONENT_ADMINISTRATOR . '/controlcenter/controlcenter.php';
	JToolBarHelper::preferences('com_conepage');
	CompojoomControlCenter::handleRequest('information');

	return;
}

$controller = JControllerLegacy::getInstance('conepage');
$controller->execute($input->get('task'));
$controller->redirect();
