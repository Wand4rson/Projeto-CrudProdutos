@extends('painel.base')

@section('content')

        <div class="alert alert-primary" role="alert">
            <h3>Lista de Produtos</h3>
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
            <a class="btn btn-primary btn-sm" href="{{route('painel.produto.cadastro')}}" role="button"><i class="fas fa-plus-square"></i> Novo Produto</a>
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

                @foreach($produtos as $produto)
                    <tr>        
                        <td>{{$produto->id}}</td>
                        <td><a href="{{route('painel.produto.listarprodutostag', $produto->id)}}">{{$produto->nome}}</a></td>                                                                
                        <td>
                            <a href="{{route('painel.produto.remover', $produto->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Excluir</a>
                            <a href="{{route('painel.produto.editar', $produto->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Editar</a>	                    			                            
                        </td>
                        
                    </tr>             
                @endforeach

            </tbody>
	        </table>    


            <small>{{'Qtde Registros :'.count($produtos)}}</small>
            {{ $produtos->links() }}



        <br/>
        <br/>
        <a href="{{route('painel.dashboard')}}"  class="btn btn-link">Voltar para Dashboard</a>

@endsection