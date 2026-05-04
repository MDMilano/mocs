<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 5])
                    ->columnSpanFull()
                    ->schema([
                        Group::make()
                            ->columnSpan(['default' => 1, 'lg' => 3])
                            ->schema([
                                Section::make('User Details')
                                    ->columns(2)
                                    ->schema([
                                        Group::make()
                                            ->schema([
                                                FileUpload::make('avatar_url')
                                                    ->label('Avatar')
                                                    ->avatar()
                                                    ->imageEditor()
                                                    ->circleCropper()
                                                    ->disk('public')
                                                    ->acceptedFileTypes(['image/*'])
                                                    ->directory('avatars')
                                                    ->visibility('public')
                                                    ->maxSize(1024)
                                                    ->columnSpanFull()
                                            ]),
                                        Group::make()
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('Full Name')
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('email')
                                                    ->email()
                                                    // ->rules(['email:rfc,dns'])
                                                    ->unique(ignoreRecord: true)
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->helperText('Must be a valid email address. The system will send an email to this address with login credentials.'),
                                            ]),
                                    ]),

                                Section::make('Account Security')
                                    ->visibleOn('create')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Active Account')
                                            ->helperText('Turn this off to instantly suspend the user and lock them out.')
                                            ->default(true),
                                            
                                        Toggle::make('must_change_password')
                                            ->label('Force Password Change')
                                            ->helperText('Require the user to change their password on their next login.')
                                            ->default(true),
                                    ])->columns(2),
                            ])
                            ->columnSpan(['default' => 1, 'lg' => 3]),

                        Section::make('Role Assignment')
                            ->schema([
                                Select::make('roles')
                                    ->relationship('roles', 'name', modifyQueryUsing: fn ($query) => $query->whereNotIn('name', ['admin']))
                                    ->getOptionLabelFromRecordUsing(fn ($record) => ucwords(str_replace('_', ' ', $record->name)))
                                    ->default(fn () => Role::where('name', 'user')->first()->id)
                                    ->preload()
                                    ->required(),
                            ])
                            ->columnSpan(['default' => 1, 'lg' => 2]),
                    ]),
            ]);
    }
}
