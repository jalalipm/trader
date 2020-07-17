<?php

require_once 'Jibit.class.php';


if (empty($_GET['amount']) || empty($_GET['refnum']) || empty($_GET['state'])) {
    echo 'No data found.';
    return false;
}


//get data from query string
$amount = $_GET['amount'];
$refNum = $_GET['refnum'];
$state = $_GET['state'];

if ($state !== 'SUCCESSFUL') {
    echo 'Transaction failed error: ' . $state;
    return false;
}

// Your Api Key :
$apiKey = 'xxxxx';
// Your Api Secret :
$apiSecret = 'xx-xx';


/** @var Jibit $jibit */
$jibit = new Jibit($apiKey, $apiSecret);

// Making payment verify
$requestResult = $jibit->paymentVerify($refNum);

if (!empty($requestResult['status']) && $requestResult['status'] === 'Successful') {
    //successful result
    echo 'Successful! refNum:' . $refNum;
    return false;
}
//fail result and show the error
echo 'Payment fail.';



