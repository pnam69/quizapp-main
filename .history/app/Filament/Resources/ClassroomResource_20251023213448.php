<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassroomResource\Pages;
use App\Filament\Resources\ClassroomResource\RelationManagers\StudentsRelationManager;
use App\Models\Classroom;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;

    protected static ?string $label = 'Class';
    protected static ?string $pluralLabel = 'Classes';
    protected static ?string $navigationLabel = 'Classes';
    protected static ?string $slug = 'classes';
    protected static ?string $navigationIcon = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('course_year')
                    ->label('Year')
                    ->maxLength(50),
                Forms\Components\Select::make('main_teacher_id')
                    ->label('Main Teacher')
                    ->relationship('mainTeacher', 'name')
                    ->searchable()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Class')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('course_year')->label('Year'),
                Tables\Columns\TextColumn::make('mainTeacher.name')->label('Main Teacher'),
                Tables\Columns\TextColumn::make('students_count')
                    ->counts('students')
                    ->label('Students'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Stack
Context
Debug
Flare
Share
Share with Flare
Docs

Stack

Context

Debug
Create Share
Docs

Ignition Settings
Docs
Editor

PhpStorm
Theme
auto
Save settings
Settings will be saved locally in ~/.ignition.json.

SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quizapp.class_courses' doesn't exist (Connection: mysql, SQL: select `class_courses`.`name`, `class_courses`.`id` from `class_courses` order by `class_courses`.`name` asc)
Illuminate
 \ 
Database
 \ 
QueryException
PHP 8.2.12
10.45.1
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'quizapp.class_courses' doesn't exist
select `class_courses`.`name`, `class_courses`.`id` from `class_courses` order by `class_courses`.`name` asc



Expand vendor frames
153 vendor frames
D:\Android\quizapp1\quizapp-main\quizapp-main\public\index
.php
 
: 51
require_once
1 vendor frame
D:\Android\quizapp1\quizapp-main\quizapp-main\public\index
.php
 
: 51































|

| Composer provides a convenient, automatically generated class loader for

| this application. We just need to utilize it! We'll simply require it

| into the script here so we don't need to manually load our classes.

|

*/



require __DIR__.'/../vendor/autoload.php';



/*

|--------------------------------------------------------------------------

| Run The Application

|--------------------------------------------------------------------------

|

| Once we have the application, we can handle the incoming request using

| the application's HTTP kernel. Then, we will send the response back

| to this client's browser, allowing them to enjoy our application.

|

*/



$app = require_once __DIR__.'/../bootstrap/app.php';



$kernel = $app->make(Kernel::class);



$response = $kernel->handle(

    $request = Request::capture()

)->send();



$kernel->terminate($request, $response);

arguments
$request:Illuminate\Http\Request
GET http://127.0.0.1:8000/admin/quiz-headers

Request
Browser
Headers
Body
App
Routing
Views
Context
User
Versions
Request
http://127.0.0.1:8000/admin/quiz-headers
GET
curl "http://127.0.0.1:8000/admin/quiz-headers" \
   -X GET \
   -H 'host: 127.0.0.1:8000' \
   -H 'connection: keep-alive' \
   -H 'sec-ch-ua: "Brave";v="141", "Not?A_Brand";v="8", "Chromium";v="141"' \
   -H 'sec-ch-ua-mobile: ?0' \
   -H 'sec-ch-ua-platform: "Windows"' \
   -H 'upgrade-insecure-requests: 1' \
   -H 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36' \
   -H 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8' \
   -H 'sec-gpc: 1' \
   -H 'accept-language: en-US,en;q=0.9' \
   -H 'sec-fetch-site: same-origin' \
   -H 'sec-fetch-mode: navigate' \
   -H 'sec-fetch-user: ?1' \
   -H 'sec-fetch-dest: document' \
   -H 'referer: http://127.0.0.1:8000/admin' \
   -H 'accept-encoding: gzip, deflate, br, zstd' \
   -H 'cookie: <CENSORED>';


Browser
Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36

Headers
host
127.0.0.1:8000

connection
keep-alive

sec-ch-ua
"Brave";v="141", "Not?A_Brand";v="8", "Chromium";v="141"

sec-ch-ua-mobile
?0

sec-ch-ua-platform
"Windows"

upgrade-insecure-requests
1

user-agent
Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36

accept
text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8

sec-gpc
1

accept-language
en-US,en;q=0.9

sec-fetch-site
same-origin

sec-fetch-mode
navigate

sec-fetch-user
?1

sec-fetch-dest
document

referer
http://127.0.0.1:8000/admin

accept-encoding
gzip, deflate, br, zstd

cookie
<CENSORED>

Body
[]

App
Routing
Controller
App\Filament\Resources\QuizHeaderResource\Pages\ListQuizHeaders@__invoke

Route name
filament.admin.resources.quiz-headers.index

Middleware
panel:admin

Illuminate\Cookie\Middleware\EncryptCookies

Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse

Illuminate\Session\Middleware\StartSession

Illuminate\Session\Middleware\AuthenticateSession

Illuminate\View\Middleware\ShareErrorsFromSession

Illuminate\Foundation\Http\Middleware\VerifyCsrfToken

Illuminate\Routing\Middleware\SubstituteBindings

Filament\Http\Middleware\DisableBladeIconComponents

Filament\Http\Middleware\DispatchServingFilamentEvent

Jeffgreco13\FilamentBreezy\Middleware\MustTwoFactor

Filament\Http\Middleware\Authenticate

verified:filament.admin.auth.email-verification.prompt

Views
View
D:\Android\quizapp1\quizapp-main\quizapp-main\vendor\filament\forms\resources\views\components\select.blade
.php
Data
Context
User
admin@admin.com
Admin User

admin@admin.com

{
    "id": 1,
    "name": "Admin User",
    "email": "admin@admin.com",
    "is_admin": 1,
    "is_active": 1,
    "email_verified_at": null,
    "last_login": null,
    "current_team_id": null,
    "profile_photo_path": null,
    "created_at": "2025-10-16T03:15:42.000000Z",
    "updated_at": "2025-10-16T03:15:42.000000Z",
    "avatar_url": null,
    "class_course_id": null,
    "age": null,
    "courses": null,
    "breezy_sessions": [],
    "roles": [
        {
            "id": 1,
            "name": "teacher",
            "guard_name": "web",
            "created_at": "2025-10-16T03:16:33.000000Z",
            "updated_at": "2025-10-16T15:52:36.000000Z",
            "pivot": {
                "model_type": "App\\Models\\User",
                "model_id": 1,
                "role_id": 1
            }
        },
        {
            "id": 3,
            "name": "super_admin",
            "guard_name": "web",
            "created_at": "2025-10-17T02:03:26.000000Z",
            "updated_at": "2025-10-17T02:03:26.000000Z",
            "pivot": {
                "model_type": "App\\Models\\User",
                "model_id": 1,
                "role_id": 3
            }
        }
    ],
    "permissions": []
}


Versions
Php Version
8.2.12

Laravel Version
10.45.1

Laravel Locale
en

Laravel Config Cached
false
App Debug
true
App Env
local


10
Queries
9:34:36 PM
3.07ms
mysql
select * from `users` where `id` = 1 limit 1


1 query parameter
9:34:36 PM
0.51ms
mysql
select * from `breezy_sessions` where `breezy_sessions`.`authenticatable_id` in (1) and `breezy_sessions`.`authenticatable_type` = App\Models\User


1 query parameter
9:34:36 PM
0.63ms
mysql
select `roles`.*, `model_has_roles`.`model_id` as `pivot_model_id`, `model_has_roles`.`role_id` as `pivot_role_id`, `model_has_roles`.`model_type` as `pivot_model_type` from `roles` inner join `model_has_roles` on `roles`.`id` = `model_has_roles`.`role_id` where `model_has_roles`.`model_id` in (1) and `model_has_roles`.`model_type` = App\Models\User


1 query parameter
9:34:36 PM
0.63ms
mysql
select `permissions`.*, `model_has_permissions`.`model_id` as `pivot_model_id`, `model_has_permissions`.`permission_id` as `pivot_permission_id`, `model_has_permissions`.`model_type` as `pivot_model_type` from `permissions` inner join `model_has_permissions` on `permissions`.`id` = `model_has_permissions`.`permission_id` where `model_has_permissions`.`model_id` in (1) and `model_has_permissions`.`model_type` = App\Models\User


1 query parameter
9:34:37 PM
0.53ms
mysql
select count(*) as aggregate from `quiz_headers`


9:34:37 PM
0.44ms
mysql
select * from `quiz_headers` order by `quiz_headers`.`id` asc limit 10 offset 0


9:34:37 PM
0.43ms
mysql
select * from `users` where `users`.`id` in (1, 4)


9:34:37 PM
0.36ms
mysql
select * from `breezy_sessions` where `breezy_sessions`.`authenticatable_id` in (1, 4) and `breezy_sessions`.`authenticatable_type` = App\Models\User


1 query parameter
9:34:37 PM
0.33ms
mysql
select * from `sections` where `sections`.`id` in (1)


9:34:37 PM
0.34ms
mysql
select * from `certifications` where `certifications`.`id` in (1)


·
Source
·
Docs
·
Laravel
Ignition is built byFlare, the Laravel error reporting service.::route('/'),
            'create' => Pages\CreateClassroom::route('/create'),
            'view' => Pages\ViewClassroom::route('/{record}'),
            'edit' => Pages\EditClassroom::route('/{record}/edit'),
        ];
    }
}
