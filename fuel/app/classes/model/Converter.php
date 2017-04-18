<?php

class Model_Converter
{
	//Input file extension
	public $inputExt;
	//Output file extension
	public $outputExt;
	//Upload file temporary name
	public $tempName;
	//Directory for saving file after converting
	public $tempDir;
	//Random file name for saving after converting
	public $fileName;
	//Array with allow file extensions
    public $ext = ['csv', 'xml', 'yml', 'json'];

    /**
	 * Creating new converter instance and getting parameters from request(input)
	 */
	public function __construct()
	{
		//Getting extension of upload file
		$inputExt = explode('.', Input::file('input')['name']);
		$this->inputExt = $inputExt[count($inputExt)-1];

		$this->outputExt = Input::post('output');e extension from Form
		$this->tempName = Input::file('input')['tmp_name'];
		$this->tempDir = 'temp'.DIRECTORY_SEPARATOR;
		//Getting random string for filename
		$this->fileName = Str::random('sha1');
	}

	/**
	 * Making validation of input/output extensions
	 * 
	 * @param   Array  Data array
	 * @param   String Directory for savig new file
	 * @param   String Name for new file
	 * @return  Array Array with errors if validation not succeed
	 */
	public function validation($errors = [])
	{
		if(!in_array($this->inputExt, $this->ext)){
			$errors[] = 'Wrong input file extension!';
		}

		if(!in_array($this->outputExt, $this->ext)){
			$errors[] = 'Wrong output file extension!';
		}
		return $errors;
	}

	/**
	 * Parsing data from file to PHP array
	 * 
	 * @return  Array Array with errors if validation not succeed
	 */
	public function parseData()
	{
		return Helper_Parse::{'parse_'.$this->inputExt}($this->tempName);				
	}

	/**
	 * Saving PHP array to file
	 * 
	 * @param   Array  Data array
	 */
	public function saveData($data)
	{
		Helper_Save::{'to_'.$this->outputExt}($data, $this->tempDir, $this->fileName.'.'.$this->outputExt);
	}

	/**
	 * Echoing link for file downloading in JSON representation
	 * 
	 * @return  String JSON string
	 */
	public function getLink()
	{
		$data = ['success' => "/download?fn={$this->fileName}&ext={$this->outputExt}"];
		Helper_Json::response($data);
	}
}