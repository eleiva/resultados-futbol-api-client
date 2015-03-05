<?
namespace ResultadosFutbol;

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
    // Check if we must use Basic Auth or 1 legged oAuth, if SSL we use basic, if not we use OAuth 1.0a one-legged
    $params['key']     = $this->_consumer_key."dsad";
		$params['tz']			 = $this->_time_zone;
		$params['format']	 = $this->_response_type;

    if (isset( $params ) && is_array( $params )) {
      $paramString = '?' . http_build_query( $params );
    } else {
      $paramString = null;
		}

    curl_setopt( $ch, CURLOPT_URL, $this->_api_url . $paramString );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 30 );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

    $return = curl_exec( $ch );
		$code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );

    if (empty( $return ) || $return == 'no-version') {
			$return = '{"errors":[{"code":"' . $code . '","message":"cURL HTTP error ' . $code . '"}]}';
			if ( $this->_response_type != 'json' ){
				$return = json_decode( $return );
			}
    }

    return $return;
  }

}
