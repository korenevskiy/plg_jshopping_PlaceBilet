<?php  defined('_JEXEC') or die; return; ?>
<title>Пушка!!!</title>
<h4>Пушка!!</h4>
<pre>event_id:						
1299361		Обзорная экскурсия «В гостях у мастера»				31янв2023
1243159		Экспозиция мастерской А. И. Курнакова				31дек2023
1241531		Экспозиция галереи А. И. Курнакова					31дек2023

1858741		Экспозиция Орловского музея изобразительных искусств 30дек 2022
</pre>
<?php

 /** ----------------------------------------------------------------------
 * mod_PlaceBilet - Module for plagin Joomshopping Component for CMS Joomla
 * Потом разархивирует архивы в новое место где располагается папка пакета
 * В результате в новой папке пакета находятся архивы и папки расширений
 * ------------------------------------------------------------------------
 * author    Sergei Borisovich Korenevskiy
 * @copyright (C) 2019 //explorer-office.ru. All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @package plg_PlaceBilet
 * Websites: //explorer-office.ru/download/joomla/category/view/1
 * Technical Support:  Forum - //fb.com/groups/multimodulefb.com/groups/placebilet/
 * Technical Support:  Forum - //vk.com/placebilet
 * -------------------------------------------------------------------------
 **/ 


use \API\Kultura\Pushka\Pushka;
use \API\Kultura\Pushka\PushkaData;
use \API\Kultura\Pushka\Ticket;
use \API\Kultura\Pushka\Bad;
use \API\Kultura\Pushka\Visit;
use \API\Kultura\Pushka\Event;
use \API\Kultura\Pushka\Refund;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1'); 
error_reporting(E_ALL);

define('_JEXEC', true);

function getNewId($file = ''){
	$file = __DIR__ . '/' . $file . '.txt'; 
	$Id = file_exists($file) ? file_get_contents($file) : 0;
	settype($Id, 'int'); 
	file_put_contents($file, ++$Id);
	return $Id;
}

//echo "<br> 111<br>";
if(! class_exists('\API\Kultura\Pushka\Pushka'))
require_once __DIR__ . '/pushka.php';
//$lib = ();
//echo $lib . '<br> ';
//try {
//
//
//	
//} catch (Exception $exc) {
//	echo $exc->getTraceAsString();
//	echo '<br>';
//	echo $exc->getMessage();
//}

//echo file_exists($lib) ? 'Yes' : 'Noe';
//echo "<br> 222";
//https://3dsec.sberbank.ru/payment/rest
//https://securepayments.sberbank.ru/payment/rest/

//return;

$write_file = false;

// Инициализация объекта API
$api_key = 'WssqLTOSDR9wf65RiIba';
$organization_id = 2557;

$pushka = Pushka::new($api_key, Pushka::URLTest, true);
PushkaData::$addInObjectDataString = true;

$data = Ticket::new();

// Публикация Билета
$data->buyer_mobile_phone		= '9004881200'; // *Мобильный телефон (10 цифр)

$data->payment_ticket_price		= '30';		// *Цена билета (номинал)
$data->payment_date				= time();//0;//time();		// *Дата/время совершения платежа (unix timestamp
$data->payment_amount			= 30; // *Сумма платежа по Пушкинской карте

$data->session_event_id			= 1299361; //*ID мероприятия в PRO.Культура   1299361	1243159		1241531
$data->session_organization_id	= $organization_id;//666666; //*ID организации в Про.Культура
$data->session_date				= mktime(10, 00, 00, 01, 31, 2023);	//*Дата/Время проведения сеанса (unix timestamp)
		 
$data->barcode					= '9004881200123';
$data->barcode_type				= '5'; //EAN-13 Штрихкод -3бит,  Code128 Штрихкод -2бит,  QRcode -1бит,(5- QR и EAN13; 1 - QR; 4 - EAN13, 3 -QRиCODE128, ) 
$data->visitor_full_name		= "Kornelius";// Серджио Великий

// Необязательные свойства
$data->comment			= "KogdaJe!";
$data->payment_id		= getNewId('payment_id');  // ID платежа у Билетного оператора
$data->payment_rrn		= getNewId('payment_rrn');	// RRN (Retrieval Reference Number) уникальный идентификатор транзакции
//$data->session_place	= "OMII IZO/ main hall"; // Адрес/описание места проведения мероприятия
//$data->params			= "1zal 2sector 1ryad 3mesto."; // Зал+Сектор+Ряд+Место
//$data->visitor_first_name = 'Sergio';
//$data->visitor_middle_name = 'Bors';
//$data->visitor_last_name = 'Ko';



echo "<br>Запрос данные:<pre>";
echo print_r(json_decode($data, JSON_PRETTY_PRINT),true);
echo "</pre><br>";
//  [session_date_string] => 2023-01-20 20:00:00
//  [payment_date_string] => 2023-01-20 17:22:55 
// Запрос API - Публикация Билета
//$response = $pushka->AddTicket($data);	$write_file = true;						//	OK
$response = $pushka->GetTicket('VM433211164298');	$write_file = false;			// ОК
//$response = $pushka->GetEvent('1243159','9004881200123');						//	OK

//$response = $pushka->VisitTicket('0000721b-9a39-45aa-9c58-01bea67d27b5');		//	OK		Гасить можно не более чем за 2 часа до события
//$response = $pushka->RefundTicket('0000721b-013d-4359-aff4-8933421d8818');	$write_file = false;//	OK
//$response = $pushka->VisitTicketByEvent('1241531', '9004881200xXx', mktime(18, 00, 00, 01, 20, 2023));// visit_date must be less than or equal to the current time + 1 hour

// <editor-fold defaultstate="collapsed" desc="Цветовой статус">
if (isset($response->status)) {
	$color = '';
	switch ($response->status) {
		case 'active':
			$color = '#030';
			break;
		case 'visited':
			$color = 'blue';
			break;
		case 'refunded':
			$color = 'brown';
			break;
		case 'canceled':
			$color = '#444';
			break;
	
	}//active, visited, refunded, canceled
	echo "<label style='background-color:$color; padding: 10px 40px; border-radius: 10px;display: inline-block; font-size: 24px;'>$response->status</label>";
	echo "</pre><br>";
}// </editor-fold>

echo "<br>Ответ:<pre>";//. get_class($response) . "\n";
//echo print_r(json_decode($response, JSON_PRETTY_PRINT),true);
echo print_r($response,true);
echo "</pre>";
		

// <editor-fold defaultstate="collapsed" desc="Сохранение и Вывод отчета ЛОГ">

$response_data = json_decode($response, FALSE); //Тут будет массив с ответом. В частности в $resp['id'] будет айди билета, присвоенный реестром

if(isset($response_data->session->date))
$dtTicket = date("Y-m-d H:i:s",  ($response_data->session->date));

if(isset($response_data->payment->date))
$dtTicket = date("Y-m-d H:i:s",  ($response_data->payment->date));

if(isset($response_data->session->date))
$dtSession = date("Y-m-d H:i:s",  ($response_data->session->date));

$dt = date("Y-m-d H:i:s"); //date( 'Y-mM-d H:i:s' );

if($write_file){
file_put_contents(__DIR__ . '/_Response.txt',
	"\n$dt		$dtTicket		$dtSession		$response_data->status		{$response_data->session->event_id}		$response_data->barcode			$response_data->id", FILE_APPEND);
}
		
if(file_exists(__DIR__.'/_Response.txt')){
	echo "<pre>Лог:\n";
	echo file_get_contents(__DIR__.'/_Response.txt');
	echo "</pre>";
}
// </editor-fold>


//echo "<br> 333";
//echo $pushka->test();
//echo "<br> 444";



?>
<style>html{color: white;background-color: black;text-shadow: 0 0 none;}</style> 

 
<?php 


echo "<br>Хеши :<pre>";
echo print_r(hash_algos(),true);
echo "</pre>";

