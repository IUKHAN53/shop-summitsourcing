<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CategoriesOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total', Category::query()->count()),
        ];
    }
}
