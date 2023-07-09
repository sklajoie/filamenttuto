<?php

namespace App\Filament\Resources\EmployerResource\Widgets;

use App\Models\Country;
use App\Models\Employer;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class EmployerStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $usa = Country::where('country_code', 'USA')->withCount('employers')->first();
        $ci = Country::where('country_code', 'CI')->withCount('employers')->first();
        //  dd($ci->employers_count);
        return [
            Card::make('All Employers', Employer::all()->count()),
            Card::make('USA Employers', $usa ? $usa->employers_count:0),
            Card::make('CI Employers', $ci ? $ci->employers_count:0),
            Card::make('Average time on page', '3:12'),
        ];
    }
}
