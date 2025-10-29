<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HubResource\Pages;
use App\Models\{Hub, Certification, Section, User};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class HubResource extends Resource
{
    protected static ?string $model = Hub::class;
    protected static ?string $navigationGroup = 'Study Hub';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description'),

                Forms\Components\Select::make('type')
                    ->options([
                        'pdf' => 'PDF',
                        'video' => 'Video',
                        'link' => 'External Link',
                        'document' => 'Document',
                        'other' => 'Other',
                    ])
                    ->required()
                    ->reactive(),

                Forms\Components\FileUpload::make('file_path')
                    ->label('Upload File(s)')
                    ->directory('study_materials')
                    ->multiple()
                    ->json()
                    ->visible(fn($get) => in_array($get('type'), ['pdf', 'document', 'other'])),

                Forms\Components\TextInput::make('link_url')
                    ->label('External Link')
                    ->visible(fn($get) => in_array($get('type'), ['link', 'video'])),

                Forms\Components\Select::make('certification_id')
                    ->label('Certification')
                    ->options(Certification::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('section_id')
                    ->label('Section')
                    ->options(Section::pluck('name', 'id'))
                    ->searchable()
                    ->nullable(),

                Forms\Components\Select::make('users')
                    ->label('Assign to Students')
                    ->multiple()
                    ->options(User::pluck('name', 'id'))
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('type')->colors([
                    'primary' => 'pdf',
                    'warning' => 'video',
                    'success' => 'link',
                    'gray' => 'other',
                ]),
                Tables\Columns\TextColumn::make('certification.name')->label('Certification'),
                Tables\Columns\TextColumn::make('section.name')->label('Section'),
                Tables\Columns\TextColumn::make('users')
                    ->label('Assigned Students')
                    ->formatStateUsing(fn($users) => $users->pluck('name')->join(', ')),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHubs::route('/'),
            'create' => Pages\CreateHub::route('/create'),
            'edit' => Pages\EditHub::route('/{record}/edit'),
        ];
    }
}
