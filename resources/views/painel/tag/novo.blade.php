@extends('painel.base')

@section('content')

        <div class="alert alert-primary" role="alert">
            <h3>Criar Nova Tag</h3>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $erro)
                <li>{{$erro}}</li>
                @endforeach
            </ul>
            </div>
        @endif
        
        <form method="POST" action="{{route('painel.tag.cadastroaction')}}">

            @csrf
            
            <div class="form-group mb-2">
                <label for="nome">Nome da Tag</label>
                <input type="text" name="nome" class="form-control" value="{{old('nome')}}" required>  
            </div>
            
            <button type="submit" class="btn btn-primary">Salvar</button>

        </form>

        <br/>
        <br/>
        <a href="{{route('painel.dashboard')}}"  class="btn btn-link">Voltar para Dashboard</a>

@endsection