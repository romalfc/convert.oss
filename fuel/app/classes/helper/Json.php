<?php

class Helper_Json
{
	public static function response($data)
	{
		print_r(json_encode($data));
	}
}