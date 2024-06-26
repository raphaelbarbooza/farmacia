<?php

namespace App\Filament\Resources;

use App\Filament\Imports\BrasindiceImporter;
use App\Filament\Imports\Custom\CustomTableImportAction;
use App\Filament\Imports\Custom\Parsers\SimproParser;
use App\Filament\Imports\SimproImporter;
use App\Filament\Resources\BrasindiceResource\Pages;
use App\Filament\Resources\BrasindiceResource\RelationManagers;
use App\Models\Brasindice;
use Filament\Tables\Actions\ImportAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BrasindiceResource extends Resource
{
    protected static ?string $model = Brasindice::class;

    protected static ?string $pluralLabel = 'Brasindice';

    protected static ?string $navigationGroup = 'Tabelas';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('laboratorio')
                    ->searchable(),
                Tables\Columns\TextColumn::make('produto'),
                Tables\Columns\TextColumn::make('aliquota_id')
                    ->label('Alíquota'),
            ])
            ->headerActions([
                CustomTableImportAction::make()
                    ->importer(BrasindiceImporter::class)
                    ->csvDelimiter(',')
                    ->setCustomForm([
                        Forms\Components\TextInput::make('aliquota_id')
                            ->label('Alíquota')
                            ->required(),
                        Forms\Components\Select::make('tipo_brasindice')
                            ->label('Tipo de Tabela')
                            ->options([
                                1 => 'Medicamento',
                                2 => 'Solução'
                            ])
                            ->required(),
                        Forms\Components\Checkbox::make('restrito_hospital')
                            ->label('Restrito Hospital?'),
                        Forms\Components\TextInput::make('versao_update')
                            ->label('Versão baixada')
                            ->required(),
                    ])
            ])
            ->filters([
                Tables\Filters\Filter::make('rh')
                    ->label('Restrito Hospital')
                    ->toggle(),
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
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
            'index' => Pages\ListBrasindices::route('/'),
            'create' => Pages\CreateBrasindice::route('/create'),
//            'edit' => Pages\EditBrasindice::route('/{record}/edit'),
        ];
    }
}
