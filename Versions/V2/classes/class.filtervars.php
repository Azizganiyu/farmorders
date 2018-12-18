<?php
class FilterVars
{
	//function to filter string inputs
	public static function filterString($string)
	{
		htmlspecialchars($string);
		strip_tags($string);
		return $string;
	}

	//function to fiter and validate email
	public static function filterEmail($email)
	{
		htmlspecialchars($email);
		strip_tags($email);
		filter_var($email,FILTER_VALIDATE_EMAIL);
		return $email;
	}
}

?>