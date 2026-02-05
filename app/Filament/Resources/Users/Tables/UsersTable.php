<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\HakAkses;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Data akun masih kosong')
            ->emptyStateDescription('Tambahkan akun untuk mulai menggunakan sistem.')
            ->columns([
                ImageColumn::make('profile_pict')
                    ->circular()
                    ->extraImgAttributes([
                        'alt' => 'Logo',
                        'loading' => 'lazy'
                    ])
                    ->label('Foto')
                    ->getStateUsing(function ($record) {
                        return $record->profile_pict ?? 'images/default_pp.jpg';
                    })
                    ->defaultImageUrl(asset('images/default_pp.jpg')),

                TextColumn::make('name')
                    ->searchable()
                    ->label('Nama')
                    ->copyable()
                    ->formatStateUsing(fn($state) => Str::limit($state, 20))
                    ->tooltip(fn($state) => $state)
                    ->copyMessage('Nama pengguna disalin!')
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->formatStateUsing(fn($state) => Str::limit($state, 20))
                    ->tooltip(fn($state) => $state)
                    ->copyMessage('Email pengguna disalin!')
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('role')
                    ->label('Hak Akses')
                    ->badge()
                    ->sortable()
                    ->color(fn(HakAkses $state): string => match ($state) {
                        HakAkses::SUPERADMIN => 'success',
                        HakAkses::ADMIN => 'warning',
                        HakAkses::USER => 'danger',
                    })
                    ->formatStateUsing(fn(HakAkses $state): string => $state->label()),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Hak Akses')
                    ->options(HakAkses::class),

                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        '1' => 'Aktif',
                        '0' => 'Tidak Aktif',
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()->color('warning'),
                    ViewAction::make()->color(Color::Indigo),
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('cetakKartu')
                        ->label('Cetak Kartu')
                        ->icon(LucideIcon::IdCard)
                        ->color(Color::Indigo)
                        ->action(function ($records) {
                            if ($records->count() > 4) {
                                Notification::make()
                                    ->title('Batas Maksimal Terlampaui')
                                    ->body('Maksimal hanya 4 kartu yang dapat dicetak dalam satu aksi.')
                                    ->danger()
                                    ->send();

                                return;
                            }
                            $ids = $records->pluck('id')->implode(',');

                            return redirect()->route('kartu.download', [
                                'ids' => explode(',', $ids),
                            ]);
                        })
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
