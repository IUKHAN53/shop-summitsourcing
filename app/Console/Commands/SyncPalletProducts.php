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

        $this->info("Total products found: $total. Fetching in $totalPages pages...");

        $productIds = $this->getAllProductIds($alibaba, $totalPages);

        $this->info('Total product IDs fetched: ' . count($productIds));

        $productList = $this->fetchProductDetails($productIds, $alibaba);

        // Truncate the Product table before inserting new data
        $this->info('Truncating the Product table...');
        Product::truncate();

        $this->info('Inserting products into the database...');
        Product::query()->insert($productList);

        $this->info('Synchronization completed successfully.');
    }

    private function getTotalProductsCount(AlibabaService $alibaba): int
    {
        $params = [
            'offerPoolQueryParam' => json_encode([
                'offerPoolId' => 218866357,
                'taskId' => 1001,
                'language' => 'en',
                'pageNo' => '1',
                'pageSize' => '1'
            ]),
        ];
        $data = $alibaba->getPalletProducts($params);
        return $data['result']['result'][0]['offerPoolTotal'];
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

    private function fetchProductDetails(array $productIds, AlibabaService $alibaba): array
    {
        $productList = [];
        $count = count($productIds);
        $iteration = 1;
        foreach ($productIds as $productId) {
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
