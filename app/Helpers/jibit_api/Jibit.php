<?php
// require_once 'cache.class.php';

namespace App\Helpers\jibit_api;

use App\Helpers\jibit_api\cache;

class Jibit
{
    const BASE_URL = 'https://api.jibit.ir/ppg/v2';
    public $accessToken;
    private $apiKey;
    private $secretKey;
    private $refreshToken;

    public function __construct($apiKey, $secretKey)
    {
        $this->apiKey = $apiKey;
        $this->secretKey = $secretKey;
    }

    /**
     * @param int $amount
     * @param string $referenceNumber
     * @param string $userIdentifier
     * @param string $callbackUrl
     * @param string $currency
     * @param null $description
     * @param $additionalData
     * @return bool|mixed|string
     */
    public function paymentRequest($amount, $referenceNumber, $userIdentifier, $callbackUrl, $currency = 'TOMAN', $description = null, $additionalData = null)
    {
        $this->generateToken(true);
        $data = [
            'merchantCode' => $this->apiKey,
            'password' => $this->secretKey,
            'amount' => $amount,
            'referenceNumber' => $referenceNumber,
            'userIdentifier' => $userIdentifier,
            'callbackUrl' => $callbackUrl,
            'currency' => $currency,
            'description' => $description,
            'additionalData' => $additionalData,
        ];
        // dd($data);
        return $this->callCurl('/orders', $data, true);
    }

    /**
     * @param bool $isForce
     * @return string
     */
    private function generateToken($isForce = false)
    {
        // $cache = new cache();
        // if ($isForce === false && $cache->isCached('accessToken')) {
        //     $this->setAccessToken($cache->retrieve('accessToken'));
        // } else if ($cache->isCached('refreshToken')) {
        //     $refreshToken = $this->refreshTokens();
        //     if ($refreshToken !== 'ok') {
        //         $this->generateNewToken();
        //     }
        // } else {
        $this->generateNewToken();
        // }
        return 'unExcepted Err in generateToken.';
    }

    private function refreshTokens()
    {
        echo 'refreshing';
        $cache = new \App\Helpers\jibit_api\Cache();
        $data = [
            'accessToken' => str_replace('Bearer ', '', $cache->retrieve('accessToken')),
            'refreshToken' => $cache->retrieve('refreshToken'),
        ];
        $result = $this->callCurl('/tokens/refresh', $data, false);
        if (empty($result['accessToken'])) {
            return 'Err in refresh token.';
        }
        if (!empty($result['accessToken'])) {
            $cache = new \App\Helpers\jibit_api\Cache();
            $cache->store('accessToken', 'Bearer ' . $result['accessToken'], 24 * 60 * 60);
            $cache->store('refreshToken', $result['refreshToken'], 24 * 60 * 60);
            $this->setAccessToken('Bearer ' . $result['accessToken']);
            $this->setRefreshToken($result['refreshToken']);
            return 'ok';
        }

        return 'unExcepted Err in refreshToken.';
    }

    /**
     * @param $url
     * @param $arrayData
     * @param bool $haveAuth
     * @param int $try
     * @param string $method
     * @return bool|mixed|string
     */
    private function callCurl($url, $arrayData, $haveAuth = false, $try = 0, $method = 'POST')
    {
        $data = $arrayData;
        $jsonData = json_encode($data);
        $accessToken = '';
        if ($haveAuth) {
            $accessToken = $this->getAccessToken();
        }
        $ch = curl_init(self::BASE_URL . $url);
        // https://api.jibit.ir/ppg/v2/orders/dw5QdxZw
        // https://api.jibit.ir/ppg/v2/orders/verify/WrQj4E3n
        // https://api.jibit.ir/ppg/v2/tokens/generate
        // if ($try == 1) {
        //     $try = 0;
        //     dd(self::BASE_URL . $url);
        // }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Jibit.class Rest Api');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: ' . $accessToken,
            'Content-Length: ' . strlen($jsonData)
        ));
        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true);
        // dd($data, $result);
        curl_close($ch);

        if ($err) {
            return 'cURL Error #:' . $err;
        }
        if (empty($result['errors'])) {
            return $result;
        }
        if ($haveAuth === true && $result['errors'][0]['code'] === 'security.auth_required') {
            $this->generateToken(true);
            if ($try === 0) {
                return $this->callCurl($url, $arrayData, $haveAuth, 1);
            }

            return 'Err in auth.';
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param mixed $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param mixed $refreshToken
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    private function generateNewToken()
    {
        $data = [
            'merchantCode' => $this->apiKey,
            'password' => $this->secretKey,
        ];
        $result = $this->callCurl('/tokens/generate', $data);

        if (empty($result['accessToken'])) {
            return 'Err in generate new token.';
        }
        if (!empty($result['accessToken'])) {
            $cache = new cache();
            $cache->store('accessToken', 'Bearer ' . $result['accessToken'], 24 * 60 * 60);
            $cache->store('refreshToken', $result['refreshToken'], 24 * 60 * 60);
            // dd($result['accessToken']);
            $this->setAccessToken('Bearer ' . $result['accessToken']);
            $this->setRefreshToken($result['refreshToken']);
            return 'ok';
        }
        return 'unExcepted Err in generateNewToken.';
    }
    /**
     * @param string $refNum
     * @return bool|mixed|string
     */
    public function paymentVerify($refNum)
    {
        $this->generateToken();
        $data = [];
        return $this->callCurl('/orders/' /*. 'verify/'*/ . $refNum, $data, true, 0, 'GET');
    }
}
