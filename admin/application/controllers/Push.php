<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	exit(0);
}
class Push extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model('Api_Model', 'w_m');
		$this->load->library('form_validation');
	}

	// This is a sample snippet. Always store and fetch the private key from crypto vault

	// function createSignature() {
	// 	$payload =json_decode(file_get_contents('php://input'), true);	

	// $privateKey = "-----BEGIN RSA PRIVATE KEY-----
	// MIIEpQIBAAKCAQEA2R+5+b1HZSNNMotnr7Z/5By4NSTZW4dDMGDy2huOSLn1EF6v
	// 75sssdY5kRkFoihLIeNQA+yzsi0kzpz3rCCCmo1DJwgoqA48JVQwwBjZ9SHeC0nE
	// 66VODmMJJGNWe1quHWQb3otIzS+U+rtd1Alzo9up8u8e+FrecyjO6fBMZfd32iO7
	// qPtExtA1XDtKMqoRbHMiAz940xA5+BLmJC+gp1IYsVce2KA5BW1laPxbku42aQR7
	// eZipSa3BYRY8m964Aj6vLj4kTeTbrc4OH7yatRdWbVbrwVWpg936g8Q3Qf3jQY+H
	// Mu76l1WeXK4GkPkA+oJXY6ag1XhhqtOrLw3rJwIDAQABAoIBAQCjy2thG4lgouD5
	// 4HC3/dU9IO1WKhZPFht5w6lxIJiWBLL7RnMzLrzo69NBwr6dNgh36CPU0hw9rhC2
	// TXQKRfxA25BtQZpqLVLyVjDwuc6zPnljyqLjojDgaZXb/ZSgOihfw8XCfRDOubaJ
	// 8A84hmjWlEABJKMYeHSYK5Dsqnr37/Oj4OT2NWLaRx8Kk0HPuv/bxx3MHurIHRtG
	// 514UJZcOfN8Ti69/DoYbtb/Mpg/djXr5s47TafxPa8jyT2E8nWboPvYPDQcdu2CI
	// E0mbrj2C0Ak7g20ZYzm9HCbJHVG+2rPSjVgXKW2ZgXoZflte+G5vRfDrZH+TZuo+
	// ja0pVlIBAoGBAP4ZEtdpRJp5kvj7bUIkXd5E6lrxd2M0VprfMhHk0i+Z1p1nF8St
	// F6p9uIGuRIEthvdRZVy56fWCHXOfmquRJDHazQZVnnXcRaqhuMYdZoJ3i1KkmSL4
	// X/SdBsB4rY4FQZWNtwKoSeDugQeJzf4bhyn0iZGbWPq+XO70MxXya8CfAoGBANq/
	// zL6ul+G6i/nXrfzwUr83EtXh6Zoj51YBK4g3ZIIuWkWvbo9NguV3p9KmeRKMWwYO
	// RHC7aVwpHdjzOyzmSFdmC+5dqVe6rkdl9AzxpKt0p0rOznmZUhDcdElCk0p6pC5R
	// QDAt2PA4aR3kT+9z2dPV0IHsUGiouF/LtmTmdCB5AoGAIShUdRefhCjpLORiVYc5
	// WI/VpRhtY9yokH0fo4Ygh2Wjw9Z4G4oa1HyjXwjGl7TBL/THLVp1VTwta7EgFdNS
	// zc6ngnQZwXeE/8cqvW+IuO2wmJAyC4Ytv1XeU69rtmSpMkLT5tzfByMYY0twPgCJ
	// msf2S7Hh4paEugnTwMFpnjECgYEAoTqc/i5RY97LLOr7ImM/mhBNobdRJnswFwPl
	// whCR1CG2B4a2Rokq4VbAK1LoCfPJYz1A1JZNoc/sX+tmwkE5MLHWOWpvVmoR6i4L
	// Iz83z+e7JjgnlxialDLowtZ/GXYrbLgWR2yDaQsq7w1InYUWGDyP4jL7USiKPJE5
	// bkUtcoECgYEAwhbb1NxzteIr8zlytMj52sgeiJPQRjbU5CoMAJuiHvYHT8jQwso7
	// lfbz+fXdQamU29v1Hdhc2JR1xWxrTz4bAt1l9lWK8zQBTK3SOlhyvrvNkKtTwjan
	// sR6+uwB9KY5mrF++pRA8IL2f0yhx2uqwDkX/Og6ZnFHJn3BvQM/DWPg=
	// -----END RSA PRIVATE KEY-----
	// ";

	// 	$response = array();
	// 	$requiredFields = ["order_id", "merchant_id", "amount", "timestamp", "customer_id"];
	// 	foreach ($requiredFields as $key){
	// 		if(!array_key_exists($key, $payload)){
	// 			echo json_encode(['status'=>false,'message'=>$key . " is not present "]);
	// 			return;
	// 		}
	// 	}
	// 	$signaturePayload = json_encode($payload);
	// 	$signature = "";
	// 	openssl_sign($signaturePayload, $signature, $privateKey, "sha256WithRSAEncryption");
	// 	array_push($response, base64_encode($signature));
	// 	array_push($response,$signaturePayload);
	// 	echo json_encode(['status'=>true,'data'=> $response,"signature"=>base64_encode($signature)]);
	// }


	public function createSignature()
	{
		$payload = json_decode(file_get_contents('php://input'), true);

		$privateKey = "-----BEGIN RSA PRIVATE KEY-----\nMIIEpQIBAAKCAQEA2R+5+b1HZSNNMotnr7Z/5By4NSTZW4dDMGDy2huOSLn1EF6v
		75sssdY5kRkFoihLIeNQA+yzsi0kzpz3rCCCmo1DJwgoqA48JVQwwBjZ9SHeC0nE
		66VODmMJJGNWe1quHWQb3otIzS+U+rtd1Alzo9up8u8e+FrecyjO6fBMZfd32iO7
		qPtExtA1XDtKMqoRbHMiAz940xA5+BLmJC+gp1IYsVce2KA5BW1laPxbku42aQR7
		eZipSa3BYRY8m964Aj6vLj4kTeTbrc4OH7yatRdWbVbrwVWpg936g8Q3Qf3jQY+H
		Mu76l1WeXK4GkPkA+oJXY6ag1XhhqtOrLw3rJwIDAQABAoIBAQCjy2thG4lgouD5
		4HC3/dU9IO1WKhZPFht5w6lxIJiWBLL7RnMzLrzo69NBwr6dNgh36CPU0hw9rhC2
		TXQKRfxA25BtQZpqLVLyVjDwuc6zPnljyqLjojDgaZXb/ZSgOihfw8XCfRDOubaJ
		8A84hmjWlEABJKMYeHSYK5Dsqnr37/Oj4OT2NWLaRx8Kk0HPuv/bxx3MHurIHRtG
		514UJZcOfN8Ti69/DoYbtb/Mpg/djXr5s47TafxPa8jyT2E8nWboPvYPDQcdu2CI
		E0mbrj2C0Ak7g20ZYzm9HCbJHVG+2rPSjVgXKW2ZgXoZflte+G5vRfDrZH+TZuo+
		ja0pVlIBAoGBAP4ZEtdpRJp5kvj7bUIkXd5E6lrxd2M0VprfMhHk0i+Z1p1nF8St
		F6p9uIGuRIEthvdRZVy56fWCHXOfmquRJDHazQZVnnXcRaqhuMYdZoJ3i1KkmSL4
		X/SdBsB4rY4FQZWNtwKoSeDugQeJzf4bhyn0iZGbWPq+XO70MxXya8CfAoGBANq/
		zL6ul+G6i/nXrfzwUr83EtXh6Zoj51YBK4g3ZIIuWkWvbo9NguV3p9KmeRKMWwYO
		RHC7aVwpHdjzOyzmSFdmC+5dqVe6rkdl9AzxpKt0p0rOznmZUhDcdElCk0p6pC5R
		QDAt2PA4aR3kT+9z2dPV0IHsUGiouF/LtmTmdCB5AoGAIShUdRefhCjpLORiVYc5
		WI/VpRhtY9yokH0fo4Ygh2Wjw9Z4G4oa1HyjXwjGl7TBL/THLVp1VTwta7EgFdNS
		zc6ngnQZwXeE/8cqvW+IuO2wmJAyC4Ytv1XeU69rtmSpMkLT5tzfByMYY0twPgCJ
		msf2S7Hh4paEugnTwMFpnjECgYEAoTqc/i5RY97LLOr7ImM/mhBNobdRJnswFwPl
		whCR1CG2B4a2Rokq4VbAK1LoCfPJYz1A1JZNoc/sX+tmwkE5MLHWOWpvVmoR6i4L
		Iz83z+e7JjgnlxialDLowtZ/GXYrbLgWR2yDaQsq7w1InYUWGDyP4jL7USiKPJE5
		bkUtcoECgYEAwhbb1NxzteIr8zlytMj52sgeiJPQRjbU5CoMAJuiHvYHT8jQwso7
		lfbz+fXdQamU29v1Hdhc2JR1xWxrTz4bAt1l9lWK8zQBTK3SOlhyvrvNkKtTwjan
		sR6+uwB9KY5mrF++pRA8IL2f0yhx2uqwDkX/Og6ZnFHJn3BvQM/DWPg=\n-----END RSA PRIVATE KEY-----";
		$response = array();
		$requiredFields = ["order_id", "merchant_id", "amount", "timestamp", "customer_id"];
		foreach ($requiredFields as $key) {
			if (!array_key_exists($key, $payload)) {
				echo json_encode(['status' => false, 'message' => $key . " is not present "]);
				return;
			}
		}
		$signaturePayload = json_encode($payload);
		$signature = "";
		openssl_sign($signaturePayload, $signature, $privateKey, "sha256WithRSAEncryption");
		array_push($response, base64_encode($signature));
		array_push($response, $signaturePayload);

		$this->db->insert('cashfree_transaction', [
			'user_id' => $payload['customer_id'],
			'order_id' => $payload['order_id'],
			'jsondata' => $signaturePayload,
			'amount' => $payload['amount'],
			'created_at' => date('Y-m-d H:i:s')
		]);
		echo json_encode(['status' => true, 'data' => $response, "signature" => base64_encode($signature)]);
	}

	public function createSignatureJuspay()
	{
		$payload = json_decode(file_get_contents('php://input'), true);

		$privateKey = "-----BEGIN RSA PRIVATE KEY-----\nMIIEowIBAAKCAQEA3QYEJzWlyj8zb8qN9IXTKlkyeM+FEAUDZBd319LUCBHlkFQl
		J+Scqlz6TIjUkAWqnfRad0CUe+mwS8PgsgZeJE/BT7x3o2xHCt89gekq31VAAcMB
		cxbNMcc/3Upfll2L8qqCSwjIm3xZfFZHGDhG/I+7IAhbiP1DrSm4Of4J8xNGVrcB
		Sgj+w9JrneYaAJv1/wpwAy+hH6GxqrGAQZ5xc1ePqoFjYgmW3D4lLdvWvH2ZR+kf
		V5kBJvstbH0bOtv7FHGR6UCNh6DPjnLDVFeCN7NPoBWpbLCXnhZbEqqY85MubXqa
		LrI+2R2kLpsCnsW9FshlZlX62ICg398klyvPIwIDAQABAoIBADBCrgl5t1ev8SVJ
		zzFDP1aR32lttppG3fSvAyYHDPEuJzgah3pseqDgaG7pubAw7I5M2qwLV+CuqCYD
		AT8eENRQ7d7hQiZW8DQ5ho6lQQ0+6hj4YYqlwexKm3FQWgrVJke4X3bO1i7NOiTi
		Gef58dYX9D4MVSBWXL6ky2suQzHl7W4sG2HknR22jTOuvK9JKUUThXvu0klqXeOQ
		64KW04Fbfuvlf01nX89GV6J4+isLwOW3CfXgefy60vKnXfM3Q6fP9TN/pDOmlUqp
		PmNvdSu/x7PK9/MbdreUOqNG4qhOqphyezzs30ZCZm+6gu+vujzOARrrXrCX2sMk
		+IQ6gkECgYEA/eiIHMFq70XCLejZWX6HHp/aDD29nIJgewYilFeik0hZy15k82/4
		xf9S5zb0GvWWBedkt6og2kWpzBtSZNE8o9k7MYIoUZLrmJvrxHl0wQFxNnQfVGxg
		FUYGUVLEPdVkLLVtxl3HjJ7+IXOMY70kddelCv1o5RiD6qfD+ygzW7ECgYEA3tgi
		MvYsXz0F2UVZK3OhHxrWLi8PXvPUIpuQMLnkAF6aS7JTH0h+/nhE9b9db37Pmsr2
		HfTE+OHgN2SpLl6m+13s1Q1z5+Myo7rGF1oDDW+PNlbin1AvIV0gWXl1i5z2Ggdj
		mPhOxFjKqnF6aVD/qkYcV5EY/jU5zGJm4GwpURMCgYEAucZ8aIXARweEVvDqrodc
		N7T/5jr6U9w02W6YuG8SXa7vPFR5ioBfxgbVUqUrn9oWhYVTdOp+lRWpcdR/yZIq
		SzvzCntQIrdbt9JFhADVwy3Z9typ26xb9NTCZJgpS5CpdejdQ+lzyti92h3gF03Z
		snswn8TgDdeNFZDgXRCB21ECgYBK0P+yYmoFU6SKDLliWEDpA4aTHOOpOm2nbNkd
		Mtv0r85XybgUka9pWhG0/BmvnECxNKEq74nOEW/IyTfvxIGFdURVR135pZLT25o0
		LtlFgoXvdX5ChJY+OljpEVlAlWMe3Ao5SmyPiUwJq22wvCwKC93qHGHqvw33q7Xk
		dQvuFwKBgAKgJoIu9oodT/FzzBz4Q7bYd6Q8EuFcyHAYVv3F0ahPPE+Rtnm8eX86
		d2nk5QQMWQCAshFnTOkeJzq4QlZNMbZ/wzd8JaOoNbXrbbJBaSUTSuwMs1lAxKg/
		ZiQDc1Kp/aqiwhROHDRmVEtgmEx4inGcICVLxj2J2DDeM1k0DOn+\n-----END RSA PRIVATE KEY-----";
		$response = array();
		$requiredFields = ["order_id", "merchant_id", "amount", "timestamp", "customer_id"];
		foreach ($requiredFields as $key) {
			if (!array_key_exists($key, $payload)) {
				echo json_encode(['status' => false, 'message' => $key . " is not present "]);
				return;
			}
		}
		$signaturePayload = json_encode($payload);
		$signature = "";
		openssl_sign($signaturePayload, $signature, $privateKey, "sha256WithRSAEncryption");
		array_push($response, base64_encode($signature));
		array_push($response, $signaturePayload);

		$this->db->insert('cashfree_transaction', [
			'user_id' => $payload['customer_id'],
			'order_id' => $payload['order_id'],
			'jsondata' => $signaturePayload,
			'amount' => $payload['amount'],
			'created_at' => date('Y-m-d H:i:s')
		]);
		echo json_encode(['status' => true, 'data' => $response, "signature" => base64_encode($signature)]);
	}

	public function juspay()
	{
		# code...

		// if($_POST){
		// 	print_r($_POST);die;
		// }


		$api_key = "EEB026213E0400EBCACB6ABD2EEE32";
		$secret_key = "YOUR SECRET KEY";
		$paymentURL = "https://sandbox.juspay.in/orders/";
		$returnURL = "https://astrohelp24.com/admin/push/add_payment_new";

		$pay = 1;
		if ($pay == 1) {
			$aid = 1;
			$applicant_email = "harpreet@appslure.com";
			$transaction_number = time();
			$app_fees = 10;
			$txID = '001';
			$txID = "APP-" . date("Y") . "-" . str_pad($transaction_number, 6, "0", STR_PAD_LEFT);
			$ch = curl_init($paymentURL);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERPWD, $api_key);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('customer_id' => str_pad($aid, 6, "0", STR_PAD_LEFT), 'customer_email' => $applicant_email, 'amount' => $app_fees, 'order_id' => $txID, 'return_url' => $returnURL));
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_TIMEOUT, 15);
			$response = curl_exec($ch);
			$response_json = json_decode($response);
			$payment_link = "";
			// print_r($response_json);die;
			$payment_link = $response_json->payment_links->web;
			// foreach($response_json as $key=>$val)
			// {
			// 	if($key=="payment_links")
			// 	{
			// 		foreach($val as $one_val)
			// 		{
			// 			if($payment_link=="")
			// 			{
			// 				$payment_link=$one_val;
			// 			}
			// 		}
			// 	}
			// }

			header("Location: " . $payment_link);
		} else {
			$error_msg = "There was an error with your application. Please try again.";
		}








		/*

				#Example integration with iFrame based solution

		#Step 1

		#Initiate the order with initorder api call
		$ch = curl_init('https://sandbox.juspay.in/init_order');

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    

		#You should use your API key here. This API is a test Key wont work in production.                 
		curl_setopt($ch, CURLOPT_USERPWD, 'EEB026213E0400EBCACB6ABD2EEE32:');
		curl_setopt($ch, CURLOPT_POST, 1); 


		#Set the customer_id, customer_email , amount and order_id as per details.
		#NOTE: The amount and order_id are the fields associated with the "current" order.
		$customer_id = 'guest_user_101';
		$customer_email = 'customer@mail.com';
		$amount = '10.00';
		$order_id = rand();
		#Return Url
		$return_url = "http://localhost/payment_status.php";

		curl_setopt($ch, CURLOPT_POSTFIELDS, array('customer_id' => $customer_id , 'customer_email' => $customer_email , 
								'amount' => $amount , 'order_id' => $order_id , 'return_url' => $return_url ));
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);                    
		curl_setopt($ch,CURLOPT_TIMEOUT, 15); 

		$response = curl_exec($ch); 
		*/
		$template['page'] = "push/juspay";
		$template['page_title'] = "Juspay";

		$this->load->view('template', $template);
	}

	function verify_hmac($params, $secret)
	{
		$receivedHmac = $params['signature'];
		// UrlEncode key/value pairs
		$encoded_params = [];
		foreach ($params as $key => $value) {
			if ($key != 'signature' && $key != 'signature_algorithm') {
				$encoded_params[urlencode($key)] = urlencode($value);
			}
		}
		ksort($encoded_params);
		$serialized_params = "";
		foreach ($encoded_params as $key => $value) {
			$serialized_params = $serialized_params . $key . "=" . $value . "&";
		}
		$serialized_params = urlencode(substr($serialized_params, 0, -1));
		$computedHmac = base64_encode(hash_hmac('sha256', $serialized_params, $secret, true));
		$receivedHmac = urldecode($receivedHmac);
		return urldecode($computedHmac) == $receivedHmac;
	}
	public function add_payment()
	{
		# code...APP-2021-1638768161
		$data = $_REQUEST;
		$status = $_REQUEST['status'];
		if ($status == 'CHARGED') {
			echo "<h1>Transaction is successfull</h1><br/>";
		} else {
		}
		print_r($data);
		// $signature = $this->verify_hmac($_REQUEST,'EEB026213E0400EBCACB6ABD2EEE32');
		// print_r($signature);


	}


	public function juspay_new()
	{
		$api_key = "EEB026213E0400EBCACB6ABD2EEE32";
		$secret_key = "YOUR SECRET KEY";
		$paymentURL = "https://sandbox.juspay.in/orders/";
		$returnURL = "https://astrohelp24.com/admin/push/add_payment_new";

		$pay = 1;
		if ($pay == 1) {
			$aid = 1;
			$applicant_email = "hssaggu567@gmail.com";
			$transaction_number = time();
			$app_fees = 10;
			$txID = '001';
			$txID = "APP-" . date("Y") . "-" . str_pad($transaction_number, 6, "0", STR_PAD_LEFT);
			$ch = curl_init($paymentURL);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERPWD, $api_key);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('customer_id' => str_pad($aid, 6, "0", STR_PAD_LEFT), 'customer_email' => $applicant_email, 'amount' => $app_fees, 'order_id' => $txID, 'return_url' => $returnURL));
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_TIMEOUT, 15);
			$response = curl_exec($ch);
			$response_json = json_decode($response);
			$payment_link = "";
			// print_r($response_json);die;
			$payment_link = $response_json->payment_links->web;
			// foreach($response_json as $key=>$val)
			// {
			// 	if($key=="payment_links")
			// 	{
			// 		foreach($val as $one_val)
			// 		{
			// 			if($payment_link=="")
			// 			{
			// 				$payment_link=$one_val;
			// 			}
			// 		}
			// 	}
			// }

			header("Location: " . $payment_link);
		} else {
			$error_msg = "There was an error with your application. Please try again.";
		}


		$template['page'] = "push/juspay";
		$template['page_title'] = "Juspay";

		$this->load->view('template', $template);
	}

	public function add_payment_new()
	{
		# code...APP-2021-1638768161
		$data = $_REQUEST;
		$status = $_REQUEST['status'];
		$order_id = $_REQUEST['order_id'];
		// print_r($order_id);die;

		$headers = array(
			'Content-Type:application/x-www-form-urlencoded',
			'x-merchantid:astroinfo24',
			'version: 2018-10-25',
			'api_key:EEB026213E0400EBCACB6ABD2EEE32'
		);

		$ch = curl_init("https://sandbox.juspay.in/orders/" . $order_id);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERPWD, "EEB026213E0400EBCACB6ABD2EEE32");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		// curl_setopt($ch, CURLOPT_POST, 1);
		// curl_setopt( $ch, CURLOPT_POSTFIELDS, [] );

		// curl_setopt($ch, CURLOPT_POSTFIELDS, array('customer_id' => str_pad($aid,6,"0",STR_PAD_LEFT) , 'customer_email' => $applicant_email , 'amount' => $app_fees , 'order_id' => $txID , 'return_url' => $returnURL ));
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		$response = curl_exec($ch);
		$response_json = json_decode($response, true);
		// 		echo json_encode($response_json);
		// die;
		$status = $response_json['status'];
		$str = '';
		$str .= "<b>Customerid : </b>" . $response_json['customer_id'] . "<br/>";
		$str .= "<b>status : </b>" . $response_json['status'] . "<br/>";
		$str .= "<b>OrderId : </b>" . $response_json['order_id'] . "<br/>";
		$str .= "<b>amount : </b>" . $response_json['amount'] . "<br/>";
		$str .= "<b>currency : </b>" . $response_json['currency'] . "<br/>";
		$str .= "<b>TXN ID : </b>" . $response_json['txn_id'] . "<br/>";
		$str .= "<b>payment_method_type : </b>" . $response_json['payment_method_type'] . "<br/>";
		$str .= "<b>payment_method : </b>" . $response_json['payment_method'] . "<br/>";

		if ($status == 'CHARGED') {
			echo '<h1 style="color:green">Transaction is successfull</h1><br/>' . $str;
		} else {

			echo  '<h1 style="color:red">Transaction is successfull</h1><br/>' . $str;
		}
		// print_r($data);
		// $signature = $this->verify_hmac($_REQUEST,'EEB026213E0400EBCACB6ABD2EEE32');
		// print_r($signature);


	}



	public function juspay_data()
	{
		$data = $_REQUEST;
		$this->db->insert('juspay_data', ['json' => json_encode($data), 'created_at' => date('Y-m-d H:i:s')]);
		if (empty($data)) {
			$data = (file_get_contents('php://input'));
			$url = "https://astrohelp24.com:5030/api/recharge_by_juspay_webhook";
			
			$ch = curl_init ($url);
			curl_setopt ($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER,
        	array("Content-type: application/json"));
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec ($ch); 
			
			if(!$response){
				//  $this->db->insert('juspay_data', ['json' => curl_error($ch) , 'created_at' => date('Y-m-d H:i:s')]);

			}
			curl_close($ch);
		}else{
			$data = json_encode($data);
			$url = "https://astrohelp24.com:5030/api/recharge_by_juspay_webhook";
			
			$ch = curl_init ($url);
			curl_setopt ($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER,
        	array("Content-type: application/json"));
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec ($ch); 
			
			if(!$response){
				//  $this->db->insert('juspay_data', ['json' => curl_error($ch) , 'created_at' => date('Y-m-d H:i:s')]);

			}
			curl_close($ch);
		}
		return 1;
	}


	public function tatatele_pick_by_customer()
	{
		$data = $_POST;
		return $this->db->insert('tatatele_response', ['json' => json_encode($data), 'status' => 'pick_by_customer', 'created_at' => date('Y-m-d H:i:s')]);
	}

	public function tatatele_pick_by_agent()
	{
		$data = $_POST;
		return $this->db->insert('tatatele_response', ['json' => json_encode($data), 'status' => 'pick_by_agent', 'created_at' => date('Y-m-d H:i:s')]);
	}

	public function tatatele_call_hangup()
	{
		$data = $_POST;
		return $this->db->insert('tatatele_response', ['json' => json_encode($data), 'status' => 'call_hangup', 'created_at' => date('Y-m-d H:i:s')]);
	}

	public function tatatele_call_missed()
	{
		$data = $_POST;
		 $this->db->insert('tatatele_response', ['json' => json_encode($data), 'status' => 'call_missed', 'created_at' => date('Y-m-d H:i:s')]);
		 
		 sleep(3);
		 $call_id = $data['call_id'];
		 $bookingdata = $this->db->get_where('bookings', ['bridge_id' => $call_id])->row();
		 if($bookingdata){
			 $this->db->where('id',$bookingdata->id);
			 $this->db->update('bookings',['status'=>3]);
		 }
		 return;

		//  $bookingdata = $this->db->get_where('bookings', ['bridge_id' => $call_id])->row();
	}

	public function tatatele_call_answered_agent()
	{
		$data = $_POST;
		$call_id = $data['call_id'];
		$this->db->insert('tatatele_response', ['json' => json_encode($data), 'status' => 'answered_by_agent', 'created_at' => date('Y-m-d H:i:s')]);

		// $this->db->where_in('status', [0, 1, 6]);
		$bookingdata = $this->db->get_where('bookings', ['bridge_id' => $call_id])->row();
		$dateTime = date('Y-m-d H:i:s');

		if (!$bookingdata) {
			$user_phone = strval($data['call_to_number']);
			$user_phone_no = substr($user_phone, -10);
			$user = $this->db->get_where('user', ['phone' => $user_phone_no])->row();
			if (!$user) {
				return 1;
			}

			$astro_phone = strval($data['answer_agent_number']);
			$astro_phone_no = substr($astro_phone, -10);

			$astrologer = $this->db->get_where('astrologers', ['phone' => $astro_phone_no])->row();
			if (!$astrologer) {
				return 1;
			}


			$price_per_mint = floatval($astrologer->price_per_mint_audio);
			$video_price = $astrologer->price_per_mint_chat;
			$audio_price = $astrologer->price_per_mint_audio;
			$chat_price = $astrologer->price_per_mint_chat;
			if ($astrologer->discount_on) {
				$timed = time();

				if ($timed >= strtotime($astrologer->discount_start) && $timed <= strtotime($astrologer->discount_end)) {
					$discount_on_arr = explode('|', $astrologer->discount_on);
					$discount_pct = floatval($astrologer->discount);
					if ($discount_pct) {
						if (in_array('audio', $discount_on_arr)) {
							$audio_price = $audio_price * ($discount_pct / 100);
						}

						if (in_array('chat', $discount_on_arr)) {
							$chat_price = $chat_price * ($discount_pct / 100);
						}

						if (in_array('video', $discount_on_arr)) {
							$video_price = $video_price * ($discount_pct / 100);
						}
					}
				}
			}
			$price_per_mint = $audio_price;

			$wallet = floatval($user->wallet);
			if ($wallet < $price_per_mint) {
				return 1;
			}

			$total_minutes = floor($wallet / $price_per_mint);
			$total_seconds = $total_minutes * 60;
			$payable_amount = $total_minutes * $price_per_mint;
			$storedata = [
				'user_id' => $user->id,
				'assign_id' => $astrologer->id,
				'price_per_mint' => $price_per_mint,
				'subtotal' => $price_per_mint,
				'payable_amount' => $payable_amount,
				'type' => 2,
				'booking_type' => 2,
				'user_name' => $user->name,
				'user_phone' => $user->phone,
				'user_gender' => $user->gender,
				'user_dob' => $user->dob,
				'user_tob' => $user->birth_time,
				'user_pob' => $user->place_of_birth,
				'member_id' => 0,
				'schedule_date' => date('Y-m-d'),
				'schedule_time' => date('H:i:s'),
				'schedule_date_time' => $dateTime,
				'start_time' => $dateTime,
				'total_minutes' => $total_minutes,
				'time_minutes' => $total_minutes,
				'total_seconds' => $total_seconds,
				'is_confirmed' => 1,
				'status' => 1,
				'astrologer_comission_perct' => $astrologer->share_percentage,
				'ivr_unique_id' => $data['uuid'],
				'created_at' => $dateTime,
				'updated_at' => $dateTime,
				'bridge_id' => $call_id
			];
			// print_r($storedata);die;

			sleep(1);
			$bookingdata = $this->db->get_where('bookings', ['bridge_id' => $call_id])->row();
			if (!$bookingdata) {

				$this->db->insert('bookings', $storedata);
			}
			// print_r($this->db->last_query());die;

		} else {

			$user = $this->db->get_where('user', ['id' => $bookingdata->id])->row();
			if (!$user) {
				return 1;
			}


			$astrologer = $this->db->get_where('astrologers', ['id' => $bookingdata->assign_id])->row();
			if (!$astrologer) {
				return 1;
			}

			$price_per_mint = floatval($astrologer->price_per_mint_audio);
			$video_price = $astrologer->price_per_mint_chat;
			$audio_price = $astrologer->price_per_mint_audio;
			$chat_price = $astrologer->price_per_mint_chat;
			if ($astrologer->discount_on) {
				$timed = time();

				if ($timed >= strtotime($astrologer->discount_start) && $timed <= strtotime($astrologer->discount_end)) {
					$discount_on_arr = explode('|', $astrologer->discount_on);
					$discount_pct = floatval($astrologer->discount);
					if ($discount_pct) {
						if (in_array('audio', $discount_on_arr)) {
							$audio_price = $audio_price * ($discount_pct / 100);

							$price_per_mint = $audio_price;

							$wallet = floatval($user->wallet);
							if ($wallet < $price_per_mint) {
								return 1;
							}
							$total_minutes = floor($wallet / $price_per_mint);
							$total_seconds = $total_minutes * 60;
							$dateTime = date('Y-m-d H:i:s');
							$payable_amount = $total_minutes * $price_per_mint;
							$storedata = [
								'price_per_mint' => $price_per_mint,
								'subtotal' => $price_per_mint,
								'payable_amount' => $payable_amount,
								'ivr_unique_id' => $data['uuid'],
								'updated_at' => $dateTime,
								'bridge_id' => $call_id
							];
							$this->db->where('id', $bookingdata->id);
							return $this->db->update('bookings', $storedata);
						}

						if (in_array('chat', $discount_on_arr)) {
							$chat_price = $chat_price * ($discount_pct / 100);
						}

						if (in_array('video', $discount_on_arr)) {
							$video_price = $video_price * ($discount_pct / 100);
						}
					}
				}
			}
		}
	}

	public function tatatele_call_answered_agent_2()
	{
		$data = $_POST;
		$call_id = $data['call_id'];
		// sleep(1);

		//  $this->db->insert('tatatele_response', ['json' => json_encode($data), 'status' => 'answered_by_agent', 'created_at' => date('Y-m-d H:i:s')]);

		// $this->db->where_in('status', [0, 1, 6]);
		$bookingdata = false;
		// $bookingdata = $this->db->get_where('bookings', ['bridge_id' => $call_id])->row();
		if (!$bookingdata) {

			$user_phone = ($data['call_to_number']);
			if (strlen($user_phone) > 10) {
				$user_phone = substr($user_phone, -10);
			}
			// print_r($user_phone);die;
			$user = $this->db->get_where('user', ['phone' => $user_phone])->row();
			// print_r($user);
			// die;
			if (!$user) {
				return 1;
			}

			// print_r($user);
			// $this->db->insert('tatatele_response', ['json' => json_encode($user), 'status' => 'answered_by_agent', 'created_at' => date('Y-m-d H:i:s')]);


			$astro_phone = strval($data['answer_agent_number']);
			$astro_phone_no = substr($astro_phone, -10);
			$astrologer = $this->db->get_where('astrologers', ['phone' => $astro_phone_no])->row();
			if (!$astrologer) {
				return 1;
			}
			// $this->db->insert('tatatele_response', ['json' => json_encode($astrologer), 'status' => 'answered_by_agent', 'created_at' => date('Y-m-d H:i:s')]);

			$price_per_mint = floatval($astrologer->price_per_mint_audio);
			$video_price = $astrologer->price_per_mint_chat;
			$audio_price = $astrologer->price_per_mint_audio;
			$chat_price = $astrologer->price_per_mint_chat;
			if ($astrologer->discount_on) {
				$timed = time();

				if ($timed >= strtotime($astrologer->discount_start) && $timed <= strtotime($astrologer->discount_end)) {
					$discount_on_arr = explode('|', $astrologer->discount_on);
					$discount_pct = floatval($astrologer->discount);
					if ($discount_pct) {
						if (in_array('audio', $discount_on_arr)) {
							$audio_price = $audio_price * ($discount_pct / 100);
						}

						if (in_array('chat', $discount_on_arr)) {
							$chat_price = $chat_price * ($discount_pct / 100);
						}

						if (in_array('video', $discount_on_arr)) {
							$video_price = $video_price * ($discount_pct / 100);
						}
					}
				}
			}
			$price_per_mint = $audio_price;

			$wallet = floatval($user->wallet);
			// if($wallet < $price_per_mint){
			// 	return 1;
			// }
			$total_minutes = floor($wallet / $price_per_mint);
			$total_seconds = $total_minutes * 60;
			$dateTime = date('Y-m-d H:i:s');
			$payable_amount = $total_minutes * $price_per_mint;
			$storedata = [
				'user_id' => $user->id,
				'assign_id' => $astrologer->id,
				'price_per_mint' => $price_per_mint,
				'subtotal' => $price_per_mint,
				'payable_amount' => $payable_amount,
				'type' => 2,
				'booking_type' => 2,
				'user_name' => $user->name,
				'user_phone' => $user->phone,
				'user_gender' => $user->gender,
				'user_dob' => $user->dob,
				'user_tob' => $user->birth_time,
				'user_pob' => $user->place_of_birth,
				'member_id' => 0,
				'schedule_date' => date('Y-m-d'),
				'schedule_time' => date('H:i:s'),
				'schedule_date_time' => $dateTime,
				'start_time' => $dateTime,
				'total_minutes' => $total_minutes,
				'time_minutes' => $total_minutes,
				'total_seconds' => $total_seconds,
				'is_confirmed' => 1,
				'status' => 1,
				'astrologer_comission_perct' => $astrologer->share_percentage,
				'ivr_unique_id' => $data['uuid'],
				'created_at' => $dateTime,
				'updated_at' => $dateTime,
				'bridge_id' => $call_id
			];
			print_r($storedata);
			die;
			// sleep(1);
			$this->db->insert('tatatele_response', ['json' => json_encode($storedata), 'status' => 'storedata', 'created_at' => date('Y-m-d H:i:s')]);

			$bookingdata = $this->db->get_where('bookings', ['bridge_id' => $call_id])->row();
			$this->db->insert('tatatele_response', ['json' => $this->db->last_query(), 'status' => 'answered_by_agent', 'created_at' => date('Y-m-d H:i:s')]);

			if (!$bookingdata) {

				$this->db->insert('bookings', $storedata);
			}
		}
	}
}
