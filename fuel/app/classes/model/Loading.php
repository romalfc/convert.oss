<?php

class Model_Loading
{
	public $fileName;
	public $fileExt;
	public $source;

	/**
	 * Creating new loading instance and getting parameters from GET request
	 */
	public function __construct()
	{
		$this->fileName = Input::get('fn');
		$this->fileExt = Input::get('ext');
	}

	/**
	 * File downloading if exist
	 */
	public function run()
	{
		$this->source = DOCROOT.'temp'.DIRECTORY_SEPARATOR.$this->fileName.'.'.$this->fileExt;
		$exists = File::exists($this->source);
		if($exists){
			return File::download($this->source, null, null, null, true);
		}
	}
}