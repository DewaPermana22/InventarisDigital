<?php

namespace App\Filament\Resources\BarangTersedias;

use App\Enums\HakAkses;
use App\Enums\KondisiBarang;
use App\Enums\StatusPeminjaman;
use App\Filament\Resources\BarangTersedias\Pages\CreateBarangTersedia;
use App\Filament\Resources\BarangTersedias\Pages\EditBarangTersedia;
use App\Filament\Resources\BarangTersedias\Pages\ListBarangTersedias;
use App\Filament\Resources\BarangTersedias\Pages\ViewBarangTersedia;
use App\Filament\Resources\BarangTersedias\Schemas\BarangTersediaForm;
use App\Filament\Resources\BarangTersedias\Schemas\BarangTersediaInfolist;
use App\Filament\Resources\BarangTersedias\Tables\BarangTersediasTable;
use App\Models\Barang;
use App\Models\BarangTersedia;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class BarangTersediaResource extends Resource
{
    protected static ?string $model = Barang::class;
    public static function canViewAny(): bool
    {
        return Auth::user()?->role == HakAkses::USER;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role == HakAkses::USER;
    }
    protected static string|UnitEnum|null $navigationGroup = "Aktivitas";
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Cube;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $label = "Barang Tersedia";
    public static function form(Schema $schema): Schema
    {
        return BarangTersediaForm::configure($schema);
    }

    //Filter barang yang sedang tersedia
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('kondisi', KondisiBarang::BAIK)
            ->whereDoesntHave('peminjaman', function (Builder $query) {
                $query->whereNotIn('status', StatusPeminjaman::inactive());
            });
    }
    public static function table(Table $table): Table
    {
        return BarangTersediasTable::configure($table);
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
            'index' => ListBarangTersedias::route('/'),
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
