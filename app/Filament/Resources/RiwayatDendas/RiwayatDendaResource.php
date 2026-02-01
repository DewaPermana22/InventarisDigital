<?php

namespace App\Filament\Resources\RiwayatDendas;

use App\Enums\HakAkses;
use App\Filament\Resources\RiwayatDendas\Pages\CreateRiwayatDenda;
use App\Filament\Resources\RiwayatDendas\Pages\EditRiwayatDenda;
use App\Filament\Resources\RiwayatDendas\Pages\ListRiwayatDendas;
use App\Filament\Resources\RiwayatDendas\Pages\ViewRiwayatDenda;
use App\Filament\Resources\RiwayatDendas\Schemas\RiwayatDendaForm;
use App\Filament\Resources\RiwayatDendas\Schemas\RiwayatDendaInfolist;
use App\Filament\Resources\RiwayatDendas\Tables\RiwayatDendasTable;
use App\Models\PeminjamanBarang;
use App\Models\RiwayatDenda;
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

class RiwayatDendaResource extends Resource
{
    protected static ?string $model = PeminjamanBarang::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::HandCoins;

    public static function canViewAny(): bool
    {
        return Auth::user()?->role == HakAkses::USER;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role == HakAkses::USER;
    }
    protected static string|UnitEnum|null $navigationGroup = "Riwayat";
    protected static ?string $navigationLabel = "Riwayat Denda";
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = "Riwayat Denda";

    public static function table(Table $table): Table
    {
        return RiwayatDendasTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('peminjam_id', Auth::id())
            ->whereHas('verifikasiPengembalian');
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
            'index' => ListRiwayatDendas::route('/'),
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
