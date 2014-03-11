<?php

namespace EmailScheduler\Mailer;

class SmtpMailer extends Mailer {

	/**
	 * {@inheritdoc}
	 */
	public function createTransport() {
		return \Swift_SmtpTransport::newInstance(
				$this->config->getHost(), 
				$this->config->getPort(), 
				$this->config->isSsl() ? 'ssl' : null
			)
			->setUsername($this->config->getUsername())
			->setPassword($this->config->getPassword());
	}
}