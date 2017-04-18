<?php

//namespace Fuel\App;

/**
 * Main controller tests
 *
 * @group Core
 * @group Arr
 */
class Tests_Main extends Fuel\Core\TestCase {

    /**
     * Tests Test_Main::testFalseExtension()
     *
     * @test
     */
    public function testFalseExtensions()
    {
        $converter = new Model_Converter();
        $converter->inputExt = 'avi';
        $converter->outputExt = 'mp4';
        $validation = $converter->validation();

        $expected = 
        [
            '0' => 'Wrong input file extension!',
            '1' => 'Wrong output file extension!'
        ];
        $output = $converter->validation();

        $this->assertEquals($expected, $output);
    }

    /**
     * Tests Test_Main::testSuccessExtensions()
     *
     * @test
     */
    public function testSuccessExtensions()
    {
        $converter = new Model_Converter();
        $converter->inputExt = 'csv';
        $converter->outputExt = 'xml';
        $validation = $converter->validation();

        $expected = [];
        $output = $converter->validation();

        $this->assertEquals($expected, $output);
    }
}