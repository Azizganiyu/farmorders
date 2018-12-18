<?php

//
class DB
{
	const user = 'root';
	const password = '';
	//const user = 'farmorde_Aziz';
	//const password = 'Aziz1996@farmorders';

	//PDO connection in a try and catch block
	public static function connect()
	{

		try
		{

			$conn = new PDO ('mysql:host=127.0.0.1; dbname=farmorders; charset=utf8', self::user, self::password);
			//$conn = new PDO ('mysql:host=127.0.0.1; dbname=farmorde_Farmorders; charset=utf8', self::user, self::password);
			//err mode attribute
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} 
		catch(PDOException $e)
		{
			echo "database connection failed:".$e->getMessage();
			exit();
		}
		return $conn;
	}

	//function to query database
	public static function query ($query, $params = array())
	{

		$statement = self::connect()->prepare($query);
		$statement->execute($params);
		
		if(explode(' ', $query)[0]=='SELECT')
		{
			$result = $statement->fetchAll();
			return $result;
		}
	}
}

?>