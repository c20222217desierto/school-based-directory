<?php

namespace App\Filament\Widgets;

use App\Models\Research;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

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
                ->icon('heroicon-o-book-open'), // ✅ Valid icon

            Card::make('Unpublished Research', Research::where('status', 'unpublished')->count())
                ->description('Unpublished research')
                ->color('warning')
                ->icon('heroicon-o-archive-box'), // ✅ Changed to valid icon

            Card::make('Total Research', Research::count())
                ->description('All research records')
                ->color('info')
                ->icon('heroicon-o-clipboard-document-list'), // ✅ Valid icon
        ];
    }
}
