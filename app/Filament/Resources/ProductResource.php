<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function Laravel\Prompts\textarea;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name_product')
                ->label('Nome do Produto')
                ->required()
                ->maxLength(150),

                Textarea::make('description')
                ->label('Descrição do Produto')
                ->rows(4)
                ->nullable(),

                TextInput::make('price')
                ->label('Preço')
                ->numeric()
                ->prefix('R$')
                ->required(),

                TextInput::make('stock')
                ->label('Quantidade no Estoque')
                ->numeric()
                ->required()
                ->default(0)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_product')
                ->label('Nome')
                ->searchable(),
                TextColumn::make('description')
                ->label('Descrição')
                ->sortable(),
                TextColumn::make('price')
                ->label('Preço')
                ->sortable(),
                TextColumn::make('stock')
                ->label('Estoque')
                ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
