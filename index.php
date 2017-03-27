<?php

require_once '../Composer/vendor/autoload.php';
require_once 'Configuration.php';
require_once 'Controllers/Authenticator.php';

if (!Authenticator::IsLoggedIn())
{
	Redirect('/login');
	return;
}

$Template = new Twig_Environment(new Twig_Loader_Filesystem(array('Templates', 'Templates/Modules')), array('cache' => '../Cache', 'auto_reload' => true));
$Template->display(
	'Home.html',
	array(
		'BiographyAuthorRequests' => $GLOBALS['YearbookModel']->FindBiographiesByAuthorStudentId($_SESSION['StudentId']),
		'BiographyTargetRequests' => $GLOBALS['YearbookModel']->FindBiographiesByTargetStudentId($_SESSION['StudentId']),
		'TaskStates' => TaskState::GetTaskStates()
	)
);
// e^3y=x^2+y
?>