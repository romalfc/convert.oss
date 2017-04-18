<?php

class Helper_Save
{
	/**
	 * Write PHP array to JSON file
	 * 
	 * @param   Array  Data array
	 * @param   String Directory for savig new file
	 * @param   String Name for new file
	 * @return  null
	 */
	public static function to_json($array, $dir, $filename)
	{		
		//Decoding array to JSON with PHP flags before saving
		$output = json_encode($array, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		//Creating of file
		File::create(DOCROOT.DIRECTORY_SEPARATOR.$dir, $filename, $output);
		return;
	}

	/**
	 * Write PHP array to CSV file
	 * 
	 * @param   Array  Data array
	 * @param   String Directory for savig new file
	 * @param   String Name for new file
	 * @return  null
	 */
	public static function to_csv($array, $dir, $filename)
	{
		//Modifying associative array to plain
		$data = self::assoc_to_plain($array);
		//Opening new file for writing
		$fh = fopen($dir.$filename, "w");
		//Putting labels
        fputcsv($fh, array_keys($data));
        //Putting rows
        fputcsv($fh, array_values($data));
        //Rewind file pointer
        rewind($fh);
        //Closing file for writing
        fclose($fh);
        return;
	}

	/**
	 * Change associative array to plain
	 * 
	 * @param   Array  Data array
	 * @param   String String with previous keys queue
	 * @return  Array  Plain array
	 */
	public static function assoc_to_plain($array, $key_prev = null, $return_array = null)
	{
		foreach ($array as $key => $value) {
			$key = (is_null($key_prev))? $key: $key_prev.'->'.$key;
			if(is_array($value)){				
				$return_array = self::assoc_to_plain($value, $key, $return_array);
			} else {
				$return_array[$key] = $value;
			}
		}
		return $return_array;
	}

	/**
	 * Write PHP array to XML file
	 * 
	 * @param   Array  Data array
	 * @param   String Directory for saving new file
	 * @param   String Name for new file
	 * @return  null
	 */
	public static function to_xml($array, $dir, $filename)
	{		
		//Creating new XML instance
		$xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
		//Parsing PHP array to XML
		self::arr_to_xml($array, $xml_data);
		//Saving XML data to file
		$xml_data->saveXML($dir.$filename);	
		return;
	}
	
	/**
	 * Parse PHP array to XML data
	 * 
	 * @param   Array  Data array
	 * @param   Link   XML data
	 * @return  null
	 */
	public static function arr_to_xml( $data, &$xml_data ) 
	{
	    foreach( $data as $key => $value ) {
	        if( is_numeric($key) ){
	        	//if keys numeric add new item (0 => item0)
	            $key = 'item'.$key; 
	        }
	        if( is_array($value) ) {
	        	//if array add new node and calling method recursively for this array
	            $subnode = $xml_data->addChild($key);
	            self::arr_to_xml($value, $subnode);
	        } else {
	            $xml_data->addChild("$key", htmlspecialchars("$value"));
	        }
	     }
	}

	/**
	 * Parse PHP array to YML data
	 * 
	 * @param   Array  Data array
	 * @param   String Path to directory for file saving
	 * @param   String Name of new file
	 * @return  null
	 */
	public static function to_yml($array, $dir, $filename)
	{
		//Using default FuelPHP class for formatting data to YML
		$output = Format::forge($array)->to_yaml();
		//Creatng new YML file
		File::create(DOCROOT.DIRECTORY_SEPARATOR.$dir, $filename, $output);
		return;
	}
}