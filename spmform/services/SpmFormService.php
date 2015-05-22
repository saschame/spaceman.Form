<?php
namespace Craft;

/**
 * Contact Form service
 */
class SpmFormService extends BaseApplicationComponent
{
	/**
	 * Sends an email submitted through a contact form.
	 *
	 * @param SpmFormModel $message
	 * @throws Exception
	 * @return bool
	 */
	public function sendMessage(SpmFormModel $message)
	{
		$settings = craft()->plugins->getPlugin('spmform')->getSettings();

		if (!$settings->toEmail)
		{
			throw new Exception('The "To Email" address is not set on the plugin’s settings page.');
		}

		// Fire an 'onBeforeSend' event
		Craft::import('plugins.spmform.events.SpmFormEvent');
		$event = new SpmFormEvent($this, array('message' => $message));
		$this->onBeforeSend($event);

		if ($event->isValid)
		{
			if (!$event->fakeIt)
			{
				$toEmails = ArrayHelper::stringToArray($settings->toEmail);

				foreach ($toEmails as $toEmail)
				{
					$email = new EmailModel();
					$emailSettings = craft()->email->getSettings();

					$email->fromEmail = $emailSettings['emailAddress'];
					$email->replyTo   = $message->fromEmail;
					$email->sender    = $emailSettings['emailAddress'];
					$email->fromName  = $settings->prependSender . ($settings->prependSender && $message->fromName ? ' ' : '') . $message->fromName;
					$email->toEmail   = $toEmail;
					$email->subject   = $settings->prependSubject . ($settings->prependSubject && $message->subject ? ' - ' : '') . $message->subject;
					$email->body      = $message->message;

					if ($message->attachment)
					{
						$email->addAttachment($message->attachment->getTempName(), $message->attachment->getName(), 'base64', $message->attachment->getType());
					}

					craft()->email->sendEmail($email);
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * Fires an 'onBeforeSend' event.
	 *
	 * @param SpmFormEvent $event
	 */
	public function onBeforeSend(SpmFormEvent $event)
	{
		$this->raiseEvent('onBeforeSend', $event);
	}
}
