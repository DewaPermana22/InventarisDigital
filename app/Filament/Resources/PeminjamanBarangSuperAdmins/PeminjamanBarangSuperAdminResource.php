<?php

namespace App\Filament\Resources\PeminjamanBarangSuperAdmins;

use App\Enums\HakAkses;
use App\Enums\StatusPeminjaman;
use App\Filament\Resources\PeminjamanBarangSuperAdmins\Pages\CreatePeminjamanBarangSuperAdmin;
use App\Filament\Resources\PeminjamanBarangSuperAdmins\Pages\EditPeminjamanBarangSuperAdmin;
use App\Filament\Resources\PeminjamanBarangSuperAdmins\Pages\ListPeminjamanBarangSuperAdmins;
use App\Filament\Resources\PeminjamanBarangSuperAdmins\Schemas\PeminjamanBarangSuperAdminForm;
use App\Filament\Resources\PeminjamanBarangSuperAdmins\Tables\PeminjamanBarangSuperAdminsTable;
use App\Models\PeminjamanBarang;
use App\Models\PeminjamanBarangSuperAdmin;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class PeminjamanBarangSuperAdminResource extends Resource
{
    protected static ?string $model = PeminjamanBarang::class;

   protected static string|BackedEnum|null $navigationIcon = LucideIcon::PackagePlus;
    protected static ?int $navigationSort = 5;
   public static function canViewAny(): bool
    {
        return Auth::user()?->role == HakAkses::SUPERADMIN;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', StatusPeminjaman::DIPINJAM)
        ->where('petugas_id', Auth::id());
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role == HakAkses::SUPERADMIN;
    }

    protected static ?string $navigationLabel = "Peminjaman Barang";

    protected static string|UnitEnum|null $navigationGroup = "Peminjaman";

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PeminjamanBarangSuperAdminForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PeminjamanBarangSuperAdminsTable::configure($table);
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
            'index' => ListPeminjamanBarangSuperAdmins::route('/'),
            'create' => CreatePeminjamanBarangSuperAdmin::route('/create'),
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
