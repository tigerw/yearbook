<?php
session_start();

set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']);

require_once 'Controllers/Task State.php';
require_once 'Models/Yearbook Entity Model.php';

if (!($INIParseResult = parse_ini_file('Configuration.ini')))
{
	http_response_code(500);
	die('No configuration file.');
	return;
}

define('DATABASE_HOST', $INIParseResult['DatabaseAddress']);
define('DATABASE_USER', $INIParseResult['DatabaseUsername']);
define('DATABASE_PASSWORD', $INIParseResult['DatabasePassword']);
define('DATABASE_NAME', $INIParseResult['DatabaseName']);
define('YEARBOOK_YEAR', 2017);

function Redirect($Address)
{
	header('Location: ' . $Address);
}

$GLOBALS['YearbookModel'] = new YearbookModel();