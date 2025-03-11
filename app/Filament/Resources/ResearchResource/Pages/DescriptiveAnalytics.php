<?php
namespace App\Filament\Resources\ResearchResource\Pages;

use Filament\Pages\Page;
use App\Filament\Resources\ResearchResource;

class DescriptiveAnalytics extends Page
{
    protected static ?string $resource = ResearchResource::class; // ✅ Connect to ResearchResource
    protected static ?string $title = 'Descriptive Analytics';
    protected static string $view = 'filament.resources.research-resource.pages.descriptive-analytics';
}
