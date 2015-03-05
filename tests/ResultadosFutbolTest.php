<?php 

require_once __DIR__ . '/../vendor/autoload.php';

use ResultadosFutbol\ResultadosFutbolClient;

class ResultadosFutbolTest extends \PHPUnit_Framework_TestCase
{

	public function setUp(){
		
	}

	public function tearDown(){}

	public function testRetrieveTeams(){
		$rfutbol = new ResultadosFutbolClient('9d015e91dd9465caf217987d3b673ac1','json');
		$result = json_decode($rfutbol->getTeams());
	//	print_r($result);
		$this->assertTrue(!isset($result->errors));
	}

	public function testRetrieveMatchs(){
		$rfutbol = new ResultadosFutbolClient('9d015e91dd9465caf217987d3b673ac1','json');
		$result = json_decode($rfutbol->getMatchs());
	//	print_r($result);
		$this->assertTrue(!isset($result->errors));
	}

}
	
