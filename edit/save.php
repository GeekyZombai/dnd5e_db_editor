<?php

require '../server/db.php';
require '../server/global.php';

session_start();

$db = new DBHandler();

/************************************************************************/

function redirect()
{
	echo("<br />Redirecting you in 3 seconds...");
	header('refresh:3;url=../level.php');
}

/************************************************************************/

function redirect_to($url)
{
		echo("<br />Redirecting you in 3 seconds...");
	header('refresh:3;url=../' . $url);
}

/************************************************************************/

function edit_level()
{
	global $db;
	$max_level = $db->get_max_level();
	if ($_POST['Level'] <= $max_level)
	{
		if ($db->update_level($_POST['Level'], $_POST['RequiredXP'], $_POST['ProficiencyBonus'], $_POST['Tier'], $_POST['AbilityPoints']))
		{
			echo("Save Sucessful!");
			redirect_to("level.php");
		}//if
		else
		{	
			echo("Error: " . $db->get_error());
			redirect_to("level.php");
		}//else
	}//if
	else
	{
		if ($db->insert_level($_POST['Level'], $_POST['RequiredXP'], $_POST['ProficiencyBonus'], $_POST['Tier'], $_POST['AbilityPoints']))
		{
			echo("Save Sucessful!");
			redirect_to("level.php");
		}//if
		else
		{	
			echo("Error: " . $db->get_error());
			redirect_to("level.php");
		}//else
	}
}

/************************************************************************/

if (isset($_SESSION['editing']))
{
	switch($_SESSION['editing'])
	{
		case 'Level':
			edit_level();
			break;
		default:
			echo("Error: Edit Table Not Found");
			redirect();
		break;
	}
}
else
{
	echo("Error:  Session Variable Not Set");
	redirect();
}


?>