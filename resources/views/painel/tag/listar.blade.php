@extends('painel.base')

@section('content')

        <div class="alert alert-primary" role="alert">
            <h3>Lista de Tags</h3>
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
    
        <br/>
            <a class="btn btn-primary btn-sm" href="{{route('painel.tag.cadastro')}}" role="button"><i class="fas fa-plus-square"></i> Nova TAG</a>
        <br/>
        <br/>

        <table class="table table-bordered table-sm table-hover">
            <thead>
                <tr>            
                <th scope="col">#</th>
                <th scope="col">Nome</th>                
                <th scope="col">Ações </th>
                </tr>
            </thead>
            <tbody>

                @foreach($tags as $tag)
                    <tr>        
                        <td>{{$tag->id}}</td>
                        <td><a href="{{route('painel.tag.listarprodutos', $tag->id)}}">{{$tag->nome}}</a></td>                                                                
                        <td>
                            <a href="{{route('painel.tag.remover', $tag->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Excluir</a>
                            <a href="{{route('painel.tag.editar', $tag->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Editar</a>	                    			                            
                        </td>
                        
                    </tr>             
                @endforeach

            </tbody>
	        </table>    


            <small>{{'Qtde Registros :'.count($tags)}}</small>
            {{ $tags->links() }}



        <br/>
        <br/>
        <a href="{{route('painel.dashboard')}}"  class="btn btn-link">Voltar para Dashboard</a>

@endsection