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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Banknotes;

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

    public static function form(Schema $schema): Schema
    {
        return RiwayatDendaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RiwayatDendaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RiwayatDendasTable::configure($table);
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
            'create' => CreateRiwayatDenda::route('/create'),
            'view' => ViewRiwayatDenda::route('/{record}'),
            'edit' => EditRiwayatDenda::route('/{record}/edit'),
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
