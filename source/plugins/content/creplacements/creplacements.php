<?php
/**
 * @package    COnePage
 * @author     Yves Hoppe <yves@compojoom.com>
 * @date       10.12.13
 *
 * @copyright  Copyright (C) 2008 - 2013 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

// import libaries
jimport('joomla.event.plugin');

if (!defined('CDEBUG'))
{
	define('CDEBUG', false);
}

/**
 * Class plgContentCAddScript
 *
 * @since  1.1.0
 */
class PlgContentCReplacements extends JPlugin
{
	/**
	 * @var   string  $tag  The replacement
	 */
	private $tag = "creplace";

	private $replaces = null;

	/**
	 * On Content prepare
	 *
	 * @param   string  $context   - The context
	 * @param   object  &$article  - The article
	 * @param   object  &$params   - The params
	 * @param   int     $page      - The page
	 *
	 * @return  void
	 */
	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{
		// Skip plug-in activation when the content is being indexed
		if ($context === 'com_finder.indexer')
		{
			return;
		}

		$this->parseContent($article);
	}

	/**
	 * Replaces the content
	 *
	 * @param   object  $article  - The article
	 *
	 * @return  bool
	 */
	public function parseContent($article)
	{
		if (strpos($article->text, '{' . $this->tag) === false)
		{
			if (CDEBUG)
			{
				echo 'Replacement plugin not active in this page';
			}

			return false;
		}

		$doc = JFactory::getDocument();

		// Find {creplace}...{/creplace} tags and emit code
		$tag = preg_quote($this->tag, '#');
		$pattern = '#\{' . $tag . '([^{}]*)(?<!/)\}(.+?)\{/' . $tag . '\}#msSu';

		$count = $this->replaceAllTags($article->text, $pattern);
	}

	/**
	 * Replaces all found tags
	 *
	 * @param   string  &$text    - The text
	 * @param   string  $pattern  - The pattern
	 *
	 * @return  int
	 */
	public function replaceAllTags(&$text, $pattern)
	{
		$count = 0;
		$offset = 0;

		while (preg_match($pattern, $text, $match, PREG_OFFSET_CAPTURE, $offset))
		{
			$count++;
			$start = $match[0][1];
			$end = $start + strlen($match[0][0]);

			try
			{
				$body = $this->replacReplacement(trim($match[2][0]), trim($match[1][0]));
				$text = substr($text, 0, $start) . $body . substr($text, $end);
				$offset = $start + strlen($body);
			}
			catch (Exception $e)
			{
				$app = JFactory::getApplication();
				$app->enqueueMessage($e->getMessage(), 'error');
				$offset = $end;
			}
		}

		return $count;
	}

	/**
	 * Gets the replacement
	 *
	 * @param   string  $source  The source
	 * @param   string  $params  The params
	 *
	 * @return  string
	 */
	public function replacReplacement($source, $params)
	{
		if (CDEBUG)
		{
			echo "source: " . $source . " params: " . $params;
		}

		if ($this->replaces == null)
		{
			$this->replaces = json_decode($this->params->get("replaces", ''), true);
		}

		foreach ($this->replaces as $k => $v)
		{
			if ($source == $k)
			{
				return $v;
			}
		}

		// We replace the script tags through nothing
		if (CDEBUG)
		{
			return "NOT FOUND";
		}
		else
		{
			return "";
		}
	}
}
