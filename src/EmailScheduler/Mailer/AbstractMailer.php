<?php

namespace EmailScheduler\Mailer;

use EmailScheduler\Configuration\Configuration,
	EmailScheduler\Model\Schedule;

abstract class AbstractMailer {
	
	/**
	 * Transport configuration object
	 * 
	 * @type Configuration
	 */
	protected $config;

	/**
	 * Transport object
	 *
	 * @type \Swift_SmtpTransport|\Swift_SendmailTransport|\Swift_MailTransport|*
	 */
	protected $transport;
	
	/**
	 * Construct this class with a Configuration object
	 *
	 * @type Configuration $config
	 * @constructor
	 */
	public function __construct(Configuration $config) {
		$this->config = $config;
	}

	/**
	 * Create a transport object
	 * 
	 * @return \Swift_SmtpTransport|\Swift_SendmailTransport|\Swift_MailTransport|*
	 */
	abstract protected function createTransport();
	
	/**
	 * Get the transport object
	 * 
	 * @return \Swift_SmtpTransport|\Swift_SendmailTransport|\Swift_MailTransport|*
	 */
	public function getTransport() {
		// use cache when we can
		if ($this->transport) {
			return $this->transport;
		}
		
		// create a new transport object
		$this->transport = $this->createTransport();
		return $this->transport;
	}
	
	/**
	 * Send email to an array of Schedule entities
	 * Entities are updated with new dates and attemptCounts
	 * 
	 * @param array<Schedule> $schedules
	 * @return Mailer this object (fluent interface)
	 */
	public function send(array $schedules) {
		
		// get a swift-mailer instance using our transport
		$mailer = \Swift_Mailer::newInstance($this->getTransport());
		
		// iterate schedules and send them
		foreach ($schedules as $schedule) {

			if ($schedule instanceof Schedule) {
				
				$sent = $mailer->send(
					\Swift_Message::newInstance()
						->setSubject($schedule->subject)
						->setFrom(array($schedule->emailFromName => $schedule->emailFrom))
						->setTo(array($schedule->emailToName => $schedule->emailTo))
						->setBody($schedule->emailBody)
				);
			
				// update delivered-at if it was sent
				if ($sent) {
					$schedule->deliveredAt = new \DateTime('now');
				}
			
				// updated attemptCount and updatedAt
				$schedule->attemptCount = (int)$schedule->attemptCount + 1;
				$schedule->updatedAt = new \DateTime('now');
			}
		}
		
		return $this;
		
	}
}