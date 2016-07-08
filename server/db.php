<?php

class DBHandler {

/************************************************************************/

const HOST_NAME  = 'localhost';
const USER_NAME  = 'webapp';
const USER_PASS  = 'dragons';      
const DB_NAME    = 'dnd5e';

/************************************************************************/

const SELECT_ALL  = 'SELECT * FROM ';
const SELECT_LEVEL = 'SELECT * FROM Level WHERE level = ';
const SELECT_MAX_LEVEL = 'SELECT MAX(Level) FROM Level';
const UPDATE_LEVEL = 'UPDATE LEVEL SET Level = ?,  RequiredXP = ?, ProficiencyBonus = ?, Tier = ?, AbilityPoints = ? WHERE Level = ?';
const INSERT_LEVEL = 'INSERT INTO Level (Level, RequiredXP, ProficiencyBonus, Tier, AbilityPoints) VALUES (?,?,?,?,?)';

/************************************************************************/

private $adapter;

/************************************************************************/

private function is_db_ok()
{
	if (is_null($this->adapter) || $this->adapter->connect_error == TRUE || $this->adapter->error == TRUE)
	{
		return false;
	}
	return true;
}//func

public function get_error()
{
	return $this->adapter->error;
}

/************************************************************************/

public function __construct()
{
	$this->adapter = new mysqli(self::HOST_NAME, self::USER_NAME, self::USER_PASS, self::DB_NAME);
}

/************************************************************************/

public function __destruct()
{

	if ($this->is_db_ok())
	{
		$this->adapter->close();
		$this->adapter = NULL;
	}

}

/************************************************************************/

public function get_all_levels()
{
	$rows = array();
	$result = $this->adapter->query(self::SELECT_ALL . "Level");

	if ($this->is_db_ok())
	{
		while ($row = $result->fetch_assoc())
		{
			$rows[] = $row;
		}//while	
		return $rows;
	}
	return null;
}

public function get_level($level)
{
	$rows = array();
	$result = $this->adapter->query(self::SELECT_LEVEL . $level);

	if ($this->is_db_ok())
	{
		while ($row = $result->fetch_assoc())
		{
			$rows[] = $row;
		}//while	
		return $rows;
	}
	return null;
}

/************************************************************************/

public function get_max_level()
{
	$result = $this->adapter->query(self::SELECT_MAX_LEVEL);

	if ($this->is_db_ok())
	{
		return $result->fetch_assoc()['MAX(Level)'];
	}
}

/************************************************************************/

public function update_level($level, $reqXP, $prof, $tier, $ap)
{
	if ($stmt = $this->adapter->prepare(self::UPDATE_LEVEL))
	{
		$stmt->bind_param('iiiiii', $level, $reqXP, $prof, $tier, $ap, $level);
		$stmt->execute();
		$stmt->close();	
		return true;
	}
	return false;
}

/************************************************************************/

public function insert_level($level, $reqXP, $prof, $tier, $ap)
{
	if ($stmt = $this->adapter->prepare(self::INSERT_LEVEL))
	{
		$stmt->bind_param('iiiii', $level, $reqXP, $prof, $tier, $ap);
		$stmt->execute();
		$stmt->close();	
		return true;
	}
	return false;
}

}//class

?>
