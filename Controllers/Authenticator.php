<?php
class Authenticator
{
	public static function PerformLogin($StudentId, $Surname)
	{
		$Student = $GLOBALS['YearbookModel']->FindStudentById($StudentId);
		
		if ($Student === null)
		{
			return false;
		}
		
		if (strcasecmp($Student->Surname, $Surname) === 0)
		{
			self::MakeLoginSession($Student);
			return true;
		}
		
		return false;
	}
	
	private static function MakeLoginSession($Student)
	{
		$_SESSION['StudentId'] = $Student->StudentId;
	}	
	
	public static function IsLoggedIn()
	{
		return isset($_SESSION['StudentId']);
	}
}