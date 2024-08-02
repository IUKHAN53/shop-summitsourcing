<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ExchangeRate;
use App\Models\Product;
use App\Services\AlibabaService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getDetails($id)
    {
        return view('frontend.product_detail', compact('id'));
    }

    public function searchProducts(Request $request)
    {
        if ($request->file('image')) {
            $alibaba = new \App\Services\AlibabaService();
            $file = base64_encode(file_get_contents($request->file('image')));
            $params = [
                'uploadImageParam' => json_encode([
                    'imageBase64' => $file,
                ]),
            ];
            $result = $alibaba->uploadImage($params);
            $data = $result;
            dd($data);
        }

        $searchTerm = $request->input('search');
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 15);
        $sort = $request->input('sort');
        $orderBy = [];
        if ($sort != 'default') {
            $orderBy = [
                'price' => $sort
            ];
        }
        $type = $request->input('type', 'all');
        $type = $type == 'dropshipping' ? 'isSelect' : 'isQqyx';

        $alibaba = new \App\Services\AlibabaService();
        $params = [
            'offerQueryParam' => json_encode([
                'keyword' => $searchTerm,
                'filter' => $type,
                'pageSize' => $pageSize,
                'beginPage' => $page,
                'country' => 'en',
                $sort != 'default' ? 'sort' : '' => json_encode($orderBy)
            ]),
        ];

        $result = $alibaba->searchProductsByKeyword($params);
        $data = $result['result']['result'];
        $total_records = $data['totalRecords'];
        $pages = $data['totalPage'];
        $products = $data['data'] ?? [];

        return view('frontend.products_list', compact('products', 'searchTerm', 'total_records', 'pages', 'page', 'pageSize', 'sort'));
    }

    public function getPalletProducts(Request $request)
    {
        $pageSize = $request->input('pageSize', 15);
        $sort = $request->input('sort', 'asc');
        $orderBy = $request->input('orderBy', 'price');
        $search = $request->input('search', '');

        $query = Product::query();

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $products = $query->orderBy($orderBy, $sort)->paginate($pageSize);

        return view('frontend.pallet_products', compact('products', 'sort', 'orderBy', 'search'));
    }

    public function searchDropshippingProducts(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 15);
        $sort = $request->input('sort');
        $orderBy = [];
        if ($sort != 'default') {
            $orderBy = [
                'price' => $sort
            ];
        }

        $alibaba = new \App\Services\AlibabaService();
        $params = [
            'offerQueryParam' => json_encode([
                'keyword' => $searchTerm,
                'filter' => 'isSelect',
                'pageSize' => $pageSize,
                'beginPage' => $page,
                'country' => 'en',
                $sort != 'default' ? 'sort' : '' => json_encode($orderBy)
            ]),
        ];

        $result = $alibaba->searchProductsByKeyword($params);
        $data = $result['result']['result'];
        $total_records = $data['totalRecords'];
        $pages = $data['totalPage'];
        $products = $data['data'];

        return view('frontend.dropshipping', compact('products', 'searchTerm', 'total_records', 'pages', 'page', 'pageSize', 'sort'));
    }

    public function categoryProducts(Request $request, $id)
    {
        $category = Category::query()->findOrFail($id);
        $palletId = $category->pallet_id;

        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $sort = $request->input('sort');

        $alibaba = new \App\Services\AlibabaService();
        $params = [
            'offerPoolQueryParam' => json_encode([
                'offerPoolId' => $palletId,
                'taskId' => 1002,
                'language' => 'en',
                'pageNo' => $page,
                'pageSize' => $pageSize
            ]),
        ];

        $result = $alibaba->getPalletProducts($params);

        if (isset($result['result']['success']) && $result['result']['success'] === 'true') {
            $productIds = [];
            $data = $result['result']['result'];
            $total_records = isset($data[0]) ? $data[0]['offerPoolTotal'] : 0;
            $pages = floor($total_records / $pageSize);
            foreach ($data as $productOffer) {
                $productIds[] = $productOffer['offerId'];
            }
            $products = $this->fetchProductDetails($productIds, $alibaba);
        } else {
            $total_records = 0;
            $pages = 0;
            $products = [];
        }
        return view('frontend.cat-products', compact('products', 'category', 'total_records', 'pages', 'page', 'pageSize', 'sort'));
    }


    private function fetchProductDetails(array $productIds, AlibabaService $alibaba): array
    {
        $productList = [];
        foreach ($productIds as $productId) {
            $data = $this->getProductDetails($productId, $alibaba);
            if (!isset($data['result']) || !isset($data['result']['result'])) {
                continue;
            }
            $result = $data['result']['result'];
            $productList[] = $result;
        }
        return $productList;
    }

    private function getProductDetails(string $productId, AlibabaService $alibaba): array
    {
        $params = [
            'offerDetailParam' => json_encode([
                'offerId' => $productId,
                'country' => 'en'
            ]),
        ];
        return $alibaba->getProductDetails($params);
    }


}
