<?php

namespace App\Filament\Resources\ResearchResource\Tables;

use Filament\Tables\Table;

class Pagination
{
    public static function apply(Table $table): Table
    {
        return $table->paginationPageOptions([10, 25, 50, 100]) // Pagination options
                     ->defaultPaginationPageOption(10); // Default to 10 items per page
    }
}
