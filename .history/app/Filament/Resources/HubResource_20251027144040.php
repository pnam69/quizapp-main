<?php

namespace App\Filament\Resources;

use App\Models\Hub;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;

class HubResource extends Resource
{
    protected static ?string $model = Hub::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Learning Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')->required()->maxLength(255),
            Textarea::make('description'),
            TextInput::make('subject')->maxLength(255),
            FileUpload::make('file_path')
                ->label('Study Material')
                ->directory('hubs')
                ->preserveFilenames()
                ->acceptedFileTypes(['application/pdf', 'video/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('subject')->sortable(),
                TextColumn::make('file_type'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
