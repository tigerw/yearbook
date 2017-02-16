<?php
class Task
{
	public function __construct($Link, $Title, $Enabled)
	{
		$this->Link = $Link;
		$this->Title = $Title;
		$this->Enabled = $Enabled;
	}

	public $Link;
	public $Title;
	public $Enabled;
}