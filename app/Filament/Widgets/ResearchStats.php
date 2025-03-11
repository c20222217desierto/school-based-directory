<?php
namespace App\Filament\Widgets;

use App\Models\Research;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class ResearchStats extends ChartWidget
{
    protected static ?string $heading = 'Research Statistics';

    protected function getData(): array
    {
        $published = Research::where('status', 'published')->count();
        $unpublished = Research::where('status', 'unpublished')->count();
        $totalResearch = Research::count();
        $totalUsers = User::count();

        return [
            'datasets' => [
                [
                    'label' => 'Count',
                    'data' => [$totalUsers, $published, $unpublished, $totalResearch],
                    'backgroundColor' => ['#4CAF50', '#2196F3', '#FFC107', '#9C27B0'],
                ],
            ],
            'labels' => ['Users', 'Published', 'Unpublished', 'Total Research'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut'; // Options: 'bar', 'line', 'pie', etc.
    }

    
}
