<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-s-user-group';
    protected static ?string $navigationGroup = 'Site Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Forms\Components\Toggle::make('is_admin')->required(),
                Forms\Components\Toggle::make('is_active')->required(),

                Forms\Components\DateTimePicker::make('email_verified_at'),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->dehydrateStateUsing(fn(?string $state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn(?string $state) => filled($state))
                    ->required(fn(string $operation) => $operation === 'create')
                    ->maxLength(255),

                // Roles (many-to-many)
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),

                // Classrooms (many-to-many)
                Forms\Components\Select::make('classrooms')
                    ->label('Classrooms')
                    ->relationship('classrooms', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->nullable(),

                // Sections (many-to-many)
                Forms\Components\Select::make('sections')
                    ->label('Sections')
                    ->relationship('sections', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->nullable(),

                // Certifications (many-to-many)
                Forms\Components\Select::make('certifications')
                    ->label('Certifications')
                    ->relationship('certifications', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\IconColumn::make('is_admin')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('email_verified_at')->dateTime()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('last_login')->dateTime()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),

                // Use plural relationships
                Tables\Columns\TagsColumn::make('classrooms.name')->label('Classrooms'),
                Tables\Columns\TagsColumn::make('sections.name')->label('Sections'),
                Tables\Columns\TagsColumn::make('certifications.name')->label('Certifications'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('User Active?')
                    ->options([true => 'Yes', false => 'No']),

                Tables\Filters\SelectFilter::make('classrooms')
                    ->label('Classrooms')
                    ->relationship('classrooms', 'name'),

                Tables\Filters\SelectFilter::make('sections')
                    ->label('Sections')
                    ->relationship('sections', 'name'),

                Tables\Filters\SelectFilter::make('certifications')
                    ->label('Certifications')
                    ->relationship('certifications', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() < 5 ? 'warning' : 'primary';
    }
}
