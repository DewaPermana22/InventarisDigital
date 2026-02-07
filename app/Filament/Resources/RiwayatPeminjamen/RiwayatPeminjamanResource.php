<?php

namespace App\Filament\Resources\RiwayatPeminjamen;

use App\Enums\HakAkses;
use App\Enums\StatusPeminjaman;
use App\Filament\Resources\RiwayatPeminjamen\Pages\CreateRiwayatPeminjaman;
use App\Filament\Resources\RiwayatPeminjamen\Pages\EditRiwayatPeminjaman;
use App\Filament\Resources\RiwayatPeminjamen\Pages\ListRiwayatPeminjamen;
use App\Filament\Resources\RiwayatPeminjamen\Pages\ViewRiwayatPeminjaman;
use App\Filament\Resources\RiwayatPeminjamen\Schemas\RiwayatPeminjamanForm;
use App\Filament\Resources\RiwayatPeminjamen\Schemas\RiwayatPeminjamanInfolist;
use App\Filament\Resources\RiwayatPeminjamen\Tables\RiwayatPeminjamenTable;
use App\Models\PeminjamanBarang;
use App\Models\RiwayatPeminjaman;
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

class RiwayatPeminjamanResource extends Resource
{
    protected static ?string $model = PeminjamanBarang::class;
    protected static ?string $slug = "loan-history";
    protected static string|UnitEnum|null $navigationGroup = "Riwayat";
    protected static ?string $label = "Riwayat Peminjaman";

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Clock;
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewAny(): bool
    {
        return Auth::user()?->role == HakAkses::USER;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role == HakAkses::USER;
    }

    public static function infolist(Schema $schema): Schema
    {
        return RiwayatPeminjamanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RiwayatPeminjamenTable::configure($table);
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
            'index' => ListRiwayatPeminjamen::route('/'),
            'view' => ViewRiwayatPeminjaman::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereIn('status', StatusPeminjaman::inactive());
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
