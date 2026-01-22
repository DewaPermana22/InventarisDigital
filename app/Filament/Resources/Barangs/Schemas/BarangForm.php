<?php

namespace App\Filament\Resources\Barangs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid as ComponentsGrid;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;
use App\Enums\KondisiBarang;

class BarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                ComponentsSection::make('Informasi Barang')
                    ->description(fn(string $operation): string =>
                    $operation === 'create'
                        ? 'Lengkapi semua data'
                        : 'Kode produk tidak dapat diubah setelah dibuat')
                    ->schema([
                        ComponentsGrid::make()

                            ->schema([
                                // Kode Barang - Disabled, auto generate
                                TextInput::make('kode_barang')
                                    ->label('Kode Barang')
                                    ->disabled()
                                    ->dehydrated()
                                    ->placeholder('Otomatis dibuat sistem')
                                    ->helperText('Kode akan dibuat otomatis')
                                    ->columnSpan(1),

                                // Nama Barang - Required
                                TextInput::make('name')
                                    ->label('Nama Barang')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Contoh: Laptop Asus X441')
                                    ->columnSpan(1),

                                // Kategori - Required
                                Select::make('category_id')
                                    ->label('Kategori')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->placeholder('Pilih kategori')
                                    ->columnSpan(1),

                                // Kondisi - Required
                                Select::make('kondisi')
                                    ->label('Kondisi')
                                    ->options(KondisiBarang::class)
                                    ->default(KondisiBarang::BAIK)
                                    ->required()
                                    ->native(false)
                                    ->columnSpan(1),

                                TextInput::make('qty')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->minValue(1)
                                    ->default(1)
                                    ->placeholder('Masukkan jumlah')
                                    ->readonly(fn(string $operation): bool => $operation !== 'create')
                                    ->helperText('Isi dengan angka')
                                    ->required(fn(string $operation): bool => $operation === 'create')
                                    ->dehydrated(fn(?string $state): bool => filled($state))
                                    ->columnSpan(1),

                                // Kategori - Required
                                Select::make('room_id')
                                    ->label('Ruangan')
                                    ->relationship('room', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->placeholder('Pilih Ruangan')
                                    ->columnSpan(1),

                                // Foto - Optional
                                FileUpload::make('foto')
                                    ->label('Foto Barang')
                                    ->image()
                                    ->directory('barangs')
                                    ->maxSize(2048)
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '1:1',
                                        '4:3',
                                        '16:9',
                                    ])
                                    ->imagePreviewHeight('80')
                                    ->panelLayout('integrated')
                                    ->columnSpan(2),
                            ])
                            ->columnSpanFull(),
                        Textarea::make('catatan')
                            ->label('Catatan Tambahan')
                            ->rows(3)
                            ->maxLength(500)
                            ->placeholder('Contoh: Barang baru, masih garansi sampai Desember 2024...')
                            ->helperText('Catatan opsional, maksimal 500 karakter')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
