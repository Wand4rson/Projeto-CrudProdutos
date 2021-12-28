    @extends('painel.base')

    @section('content')       
 
        <h2 class="text-center">Estatística de Tags</h2>

        <table class="table table-bordered table-sm table-hover">
            <thead>
                <tr>            
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Qtde Produtos Vinculados</th>                                
                </tr>
            </thead>
            <tbody>

                @foreach($tags as $tag)
                    <tr>        
                        <td>{{$tag->tag_id}}</td>
                        <td><a href="{{route('painel.tag.listarprodutos', $tag->tag_id)}}">{{$tag->nometag}}</a></td>                                                                                                            
                        <td>{{$tag->produtos_count}}</td>
                    </tr>             
                @endforeach

            </tbody>
	        </table>    


            <small>{{'Qtde Registros :'.count($tags)}}</small>

        <br/>
        <br/>
        

    @endsection
