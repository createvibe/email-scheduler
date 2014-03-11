<?php

namespace EmailScheduler\Database\Repository;

use EmailSchedule\Model\Schedule,
	EmailScheduler\Hydrator\ModelHydrator;

class ScheduleRepository extends Repository {

	/**
	 * Get pending emails (emails that need to be sent)
	 *
	 * @return array<Schedule>
	 */
	public function getNextSchedule($limit=20, $attemptCount=5) {

		static $st = null;

		if (!$st) {
			$st = $this->pdo->prepare(
				'select * ' .
				'from email_schedule ' .
				'where send_at <= now() ' .
				'and delivered_at is null ' .
				'and attempt_count <= :attemptCount ' . 
				'order by send_at asc ' .
				'limit ' . ((int)$limit)
			);
		}
		
		$hydrator = new ModelHydrator;
		$schedules = array();
		
		if ($st->execute(array('attemptCount'=>(int)$attemptCount))) {

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
		
		static $st = null;
		
		if (count($schedules) === 0) {
			return;
		}
		
		if (!$st) {
			$this->pdo->prepare(
				'update email_schedule ' .
				'set delivered_at = :deliveredAt, attempt_count = :attemptCount, updated_at = :updatedAt ' .
				'where id = :id'
			);
		}
		
		$this->pdo->beginTransaction();
		
		foreach ($schedules as $schedule) {
			
			if (!($schedule instanceof Schedule)) {

				$this->pdo->rollBack();

				throw new \InvalidArgumentException('Each element in the $schedules array must be an instance of Schedule');
			}
			
			$deliveredAt = $schedule->deliveredAt;
			if ($deliveredAt instanceof \DateTime) {
				$deliveredAt = $deliveredAt->format('Y-m-d H:i:s');
			}
			
			$updatedAt = $schedule->updatedAt;
			if ($updatedAt instanceof \DateTime) {
				$updatedAt = $updatedAt->format('Y-m-d H:i:s');
			}
		
			$st->execute(array(
				'id' => (int)$schedule->id ,
				'deliveredAt' => $deliveredAt ,
				'updatedAt' => $updatedAt ,
				'attemptCount' => (int)$schedule->attemptCount
			));
		}
		
		$this->pdo->commit();
	}
}