<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use App\Services\AlibabaService;

class SyncPalletProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-pallet-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync pallet products from Alibaba API to local database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $alibaba = new AlibabaService();
        $this->info('Starting the synchronization of pallet products...');

        // Get total count of products
        $this->info('Fetching total number of products...');
        $total = $this->getTotalProductsCount($alibaba);
        $totalPages = ceil($total / 50);

        $this->info("Fetching Products IDs from best selling pallet...");

        $productIds = $this->getBestSellerProducts($alibaba);

        $this->info('Total product IDs fetched: ' . count($productIds));

        $productList2 = $this->fetchProductDetails($productIds, $alibaba, 'best_selling');

        $this->info("Total products found: $total. Fetching in $totalPages pages...");

        $productIds = $this->getAllProductIds($alibaba, $totalPages);

        $this->info('Total product IDs fetched: ' . count($productIds));

        $productList1 = $this->fetchProductDetails($productIds, $alibaba);

        $this->info('Inserting new products into the database...');
        Product::query()->insert($productList1);
        Product::query()->insert($productList2);

        $this->info('Synchronization completed successfully.');
    }

    private function getTotalProductsCount(AlibabaService $alibaba): int
    {
        $params = [
            'appKey' => 4611591,
            'palletId' => 218866357,
        ];
        $data = $alibaba->getPalletProductsCount($params);
        return $data['result']['model'];
    }

    private function getAllProductIds(AlibabaService $alibaba, int $totalPages): array
    {
        $productIds = [];
        for ($i = 1; $i <= $totalPages; $i++) {
            $this->info("Fetching product IDs from page $i...");
            $params = [
                'offerPoolQueryParam' => json_encode([
                    'offerPoolId' => 218866357,
                    'taskId' => 1001,
                    'language' => 'en',
                    'pageNo' => $i,
                    'pageSize' => '100'
                ]),
            ];
            $data = $alibaba->getPalletProducts($params);
            if (isset($data['result']['success']) && $data['result']['success'] === 'true') {
                $products = $data['result']['result'];
                foreach ($products as $productOffer) {
                    $productIds[] = $productOffer['offerId'];
                }
            }
        }
        return $productIds;
    }

    public function getBestSellerProducts(AlibabaService $alibaba): array
    {
        //        get 30 products from another pallet
        $productIds = [];
        $params = [
            'offerPoolQueryParam' => json_encode([
                'offerPoolId' => 218873525,
                'taskId' => 1002,
                'language' => 'en',
                'pageNo' => 1,
                'pageSize' => '30'
            ]),
        ];
        $data = $alibaba->getPalletProducts($params);
        if (isset($data['result']['success']) && $data['result']['success'] === 'true') {
            $products = $data['result']['result'];
            foreach ($products as $productOffer) {
                $productIds[] = $productOffer['offerId'];
            }
        }

        return $productIds;
    }

    private function fetchProductDetails(array $productIds, AlibabaService $alibaba, $type = 'trending'): array
    {
        $productList = [];
        $count = count($productIds);
        $iteration = 1;
        foreach ($productIds as $productId) {
            // Check if the product already exists in the database
            if (Product::where('offerId', $productId)->exists()) {
                $this->info("Product ID: $productId already exists. Skipping...");
                continue;
            }

            $this->info("Fetching details for product ID: $productId... (" . $iteration . "/" . $count . ")");
            $data = $this->getProductDetails($productId, $alibaba);
            if (!isset($data['result']) || !isset($data['result']['result'])) {
                continue;
            }
            $result = $data['result']['result'];
            $productList[] = [
                'offerId' => $result['offerId'],
                'category_id' => $result['topCategoryId'],
                'title' => $result['subjectTrans'],
                'images' => $result['productImage']['images'][0],
                'quantity' => $result['productSaleInfo']['amountOnSale'],
                'sold' => $result['soldOut'] ?? 0,
                'price' => $result['productSaleInfo']['priceRangeList'][0]['price'],
                'unit' => $result['productSaleInfo']['unitInfo']['transUnit'],
                'moq' => $result['minOrderQuantity'],
                'rating' => $result['tradeScore'],
                'type' => $type,
            ];
            $iteration++;
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
