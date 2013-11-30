<?php
/**
 * Tiles
 * @package Joomla!
 * @Copyright (C) 2012 - Yves Hoppe - compojoom.com
 * @All rights reserved
 * @Joomla! is Free Software
 * @Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
 * @version $Revision: 0.9.0 beta $
 **/

defined('_JEXEC') or die();

jimport('joomla.application.component.view');
jimport('joomla.application.module.helper');

class ControlCenterView extends JViewLegacy
{
	public function display($tpl = null)
	{
        $config = ControlCenterConfig::getInstance();

        JToolBarHelper::title(JText::_($config->_extensionTitle) .' &ndash; '.JText::_('COMPOJOOM_CONTROLCENTER_TASK_OVERVIEW'),'controlcenter');
        JToolBarHelper::help('screen.' . $config->_extensionTitle);

        $this->assign('config', $config);

        switch(JFactory::getApplication()->input->get('task','overview'))
        {
            case 'information':
                $this->setLayout('information');
                break;

            case 'overview':
            default:
                $this->setLayout('overview');
                break;
        }

        parent::display($tpl);
    }

}