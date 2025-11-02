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
                Forms\Components\Section::make('Material Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('Title')
                            ->placeholder('e.g., Chapter 5 Notes, Algebra Formulas'),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Brief description of this study material')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('type')
                            ->label('Material Type')
                            ->options([
                                'pdf' => 'PDF Document',
                                'document' => 'Word/Text Document',
                                'video' => 'Video (YouTube/Vimeo)',
                                'link' => 'External Link/Resource',
                                'image' => 'Image/Diagram',
                                'presentation' => 'PowerPoint/Slides',
                                'other' => 'Other',
                            ])
                            ->required()
                            ->reactive()
                            ->helperText('Select the type of study material you want to upload'),
                    ])->columns(2),

                Forms\Components\Section::make('Upload Files or Link')
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->label('Upload File(s)')
                            ->disk('public')
                            ->directory('study_materials')
                            ->multiple()
                            ->preserveFilenames(true)
                            ->visibility('public')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-powerpoint',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                'image/*',
                                'text/*',
                            ])
                            ->maxSize(51200) // 50MB
                            ->visible(fn($get) => in_array($get('type'), ['pdf', 'document', 'image', 'presentation', 'other']))
                            ->helperText('Upload study materials (PDF, Word, PowerPoint, Images). Max 50MB per file.'),

                        Forms\Components\TextInput::make('link_url')
                            ->label('External Link or Video URL')
                            ->url()
                            ->visible(fn($get) => in_array($get('type'), ['link', 'video']))
                            ->placeholder('https://www.youtube.com/watch?v=... or https://example.com')
                            ->helperText('Paste the full URL for videos (YouTube, Vimeo) or external resources'),
                    ]),

                Forms\Components\Section::make('Organization & Access')
                    ->schema([
                        Forms\Components\Select::make('certification_id')
                            ->label('Subject/Course')
                            ->options(Certification::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->helperText('Which subject/course does this material belong to?'),

                        Forms\Components\Select::make('section_id')
                            ->label('Topic/Chapter (Optional)')
                            ->options(Section::pluck('name', 'id'))
                            ->searchable()
                            ->nullable()
                            ->helperText('Optionally assign to a specific topic or chapter'),

                        Forms\Components\Select::make('users')
                            ->label('Assign to Students (Optional)')
                            ->multiple()
                            ->relationship('users', 'name')
                            ->searchable()
                            ->helperText('Leave empty to make available to all students, or select specific students')
                            ->columnSpanFull(),
                    ])->columns(2),
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
                // Show assigned users in a table column
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Assigned Students')
                    ->limit(50) // optional, truncate long names
                    ->wrap(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
