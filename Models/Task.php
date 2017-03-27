<?php
class Task
{
	public function __construct($Link, $Title, $Status)
	{
		$this->Link = $Link;
		$this->Title = $Title;
		$this->Status = $Status;
	}
	
	const Queued = 0;
	const Available = 1;
	const Complete = 2;

	public $Link;
	public $Title;
	public $Status;
}