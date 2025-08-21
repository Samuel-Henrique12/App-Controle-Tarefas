<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TarefasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //return Tarefa::all(); aqui pega todas as tarefas

        //filtrar pelo usuario autenticado
        return auth()->user()->tarefas;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Título',
            'Descrição',
            'Usuário',
            'Data Limite',
            'Criado em',
            'Atualizado em',
        ];
    }

    public function map($tarefa): array
    {
        return [
            $tarefa->id,
            $tarefa->titulo,
            $tarefa->descricao,
            $tarefa->user->name,
            date('d/m/Y', strtotime($tarefa->data_limite)),
            date('d/m/Y H:i:s', strtotime($tarefa->created_at)),
            date('d/m/Y H:i:s', strtotime($tarefa->updated_at)),
        ];
    }
}
