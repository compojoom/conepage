<?php
/**
 * @package    COnePage
 * @author     Yves Hoppe <yves@compojoom.com>
 * @date       13.06.14
 *
 * @copyright  Copyright (C) 2008 - 2014 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */


defined('_JEXEC') or die;

class modCQuoteHelper
{
	/**
	 * Sends the requested data to contact-us@compojoom.com
	 *
	 * @return  string
	 */
	public static function getAjax()
	{
		$mainframe = JFactory::getApplication();

		$input = JFactory::getApplication()->input;

		$name = $input->getString('cname', '');
		$company = $input->getString('company', '');
		$mail = $input->getString('email', '');
		$phone = $input->getString('phone', '');
		$website = $input->getString('website', '');
		$budget = $input->getString('budget', '');
		$message = $input->getString('message', '');

		$body = "New Quote order on compojoom.com" . "\n\n";
		$body .= "Name: " . $name . "\n";
		$body .= "Company: " . $company . "\n";
		$body .= "E-Mail: " . $mail . "\n";
		$body .= "Budget: " . $budget . "\n";
		$body .= "Phone: " . $phone . "\n";
		$body .= "Website: " . $website . "\n";
		$body .= "IP: " .  $_SERVER["REMOTE_ADDR"] . "\n";
		$body .= "User Agent: " . $_SERVER["HTTP_USER_AGENT"] . "\n\n";
		$body .= "Message: \n " . $message . "\n";

		$subject = "Quote-Request [" . $name . "]";

		$mailer = JFactory::getMailer();

		$sender = $mainframe->getCfg('fromname');
		$from = $mainframe->getCfg('mailfrom');

		$success = $mailer->sendMail(
			$from, $sender, "contact-us@compojoom.com", $subject, $body, false,
			null, null, null, $mail, $name
		);

		return "Thank you for inquiry! We contact you as soon as possible!";
	}
}
