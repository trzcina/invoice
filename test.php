<?php
error_reporting(E_ALL);
require_once 'InvoiceService.php';



//$invs = new InvoiceService("admin","ec676bc011b174119820533c4f757bb5"); // admin
$invs = new InvoiceService("guest", "2c8daaa3ea7726e73d01c849205bc0bo");  // guest


$mailParameters = array("from"=>'mchrzaszcz90@gmail.com',
						   "to"=>'mchrzaszcz90@gmail.com',
						   "subject"=>'tytul',
						   "body"=>'tresc'
						   );


$parameters = 
		array("invoice"=>array("number"=>'FV/2013/2000',
				  "type"=>'FV',
				  "seller"=>"Jan Kowalski
				  			 Ul. Słoneczna 5
				  			 55-312 Wrocław",
				  "buyer"=>"Aneta Środa
				  			 Ul. Wojska 9
				  			 55-392 Wrocław",
				  "city"=>"Wrocław",
				  "sellerBankAccount"=>"PL 289171987123987",
				  "paymentType"=>"gotówka",
				  "dateAdd"=>"2013-10-10",
				  "datePayment"=>"2013-10-20",
				  "dateSell"=>"2013-10-20",
				  "items"=> array(
				  	array("itemPaymentNetto"=>29,
				  		  "itemTitle"=>"Usługa",
				  		  "itemVatRate"=>23,
				  		  "itemCount"=>2,
				  		  "itemUnit"=>"szt"),
				  	array("itemPaymentNetto"=>100,
				  		  "itemTitle"=>"Usługa",
				  		  "itemVatRate"=>7,
				  		  "itemCount"=>1,
				  		  "itemUnit"=>"szt"),
				  	array("itemPaymentNetto"=>30,
				  		  "itemTitle"=>"Usługa",
				  		  "itemVatRate"=>7,
				  		  "itemCount"=>1,
				  		  "itemUnit"=>"szt"),
				  	array("itemPaymentNetto"=>12.50,
				  		  "itemTitle"=>"Usługa",
				  		  "itemVatRate"=>7,
				  		  "itemCount"=>1,
				  		  "itemUnit"=>"szt"),
				  	array("itemPaymentNetto"=>1259,
				  		  "itemTitle"=>"Usługa dwa",
				  		  "itemVatRate"=>23,
				  		  "itemCount"=>2,
				  		  "itemUnit"=>"szt"
				  		  ))
			  
			  ),
			"email"=>$mailParameters);



$params_json = json_encode($parameters);
$paramsEmail_json = json_encode($mailParameters);


echo json_encode($parameters);
echo '<br><br>'.json_encode($mailParameters);



/*
echo '<hr/>listAll<hr/>';
$result = $invs->listAll();
var_dump(json_decode($result['output']));


echo '<hr/>getMail<hr/>';
$result = $invs->getMail('0e93113f30e46df2b7302a556f9caf778d00cef6.pdf', $paramsEmail_json);
var_dump(json_decode($result['output']));

echo '<hr/>getPdf<hr/>';
$result = $invs->getPdf('79614108d2786433d6e29566d22883f228cbaae9.pdf');
var_dump(json_decode($result['output']));

echo '<hr/>getPdfPlain<hr/>';
$result = $invs->getPdfPlain('8c19e807c3dfcbdbde2e4475588695528202c13e.pdf');
var_dump($result['output']);

echo '<hr/>getJson<hr/>';
$result = $invs->getJson('8c19e807c3dfcbdbde2e4475588695528202c13e.pdf');
var_dump(json_decode($result['output']));

echo '<hr/>generateJson<hr/>';
$result = $invs->generateJson($params_json);
var_dump(json_decode($result['output']));
*/
echo '<hr/>generateMail<hr/>';
$result = $invs->generateMail($params_json);
var_dump(json_decode($result['output']));
/*
echo '<hr/>listAll<hr/>';
$result = $invs->listAll();
var_dump(json_decode($result['output']));

echo '<hr/>stats<hr/>';
$result = $invs->stats();
var_dump(json_decode($result['output']));

echo '<hr/>delete<hr/>';
$result = $invs->delete('8c19e807c3dfcbdbde2e4475588695528202c13e.pdf');
var_dump(json_decode($result['output']));

echo '<hr/>test<hr/>';
$result = $invs->stats();
var_dump(json_decode($result['output']));

*/

echo '<hr/>stats<hr/>';
$result = $invs->stats();
var_dump(json_decode($result['output']));