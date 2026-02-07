<?php

namespace App\Filament\Resources\KategoriBarangs;

use App\Enums\HakAkses;
use App\Filament\Resources\KategoriBarangs\Pages\CreateKategoriBarang;
use App\Filament\Resources\KategoriBarangs\Pages\EditKategoriBarang;
use App\Filament\Resources\KategoriBarangs\Pages\ListKategoriBarangs;
use App\Filament\Resources\KategoriBarangs\Schemas\KategoriBarangForm;
use App\Filament\Resources\KategoriBarangs\Tables\KategoriBarangsTable;
use App\Models\KategoriBarang;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class KategoriBarangResource extends Resource
{
    protected static ?string $model = KategoriBarang::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $slug = "item-categories";
    protected static ?string $navigationLabel = 'Kategori Barang';
    protected static ?string $breadcrumb = 'Kategori Barang';
    protected static string|UnitEnum|null $navigationGroup = "Inventaris";

    public static function canViewAny(): bool
    {
        return Auth::user()?->role == HakAkses::SUPERADMIN;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->role == HakAkses::SUPERADMIN;
    }

    public static function form(Schema $schema): Schema
    {
        return KategoriBarangForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KategoriBarangsTable::configure($table);
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
            'index' => ListKategoriBarangs::route('/'),
            'create' => CreateKategoriBarang::route('/create'),
            'edit' => EditKategoriBarang::route('/{record}/edit'),
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
