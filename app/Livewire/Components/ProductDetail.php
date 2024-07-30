<?php

namespace App\Livewire\Components;

use App\Models\Category;
use Livewire\Component;

class ProductDetail extends Component
{
    public array $skus = [];
    public array $sku_groups = [];
    public array $selectedSku = [];
    public array $product_attributes = [];
    public array $product = [];
    public float $price = 0;
    public float $quantity = 0;

    public function mount($id)
    {
        $product_detail = $this->getProductDetails($id)['result']['result'];
        $this->skus = $product_detail['productSkuInfos'];
        $this->sku_groups = $this->makeSkuGroups($product_detail['productSkuInfos']);
        $this->product_attributes = $this->cleanAttributes($product_detail['productAttribute']);
        $this->price = $product_detail['productSaleInfo']['priceRangeList'][0]['price'];
        $this->quantity = $product_detail['productSaleInfo']['amountOnSale'];
        $this->product = [
            'category' => Category::query()->where('alibaba_id', $product_detail['topCategoryId'])->first(),
            'title' => $product_detail['subjectTrans'],
            'description' => $product_detail['description'],
            'images' => $product_detail['productImage']['images'],
            'sold' => $product_detail['soldOut'],
            'moq' => $product_detail['minOrderQuantity'],
            'rating' => $product_detail['tradeScore'],
            'width' => calculateWidth($product_detail['tradeScore']),
            'seller_info' => $product_detail['sellerDataInfo'],
            'dropshipping_info' => $product_detail['productShippingInfo'],
        ];
    }

    public function render()
    {
        return view('livewire.components.product-detail');
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

    public function makeSkuGroups(mixed $skus)
    {
        $sku_groups = [];
        foreach ($skus as $sku) {
            foreach ($sku['skuAttributes'] as $attribute) {
                $sku_groups[$attribute['attributeNameTrans']][] = [
                    'id' => $sku['skuId'],
                    'name' => $attribute['valueTrans'],
                    'price' => $sku['price'] ?? $this->price,
                    'amountOnSale' => $sku['amountOnSale'],
                    'image' => $attribute['skuImageUrl'] ?? null,
                ];
            }
        }
        return $sku_groups;
    }

    public function selectSku($sku)
    {
        dd($sku); // This will return the selected sku (array
        $this->selectedSku = $sku;
    }

}
