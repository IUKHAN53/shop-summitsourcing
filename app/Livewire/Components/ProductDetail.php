<?php

namespace App\Livewire\Components;

use App\Models\Category;
use Livewire\Component;

class ProductDetail extends Component
{
    public array $skus = [];

    public $sku_groups;
    public $selectedAttributes = [];
    public $selectedSku;
    public $currentGroup;
    public $attributeStack = [];

    public array $product_attributes = [];
    public array $product = [];
    public float $price = 0;
    public float $quantity = 0;

    public function mount($id)
    {
        $product_detail = $this->getProductDetails($id)['result']['result'];
        $this->skus = $product_detail['productSkuInfos'];
        $this->sku_groups = $this->makeSkuGroups($product_detail['productSkuInfos']);
        $this->currentGroup = $this->sku_groups;
        $this->setDefaultSelectedSku();
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

    public function makeSkuGroups($skus)
    {
        $sku_groups = [];

        foreach ($skus as $sku) {
            $attributes = $sku['skuAttributes'];
            $price = $sku['consignPrice'] ?? $this->price;
            $amountOnSale = $sku['amountOnSale'];
            $skuId = $sku['skuId'];

            $this->addAttributesToGroup($sku_groups, $attributes, $price, $amountOnSale, $skuId);
        }

        return $sku_groups;
    }

    private function addAttributesToGroup(&$group, $attributes, $price, $amountOnSale, $skuId)
    {
        $attribute = array_shift($attributes);

        if (!isset($group[$attribute['attributeNameTrans']])) {
            $group[$attribute['attributeNameTrans']] = [];
        }

        if (!isset($group[$attribute['attributeNameTrans']][$attribute['valueTrans']])) {
            $group[$attribute['attributeNameTrans']][$attribute['valueTrans']] = [
                'childAttributes' => []
            ];
        }

        if (empty($attributes)) {
            $group[$attribute['attributeNameTrans']][$attribute['valueTrans']] = [
                'id' => $skuId,
                'price' => $price,
                'amountOnSale' => $amountOnSale,
                'image' => $attribute['skuImageUrl'] ?? null,
            ];
        } else {
            $this->addAttributesToGroup(
                $group[$attribute['attributeNameTrans']][$attribute['valueTrans']]['childAttributes'],
                $attributes,
                $price,
                $amountOnSale,
                $skuId
            );
        }
    }

    public function resetAndSelectAttribute($attribute, $value)
    {
        $this->selectedAttributes = [];
        $this->selectedSku = null;
        $this->currentGroup = $this->sku_groups;
        $this->attributeStack = [];

        $this->selectAttribute($attribute, $value);
    }

    public function selectAttribute($attribute, $value)
    {
        $this->selectedAttributes[$attribute] = $value;

        if (isset($this->currentGroup[$attribute][$value]['childAttributes']) && !empty($this->currentGroup[$attribute][$value]['childAttributes'])) {
            $this->currentGroup = $this->currentGroup[$attribute][$value]['childAttributes'];
            $this->attributeStack[] = [
                'name' => $attribute,
                'group' => $this->currentGroup
            ];
            $this->selectedSku = null;
        } else {
            $this->selectedSku = $this->currentGroup[$attribute][$value];
            $this->attributeStack[] = [
                'name' => $attribute,
                'group' => []
            ];
        }
    }

    private function setDefaultSelectedSku()
    {
        foreach ($this->sku_groups as $rootName => $group) {
            foreach ($group as $value => $details) {
                if (isset($details['childAttributes']) && !empty($details['childAttributes'])) {
                    $this->selectAttribute($rootName, $value);
                    return;
                } else {
                    $this->selectedSku = $details;
                    $this->selectedAttributes[$rootName] = $value;
                    return;
                }
            }
        }
    }

}
