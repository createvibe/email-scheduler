<?php

namespace EmailScheduler\Database\Repository;

use EmailScheduler\Model\Schedule,
	EmailScheduler\Hydrator\ModelHydrator;

/**
 * The Schedule Repository provides easy access to common email scheduling functionality
 */
class ScheduleRepository extends Repository {
	
	/**
	 * Insert a Schedule into the database
	 * 
	 * @param array<Schedule> $schedules Array of schedules to insert
	 * @return void
	 */
	public function insertSchedules(array $schedules) {

		// TODO : we need to fetch the next id in the sequence for oracle / pgsql
		$st = $this->pdo->prepare(
			'insert into email_schedule ' .
			'(user_id, email_from, email_from_name, email_to, email_to_name, email_subject, email_body, ' .
				'delivered_at, send_at, created_at, updated_at) ' .
			'values (:userId, :from, :fromName, :to, :toName, :subject, :body, :delivered, :send, :created, :updated)'
		);
		
		foreach ($schedules as $schedule) {
			
			if ($schedule instanceof Schedule) {
		
				// make sure we have a created-at
				if (!$schedule->createdAt) {
					$createdAt = date('Y-m-d H:i:s');
				} else {
					$createdAt = $schedule->createdAt->format('Y-m-d H:i:s');
				}
		
				$bool = $st->execute(array(
					'userId' => $schedule->userId ,
					'from' => $schedule->emailFrom ,
					'fromName' => $schedule->emailFromName ,
					'to' => $schedule->emailTo ,
					'toName' => $schedule->emailToName ,
					'subject' => $schedule->emailSubject ,
					'delivered' => $schedule->deliveredAt ? $schedule->deliveredAt->format('Y-m-d H:i:s') : null ,
					'send' => $schedule->sendAt ? $schedule->sendAt->format('Y-m-d H:i:s') : null ,
					'createdAt' => $createdAt ,
					'updatedAt' => $schedule->updatedAt ? $schedule->updatedAt->format('Y-m-d H:i:s') : null
				));
		
				$st->closeCursor();
		
				if ($bool) {
					$schedule->id = $this->pdo->lastInsertId();
					$schedule->createdAt = $createdAt;
				}
			}
		}
	}

	/**
	 * Get pending emails (emails that need to be sent)
	 *
	 * @param int $limit|null The number of schedules to limit the response to (use null or -1 for no limit)
	 * @param int $attemptCount|null The number of attempts a message is allowed to make before it gets skipped (if empty, only 1 attempt is made)
	 * @return array<Schedule>
	 */
	public function getNextSchedule($limit=null, $attemptCount=0) {

		$st = $this->pdo->prepare(
			'select id, user_id, email_from, email_from_name, email_to, email_to_name, email_subject, email_body, ' .
					'attempt_count, delivered_at, send_at, created_at, updated_at ' .
			'from email_schedule ' .
			'where send_at <= :now ' .
			'and delivered_at is null ' .
			'and attempt_count < :attemptCount ' . 
			'order by send_at asc' .
			($limit && $limit > 0 ? ' limit ' . ((int)$limit) : '')
		);

		$hydrator = new ModelHydrator;
		$schedules = array();
		
		$params = array(
			'now' => date('Y-m-d H:i:s') , 
			'attemptCount' => (int)$attemptCount ?: 1
		);
		
		if ($st->execute($params)) {

			while ($row = $st->fetch(\PDO::FETCH_ASSOC)) {

				$schedules[] = $hydrator->hydrate(new Schedule, $row);

			}
		}
		
		$st->closeCursor();
		
		return $schedules;
	}
	
	/**
	 * Update an array of schedules
	 *
	 * @param array<Schedule> $schedules
	 * @return void
	 * @throws \InvalidArgumentException
	 */
	public function updateSchedules(array $schedules) {
		
		if (count($schedules) === 0) {
			return;
		}
		
		$st = $this->pdo->prepare(
			'update email_schedule ' .
			'set delivered_at = :deliveredAt, attempt_count = :attemptCount, updated_at = :updatedAt ' .
			'where id = :id'
		);
		
		foreach ($schedules as $schedule) {
			
			if ($schedule instanceof Schedule) {

				$deliveredAt = $schedule->deliveredAt;
				if ($deliveredAt instanceof \DateTime) {
					$deliveredAt = $deliveredAt->format('Y-m-d H:i:s');
				}
			
				$updatedAt = new \DateTime;
				$updatedAt = $updatedAt->format('Y-m-d H:i:s');
		
				$st->execute(array(
					'id' => (int)$schedule->id ,
					'deliveredAt' => $deliveredAt ,
					'updatedAt' => $updatedAt ,
					'attemptCount' => (int)$schedule->attemptCount
				));
			}
		}
		
		$st->closeCursor();
	}
	
	/**
	 * Delete schedules that have been delivered on or before the specified time
	 *
	 * @param \DateTime $dateTime The datetime object specifying the delivered_at to start pruning from
	 * @return void
	 */
	public function pruneDeliveredSchedules(\DateTime $dateTime) {
		
		$st = $this->pdo->prepare('select id from email_schedule where delivered_at <= :pruneDate');	
		
		$params = array(
			'pruneDate' => $dateTime->format('Y-m-d H:i:s')
		);
		
		if ($st->execute($params)) {
			
			$this->deleteSchedules($st->fetchAll(\PDO::FETCH_COLUMN, 0));
		}
	}
	
	/**
	 * Delete Schedules from the database
	 *
	 * @param array<Schedule|int> $schedules
	 * @return void
	 */
	public function deleteSchedules(array $schedules) {
		
		$ids = array();
		
		foreach ($schedules as $schedule) {
			if ($schedule instanceof Schedule) {

				$ids[] = $schedule->id;

			} elseif (is_numeric($schedule)) {

				$ids[] = $schedule;
			}
		}
		
		$len = count($ids);
		if ($len > 0) {
			$st = $this->pdo->execute(
				'delete email_schedule ' .
				'from email_schedule ' .
				'where id in (' . trim(str_repeat('?,', $len), ',') . ')'
			);
			$st->execute($ids);
			$st->closeCursor();
		}
	}
	
}
