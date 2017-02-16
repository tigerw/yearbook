<?php
require_once '../Composer/vendor/autoload.php';
require_once 'Configuration.php';
require_once 'Controllers/Authenticator.php';

if (Authenticator::IsLoggedIn())
{
	Redirect('/');
	return;
}

$Template = new Twig_Environment(new Twig_Loader_Filesystem(array('Templates', 'Templates/Modules')), array('cache' => '../Cache', 'auto_reload' => true));

if (isset($_POST['StudentId']) && isset($_POST['Surname']))
{
	if (!Authenticator::PerformLogin($_POST['StudentId'], $_POST['Surname']))
	{
		$Template->display('Login.html', array('AttemptedAndUnsuccessful' => true));
		return;
	}
	
	Redirect('/');
	return;
}

$Template->display('Login.html', array('AttemptedAndUnsuccessful' => false));