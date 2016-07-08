<?php

	require '../server/db.php';
	require '../server/global.php';

	session_start();

	$level = 0;

	if (isset($_GET['id']))
	{
		$level = $_GET['id'];
		$db = new DBHandler();
		$rows = $db->get_level($level);
	}

	$_SESSION["editing"] = "Level";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Dnd5e Database Editor</title>
		<link rel="stylesheet" type="text/css" href="../styles/common.css">
	</head>
	<body>
		<?php require '../nav.php' ?>
		<form action="save.php" method="post">
			<ul>
				<li>
					<label for="Level">Level</label>
					<input id="Level" name="Level" type="number" value="<?= $_GET['id'] ?>"/>
				</li>
				<li>
					<label for="RequiredXP">Required XP</label>
					<input id="RequiredXP" name="RequiredXP" type="number" value="<?= $rows[0]['RequiredXP']?>"/>
				</li>
				<li>
					<label for="ProficiencyBonus">Proficiency Bonus</label>
					<input id="ProficiencyBonus" name="ProficiencyBonus" type="number" value="<?= $rows[0]['ProficiencyBonus']?>"/>
				</li>
				<li>
					<label for="Tier">Tier</label>
					<input id="Tier" name="Tier" type="number" value="<?= $rows[0]['Tier']?>"/>
				</li>
				<li>
					<label for="AbilityPoints">Ability Points</label>
					<input id="AbilityPoints" name="AbilityPoints" type="number" value="<?= $rows[0]['AbilityPoints']?>"/>
				</li>
				<li><input id="submit" type="submit" value="Save"/></li>
			</ul>
		</form>

	</body>
</html>