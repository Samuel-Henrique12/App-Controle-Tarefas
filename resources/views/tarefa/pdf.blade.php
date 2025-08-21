<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #fff;
            padding: 0;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        h2 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            color: #2d3748;
        }
        table {
            width: 100%;
            background: #fff;
            border-radius: 0.5rem;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            padding: 0.5rem 0.7rem;
            text-align: left;
        }
        th {
            background: #e5e7eb;
            color: #4b5563;
            font-weight: 600;
        }
        tr {
            border-bottom: 1px solid #e5e7eb;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
<h2>Lista de Tarefas</h2>
<table>
    <thead>
    <tr>
        <th style="font-weight: bold;">ID</th>
        <th>Título</th>
        <th>Descrição</th>
        <th>Data Limite</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tarefas as $tarefa)
        <tr>
            <td style="font-weight: bold;">{{ $tarefa->id }}</td>
            <td>{{ $tarefa->titulo }}</td>
            <td>{{ $tarefa->descricao }}</td>
            <td>{{ date('d/m/Y', strtotime($tarefa->data_limite)) }}</td>
        </tr>
    @endforeach
    <h1>Página 1</h1>
    <div class="page-break"></div>
    <h1>Página 2</h1>
    </tbody>
</table>
</body>
</html>
