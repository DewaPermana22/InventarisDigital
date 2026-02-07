<?php

namespace App\Filament\Resources\MonitoringPeminjamen;

use App\Enums\HakAkses;
use App\Enums\StatusPeminjaman;
use App\Filament\Resources\MonitoringPeminjamen\Pages\CreateMonitoringPeminjaman;
use App\Filament\Resources\MonitoringPeminjamen\Pages\EditMonitoringPeminjaman;
use App\Filament\Resources\MonitoringPeminjamen\Pages\ListMonitoringPeminjamen;
use App\Filament\Resources\MonitoringPeminjamen\Pages\ViewMonitoringPeminjaman;
use App\Filament\Resources\MonitoringPeminjamen\Schemas\MonitoringPeminjamanForm;
use App\Filament\Resources\MonitoringPeminjamen\Schemas\MonitoringPeminjamanInfolist;
use App\Filament\Resources\MonitoringPeminjamen\Tables\MonitoringPeminjamenTable;
use App\Models\PeminjamanBarang;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class MonitoringPeminjamanResource extends Resource
{
    protected static ?string $model = PeminjamanBarang::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationLabel = "Monitoring Peminjaman";

    protected static ?string $slug = 'loan-monitoring';
    public static function canViewAny(): bool
    {
        return Auth::user()?->role == HakAkses::ADMIN || Auth::user()?->role == HakAkses::SUPERADMIN;
    }
    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role == HakAkses::ADMIN || Auth::user()?->role == HakAkses::SUPERADMIN;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['barang', 'peminjam'])
        ->whereIn('status', StatusPeminjaman::active());
    }

    public static function infolist(Schema $schema): Schema
    {
        return MonitoringPeminjamanInfolist::configure($schema);
    }

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::PackageSearch;


    public static function table(Table $table): Table
    {
        return MonitoringPeminjamenTable::configure($table);
    }

        protected static ?string $label = "Monitoring Peminjaman";


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMonitoringPeminjamen::route('/'),
            'view' => ViewMonitoringPeminjaman::route('/{record}'),
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
