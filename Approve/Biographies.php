<?php

require_once '../Configuration.php';
require_once '../../Composer/vendor/autoload.php';
require_once 'Controllers/Authenticator.php';

$Template = new Twig_Environment(new Twig_Loader_Filesystem(array('../Templates', '../Templates/Modules', '../Templates/Approve')), array('cache' => '../../Cache', 'auto_reload' => true));
$Template->addFilter(
	new Twig_Filter(
		'FirstNameBiographiesSort',
		function ($Biographies)
		{
    		if (!usort(
				$Biographies,
				function ($Lhs, $Rhs)
				{
					return strcmp($Lhs->Target->Forename, $Rhs->Target->Forename);
				}
			))
			{
				throw new Exception('usort: unexpected failure.');
			}
			
			return $Biographies;
		}
	)
);

$Template->display(
	'Biographies.html',
	array(
		'Biographies' => $GLOBALS['YearbookModel']->FindBiographies()
	)
);
?>