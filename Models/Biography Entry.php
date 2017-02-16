<?php
class BiographyEntry
{
	public function __construct($Record)
	{
		$this->EntryId = $Record['EntryId'];
		$this->AuthorStudentId = $Record['AuthorStudentId'];
		$this->TargetStudentId = $Record['TargetStudentId'];
		$this->Content = $Record['Content'] ?? '';
		$this->Signature = $Record['Signature'] ?? '';
		$this->Status = $Record['Status'] ?? '';
		
		$this->Author = $GLOBALS['YearbookModel']->FindStudentById($this->AuthorStudentId);
		$this->Target = $GLOBALS['YearbookModel']->FindStudentById($this->TargetStudentId);
	}

	public $EntryId;
	public $AuthorStudentId;
	public $TargetStudentId;
	public $Content;
	public $Signature;
	public $Status;
	
	public $Target;
	public $Author;
}