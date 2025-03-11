<?php

namespace App\Filament\Resources\YesResource\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Research;
use App\Models\User;

class ResearchOverview extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Users', User::count())
                ->description('Number of registered users')
                ->color('success')
                ->icon('heroicon-o-user-group'),

            Card::make('Published Research', Research::where('status', 'published')->count())
                ->description('Published research')
                ->color('primary')
                ->icon('heroicon-o-book-open'),

            Card::make('Unpublished Research', Research::where('status', 'unpublished')->count())
                ->description('Unpublished research')
                ->color('warning')
                ->icon('heroicon-o-document'),
        ];
    }
}
