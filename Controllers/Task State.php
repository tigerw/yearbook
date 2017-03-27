<?php
require_once 'Models/Task.php';

class EnabledTaskState
{
	public function __construct($Task, $Completed)
	{
		$this->Task = $Task;
		$this->Completed = $Completed;
	}

	public $Task;
	public $Completed;
}

class DisabledTaskState
{
	public function __construct($Task)
	{
		$this->Task = $Task;
	}

	public $Task;
}

class TaskState
{
	public static function GetTaskStates()
	{
		$TaskStates = array();

		foreach (
			array(
				new Task('/think', 'Come up with awards', Task::Complete),
				new Task('/question', 'Come up with questions', Task::Complete),
				new Task('/choose', 'Choose people to author', Task::Complete),
				new Task('/write', 'Write your entries', Task::Available),
				new Task('/vote', 'Vote for awards', Task::Queued),
				new Task('/answer', 'Answer questions', Task::Queued),
				new Task('/photograph', 'Add your profile photos', Task::Queued)
			) as $Key => $Task
		)
		{
			if (!$Task->Status === Task::Available)
			{
				$TaskStates[] = new DisabledTaskState($Task);
				continue;
			}
			$TaskStates[] = new EnabledTaskState($Task, self::GetTaskState($Key));
		}

		return $TaskStates;
	}

	private static function GetTaskState($Key)
	{
		switch ($Key)
		{
			case 0: return !empty($GLOBALS['YearbookModel']->FindAwardsByStudentId($_SESSION['StudentId']));
			case 1: return !empty($GLOBALS['YearbookModel']->FindQuestionsByStudentId($_SESSION['StudentId']));
			case 2: return (count($GLOBALS['YearbookModel']->FindBiographiesByTargetStudentId($_SESSION['StudentId'])) === 5);
			case 4: return !empty($GLOBALS['YearbookModel']->FindAwardVotesByVotingStudentId($_SESSION['StudentId']));
			default: return false;
		}
	}
}