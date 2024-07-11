<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\ExchangeRate;

class UpdateExchangeRates extends Command
{
    protected $signature = 'exchange:update';
    protected $description = 'Update exchange rates from API';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $response = Http::get("https://open.er-api.com/v6/latest/CNY");
        if ($response->successful()) {
            $rates = $response->json()['rates'];

            foreach ($rates as $currency => $rate) {
                ExchangeRate::updateOrCreate(
                    ['currency' => $currency],
                    ['rate' => $rate]
                );
            }

            $this->info('Exchange rates updated successfully.');
        } else {
            $this->error('Failed to fetch exchange rates.');
        }
    }
}
