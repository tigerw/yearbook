<?php
require_once '../Composer/vendor/autoload.php';
require_once 'Configuration.php';
require_once 'Controllers/Authenticator.php';

if (!Authenticator::IsLoggedIn())
{
	Redirect('/login');
	return;
}

$AddSuccess = true;
if (isset($_POST['AuthorStudentId']))
{
	try
	{
		$GLOBALS['YearbookModel']->AddBiographyEntry($_POST['AuthorStudentId'], $_SESSION['StudentId']);
	}
	catch (MeekroDBException $DBException)
	{
        $AddSuccess = false;
	}
}

$Template = new Twig_Environment(new Twig_Loader_Filesystem(array('Templates', 'Templates/Modules')), array('cache' => '../Cache', 'auto_reload' => true));
$Template->display(
	'Choose.html',
	array(
		'Students' => $GLOBALS['YearbookModel']->FindStudents(),
        'BiographyEntries' => $GLOBALS['YearbookModel']->FindBiographiesByTargetStudentId($_SESSION['StudentId']),
        'OperationSuccessful' => $AddSuccess, 
		'TaskStates' => TaskState::GetTaskStates()
	)
);