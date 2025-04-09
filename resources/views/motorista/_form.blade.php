@extends('adminlte::page')

@section('title', 'Cadastrar Motorista')

@section('content_header')
    <h1>Novo Motorista</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('motoristas.store') }}" method="POST" id="form-motorista">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="cnh" class="form-label">CNH</label>
                        <input type="text" class="form-control" id="cnh" name="cnh" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="vencimento_cnh" class="form-label">Vencimento da CNH</label>
                        <input type="date" class="form-control" id="vencimento_cnh" name="vencimento_cnh" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="secretaria_id" class="form-label">Secretaria</label>
                        <select class="form-control"  id="secretaria" name="secretaria_id" required>
                            <option value="">Selecione uma Secretaria</option>
                            @foreach ($secretarias as $secretaria)
                                <option value="{{ $secretaria['id'] }}">
                                    {{ $secretaria['nome'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('motoristas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Salvar Motorista</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

@endsection