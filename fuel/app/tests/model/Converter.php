<?php

//namespace Fuel\App;

/**
 * Main controller tests
 *
 * @group Core
 * @group Arr
 */
class Tests_Converter extends Fuel\Core\TestCase {

    /**
     * Tests Test_Converter::testParseXml()
     *
     * @test
     */
    public function testParseXml()
    {
    	$ds = DIRECTORY_SEPARATOR;
        $converter = new Model_Converter();
        $converter->inputExt = 'xml';
        $converter->outputExt = 'json';
        $converter->tempName = DOCROOT.'public'.$ds.'test_files'.$ds.'example.'.$converter->inputExt;

        $expected =  
        [
	    	'product' =>
	      	[
	            [
                    'title' => 'Soflyy T-Shirt',
                    'sku' => '999-X',
                    'parent_sku' => [],
                    'price' => [],
                    'color' => [],
                    'description' => 'This shirt is awesome.'
                ],
            	[
                    'title' => 'Soflyy T-Shirt (blue)',
                    'sku' => '999-B',
                    'parent_sku' => '999-X',
                    'price' => '15',
                    'color' => 'blue',
                    'description' => []
                ]
	        ]
		];


        $output = $converter->parseData();

        $this->assertEquals($expected, $output);
    }

    /**
     * Tests Test_Converter::testParseCsv()
     *
     * @test
     */
    public function testParseCsv()
    {
    	$ds = DIRECTORY_SEPARATOR;
        $converter = new Model_Converter();
        $converter->inputExt = 'csv';
        $converter->outputExt = 'json';
        $converter->tempName = DOCROOT.'public'.$ds.'test_files'.$ds.'example.'.$converter->inputExt;

        $expected =  
      	[
            [
                'Product Title' => 'Soflyy T-Shirt',
                'SKU' => '999-X',
                'Parent SKU' => '',
                'Price' => '',
                'Color' => '',
                'Description' => 'This shirt is awesome.'
            ]
        ];


        $output = $converter->parseData();

        $this->assertEquals($expected, $output);
    }

    /**
     * Tests Test_Converter::testParseYml()
     *
     * @test
     */
    public function testParseYml()
    {
    	$ds = DIRECTORY_SEPARATOR;
        $converter = new Model_Converter();
        $converter->inputExt = 'yml';
        $converter->outputExt = 'json';
        $converter->tempName = DOCROOT.'public'.$ds.'test_files'.$ds.'example.'.$converter->inputExt;

        $expected =  
      	[
            'environment' => 'production',
            'classes' => [
            	'nfs::server' => [
            		'exports' => [
            			'/srv/share1',
            			'/srv/share3'
            		]
            	]
            ],
            'parameters' => null
        ];


        $output = $converter->parseData();

        $this->assertEquals($expected, $output);
    }

    /**
     * Tests Test_Converter::testParseYml()
     *
     * @test
     */
    public function testParseJson()
    {
    	$ds = DIRECTORY_SEPARATOR;
        $converter = new Model_Converter();
        $converter->inputExt = 'json';
        $converter->outputExt = 'csv';
        $converter->tempName = DOCROOT.'public'.$ds.'test_files'.$ds.'example.'.$converter->inputExt;

        $expected =  
      	[
            'type' => 'project',
            'keywords' => ['application', 'website'],
            'require' => [
            	'php' => '>=5.3.3',
            	'composer/installers' => '~1.0'
            ],
            'extra' => [
            	'installer-paths' => [
            		'fuel/{$name}' => ['fuel/core']
            	]
            ]
        ];


        $output = $converter->parseData();

        $this->assertEquals($expected, $output);
    }
}