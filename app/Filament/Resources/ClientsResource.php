<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientsResource\Pages;
use App\Filament\Resources\ClientsResource\RelationManagers;
use App\Models\Clients;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientsResource extends Resource
{
    protected static ?string $model = Clients::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('Nome do Cliente')
                ->maxLength(150)
                ->required(),
                TextInput::make('email')
                ->label('Email')
                ->required()
                ->maxLength(200),
                Toggle::make('favorite')
                ->label('Cliente Frequente')
                ->helperText('Ative se esse cliente é frequente!')
                ->default(false),
                TextInput::make('phone')
                ->label('Telefone/Celular')
                ->nullable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label('Nomes')
                ->searchable(),
                TextColumn::make('email')
                ->label('Email')
                ->sortable(),
                IconColumn::make('favorite')
                ->label('Favorito')
                ->boolean(),
                
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClients::route('/create'),
            'edit' => Pages\EditClients::route('/{record}/edit'),
        ];
    }
}
