<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AlibabaService
{
    protected $url;
    protected $appKey;
    protected $appSecret;
    protected $token;
    protected $urlPath;
    protected $memberId;
    protected $apiVersion = '1';
    protected $namespace = 'com.alibaba.fenxiao.crossborder';

    public function __construct()
    {
        $this->url = 'http://gw.open.1688.com/openapi';
        $this->appKey = 4611591;
        $this->appSecret = '60zWTlqEiF';
        $this->token = '7a8b2af8-3680-492d-90c2-ebc3654be4fb';
        $this->memberId = 'tb14132031';
    }

    protected function generateSignature(array $params, string $urlPath): string
    {
        $aliParams = [];
        foreach ($params as $key => $val) {
            $aliParams[] = $key . $val;
        }
        sort($aliParams);
        $signStr = join('', $aliParams);
        $signStr = $urlPath . $signStr;
        $signature = strtoupper(bin2hex(hash_hmac("sha1", $signStr, $this->appSecret, true)));
        return $signature;
    }

    protected function generateUrl(string $apiName, array $params): string
    {
        $urlPath = 'param2/' . $this->apiVersion . '/' . $this->namespace . '/' . $apiName . '/' . $this->appKey;
        $params['memberId'] = $this->memberId;
        $params['_aop_timestamp'] = time() * 1000;
        $params['access_token'] = $this->token;
        $params['_aop_signature'] = $this->generateSignature($params, $urlPath);

        $query = http_build_query($params);
        $fullUrl = "{$this->url}/{$urlPath}?{$query}";

        return $fullUrl;
    }

    protected function getResponse(string $apiName, array $params)
    {
        $url = $this->generateUrl($apiName, $params);
        $response = Http::get($url);
        return $response->json();
    }

    protected function getPostResponse(string $apiName, array $params)
    {
        $url = $this->generateUrl($apiName, $params);
        $response = Http::post($url);
        return $response->json();
    }

    public function searchProductsByKeyword($params)
    {
        $apiName = 'product.search.keywordQuery';
        return $this->getPostResponse($apiName, $params);
    }

    public function getTopRankProducts($params)
    {
        $apiName = 'product.topList.query';
        return $this->getPostResponse($apiName, $params);
    }

    public function getRecommendedProducts($params)
    {
        $apiName = 'product.search.offerRecommend';
        return $this->getPostResponse($apiName, $params);
    }

    public function getCategoriesById($category_id)
    {
        $apiName = 'category.translation.getById';
        $params = ['categoryId' => $category_id];
        $params['language'] = 'en';
        return $this->getResponse($apiName, $params);
    }

    public function getCategoriesByKeyword($keyword)
    {
        $apiName = 'category.translation.getByKeyword';
        $params = ['keyword' => $keyword];
        $params['language'] = 'en';
        return $this->getResponse($apiName, $params);
    }

    public function getProductDetails($params)
    {
        $apiName = 'product.search.queryProductDetail';
        return $this->getPostResponse($apiName, $params);
    }

    public function getPalletProducts($params)
    {
        $apiName = 'pool.product.pull';
        return $this->getPostResponse($apiName, $params);
    }


}
