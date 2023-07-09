<?php

namespace App\Filament\Resources\EmployerResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\EmployerResource;
use App\Filament\Resources\EmployerResource\Widgets\EmployerStatsOverview;
use App\Filament\Resources\EmployerPostResource\Widgets\EmployerPostsChart;

class ListEmployers extends ListRecords
{
    protected static string $resource = EmployerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            EmployerStatsOverview::class,
            // EmployerPostsChart::class,
        ];
    }

    
}
