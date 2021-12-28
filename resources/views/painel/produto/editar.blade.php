@extends('painel.base')

@section('content')

        <div class="alert alert-primary" role="alert">
            <h3>Editar Produto</h3>
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
        
        
        <form method="POST" action="{{route('painel.produto.editaraction', $produto->id)}}">

            @csrf

            <div class="form-group mb-2">
                <label for="nome">Nome do Produto</label>
                <input type="text" name="nome" class="form-control" value="{{$produto->nome}}" required>  
            </div>
            
        
            <br/>
            <p class="text-muted">Selecione as Tags do Produto</p>            
            @foreach($tags as $key => $tag)                                                               
                <div class="form-check">
                    
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        id="tag[{{$tag->id}}]" 
                        name="tag[{{$tag->id}}]"
                        {{$tag->checked}}>


                    <label class="form-check-label" for="tag[{{$tag->id}}]">{{$tag->nome}}</label>
                   
                    

                </div>
            @endforeach            
            <br/>


            <button type="submit" class="btn btn-primary">Editar</button>

        </form>


        <br/>
        <br/>
        <a href="{{route('painel.dashboard')}}"  class="btn btn-link">Voltar para Dashboard</a>

@endsection