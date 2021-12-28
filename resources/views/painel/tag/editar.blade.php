@extends('painel.base')

@section('content')

        <div class="alert alert-primary" role="alert">
            <h3>Editar Tag</h3>
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
        
        
        <form method="POST" action="{{route('painel.tag.editaraction', $tag->id)}}">

            @csrf

            <div class="form-group mb-2">
                <label for="nome">Nome da Tag</label>
                <input type="text" name="nome" class="form-control" value="{{$tag->nome}}" required>  
            </div>

            <button type="submit" class="btn btn-primary">Editar</button>

        </form>


        <br/>
        <br/>
        <a href="{{route('painel.dashboard')}}"  class="btn btn-link">Voltar para Dashboard</a>

@endsection