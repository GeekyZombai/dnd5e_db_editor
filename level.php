<?php

	require 'server/db.php';
	require 'server/global.php';

	$db = new DBHandler();
	$rows = $db->get_all_levels();
	$max_level = $db->get_max_level()
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Dnd5e Database Editor</title>
		<link rel="stylesheet" type="text/css" href="styles/common.css">
	</head>
	<body>
		<?php require 'nav.php' ?>
		<div id="main">
			<table>
				<tr>
					<th>Level</th>
					<th>RequiredXP</th>
					<th>ProficiencyBonus</th>
					<th>Tier</th>
					<th>AbilityPoints</th>
				</tr>
				<?php foreach($rows as $row): ?>
					<tr>
						<td><?= $row['Level'] ?></td>
						<td><?= $row['RequiredXP'] ?></td>
						<td><?= $row['ProficiencyBonus'] ?></td>
						<td><?= $row['Tier'] ?></td>
						<td><?= $row['AbilityPoints'] ?></td>
						<td><a href="edit/level.php?id=<?= $row['Level'] ?>">edit</a></td>
					</tr>
				<?php endforeach; ?>
			</table>
			<a href="edit/level.php?id=<?= $max_level + 1 ?>">New</a>
		</div>
	</body>
</html>