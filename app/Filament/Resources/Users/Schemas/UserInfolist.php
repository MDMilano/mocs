<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(1)
                    // 1. PROFILE SECTION
                    ->schema([
                        Section::make('Profile Information')
                            ->icon('heroicon-o-user')
                            ->columns(4) // Creates a 4-column grid
                            ->schema([
                                // Avatar Image instead of raw text
                                ImageEntry::make('avatar_url')
                                    ->label('Avatar')
                                    ->circular()
                                    ->disk('public')
                                    ->placeholder('No avatar')
                                    ->defaultImageUrl(asset('images/default-avatar.jpg')), // Cool fallback avatar

                                Group::make()
                                    ->columnSpan(3) // Takes up the remaining 3 columns
                                    ->columns(3)
                                    ->schema([
                                        TextEntry::make('name')
                                            ->weight('bold')
                                            ->size(TextSize::Large),

                                        TextEntry::make('email')
                                            ->label('Email address')
                                            ->copyable()
                                            ->copyMessage('Copied!')
                                            ->copyMessageDuration(1500),

                                        TextEntry::make('roles.name')
                                            ->label('System Role')
                                            ->badge()
                                            ->color('primary')
                                            ->formatStateUsing(fn ($state) => ucwords(str_replace('_', ' ', $state)))
                                            ->placeholder('No role assigned'),
                                    ]),
                            ]),

                        // 2. SECURITY SECTION
                        Section::make('Account Security & Status')
                            ->icon('heroicon-o-shield-check')
                            ->columns(['default' => 2, 'sm' => 3])
                            ->schema([
                                TextEntry::make('is_active')
                                    ->label('System Access')
                                    ->icon(fn ($record) => $record->is_active ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                                    ->iconColor(fn ($record) => $record->is_active ? 'success' : 'danger')
                                    ->color(fn ($record) => $record->is_active ? 'success' : 'danger')
                                    ->state(fn ($record) => $record->is_active ? 'Active' : 'Suspended'),
                                    
                                TextEntry::make('must_change_password')
                                    ->label('Password Reset Required')
                                    ->color(fn ($record) => $record->must_change_password ? 'warning' : 'success')
                                    ->state(fn ($record) => $record->must_change_password ? 'Yes (Pending)' : 'No'),

                                TextEntry::make('email_verified_at')
                                    ->label('Email Verification')
                                    ->badge()
                                    ->color(fn ($state) => $state === 'Verified' ? 'success' : 'danger')
                                    ->getStateUsing(fn ($record) => $record->email_verified_at ? 'Verified' : 'Unverified'),

                                TextEntry::make('two_factor_confirmed_at')
                                    ->label('2FA Status')
                                    ->badge()
                                    ->color(fn ($state) => $state === 'Enabled' ? 'success' : 'danger')
                                    ->getStateUsing(fn ($record) => $record->two_factor_confirmed_at ? 'Enabled' : 'Disabled'),

                                TextEntry::make('created_at')
                                    ->label('Account Created')
                                    ->dateTime()
                                    ->icon('heroicon-m-calendar-days')
                                    ->placeholder('-'),
                                    
                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime()
                                    ->icon('heroicon-m-clock')
                                    ->placeholder('-'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
