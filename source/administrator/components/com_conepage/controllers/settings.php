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

/**
 * Class COnePageControllersettings
 *
 * @since  1.0.0
 */
class COnePageControllersettings extends COnePageController
{
	/**
	 * Constructor adds Apply task
	 */
	public function __construct()
	{
		parent::__construct();
		$this->registerTask('apply', 'save');
	}

	/**
	 * Saves the Settings
	 *
	 * @return void
	 */
	public function save()
	{
		$post = JFactory::getApplication()->input->post;
		$reset = JFactory::getApplication()->input->get('conepage', array(0), 'post', 'array');

		require_once JPATH_COMPONENT . '/models/settings.php';
		$model = new COnePageModelSettings;

		switch (JFactory::getApplication()->input->get('task'))
		{
			case 'apply':

				if ($model->store($reset))
				{
					$msg = JText::_('COM_CONEPAGE_CHANGES_TO_TILES_SETTINGS_SAVED');
				}
				else
				{
					$msg = JText::_('COM_CONEPAGE_ERROR_SAVING_TILES_SETTINGS');
				}

				$this->setRedirect('index.php?option=com_conepage&view=settings', $msg);
				break;

			case 'save':
			default:
				if ($model->store($reset))
				{
					$msg = JText::_('COM_CONEPAGE_SETTINGS_SAVED');
				}
				else
				{
					$msg = JText::_('COM_CONEPAGE_ERROR_SAVING_TILES_SETTINGS');
				}

				$this->setRedirect('index.php?option=com_conepage', $msg);
				break;
		}

		$model->checkin();
	}

	/**
	 * Displays the settings form
	 *
	 * @param   bool  $cachable   - Is the view cachable
	 * @param   bool  $urlparams  - The url parameter
	 *
	 * @return  JControllerLegacy|void
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$document = JFactory::getDocument();
		$viewName = JFactory::getApplication()->input->get('view', 'settings');

		$viewType = $document->getType();
		$view = $this->getView($viewName, $viewType);

		require_once JPATH_COMPONENT . '/models/settings.php';

		$model = new COnePageModelSettings;

		$view->setModel($model, true);

		$view->setLayout('default');
		$view->display();
	}


	/**
	 * Redirects back to overview
	 *
	 * @return  void
	 */
	public function cancel()
	{
		$this->setRedirect('index.php?option=com_conepage');
	}
}
