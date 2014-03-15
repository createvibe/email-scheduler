<?php

namespace EmailScheduler\Model;

class Schedule {
	
	/**
	 * The schedule id in the storage engine or other
	 *
	 * @type int|string
	 */
	public $id;
	
	/**
	 * The user-id sending the email (if any) from the storage engine or other
	 *
	 * @type int|string
	 */
	public $userId;
	
	/**
	 * The email address this message is being sent FROM
	 *
	 * @type string
	 */
	public $emailFrom;
	
	/**
	 * The name of the person sending this message
	 *
	 * @type string
	 */
	public $emailFromName;
	
	/**
	 * The email address this message is being sent TO
	 *
	 * @type string
	 */
	public $emailTo;
	
	/**
	 * The name of the person receiving this message
	 *
	 * @type string
	 */
	public $emailToName;
	
	/**
	 * The subjet of this message
	 *
	 * @type string
	 */
	public $emailSubject;
	
	/**
	 * The body (content) of this message
	 *
	 * @type string
	 */
	public $emailBody;
	
	/**
	 * The number of times this message has unsuccessfully attempted to send
	 *
	 * @type int
	 */
	public $attemptCount = 0;
	
	/**
	 * The datetime this message was delivered (sent)
	 *
	 * @type \DateTime
	 */
	public $deliveredAt;
	
	/**
	 * The datetime this message is expected to be sent at
	 *
	 * @type \DateTime
	 */
	public $sendAt;
	
	/**
	 * The datetime this message was created
	 *
	 * @type \DateTime
	 */
	public $createdAt;
	
	/**
	 * The datetime this message was last updated
	 *
	 * @type \DateTime
	 */
	public $updatedAt;
}