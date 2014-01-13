<?php

class InvoiceService {
	
	/**
	 * Nazwa użytkownika serwisu
	 * @var string
	 */
	var $user;

	/**
	 * Klucz api uzytkownika
	 * @var string
	 */
	var $apiKey;

	/**
	 * Konstruktor InvoiceService
	 * @param string $user   Nazwa użytkownika serwisu
	 * @param string $apiKey Klucz api uzytkownika
	 */
	function __construct($user, $apiKey) {
		$this->user = $user;
		$this->apiKey = $apiKey;
	}



	/**
	 * Tworzy połączenie z API i zwraca wynik zapytania
	 * @param  string  $url        poszczególne składowe adresu wykonującego zapytanie
	 * @param  string  $parameters parametry zapytania w formacje json (np. dane do faktury, maila)
	 * @param  boolean $isPost     czy żądanie ma być typu POST
	 * @return array               zwraca odpowiedź wygenerowaną przez API array(dane, kod http)
	 */
	private function createConnection($url, $parameters, $isPost) {
		$ch = curl_init(); 
		$output = null;

		$baseUrl = 'http://michal-faktury-api-dev/web/app_dev.php/api';

		foreach($url as $key=>$value) {
			$baseUrl .= '/'.$value;
		}

        curl_setopt($ch, CURLOPT_URL, $baseUrl); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_USERPWD, $this->user.':'.$this->apiKey);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY); 
		
		if($isPost) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('parameters'=>$parameters));
		}

		$output = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);	

		if($http_status==401) {
			return array('output'=>401, 'http_status'=>401); 
		} else {
			return array('output'=>$output, 'http_status'=>$http_status); 
		}
	}




	/**
	 * Wywołuje metodę api/get/_invoiceId_/json
	 * @param  string $invoiceId Identyfikator faktury
	 * @return array             Zwraca odpowiedź wygenerowaną przez API array(dane, kod http)
	 */
	public function getJson($invoiceId) {
        return $this->createConnection(array('get',$invoiceId,'json'),null,true);
	}

	/**
	 * Wywołuje metodę api/get/_invoiceId_/mail
	 * @param  string $invoiceId  Identyfikator faktury
	 * @param  string $parameters Parametry zapytania w formacie json - dane do wysłania e-mail  
	 * @return array              zwraca odpowiedź wygenerowaną przez API array(dane, kod http)
	 */
	public function getMail($invoiceId, $parameters) {
        return $this->createConnection(array('get',$invoiceId,'mail'),$parameters,true);
	}

	/**
	 * Wywołuje metodę api/get/_invoiceId_/pdfplain i zwraca wynik jako plik pdf
	 * @param  string $invoiceId Identyfikator faktury
	 * @return string            Odpowiedź API jako plik do pobrania
	 */
	public function getPdf($invoiceId) {
        $res = $this->createConnection(array('get',$invoiceId,'pdfplain'),null,true);


        if($res['http_status']==200) {
		//ob_start();
			header('Content-type: application/pdf');
			header('Content-Disposition: attachment; filename="downloaded.pdf"');
			echo $res['output'];
  		//$result = ob_get_contents();
  		//ob_end_clean();
  		//return $result;
  		} else {
  			return $res;
  		}
	}

	/**
	 * Wywołuje metodę api/get/_invoiceId_/pdfplain i zwraca wynik jako array
	 * @param  string $invoiceId Parametry zapytania w formacie json - dane do faktury  
	 * @return array             Odpowiedź array(dane,kod http) - dane to kod pliku pdf
	 */
	public function getPdfPlain($invoiceId) {
        return $this->createConnection(array('get',$invoiceId,'pdfplain'),null,true);
  			
	}


	/**
	 * Wywołuje metodę api/generate/json
	 * @param  string $parameters Parametry zapytania w formacie json - dane do faktury  
	 * @return array              Zwraca odpowiedź wygenerowaną przez API array(dane, kod http)
	 */
	public function generateJson($parameters) {
        return $this->createConnection(array('generate','json'),$parameters,true);
	}

	/**
	 * Wywołuje metodę api/generate/mail
	 * @param  string $parameters Parametry zapytania w formacie json - dane do faktury i wysłania e-mail
	 * @return array              Zwraca odpowiedź wygenerowaną przez API array(dane, kod http)
	 */
	public function generateMail($parameters) {
        return $this->createConnection(array('generate','mail'),$parameters,true);
	}

	/**
	 * Wywołuje metodę api/list
	 * @return array              Zwraca odpowiedź wygenerowaną przez API array(dane, kod http)
	 */
	public function listAll() {
        return $this->createConnection(array('list'),null,true);
	}

	/**
	 * Wywołuje metodę api/stats
	 * @return array              Zwraca odpowiedź wygenerowaną przez API array(dane, kod http)
	 */
	public function stats() {
        return $this->createConnection(array('stats'),null,true);
	}	

	/**
	 * Wywołuje metodę api/delete
	 * @param  string $invoiceId Identyfikator faktury
	 * @return array             Odpowiedź array(dane,kod http) - dane to kod pliku pdf
	 */
	public function delete($invoiceId) {
        return $this->createConnection(array('delete',$invoiceId),null,true);
  			
	}

	/**
	 * Wywołuje metodę api/test
	 * @return array             Odpowiedź array(dane,kod http) 
	 */
	public function test() {
        return $this->createConnection(null,null,true);
  			
	}

	
	
}

