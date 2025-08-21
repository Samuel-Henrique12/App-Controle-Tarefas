<?php

namespace App\Http\Controllers;

use App\Exports\TarefasExport;
use App\Models\Tarefa;
use App\Mail\NovaTarefaMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class TarefaController extends Controller
{
    public function __construct(){
        //$this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $tarefas = Tarefa::where('user_id', $user_id)
            ->paginate(10);
        return view("tarefa.index", compact("tarefas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $regras = [
            'titulo' => 'required|min:3|max:100',
            'descricao' => 'max:500',
            'data_limite' => 'required|date'
        ];

        $feedback = [
            'titulo.required' => 'O campo título é obrigatório.',
            'titulo.min' => 'O título deve ter pelo menos 3 caracteres.',
            'titulo.max' => 'O título não pode ter mais de 100 caracteres.',
            'descricao.max' => 'A descrição não pode ter mais de 500 caracteres.',
            'data_limite.required' => 'A data limite é obrigatória.',
            'data_limite.date' => 'A data limite deve ser uma data válida.'
        ];

        $request->validate($regras, $feedback);

        $existeTarefa = Tarefa::where('titulo', $request->titulo)
            ->where('data_limite', $request->data_limite)
            ->first();

        if ($existeTarefa) {
            return redirect()->back()->with('error', 'Já existe uma tarefa com o mesmo título e data limite.');
        }

        $dados = $request->all();
        $dados['user_id'] = $user_id; // Adiciona o ID do usuário autenticado
        $tarefa = Tarefa::create($dados);

        if ($tarefa) {
            Mail::to(auth()->user()->email)->send(new NovaTarefaMail($tarefa));
        } else {
            return redirect()->back()->with('error', 'Erro ao criar a tarefa. Por favor, tente novamente.');
        }

        return redirect()->route('tarefa.index')->with('success', 'Tarefa criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $decryptId = Crypt::decrypt($id);
        $tarefa = Tarefa::find($decryptId);

        if (!$tarefa) {
            return view('acesso-negado');
        }

        return view('tarefa.show', compact('tarefa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $decryptId = Crypt::decrypt($id);
        $tarefa = Tarefa::find($decryptId)->where('user_id', auth()->user()->id)->first();

        if (!$tarefa) {
            return view('acesso-negado');
        }
        return view('tarefa.edit', compact('tarefa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $regras = [
            'titulo' => 'required|min:3|max:100',
            'descricao' => 'max:500',
            'data_limite' => 'required|date'
        ];

        $feedback = [
            'titulo.required' => 'O campo título é obrigatório.',
            'titulo.min' => 'O título deve ter pelo menos 3 caracteres.',
            'titulo.max' => 'O título não pode ter mais de 100 caracteres.',
            'descricao.max' => 'A descrição não pode ter mais de 500 caracteres.',
            'data_limite.required' => 'A data limite é obrigatória.',
            'data_limite.date' => 'A data limite deve ser uma data válida.'
        ];

        $request->validate($regras, $feedback);

        $tarefa = Tarefa::find($id)->where('user_id', auth()->user()->id)->first();

        // Valida se o usuário autenticado é o dono da tarefa
        if (!$tarefa) {
            return view('acesso-negado');
        }

        $tarefa->fill($request->all());

        $alteracoes = [];
        foreach ($tarefa->getDirty() as $campo => $novoValor) {
            $alteracoes[] = "$campo: \"{$tarefa->getOriginal($campo)}\" → \"$novoValor\"";
        }

        if (empty($alteracoes)) {
            return redirect()->route('tarefa.show', $tarefa->id);
        }

        try {
            $tarefa->save();

            $mensagem = 'Tarefa atualizada com sucesso.<br><strong>Alterações:</strong><br>' . implode('<br>', $alteracoes);

            return redirect()
                ->route('tarefa.show', $tarefa->id)
                ->with('success', $mensagem);
        } catch (\Exception $e) {
            return redirect()
                ->route('tarefa.edit', $tarefa->id)
                ->with('error', 'Erro ao atualizar a tarefa: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $decryptId = Crypt::decrypt($id);
        $tarefa = Tarefa::find($decryptId);

        if($tarefa->user_id !== auth()->user()->id) {
            return view('acesso-negado');
        }

        if ($tarefa) {
            $tarefa->delete();
            return redirect()->route('tarefa.index')->with('success', 'Tarefa excluída com sucesso!');
        } else {
            return redirect()->route('tarefa.index')->with('error', 'Tarefa não encontrada ou já excluída.');
        }
    }

    public function exportacao($extensao)
    {
        $data_hora = now()->format('Ymd_His');
        $nome_arquivo = 'tarefas_' . $data_hora . '.'  . $extensao;

        if(in_array($extensao, ['csv', 'xlsx', 'pdf'])) {
            return Excel::download(new TarefasExport, $nome_arquivo);
        }

        return redirect()->back()->with('error', 'Tipo de exportação inválido.');
    }

    public function exportar()
    {
        $tarefas = auth()->user()->tarefas;
        $pdf = Pdf::loadView('tarefa.pdf', ['tarefas' => $tarefas]);

        // orientação
        $pdf->setPaper('a4', 'landscape');

        // return $pdf->download('tarefas.pdf');
        return $pdf->stream('tarefas.pdf'); // Abre no navegador
    }
}
