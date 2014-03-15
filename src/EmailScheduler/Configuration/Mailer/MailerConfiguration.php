<?php

namespace EmailScheduler\Configuration\Mailer;

use EmailScheduler\Configuration\Configuration;

abstract class MailerConfiguration extends Configuration {
	
	/**
	 * The content type the message should be sent as
	 *
	 * @type string
	 */
	protected $contentType = 'text/plain';
	
	/**
	 * Set the content type
	 * 
	 * @param string $contentType The content type
	 */
	public function setContentType($contentType) {
		$this->contentType = $contentType;
		return $this;
	}
	
	/**
	 * Get the content type
	 *
	 * @return string
	 */
	public function getContentType() {
		return $this->contentType;
	}
}