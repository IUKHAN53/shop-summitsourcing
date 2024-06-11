<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AlibabaService
{
    protected $url;
    protected $appKey;
    protected $appSecret;
    protected $token;
    protected $apiInfo;
    protected $memberId;
    protected $apiVersion = '1';
    protected $namespace = 'com.alibaba.fanxiao.crossborder';
    protected $apiName = 'product.search.keywordQuery';


    public function __construct()
    {
        $this->url = 'http://gw.open.1688.com/openapi/param2';
        $this->appKey = 4611591;
        $this->appSecret = '60zWTlqEiF';
        $this->token = '7a8b2af8-3680-492d-90c2-ebc3654be4fb';
        $this->apiInfo = $this->apiVersion . '/' . $this->namespace . '/' . $this->apiName . '/' . $this->appKey;
        $this->memberId = 'tb14132031';
    }

    public function generateSignature(array $params): string
    {
        $aliParams = [];
        foreach ($params as $key => $val) {
            $aliParams[] = $key . $val;
        }
        sort($aliParams);
        $signStr = join('', $aliParams);
        $signature = strtoupper(bin2hex(hash_hmac("sha1", $signStr, $this->appSecret, true)));

        return $signature;
    }
//    public function generateSignature(array $params): string
//    {
//        $aliParams = [];
//        foreach ($params as $key => $val) {
//            $aliParams[] = $key . $val;
//        }
//        sort($aliParams);
//        $signStr = join('', $aliParams);
//        $signStr = $this->apiInfo . $signStr;
//        $signature = strtoupper(bin2hex(hash_hmac("sha1", $signStr, $this->appSecret, true)));
//
//        return $signature;
//    }

    public function generateUrl(array $params): string
    {
        $params['memberId'] = $this->memberId;
        $params['_aop_timestamp'] = time() * 1000;
        $params['access_token'] = $this->token;
        $params['_aop_signature'] = $this->generateSignature($params);

        $query = http_build_query($params);
        $fullUrl = "{$this->url}/{$this->apiInfo}?{$query}";

        return $fullUrl;
    }

    public function getResponse(array $params)
    {
        $url = $this->generateUrl($params);
        $response = Http::get($url);

        return $response->json();
    }

}
