<?php
namespace Craft;

class SpmFormModel extends BaseModel
{
	protected function defineAttributes()
	{
		return array(
			'fromName'   => array(AttributeType::String, 'required' => true, 'label' => 'Name'),
			'fromEmail'  => array(AttributeType::Email,  'required' => true, 'label' => 'Email from'),
			'message'    => array(AttributeType::String, 'required' => false, 'label' => 'Message'),
			'subject'    => array(AttributeType::String, 'required' => false, 'label' => 'Subject'),
			'attachment' => AttributeType::Mixed,

			// Additional Fields
			// -----------------------------------------------------------
			'company'   		=> array(AttributeType::String, 'required' => false, 'label' => 'Company Name'),
		);
	}
}
