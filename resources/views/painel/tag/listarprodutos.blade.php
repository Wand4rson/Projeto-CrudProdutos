@extends('painel.base')

@section('content')

        <div class="alert alert-primary" role="alert">
            <h3>Lista de Produtos Vinculados a TAG</h3>
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

        <table class="table table-bordered table-sm table-hover">
            <thead>
                <tr>            
                <th scope="col">#</th>
                <th scope="col">Nome</th>                                
                </tr>
            </thead>
            <tbody>

                @foreach($produtos as $produto)
                    <tr>        
                        <td>{{$produto->produto_id}}</td>
                        <td>{{$produto->nomeproduto}}</td>                                                                                                                
                    </tr>             
                @endforeach

            </tbody>
	        </table>    


            <small>{{'Qtde Registros :'.count($produtos)}}</small>            



        <br/>
        <br/>
        <a href="{{route('painel.dashboard')}}"  class="btn btn-link">Voltar para Dashboard</a>

@endsection