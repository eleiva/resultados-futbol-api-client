<?php 

require_once __DIR__ . '/../vendor/autoload.php';

use ResultadosFutbol\ResultadosFutbolClient;

class ResultadosFutbolTest extends \PHPUnit_Framework_TestCase
{

	private $key = '9d015e91dd9465caf217987d3b673ac1';

	public function setUp(){
		
	}

	public function tearDown(){}

	public function testRetrieveMatchs(){
		$client = new ResultadosFutbolClient($this->key,'json');
		try{
			$response = $client->getMatchs();
			$body = $response->getBody();
			$this->assertTrue($response->getStatusCode() == 200);
			echo $body;
		}catch ( Exception $e ){
			$this->fail('Invalid request');
		}
	
	}

}
	
