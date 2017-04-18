<?php

class Controller_Main extends Controller
{
	/**
	 * Index page
	 *
	 * @return  Response
	 */
	public function action_index()
	{
		return Response::forge(View::forge('main/index'));
	}

	/**
	 * Method that get post data from form and make convertation
	 *
	 * @return  String Returns link for file downloading or error message in JSON
	 */
	public function action_convert()
	{
		set_time_limit(200);

		$converter = new Model_Converter();
		//Making validation of input/output extensions
		$validation = $converter->validation();
		if(!empty($validation)){
			//Sending error if validation not succeed
			Helper_Json::response(['errors' => $validation]);
			exit;
		}		
		//Parsing data from file to PHP array
		$data = $converter->parseData();
		//Converting data to output format and saving file
		$converter->saveData($data);
		//Returning link to file downloading in JSON representation
		$converter->getLink();
	}

	public function action_download()
	{
		$loading = new Model_Loading();
		//Starting downloading 
		$loading->run();
	}
}
