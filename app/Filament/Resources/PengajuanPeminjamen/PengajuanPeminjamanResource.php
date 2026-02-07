<?php

namespace App\Filament\Resources\PengajuanPeminjamen;

use App\Enums\HakAkses;
use App\Enums\StatusPeminjaman;
use App\Filament\Resources\PengajuanPeminjamen\Pages\ListPengajuanPeminjamen;
use App\Filament\Resources\PengajuanPeminjamen\Schemas\PengajuanPeminjamanForm;
use App\Filament\Resources\PengajuanPeminjamen\Schemas\PengajuanPeminjamanInfolist;
use App\Filament\Resources\PengajuanPeminjamen\Tables\PengajuanPeminjamenTable;
use App\Models\PeminjamanBarang;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class PengajuanPeminjamanResource extends Resource
{
    protected static ?string $model = PeminjamanBarang::class;
    public static function canViewAny(): bool
    {
        return Auth::user()?->role == HakAkses::ADMIN;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role == HakAkses::ADMIN;
    }

    protected static ?int $navigationSort = 1;
    protected static string|BackedEnum|null $navigationIcon = LucideIcon::ClipboardClock;
    protected static ?string $slug= "loan-requests";
    protected static string|UnitEnum|null $navigationGroup = "Aktivitas Peminjaman";
    protected static ?string $navigationLabel = "Pengajuan Peminjaman";
    public static function getBreadcrumb(): string
    {
        return "Pengajuan Peminjaman";
    }
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
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('status', StatusPeminjaman::BELUM_DISETUJUI)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
