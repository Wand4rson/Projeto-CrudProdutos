@extends('painel.base')

@section('content')

        <div class="alert alert-primary" role="alert">
            <h3>Lista Tags Vinculados ao Produto</h3>
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

                @foreach($tags as $tag)
                    <tr>        
                        <td>{{$tag->tag_id}}</td>
                        <td>{{$tag->nometag}}</td>                                                                                                                
                    </tr>             
                @endforeach

            </tbody>
	        </table>    


            <small>{{'Qtde Registros :'.count($tags)}}</small>            



        <br/>
        <br/>
        <a href="{{route('painel.dashboard')}}"  class="btn btn-link">Voltar para Dashboard</a>

@endsection