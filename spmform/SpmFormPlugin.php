<?php
namespace Craft;

class SpmFormPlugin extends BasePlugin
{
	function getName()
	{
		return Craft::t('spaceman.Form');
	}

	function getVersion()
	{
		return '1.0';
	}

	function getDeveloper()
	{
		return 'Sascha Merkofer, spaceman.agency';
	}

	function getDeveloperUrl()
	{
		return 'http://spaceman.agency';
	}

	protected function defineSettings()
	{
		return array(
			'toEmail'          => array(AttributeType::String, 'required' => true),
			'prependSender'    => AttributeType::String,
			'prependSubject'   => AttributeType::String,
			'allowAttachments' => AttributeType::Bool,
			'honeypotField'    => AttributeType::String,
		);
	}

	public function getSettingsHtml()
	{
		return craft()->templates->render('spmform/_settings', array(
			'settings' => $this->getSettings()
		));
	}
}
