<?php
include('vendor/autoload.php');
include('../GuruTechBulkSmS.php'); 

$dotenv = Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();

$sender_id = $_ENV['GURUTECH_SENDER_ID'];
$userid = $_ENV['GURUTECH_SENDER_USERID'];
$password = $_ENV['GURUTECH_PASSWORD'];
$apikey = $_ENV['GURUTECH_API_KEY'];

$contacts = ["254719462331", "254745383546", "254765462300"];
$message = "Testing bulk sms on 0722336262, 0719462331, and 0748794365";

$sms = new GuruTechBulkSmS($sender_id, $userid, $password, $apikey);
$createapikey = $sms->generate_apikey();
$readapikey = $sms->read_apikey();

// echo var_dump($apikey);
echo var_dump($readapikey['apikey']);

// foreach ($contacts as $key => $contact) {
//     $sms = new GuruTechBulkSmS($sender_id, $userid, $password);
//     $send_sms_response = $sms->send($message, [$contact]);

//     echo var_dump($send_sms_response);
// } 

$sms = new GuruTechBulkSmS($sender_id, $userid, $password, $readapikey['apikey']);
$send_sms_response = $sms->send($message, $contacts);

echo var_dump($send_sms_response);
