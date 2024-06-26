<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getDetails($id)
    {
        $product_detail = $this->getProductDetails($id)['result']['result'];
        $product = [
            'category' => Category::query()->where('alibaba_id', $product_detail['topCategoryId'])->first(),
            'attributes' => $this->cleanAttributes($product_detail['productAttribute']),
            'title' => $product_detail['subjectTrans'],
            'description' => $product_detail['description'],
            'images' => $product_detail['productImage']['images'],
            'quantity' => $product_detail['productSaleInfo']['amountOnSale'],
            'sold' => $product_detail['soldOut'],
            'price' => $product_detail['productSaleInfo']['priceRangeList'][0]['price'],
            'moq' => $product_detail['minOrderQuantity'],
            'rating' => $product_detail['tradeScore'],
            'width' => calculateWidth($product_detail['tradeScore']),
            'seller_info' => $product_detail['sellerDataInfo'],
        ];
        return view('frontend.product_detail', compact('product'));
    }


    public function searchProducts(Request $request)
    {
        $searchTerm = $request->search;
        $alibaba = new \App\Services\AlibabaService();
        $params = [
            'offerQueryParam' => json_encode([
                'keyword' => $searchTerm,
                'pageSize' => 15,
                'beginPage' => 1,
                'country' => 'en'
            ]),
        ];
        $result = $alibaba->searchProductsByKeyword($params);
        $data = $result['result']['result'];
        $total_records = $data['totalRecords'];
        $pages = $data['totalPage'];
        $products = $data['data'];
        return view('frontend.products_list', compact('products', 'searchTerm', 'total_records', 'pages'));
    }

    public function getProductDetails($productId)
    {
        $alibaba = new \App\Services\AlibabaService();
        $params = [
            'offerDetailParam' => json_encode([
                'offerId' => $productId,
                'country' => 'en'
            ]),
        ];
        return $alibaba->getProductDetails($params);
    }

    public function cleanAttributes(mixed $productAttribute)
    {
        $attributes = [];
        foreach ($productAttribute as $attribute) {
            $attributes[$attribute['attributeNameTrans']] = $attribute['valueTrans'];
        }
        return $attributes;
    }


}
