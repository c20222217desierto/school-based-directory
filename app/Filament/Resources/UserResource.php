<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 2;

    // Set a separate navigation group named "Accounts"
    protected static ?string $navigationGroup = 'Accounts';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Full Name')
                ->required(),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->unique(ignoreRecord: true)
                ->required(),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                ->hiddenOn('edit') // Hide password field when editing
                ->required(),

            Select::make('role')
                ->label('Role')
                ->options([
                    'admin' => 'Admin',
                    'user' => 'User',
                ])
                ->default('user')
                ->required(),


           

                

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->query(fn () => User::query()->where('role', 'user'))  // ✅ Show only users (not admins)
            ->columns([
                TextColumn::make('name')->label('Name'),
                TextColumn::make('email')->label('Email'),
                BadgeColumn::make('role')->label('Role')
                    ->colors([
                        'success' => 'admin',
                        'warning' => 'user',
                    ]),
                    IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean() // Shows as a check (✅) or cross (❌)
                    ->trueColor('success')
                    ->falseColor('danger'),
                  
    
                    
                TextColumn::make('created_at')->label('Created At')->date(),
            ])
            ->actions([
                EditAction::make(),
                
            ])
            
            
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('Deactivate Users')
                    ->action(fn ($records) => $records->each->update(['is_active' => false]))
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion()
                    ->successNotificationTitle('Selected users are now inactive'),
            ]);
            
            
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
