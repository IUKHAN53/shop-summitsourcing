<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class SyncCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync categories from Alibaba API to local database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $alibaba = new \App\Services\AlibabaService();
        $data = $alibaba->getCategoriesById(0);
        $children = $data['result']['result']['children'];
        $this->info('Syncing categories...');

        foreach ($children as $child) {
            $existingCategory = Category::where('alibaba_id', $child['categoryId'])->first();
            if (!$existingCategory) {
                $category = new Category();
                $category->alibaba_id = $child['categoryId'];
                $category->name = $child['translatedName'];
                $category->leaf = $child['leaf'];
                $category->level = $child['level'];
                $category->parent_id = $child['parentCateId'];
                $category->save();
                $this->info('Category added: '. $child['translatedName']);
            } else {
                $this->info('Category already exists: '. $child['translatedName']);
            }
        }

        $this->info('Categories synced successfully!');
    }
}
