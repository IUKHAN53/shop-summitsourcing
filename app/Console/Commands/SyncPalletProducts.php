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
    protected $signature = 'app:sync-pallet-products {limit? : The number of products to sync}';

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
        $limit = $this->argument('limit');
        $this->info('Starting the synchronization of pallet products...');

        $this->syncProducts($alibaba, 218866357, 'trending', $limit);
        $this->syncBestSellingProducts($alibaba, $limit);

        $this->info('Synchronization completed successfully.');
    }

    private function syncProducts(AlibabaService $alibaba, int $palletId, string $type, ?int $limit)
    {
        $this->info("Fetching total number of products for pallet ID: $palletId...");
        $total = $this->getTotalProductsCount($alibaba, $palletId);
        $totalPages = ceil($total / 50);

        $this->info("Total products found: $total. Fetching in $totalPages pages...");

        $productIds = $this->getAllProductIds($alibaba, $palletId, $totalPages, $limit);

        $this->info('Total product IDs fetched: ' . count($productIds));

        $productList = $this->fetchProductDetails($productIds, $alibaba, $type, $limit);

        $this->info('Inserting new products into the database...');
        Product::query()->insert($productList);
    }

    private function syncBestSellingProducts(AlibabaService $alibaba, ?int $limit)
    {
        $palletId = 3214452;

        $this->info("Fetching total number of best selling products for pallet ID: $palletId...");
        $totalBestSelling = $this->getTotalProductsCount($alibaba, $palletId);
        $totalBestSellingPages = ceil($totalBestSelling / 50);

        $page = rand(1, $totalBestSellingPages);

        $this->info("Fetching Products IDs from best selling pallet on page $page...");

        $productIds = $this->getBestSellerProducts($alibaba, $page, $palletId, $limit);

        $this->info('Total product IDs fetched: ' . count($productIds));

        $productList = $this->fetchProductDetails($productIds, $alibaba, 'best_selling', $limit);

        $this->info('Inserting new best selling products into the database...');
        Product::query()->insert($productList);
    }

    private function getTotalProductsCount(AlibabaService $alibaba, int $palletId): int
    {
        $params = [
            'appKey' => 4611591,
            'palletId' => $palletId,
        ];
        $data = $alibaba->getPalletProductsCount($params);
        return $data['result']['model'];
    }

    private function getAllProductIds(AlibabaService $alibaba, int $palletId, int $totalPages, ?int $limit): array
    {
        $productIds = [];
        $totalFetched = 0;
        for ($i = 1; $i <= $totalPages; $i++) {
            $this->info("Fetching product IDs from page $i...");
            $params = [
                'offerPoolQueryParam' => json_encode([
                    'offerPoolId' => $palletId,
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
                    $totalFetched++;
                    if ($limit && $totalFetched >= $limit) {
                        break 2;
                    }
                }
            }
        }
        return $productIds;
    }

    public function getBestSellerProducts(AlibabaService $alibaba, int $page, int $palletId, ?int $limit): array
    {
        $productIds = [];
        $params = [
            'offerPoolQueryParam' => json_encode([
                'offerPoolId' => $palletId,
                'taskId' => 1002,
                'language' => 'en',
                'pageNo' => $page,
                'pageSize' => '30'
            ]),
        ];
        $data = $alibaba->getPalletProducts($params);
        if (isset($data['result']['success']) && $data['result']['success'] === 'true') {
            $products = $data['result']['result'];
            foreach ($products as $productOffer) {
                $productIds[] = $productOffer['offerId'];
                if ($limit && count($productIds) >= $limit) {
                    break;
                }
            }
        }

        return $productIds;
    }

    private function fetchProductDetails(array $productIds, AlibabaService $alibaba, string $type, ?int $limit): array
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
                'unit' => isset($result['productSaleInfo']['unitInfo']) ? $result['productSaleInfo']['unitInfo']['transUnit'] : '',
                'moq' => $result['minOrderQuantity'],
                'rating' => $result['tradeScore'],
                'type' => $type,
            ];
            $iteration++;
            if ($limit && count($productList) >= $limit) {
                break;
            }
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
