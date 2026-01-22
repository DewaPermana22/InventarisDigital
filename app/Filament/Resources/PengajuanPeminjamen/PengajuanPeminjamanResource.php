<?php

namespace App\Filament\Resources\PengajuanPeminjamen;

use App\Filament\Resources\PengajuanPeminjamen\Pages\CreatePengajuanPeminjaman;
use App\Filament\Resources\PengajuanPeminjamen\Pages\EditPengajuanPeminjaman;
use App\Filament\Resources\PengajuanPeminjamen\Pages\ListPengajuanPeminjamen;
use App\Filament\Resources\PengajuanPeminjamen\Pages\ViewPengajuanPeminjaman;
use App\Filament\Resources\PengajuanPeminjamen\Schemas\PengajuanPeminjamanForm;
use App\Filament\Resources\PengajuanPeminjamen\Schemas\PengajuanPeminjamanInfolist;
use App\Filament\Resources\PengajuanPeminjamen\Tables\PengajuanPeminjamenTable;
use App\Models\Peminjaman;
use App\Models\PeminjamanBarang;
use App\Models\PengajuanPeminjaman;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengajuanPeminjamanResource extends Resource
{
    protected static ?string $model = PeminjamanBarang::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PengajuanPeminjamanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PengajuanPeminjamanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajuanPeminjamenTable::configure($table);
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
            'index' => ListPengajuanPeminjamen::route('/'),
            'create' => CreatePengajuanPeminjaman::route('/create'),
            'view' => ViewPengajuanPeminjaman::route('/{record}'),
            'edit' => EditPengajuanPeminjaman::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
