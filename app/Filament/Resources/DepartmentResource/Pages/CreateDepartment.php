<?php

namespace App\Filament\Resources\DepartmentResource\Pages;

use App\Filament\Resources\DepartmentResource;

use Filament\Resources\Pages\CreateRecord;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(), // Keep only "Create"
            $this->getCancelFormAction(), // Keep only "Cancel"
        ];
    }
}
