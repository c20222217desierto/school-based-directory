<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ResearchResource\Pages;
use App\Filament\Resources\ResearchResource\Tables\Pagination;
use App\Models\Department;
use App\Models\Research;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Storage;

class ResearchResource extends Resource {
    protected static ?string $model = Research::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Research Management';
    protected static ?string $navigationLabel = 'Research';
    protected static ?int $navigationSort = 1;
    protected static ?string $label = 'Research';
    protected static ?string $pluralLabel = 'Researches';

    public static function form(Form $form): Form {
        return $form->schema([
            Select::make('department_id')
                ->label('Department')
                ->options(Department::pluck('name', 'id'))
                ->searchable()
                ->required()
                ->placeholder('Select Department'),

            TextInput::make('title')
                ->label('Research Title')
                ->required()
                ->maxLength(255),

            TextInput::make('author')
                ->label('Author')
                ->required()
                ->maxLength(255),
            
            DatePicker::make('published_date')
                ->label('Published Date')
                ->required(),
            
            Textarea::make('abstract')
                ->label('Abstract')
                ->rows(2) // Adjust the height
                ->maxLength(1000)
                ->required()
                ->placeholder('Enter the abstract here...'),

            Select::make('status')
                ->label('Status')
                ->options([
                    'published' => 'Published',
                    'unpublished' => 'Unpublished',
                ])
                ->default('unpublished')
                ->required(),

            // File Upload Field - Google Drive Storage
            FileUpload::make('file')
                ->label('Upload Research File')
                ->disk('google') // Store in Google Drive
                ->directory('Research Project') // Folder inside Google Drive
                ->preserveFilenames()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table {
        $table = Pagination::apply($table); // Apply pagination settings

        return $table->columns([
            TextColumn::make('department.name')->label('Department'),
            TextColumn::make('title')->label('Title'),
            TextColumn::make('author')->label('Author'),
            TextColumn::make('abstract')
                ->label('Abstract')
                ->limit(100)
                ->tooltip(fn ($state) => $state)
                ->wrap(),
            
            TextColumn::make('published_date')
                ->label('Published Date')
                ->date(),
            
            BadgeColumn::make('status')
                ->label('Status')
                ->colors([
                    'success' => 'published',
                    'danger' => 'unpublished',
                ]),

               
        ])
        ->filters([
            SelectFilter::make('department_id')
                ->label('Department')
                ->relationship('department', 'name')
                ->multiple()
                ->placeholder('All Departments')
                ->preload(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getRelations(): array {
        return [];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListResearch::route('/'),
            'create' => Pages\CreateResearch::route('/create'),
            'edit' => Pages\EditResearch::route('/{record}/edit'),
        ];
    }
}
