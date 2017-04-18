<?php
use Symfony\Component\Yaml\Yaml;

class Helper_Parse
{
	/**
	 * Parse data from JSON file to PHP array
	 * 
	 * @param   String Path to JSON file
	 * @return  Array
	 */
	public static function parse_json($file)
	{
		return json_decode(file_get_contents($file), true);
	}

	/**
	 * Parse data from CSV file to PHP array
	 *
	 * @param   String Path to CSV file
	 * @param   String CSV file fields delimiter
	 * @return  Array
	 */
	public static function parse_csv($file, $delimiter = ',') 
	{ 
		$keys = [];
		$newArray = [];
		//Open file for reading
		if (($handle = fopen($file, 'r')) !== FALSE) { 
			$i = 0; 
			//Parse CSV file row by row, max row length 4000
			while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 
				for ($j = 0; $j < count($lineArray); $j++) { 
					$arr[$i][$j] = $lineArray[$j]; 
				} 
				$i++; 
			} 
			fclose($handle); 
		}  

		// Set number of elements (minus 1 because we shift off the first row)
		$count = count($arr) - 1;

		//Use first row for names  
		$labels = array_shift($arr);  
		foreach ($labels as $label) {
		  $keys[] = $label;
		}
		// Bring together labels and rows
		for ($j = 0; $j < $count; $j++) {
		  $d = array_combine($keys, $arr[$j]);
		  $newArray[$j] = $d;
		}
		return $newArray;
	}

	/**
	 * Parse data from XML file to PHP array
	 * 
	 * @param   String Path to XML file
	 * @return  Array
	 */
	public static function parse_xml($file)
	{
		//Using SimpleXML PHP extension for parsing XML data
		$data = simplexml_load_file($file);
		//Use json_decode/encode for converting PHP Objects to Arrays
		return json_decode(json_encode($data), true);
	}

	/**
	 * Parse data from YML file to PHP array
	 * 
	 * @param   String Path to YML file
	 * @return  Array
	 */
	public static function parse_yml($file)
	{
		//Using Symfony Component for parsing YML data
		return Yaml::parse(file_get_contents($file));
	}

}