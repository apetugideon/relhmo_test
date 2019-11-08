<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class monnifyClientController extends Controller
{

    //Password
    private $password = "H5EQMQSHSURJNQ7UH2R78YAH6UN54ZP7";

    //API-KEY
    private $apiKey   = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c";//"MK_TEST_WD7TZCMQV7";

    //Contract Code
    public  $contractCode = "2957982769";

    /**
     * Class Constructor
     *
     * @return void
     */
    public function __construct() {}

    //Reserve Account
    public function reserveAccount($contract_code="")
    {
        $this->contractCode = $contract_code ?? $this->contractCode;
        $url = "https://sandbox.monnify.com/api/v1/bank-transfer/reserved-accounts";
        
        $req_body = array(
            'accountReference' => 'abc123',
            'accountName' => 'Test Reserved Account',
            'currencyCode' => 'NGN',
            'contractCode' => $this->contractCode,
            'customerEmail' => 'test@tester.com'
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $req_body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->apiKey, 'Content-Type: application/json'));


        $response = curl_exec($curl);
        $result = json_decode($response);

        var_dump($result);
    }

    //Deactive Account
    public function deactivateAccount()
    {
        $this->contractCode = $contract_code ?? $this->contractCode;
        $url = "https://sandbox.monnify.com/api/v1/bank-transfer/reserved-accounts/9900725554";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->apiKey, 'Content-Type: application/json'));

        $curl_response = curl_exec($curl);

        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('Error Dectivating Account ' . var_export($info));
        }
        curl_close($curl);

        $decoded = json_decode($curl_response);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
        
        var_export($decoded);
    }

    public function transactionStatus() {
        $url  = "https://sandbox.monnify.com/api/v1/merchant/transactions/query?paymentReference=reference12345";
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $this->apiKey, 'Content-Type: application/json'));

        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('Error Retrieving Transaction Status' . var_export($info));
        }
        curl_close($curl);

        $decoded = json_decode($curl_response);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }
        echo 'response ok!';
        var_export($decoded);
    }
}
