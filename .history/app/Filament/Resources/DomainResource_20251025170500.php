<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DomainResource\Pages;
use App\Filament\Resources\DomainResource\RelationManagers;
use App\Models\Domain;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DomainResource extends Resource
{
    protected static ?string $model = Domain::class;

    protected static ?string $navigationIcon = 'heroicon-s-square-2-stack';

    protected static ?string $navigationGroup = 'Quiz Management';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 2 ? 'warning' : 'primary';
    }
    [{
	"resource": "/d:/Android/quizapp1/quizapp-main/quizapp-main/app/Filament/Resources/DomainResource.php",
	"owner": "_generated_diagnostic_collection_name_#1",
	"code": "P1038",
	"severity": 8,
	"message": "Method 'App\\Filament\\Resources\\DomainResource::canViewAny()' is not compatible with method 'Filament\\Resources\\Resource::canViewAny()'.",
	"source": "intelephense",
	"startLineNumber": 37,
	"startColumn": 5,
	"endLineNumber": 37,
	"endColumn": 51,
	"origin": "extHost1"
},{
	"resource": "/d:/Android/quizapp1/quizapp-main/quizapp-main/app/Filament/Resources/DomainResource.php",
	"owner": "_generated_diagnostic_collection_name_#4",
	"code": "PHP2439",
	"severity": 8,
	"message": "Declaration of DomainResource::canViewAny($user): bool must be compatible with Resource::canViewAny(): bool",
	"source": "PHP",
	"startLineNumber": 37,
	"startColumn": 39,
	"endLineNumber": 37,
	"endColumn": 44,
	"origin": "extHost1"
},{
	"resource": "/d:/Android/quizapp1/quizapp-main/quizapp-main/app/Filament/Resources/DomainResource.php",
	"owner": "cSpell",
	"severity": 2,
	"message": "\"Spatie\": Unknown word.",
	"source": "cSpell",
	"startLineNumber": 9,
	"startColumn": 31,
	"endLineNumber": 9,
	"endColumn": 37,
	"origin": "extHost1"
},{
	"resource": "/d:/Android/quizapp1/quizapp-main/quizapp-main/app/Filament/Resources/DomainResource.php",
	"owner": "cSpell",
	"severity": 2,
	"message": "\"Spatie\": Unknown word.",
	"source": "cSpell",
	"startLineNumber": 13,
	"startColumn": 29,
	"endLineNumber": 13,
	"endColumn": 35,
	"origin": "extHost1"
},{
	"resource": "/d:/Android/quizapp1/quizapp-main/quizapp-main/app/Filament/Resources/DomainResource.php",
	"owner": "cSpell",
	"severity": 2,
	"message": "\"heroicon\": Unknown word.",
	"source": "cSpell",
	"startLineNumber": 22,
	"startColumn": 49,
	"endLineNumber": 22,
	"endColumn": 57,
	"origin": "extHost1"
},{
	"resource": "/d:/Android/quizapp1/quizapp-main/quizapp-main/app/Filament/Resources/DomainResource.php",
	"owner": "cSpell",
	"severity": 2,
	"message": "\"toggleable\": Unknown word.",
	"source": "cSpell",
	"startLineNumber": 109,
	"startColumn": 23,
	"endLineNumber": 109,
	"endColumn": 33,
	"origin": "extHost1"
},{
	"resource": "/d:/Android/quizapp1/quizapp-main/quizapp-main/app/Filament/Resources/DomainResource.php",
	"owner": "cSpell",
	"severity": 2,
	"message": "\"toggleable\": Unknown word.",
	"source": "cSpell",
	"startLineNumber": 114,
	"startColumn": 23,
	"endLineNumber": 114,
	"endColumn": 33,
	"origin": "extHost1"
},{
	"resource": "/d:/Android/quizapp1/quizapp-main/quizapp-main/app/Filament/Resources/DomainResource.php",
	"owner": "cSpell",
	"severity": 2,
	"message": "\"toggleable\": Unknown word.",
	"source": "cSpell",
	"startLineNumber": 118,
	"startColumn": 23,
	"endLineNumber": 118,
	"endColumn": 33,
	"origin": "extHost1"
}]


    public static function canCreate(): bool
    {
        return false;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255)
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Select::make('certification_id')
                    ->relationship('certification', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Toggle::make('is_active')
                    ->required(),

                Forms\Components\MarkdownEditor::make('details')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('certification.name')
                    ->sortable()
                    ->searchable(),


                Tables\Columns\TextColumn::make('questions_count')
                    ->counts('questions')
                    ->label('Questions')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active'),

                Tables\Columns\TextColumn::make('certification.section.name')
                    ->searchable()
                    ->sortable(),


                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->label('Author')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDomains::route('/'),
            'create' => Pages\CreateDomain::route('/create'),
            'edit' => Pages\EditDomain::route('/{record}/edit'),
        ];
    }
}
