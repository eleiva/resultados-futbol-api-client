<?
namespace ResultadosFutbol;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

class ResultadosFutbolClient {

	const API_ENDPOINT =  'http://www.resultados-futbol.com/scripts/api/api.php';
	private $_consumer_key = null;
	private $_response_type = null;
	private $_api_url = null;
	private $_time_zone = 'America/Argentina/Buenos_Aires';

	public function __construct( $consumer_key, $response_type = null, $time_zone = null){
		if (!empty( $consumer_key ) ) {
      $this->_api_url = self::API_ENDPOINT;
			$this->setConsumerKey( $consumer_key );

			if ((!is_null($response_type)) && (!empty($response_type))) {
				$this->setResponseType($response_type);
			}

			if ((!is_null($time_zone)) && (!empty($time_zone))) {
				$this->setTimeZone($time_zone);
			}
    } else {
      if (!isset( $consumer_key ) ) {
        throw new Exception( 'Error: __construct() - Consumer Key is missing.' );
      }
    }
	}

	public function setTimeZone( $time_zone ){
		$this->_time_zone = $time_zone;
	}

	public function setConsumerKey( $consumer_key )
  {
    $this->_consumer_key = $consumer_key;
  } 

	public function setResponseType( $response_type )
  {
    $this->_response_type = $response_type;
  } 

	public function getMatchs($round = 1, $order = 'twin', $twolegged = 1, $year = 2015, $league = 675)
  {
		$params = [];
		$params['round'] 			= $round;
		$params['order'] 			= $order;
		$params['twolegged'] 	= $twolegged;
		$params['year'] 			= $year;
		$params['league'] 		= $league;
		$params['req']				= 'matchs';

    return $this->_make_api_call( $params );
  }

	public function getTeams($filter = 'otros', $init = 0, $limit = 20){
		$params = [];
		$params['filter'] = $filter;
		$params['init'] 	= $init;
		$params['limit'] 	= $limit;
		$params['req'] 	= 'get_teams';

    return $this->_make_api_call( $params );
	}

	private function _make_api_call( $params = array() )
  {
    $ch = curl_init();
    $params['key']     = $this->_consumer_key;
		$params['tz']			 = $this->_time_zone;
		$params['format']	 = $this->_response_type;

    if (isset( $params ) && is_array( $params )) {
      $paramString = '?' . http_build_query( $params );
    } else {
      $paramString = null;
		}

		$client = new Client();
		$response = $client->get($this->_api_url . $paramString);
		if ( $response->getBody() == 'no-version' )
			throw new TransferException;

    return $response;
  }

}
