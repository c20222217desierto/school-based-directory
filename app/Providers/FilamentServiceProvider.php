<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Filament\Panel;

class FilamentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

public function panel(Panel $panel): Panel
{
    return $panel
        ->spa(false) // Disable SPA mode if enabled
        ->renderHook('scripts.end', fn () => <<<'HTML'
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    Livewire.restart();
                });
            </script>
        HTML);
}


    public function boot(): void
    {
        Filament::serving(function () {
            // Redirect non-admin users away from the admin panel
            if (auth()->check() && auth()->user()->role !== 'admin') {
                return redirect ()->back()->with([
                    'error' => 'Access denied.'
                ]);
            }
        });
    }
}
