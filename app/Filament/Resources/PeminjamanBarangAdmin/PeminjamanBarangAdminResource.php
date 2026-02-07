<?php

namespace App\Filament\Resources\PeminjamanBarangAdmin;

use App\Enums\HakAkses;
use App\Enums\StatusPeminjaman;
use App\Filament\Resources\PeminjamanBarangAdmin\Pages\CreatePeminjamanBarangAdmin;
use App\Filament\Resources\PeminjamanBarangAdmin\Pages\ListPeminjamanBarangAdmin;
use App\Filament\Resources\PeminjamanBarangAdmin\Schemas\PeminjamanBarangAdminForm;
use App\Filament\Resources\PeminjamanBarangAdmin\Tables\PeminjamanBarangAdminTable;
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

class PeminjamanBarangAdminResource extends Resource
{
    protected static ?string $model = PeminjamanBarang::class;

   protected static string|BackedEnum|null $navigationIcon = LucideIcon::PackagePlus;
    protected static ?int $navigationSort = 0;
   public static function canViewAny(): bool
    {
        return Auth::user()?->role == HakAkses::ADMIN;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', StatusPeminjaman::DIPINJAM);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role == HakAkses::ADMIN;
    }

    protected static ?string $navigationLabel = "Peminjaman Barang";
    protected static ?string $slug = "loan-management";
    protected static string|UnitEnum|null $navigationGroup = "Aktivitas Peminjaman";

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PeminjamanBarangAdminForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PeminjamanBarangAdminTable::configure($table);
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
            'index' => ListPeminjamanBarangAdmin::route('/'),
            'create' => CreatePeminjamanBarangAdmin::route('/create'),
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
