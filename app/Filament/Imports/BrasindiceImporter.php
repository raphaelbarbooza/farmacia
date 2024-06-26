<?php

namespace App\Filament\Imports;

use App\Models\Brasindice;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Forms\Components\TextInput;

class BrasindiceImporter extends Importer
{
    protected static ?string $model = Brasindice::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('laboratorio_codigo')
                ->guess(['cod_laboratorio'])
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('laboratorio')
                ->guess(['nome_laboratorio'])
                ->rules(['max:255']),
            ImportColumn::make('produto_codigo')
                ->guess(['codigo_item'])
                ->rules(['max:255']),
            ImportColumn::make('produto')
                ->guess(['nome'])
                ->rules(['max:255']),
            ImportColumn::make('apresentacao_codigo')
                ->guess(['codigo_apresentacao'])
                ->rules(['max:255']),
            ImportColumn::make('apresentacao')
                ->rules(['max:255']),
            ImportColumn::make('pmc')
                ->guess(['preco_pmc'])
                ->rules(['max:255']),
            ImportColumn::make('pfb')
                ->guess(['preco_pfb'])
                ->rules(['max:255']),
            ImportColumn::make('fracao')
                ->guess(['qtd_fracao'])
                ->rules(['max:255']),
            ImportColumn::make('tipo_fracao_pmc')
                ->guess(['pmc'])
                ->rules(['max:255']),
            ImportColumn::make('pmc_fracao')
                ->guess(['preco_fracao_pmc'])
                ->rules(['max:255']),
            ImportColumn::make('tipo_pfb_fracao')
                ->guess(['pfb'])
                ->rules(['max:255']),
            ImportColumn::make('pfb_fracao')
                ->guess(['preco_fracao_pfb'])
                ->rules(['max:255']),
            ImportColumn::make('edicao_alteracao')
                ->guess(['ult_versao'])
                ->rules(['max:255']),
            ImportColumn::make('ipi')
                ->rules(['max:255']),
            ImportColumn::make('portaria')
                ->guess(['pis_cofins'])
                ->rules(['max:255']),
            ImportColumn::make('ean')
                ->rules(['max:255']),
            ImportColumn::make('tiss')
                ->rules(['max:255']),
            ImportColumn::make('generico')
                ->rules(['max:255']),
            ImportColumn::make('tuss')
                ->rules(['max:255']),
            ImportColumn::make('ggrem')
                ->rules(['max:255']),
            ImportColumn::make('registro')
                ->guess(['anvisa'])
                ->rules(['max:255']),
            ImportColumn::make('hierarquia')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?Brasindice
    {
        $aliquota = $this->getOptions()['aliquota_id'];
        $versao_update = $this->getOptions()['versao_update'];
        $tipo_brasindice = $this->getOptions()['tipo_brasindice'];
        $restrito_hospital = $this->getOptions()['restrito_hospital'];

        \DB::beginTransaction();
        try {
            \DB::connection('forge')->statement('CALL farmacia_importacoes.usp_CreateBrasindiceMedicamentos(?)', [$versao_update]);

            //TODO::verificar se os itens ja estão na lista antes de importar.

            $brasindice = new Brasindice();
            $brasindice->setAttribute('aliquota_id', $aliquota);
            $brasindice->setAttribute('versao_update', $versao_update);
            $brasindice->setAttribute('tipo_brasindice', $tipo_brasindice);
            $brasindice->setAttribute('restrito_hospitalar', $restrito_hospital);

            return $brasindice;
        } catch (\Throwable $t) {
            \DB::rollBack();
            dd($t->getMessage());
        }
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your brasindice import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
