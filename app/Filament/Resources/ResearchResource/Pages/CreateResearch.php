<?php

namespace App\Filament\Resources\ResearchResource\Pages;

use App\Filament\Resources\ResearchResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateResearch extends CreateRecord
{
    protected static string $resource = ResearchResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Retains the "Create" button
            $this->getCancelFormAction(), // Retains the "Cancel" button
        ];
    }
}
