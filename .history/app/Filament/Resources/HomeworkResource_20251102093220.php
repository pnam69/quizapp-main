<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeworkResource\Pages;
use App\Filament\Resources\HomeworkResource\RelationManagers;
use App\Models\{Homework, Certification, Section, Classroom};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeworkResource extends Resource
{
    protected static ?string $model = Homework::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'School Management';
    protected static ?string $navigationLabel = 'Homework & Assignments';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Assignment Information')
                    ->schema([
                        Forms\Components\Hidden::make('teacher_id')
                            ->default(fn() => Auth::id()),

                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Chapter 5 Homework, Math Assignment 1')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->placeholder('Brief description of the assignment')
                            ->rows(2)
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('instructions')
                            ->placeholder('Detailed instructions for students...')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'link',
                            ]),
                    ]),

                Forms\Components\Section::make('Assignment Settings')
                    ->schema([
                        Forms\Components\Select::make('certification_id')
                            ->label('Subject/Course')
                            ->options(Certification::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->reactive(),

                        Forms\Components\Select::make('section_id')
                            ->label('Topic/Chapter')
                            ->options(Section::pluck('name', 'id'))
                            ->searchable()
                            ->nullable(),

                        Forms\Components\Select::make('classroom_id')
                            ->label('Assign to Class')
                            ->options(Classroom::pluck('name', 'id'))
                            ->searchable()
                            ->nullable()
                            ->helperText('Leave empty to assign to all students in the subject'),

                        Forms\Components\TextInput::make('max_points')
                            ->required()
                            ->numeric()
                            ->default(100)
                            ->minValue(1)
                            ->suffix('points'),
                    ])->columns(2),

                Forms\Components\Section::make('Dates & Deadlines')
                    ->schema([
                        Forms\Components\DatePicker::make('assigned_date')
                            ->required()
                            ->default(now())
                            ->native(false),

                        Forms\Components\DateTimePicker::make('due_date')
                            ->required()
                            ->native(false)
                            ->minDate(now())
                            ->helperText('Students must submit before this date and time'),

                        Forms\Components\Toggle::make('allow_late_submission')
                            ->label('Allow late submissions')
                            ->helperText('Students can still submit after the due date')
                            ->default(false),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Publish immediately')
                            ->helperText('Students can see and submit this assignment')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Attachments & Resources')
                    ->schema([
                        Forms\Components\FileUpload::make('attachments')
                            ->label('Assignment Files')
                            ->multiple()
                            ->disk('public')
                            ->directory('homework_attachments')
                            ->preserveFilenames(true)
                            ->maxSize(51200) // 50MB
                            ->helperText('Upload worksheets, PDFs, or other materials students need')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn($record) => Str::limit($record->description, 50)),

                Tables\Columns\TextColumn::make('certification.name')
                    ->label('Subject')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('classroom.name')
                    ->label('Class')
                    ->searchable()
                    ->placeholder('All students')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('due_date')
                    ->label('Due Date')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->color(fn($record) => $record->isOverdue() ? 'danger' : 'success')
                    ->description(fn($record) => $record->isOverdue() ? 'Overdue' : 'Active'),

                Tables\Columns\TextColumn::make('submissions_count')
                    ->label('Submissions')
                    ->counts('submissions')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('max_points')
                    ->label('Points')
                    ->suffix(' pts')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('certification')
                    ->label('Subject')
                    ->relationship('certification', 'name'),
                Tables\Filters\SelectFilter::make('classroom')
                    ->label('Class')
                    ->relationship('classroom', 'name'),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published'),
                Tables\Filters\Filter::make('overdue')
                    ->query(fn($query) => $query->where('due_date', '<', now()))
                    ->label('Overdue'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('due_date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomework::route('/'),
            'create' => Pages\CreateHomework::route('/create'),
            'edit' => Pages\EditHomework::route('/{record}/edit'),
            'view' => Pages\ViewHomework::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $overdueCount = Homework::where('due_date', '<', now())
            ->where('is_published', true)
            ->count();
        
        return $overdueCount > 0 ? (string) $overdueCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}
