<?php

namespace App\Filament\Resources\ResearchResource\Pages;

use App\Filament\Resources\ResearchResource;
use App\Filament\Resources\YesResource\Widgets\ResearchOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\ResearchStats;
class ListResearch extends ListRecords
{
    protected static string $resource = ResearchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            
        ];
    }
}
