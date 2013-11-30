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
 * Script file of com_conepage component
 *
 * @since  1.0
 */
class Com_COnePageInstallerScript extends CompojoomInstaller
{
	public $release = '1.0';

	public $minimum_joomla_release = '2.5.10';

	public $extension = 'com_conepage';

	public $version = "0.9.0 Alpha";

	private $type = '';

	private $status;

	private $installationQueue = array(
		'modules' => array(
			'admin' => array(
			),
			'site' => array(
				'mod_conepage_navi' => array('left', 0),
			)
		),
		'plugins' => array(
		),
	);

	/**
	 * Method to uninstall the component
	 *
	 * @param   object  $parent  - the parent object
	 *
	 * @return void
	 */
	public function uninstall($parent)
	{
		$this->type = 'uninstall';
		$this->parent = $parent;

		$jlang = JFactory::getLanguage();
		$path = JPATH_ADMINISTRATOR;
		$jlang->load($this->extension, $path, 'en-GB', true);
		$jlang->load($this->extension, $path, $jlang->getDefault(), true);
		$jlang->load($this->extension, $path, null, true);
		$jlang->load($this->extension . '.sys', $path, 'en-GB', true);
		$jlang->load($this->extension . '.sys', $path, $jlang->getDefault(), true);
		$jlang->load($this->extension . '.sys', $path, null, true);

		$this->status->plugins = $this->uninstallPlugins($this->installationQueue['plugins']);
		$this->status->modules = $this->uninstallModules($this->installationQueue['modules']);

		echo $this->displayInfoUninstallation();
	}

	/**
	 * method to run after an install/update/discover method
	 *
	 * @param   string  $type    - the type
	 * @param   object  $parent  - the parent object
	 *
	 * @return void
	 */
	public function postflight($type, $parent)
	{
		$this->loadLanguage();
		$path = $parent->getParent()->getPath('source');
		$this->status = new stdClass;

		// Let us install the modules
		$this->status->plugins = $this->installPlugins($this->installationQueue['plugins']);
		$this->status->modules = $this->installModules($this->installationQueue['modules']);

		echo $this->displayInfoInstallation();
	}

	/**
	 * Display installation info
	 *
	 * @return string
	 */
	private function displayInfoInstallation()
	{
		$html[] = '<div class="alert alert-info">' . JText::_(strtoupper($this->extension) . '_INSTALLATION_SUCCESS') . '</div>';
		$html[] = "<table class=\"table\" border=\"0\" width=\"100%\"><tbody>";
		$html[] = "<tr><td width=\"18%\"><b>Extension:</b></td><td width=\"80%\">COnePage " . $this->version . "</td></tr>";
		$html[] = "<tr><td width=\"18%\"><b>Copyright:</b></td><td width=\"80%\">Compojoom.com - Yves Hoppe</td></tr>";
		$html[] = "<tr><td width=\"18%\"><b>Web:</b></td><td width=\"80%\"><a target=\"_blank\" href=\"http://compojoom.com\">http://compojoom.com</a></td></tr>";
		$html[] = "<tr><td width=\"18%\"><b>Version:</b></td><td width=\"80%\">" . $this->version . "</td></tr>";

		$html[] = "<tr><td colspan=\"2\">";
		$html[] = "<br /><strong>Thank you for installing COnePage!</strong><br /><br />";
		$html[] .= '<p>To get the latest news and promotions:<br />
							Like us on Facebook: <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Ffacebook.com%2Fcompojoom&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21&amp;appId=119257468194823"
							scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>
							<br />Follow us on Twitter: <a href="https://twitter.com/compojoom" class="twitter-follow-button" data-show-count="false">Follow @compojoom</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";
							fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script><br /><br />';
		$html[] = "<strong>Quick instructions:</strong><br /><br />
					Coming soon!</p>";
		$html[] = "</td>";
		$html[] = "</tr></tbody></table>";

		if ($this->status->plugins)
		{
			$html[] = $this->renderPluginInfoInstall($this->status->plugins);
		}

		if ($this->status->modules)
		{
			$html[] = $this->renderModuleInfoInstall($this->status->modules);
		}

		return implode('', $html);
	}

	/**
	 * Displays uninstall info
	 *
	 * @return string
	 */
	public function displayInfoUninstallation()
	{
		$html[] = $this->renderPluginInfoUninstall($this->status->plugins);
		$html[] = $this->renderModuleInfoUninstall($this->status->modules);

		return implode('', $html);
	}
}

/**
 * Class CompojoomInstaller
 *
 * @since  1.0
 */
class CompojoomInstaller
{
	/**
	 * Loads the language during installation
	 *
	 * @return void
	 */
	public function loadLanguage()
	{
		$extension = $this->extension;
		$jlang = JFactory::getLanguage();
		$path = $this->parent->getParent()->getPath('source') . '/administrator';
		$jlang->load($extension, $path, 'en-GB', true);
		$jlang->load($extension, $path, $jlang->getDefault(), true);
		$jlang->load($extension, $path, null, true);
		$jlang->load($extension . '.sys', $path, 'en-GB', true);
		$jlang->load($extension . '.sys', $path, $jlang->getDefault(), true);
		$jlang->load($extension . '.sys', $path, null, true);
	}

	/**
	 * Installs the modules
	 *
	 * @param   array  $modulesToInstall  - array with modules
	 *
	 * @return array
	 */
	public function installModules($modulesToInstall)
	{
		$src = $this->parent->getParent()->getPath('source');
		$status = array();

		// Modules installation
		if (count($modulesToInstall))
		{
			foreach ($modulesToInstall as $folder => $modules)
			{
				if (count($modules))
				{
					foreach ($modules as $module => $modulePreferences)
					{
						// Install the module
						if (empty($folder))
						{
							$folder = 'site';
						}

						$path = "$src/modules/$module";

						if ($folder == 'admin')
						{
							$path = "$src/administrator/modules/$module";
						}

						if (!is_dir($path))
						{
							continue;
						}

						$db = JFactory::getDbo();

						// Was the module alrady installed?
						$sql = 'SELECT COUNT(*) FROM #__modules WHERE `module`=' . $db->Quote($module);
						$db->setQuery($sql);
						$count = $db->loadResult();
						$installer = new JInstaller;
						$result = $installer->install($path);
						$status[] = array('name' => $module, 'client' => $folder, 'result' => $result);

						// Modify where it's published and its published state
						if (!$count)
						{
							list($modulePosition, $modulePublished) = $modulePreferences;
							$sql = "UPDATE #__modules SET position=" . $db->Quote($modulePosition);

							if ($modulePublished)
							{
								$sql .= ', published=1';
							}

							$sql .= ', params = ' . $db->quote($installer->getParams());
							$sql .= ' WHERE `module`=' . $db->Quote($module);
							$db->setQuery($sql);
							$db->query();

							// Get module id
							$db->setQuery('SELECT id FROM #__modules WHERE module = ' . $db->quote($module));
							$moduleId = $db->loadObject()->id;

							// Insert the module on all pages, otherwise we can't use it
							$query = 'INSERT INTO #__modules_menu(moduleid, menuid) VALUES (' . $db->quote($moduleId) . ' ,0 );';
							$db->setQuery($query);

							$db->query();
						}
					}
				}
			}
		}

		return $status;
	}

	/**
	 * Uninstall the modules
	 *
	 * @param   array  $modulesToUninstall  - modules to uninstall
	 *
	 * @return array
	 */
	public function uninstallModules($modulesToUninstall)
	{
		$status = array();

		if (count($modulesToUninstall))
		{
			$db = JFactory::getDbo();

			foreach ($modulesToUninstall as $folder => $modules)
			{
				if (count($modules))
				{
					foreach ($modules as $module => $modulePreferences)
					{
						// Find the module ID
						$db->setQuery(
							'SELECT `extension_id` FROM #__extensions WHERE `element` = '
							. $db->Quote($module) . ' AND `type` = "module"'
						);

						$id = $db->loadResult();

						// Uninstall the module
						$installer = new JInstaller;
						$result = $installer->uninstall('module', $id, 1);
						$status[] = array('name' => $module, 'client' => $folder, 'result' => $result);
					}
				}
			}
		}

		return $status;
	}

	/**
	 * Install the plugins
	 *
	 * @param   array  $plugins  - the plugins
	 *
	 * @return array
	 */
	public function installPlugins($plugins)
	{
		$src = $this->parent->getParent()->getPath('source');

		$db = JFactory::getDbo();
		$status = array();

		foreach ($plugins as $plugin => $published)
		{
			$parts = explode('_', $plugin);
			$pluginType = $parts[1];
			$pluginName = $parts[2];

			$path = $src . "/plugins/$pluginType/$pluginName";

			$query = "SELECT COUNT(*) FROM  #__extensions WHERE element=" . $db->Quote($pluginName) . " AND folder=" . $db->Quote($pluginType);

			$db->setQuery($query);
			$count = $db->loadResult();

			$installer = new JInstaller;
			$result = $installer->install($path);
			$status[] = array('name' => $plugin, 'group' => $pluginType, 'result' => $result);

			if ($published && !$count)
			{
				$query = "UPDATE #__extensions SET enabled=1 WHERE element=" . $db->Quote($pluginName) . " AND folder=" . $db->Quote($pluginType);
				$db->setQuery($query);
				$db->query();
			}
		}

		return $status;
	}

	/**
	 * Uninstall the plugins
	 *
	 * @param   array  $plugins  - the plugins to uninstall
	 *
	 * @return array
	 */
	public function uninstallPlugins($plugins)
	{
		$db = JFactory::getDbo();
		$status = array();

		foreach ($plugins as $plugin => $published)
		{
			$parts = explode('_', $plugin);
			$pluginType = $parts[1];
			$pluginName = $parts[2];
			$db->setQuery(
				'SELECT `extension_id` FROM #__extensions WHERE `type` = "plugin" AND `element` = ' . $db->Quote($pluginName)
				. ' AND `folder` = ' . $db->Quote($pluginType)
			);

			$id = $db->loadResult();

			if ($id)
			{
				$installer = new JInstaller;
				$result = $installer->uninstall('plugin', $id, 1);
				$status[] = array('name' => $plugin, 'group' => $pluginType, 'result' => $result);
			}
		}

		return $status;
	}

	/**
	 * get a variable from the manifest file (actually, from the manifest cache).
	 *
	 * @param   string  $name  - the param name
	 *
	 * @return mixed
	 */
	public function getParam($name)
	{
		$db = JFactory::getDbo();
		$db->setQuery('SELECT manifest_cache FROM #__extensions WHERE name = ' . $db->quote($name));
		$manifest = json_decode($db->loadResult(), true);

		return $manifest[$name];
	}

	/**
	 * Renders install info for the modules
	 *
	 * @param   array  $modules  - array with modules
	 *
	 * @return string
	 */
	public function renderModuleInfoInstall($modules)
	{
		$rows = 0;

		$html = array();

		if (count($modules))
		{
			$html[] = '<table class="table">';
			$html[] = '<tr>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_MODULE') . '</th>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_CLIENT') . '</th>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_STATUS') . '</th>';
			$html[] = '</tr>';

			foreach ($modules as $module)
			{
				$html[] = '<tr class="row' . (++$rows % 2) . '">';
				$html[] = '<td class="key">' . $module['name'] . '</td>';
				$html[] = '<td class="key">' . ucfirst($module['client']) . '</td>';
				$html[] = '<td>';
				$html[] = '<span style="color:' . (($module['result']) ? 'green' : 'red') . '; font-weight: bold;">';
				$html[] = ($module['result']) ? JText::_(strtoupper($this->extension) . '_MODULE_INSTALLED') : JText::_(strtoupper($this->extension) . '_MODULE_NOT_INSTALLED');
				$html[] = '</span>';
				$html[] = '</td>';
				$html[] = '</tr>';
			}

			$html[] = '</table>';
		}

		return implode('', $html);
	}

	/**
	 * Renders uninstall info about the modules
	 *
	 * @param   array  $modules  - the modules
	 *
	 * @return string
	 */
	public function renderModuleInfoUninstall($modules)
	{
		$rows = 0;
		$html = array();

		if (count($modules))
		{
			$html[] = '<table class="table">';
			$html[] = '<tr>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_MODULE') . '</th>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_CLIENT') . '</th>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_STATUS') . '</th>';
			$html[] = '</tr>';

			foreach ($modules as $module)
			{
				$html[] = '<tr class="row' . (++$rows % 2) . '">';
				$html[] = '<td class="key">' . $module['name'] . '</td>';
				$html[] = '<td class="key">' . ucfirst($module['client']) . '</td>';
				$html[] = '<td>';
				$html[] = '<span style="color:' . (($module['result']) ? 'green' : 'red') . '; font-weight: bold;">';
				$html[] = ($module['result']) ? JText::_(strtoupper($this->extension) . '_MODULE_UNINSTALLED') : JText::_(strtoupper($this->extension) . '_MODULE_COULD_NOT_UNINSTALL');
				$html[] = '</span>';
				$html[] = '</td>';
				$html[] = '</tr>';
			}

			$html[] = '</table>';
		}

		return implode('', $html);
	}

	/**
	 * Renders info about the plugins
	 *
	 * @param   array  $plugins  - the plugins
	 *
	 * @return string
	 */
	public function renderPluginInfoInstall($plugins)
	{
		$rows = 0;
		$html[] = '<table class="table">';

		if (count($plugins))
		{
			$html[] = '<tr>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_PLUGIN') . '</th>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_GROUP') . '</th>';
			$html[] = '<th>' . JText::_(strtoupper($this->extension) . '_STATUS') . '</th>';
			$html[] = '</tr>';

			foreach ($plugins as $plugin)
			{
				$html[] = '<tr class="row' . (++$rows % 2) . '">';
				$html[] = '<td class="key">' . $plugin['name'] . '</td>';
				$html[] = '<td class="key">' . ucfirst($plugin['group']) . '</td>';
				$html[] = '<td>';
				$html[] = '<span style="color: ' . (($plugin['result']) ? 'green' : 'red') . '; font-weight: bold;">';
				$html[] = ($plugin['result']) ? JText::_(strtoupper($this->extension) . '_PLUGIN_INSTALLED') : JText::_(strtoupper($this->extension) . 'PLUGIN_NOT_INSTALLED');
				$html[] = '</span>';
				$html[] = '</td>';
				$html[] = '</tr>';
			}
		}

		$html[] = '</table>';

		return implode('', $html);
	}

	/**
	 * Render plugin info about the uninstall
	 *
	 * @param   array  $plugins  - the plugins
	 *
	 * @return string
	 */
	public function renderPluginInfoUninstall($plugins)
	{
		$rows = 0;
		$html = array();

		if (count($plugins))
		{
			$html[] = '<table class="table">';
			$html[] = '<tbody>';
			$html[] = '<tr>';
			$html[] = '<th>Plugin</th>';
			$html[] = '<th>Group</th>';
			$html[] = '<th></th>';
			$html[] = '</tr>';

			foreach ($plugins as $plugin)
			{
				$html[] = '<tr class="row' . (++$rows % 2) . '">';
				$html[] = '<td class="key">' . $plugin['name'] . '</td>';
				$html[] = '<td class="key">' . ucfirst($plugin['group']) . '</td>';
				$html[] = '<td>';
				$html[] = '	<span style="color:' . (($plugin['result']) ? 'green' : 'red') . '; font-weight: bold;">';
				$html[] = ($plugin['result']) ? JText::_(strtoupper($this->extension) . '_PLUGIN_UNINSTALLED') : JText::_(strtoupper($this->extension) . '_PLUGIN_NOT_UNINSTALLED');
				$html[] = '</span>';
				$html[] = '</td>';
				$html[] = ' </tr> ';
			}

			$html[] = '</tbody > ';
			$html[] = '</table > ';
		}

		return implode('', $html);
	}

	/**
	 * method to run before an install/update/discover method
	 *
	 * @param   string  $type    - the installation type
	 * @param   object  $parent  - the parent object
	 *
	 * @return void
	 */
	public function preflight($type, $parent)
	{
		$jversion = new JVersion;

		// Extract the version number from the manifest file
		$this->release = $parent->get("manifest")->version;

		// Find mimimum required joomla version from the manifest file
		$this->minimum_joomla_release = $parent->get("manifest")->attributes()->version;

		if (version_compare($jversion->getShortVersion(), $this->minimum_joomla_release, 'lt'))
		{
			Jerror::raiseWarning(
				null, 'Cannot install ' . $this->extension . ' in a Joomla release prior to '
				. $this->minimum_joomla_release
			);

			return false;
		}

		// Abort if the component being installed is not newer than the currently installed version
		if ($type == 'update')
		{
			$oldRelease = $this->getParam('version');
			$rel = $oldRelease . ' to ' . $this->release;

			if (!strstr($this->release, 'git_'))
			{
				if (version_compare($this->release, $oldRelease, 'lt'))
				{
					Jerror::raiseWarning(null, 'Incorrect version sequence. Cannot upgrade ' . $rel);

					return false;
				}
			}
		}
	}

	/**
	 * method to update the component
	 *
	 * @param   object  $parent  - the parent object
	 *
	 * @return void
	 */
	public function update($parent)
	{
		$this->parent = $parent;
	}

	/**
	 * method to install the component
	 *
	 * @param   object  $parent  - the parent object
	 *
	 * @return void
	 */
	public function install($parent)
	{
		$this->parent = $parent;

	}
}