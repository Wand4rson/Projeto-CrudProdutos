<?php

namespace App\Http\Controllers;


use App\Models\Produto;
use App\Models\ProdutoTag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //Somente Usuários Logados Tem Acesso a Este Controller
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Editar o Usuário Logado
    public function showFormEditarUsuario()
    {
        return view('painel.usuario.usuario_editar');
    }
    
    public function showFormEditarUsuarioAction(Request $request)
    {
                    
       //1º Verifica se existe usuário com o e-mail Informado//
       $update = User::where('email', Auth::user()->email)->first();

       //Existe Email no cadastro ?
       if($update )
       {              

           //2º Verifica se a Senha existente no Usuário compara com a Digitada no Campo Antigo         
          if(Hash::check($request->input('password_old'),$update->password))
          {
              //3º Echo "Senha Digitada Igual a Antiga, Permite mudar a senha pegando a nova senha .<br/>";                
              
              $validacao = $request->validate([                                             
                  'password' => ['required','min:4'],                                    
              ]);
                                          
              $update->password = Hash::make($request->input('password'));
              $update->save();
                  
             //Faz Logoff e Força novo Login
             return redirect()->route('logout');
          
          }
          else
          {
              return redirect()->route('usuario.editar.form')->with(['passEdit'=>'Senha de Usuário não Confere com Antiga. Tente Novamente.']);
          }
          //
      }
      else
      {
          return redirect()->route('usuario.editar.form')->with(['passEdit'=>'E-mail de Usuário não existe em nossa base de dados.']);
      }    
       
     
  }

    //Exibe o Painel Admin Principal
    public function dashboard()
    {
        
        //Listar a Nuvem de Tags e Também a qtde de produtos por TAG do usuario
        $tags = DB::select(DB::raw('SELECT                
            produto_tag.tag_id,
            tag.nome AS nometag,
            COUNT(*) AS produtos_count
        FROM
            produto_tag produto_tag 
        INNER JOIN tag tag ON(tag.id = produto_tag.tag_id)
        WHERE tag.user_id=:userid GROUP BY produto_tag.tag_id, tag.nome'),
        array('userid'=>Auth::user()->id));        


        return view('painel.dashboard', ['tags'=>$tags]);
    }


    public function showListarTags()
    {
        $tags = Tag::paginate(15);
        return view('painel.tag.listar', ['tags'=>$tags]);
    }

    public function showListarProdutos()
    {
        $produtos = Produto::paginate(15);
        return view('painel.produto.listar', ['produtos'=>$produtos]);
    }

    //Exibir View que lista todos os produtos que estão Vinculados a Tag Selecionada
    public function showListarTagsProdutos($idTag)
    {
        $tag = Tag::where('id', $idTag)->where('user_id', Auth::user()->id)->first();

        if($tag)
        {
            
            $produtos = DB::select('SELECT
                produto_tag.produto_id,
                produto_tag.tag_id,
                produto.nome AS nomeproduto,
                tag.nome AS nometag
            FROM
                produto_tag produto_tag 
            INNER JOIN produto produto ON (produto.id = produto_tag.produto_id)
            INNER JOIN tag tag ON(tag.id = produto_tag.tag_id)
            WHERE produto_tag.tag_id =:tagid', ['tagid' => $idTag]);
        
        
            return view('painel.tag.listarprodutos', ['produtos'=>$produtos]);
        }
        else
        {
            return redirect()->route('painel.tag.listar')->with(['ErrorDashboard'=>'Tag selecionado não existe.']);
        }   
    }

    //Exibir View que lista todos as Tags vinculadas ao produto selecionado
    public function showListarProdutosTags($idProd)
    {
        $produto = Produto::where('id', $idProd)->where('user_id', Auth::user()->id)->first();

        if($produto)
        {
            
            $tags = DB::select('SELECT
                produto_tag.produto_id,
                produto_tag.tag_id,
                produto.nome AS nomeproduto,
                tag.nome AS nometag
            FROM
                produto_tag produto_tag 
            INNER JOIN produto produto ON (produto.id = produto_tag.produto_id)
            INNER JOIN tag tag ON(tag.id = produto_tag.tag_id)
            WHERE produto_tag.produto_id =:produtoid', ['produtoid' => $idProd]);
        
        
            return view('painel.produto.listarprodutos', ['tags'=>$tags]);
        }
        else
        {
            return redirect()->route('painel.produto.listar')->with(['ErrorDashboard'=>'Produto selecionado não existe.']);
        }   
    }

    

    public function showFormNovoProduto()
    {
        $tags = Tag::all();
        return view('painel.produto.novo', ['tags'=>$tags]);
    }
    
    public function showFormNovoProdutoAction(Request $request)
    {
        $validacao = $request->validate([           
            'nome' => ['required','min:3'],
        ]);           

        $produto = new Produto();
        $produto->nome = $request->input('nome');
        $produto->user_id = Auth::user()->id;
        $produto->save();
        $idProdutoGravado = $produto->id; //recupera o id do novo produto gravado

        //Grava Tags
        if($request->has('tag')) 
        {
            if (count($request->tag) > 0)
            {
                foreach($request->tag as $key => $tag)
                {
                    $prodtag = new ProdutoTag();
                    $prodtag->produto_id = $idProdutoGravado;
                    $prodtag->tag_id = $key;
                    $prodtag->save();
                }

            }
        }

        return redirect()->route('painel.produto.listar');

    }

    public function showFormEditarProduto($idProd)
    {
        $produto = Produto::where('id', $idProd)->where('user_id', Auth::user()->id)->first();
       
        if($produto)
        {
            

            //Todas as Tags Disponiveis no Cadastro de Tags
            $tags = Tag::all(); 

            //Todas as Tags já selecionadas pelo no Produto
            $tagsEmUso = ProdutoTag::where('produto_id', $idProd)->get();

            
            //Compara as tags existentes e se ja estiver marcada, seta como checked
            foreach($tags as $key => $tag)
            {        
                
                $tagEstaEmUso = ProdutoTag::where('produto_id', $idProd)->where('tag_id', $tag->id)->first();
                
                if($tagEstaEmUso)
                {
                    
                   
                    if($tagEstaEmUso->tag_id === $tag->id)
                    {
                        $tag['checked'] = 'checked';
                    }
                    else
                    {
                        $tag['checked'] = '';
                    }
                    
                  
                }

            }


            //Existe            
            return view('painel.produto.editar', ['produto'=>$produto, 'tags'=>$tags]);
        }
        else
        {
            return redirect()->route('painel.produto.listar')->with(['ErrorDashboard'=>'Produto selecionado não existe.']);
        }        
    }

    public function showFormEditarProdutoAction($id, Request $request)
    {        
        $produto = Produto::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if($produto)
        {            
            $validacao = $request->validate([           
                'nome' => ['required','min:3'],                
            ]);
                                  

            //Existe então edita      
            $produto->nome = $request->input('nome');            
            $produto->save();



            //1º remove todas as existentes e insere as novas
            $tagsAntigas =  ProdutoTag::where('produto_id', $id)->get();
            foreach($tagsAntigas as $remove)
            {
                    $remove->delete();
            }
            
            //Grava Tags Novas
            if($request->has('tag')) 
            {
                if (count($request->tag) > 0)
                {
                    
                    //2º Insere as novas
                    foreach($request->tag as $key => $tag)
                    {
                        $prodtag = new ProdutoTag();
                        $prodtag->produto_id = $id;
                        $prodtag->tag_id = $key;
                        $prodtag->save();
                    }

                }
            }

            return redirect()->route('painel.produto.listar');
        }
        else
        {
            return redirect()->route('painel.produto.listar')->with(['ErrorDashboard'=>'Produto selecionado não existe.']);
        }

    }

    public function showRemoverProdutoAction($id)
    {
        //Encontrou a TAG enviada
        $produto = Produto::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if($produto)
        {

            //1º Verifica se TAG está sendo Usada e não permite Remover
            $produtoEmUso = ProdutoTag::where('produto_id', $produto->id)->get();

            //2º
            if (count($produtoEmUso) > 0) {
                return redirect()->route('painel.produto.listar')->with(['ErrorDashboard'=>'Produto selecionado em uso não pode remover.']);
            }
            
            //3º Tag não está em uso Remover a TAG Remove
            $produto->delete();


            alert()->success('Atenção','Produto removido com sucesso !');


            //6-Recarrega Listagem
            return redirect()->route('painel.produto.listar');
        }
        else
        {
            return redirect()->route('painel.produto.listar')->with(['ErrorDashboard'=>'Produto selecionado não existe.']);
        }
    }
    

    public function showFormNovoTag()
    {
        return view('painel.tag.novo');
    }

    public function showFormNovoTagAction(Request $request)
    {
        $validacao = $request->validate([           
            'nome' => ['required','min:3'],
        ]);
        
        $tag = new Tag();
        $tag->nome = $request->input('nome');
        $tag->user_id = Auth::user()->id;
        $tag->save();

        return redirect()->route('painel.tag.listar');

    }

    public function showFormEditarTag($idTag)
    {
        $tag = Tag::where('id', $idTag)->where('user_id', Auth::user()->id)->first();
       
        if($tag)
        {
            //Existe            
            return view('painel.tag.editar', ['tag'=>$tag]);
        }
        else
        {
            return redirect()->route('painel.tag.listar')->with(['ErrorDashboard'=>'Tag selecionado não existe.']);
        }        
    }

    public function showFormEditarTagAction($id, Request $request)
    {        
        $tag = Tag::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if($tag)
        {            
            $validacao = $request->validate([           
                'nome' => ['required','min:3'],                
            ]);
                        
            //Existe então edita      
            $tag->nome = $request->input('nome');            
            $tag->save();

            return redirect()->route('painel.tag.listar');
        }
        else
        {
            return redirect()->route('painel.tag.listar')->with(['ErrorDashboard'=>'Tag selecionado não existe.']);
        }

    }
    
    public function showRemoverTagAction($id)
    {
        //Encontrou a TAG enviada
        $tag = Tag::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if($tag)
        {

            //1º Verifica se TAG está sendo Usada e não permite Remover
            $tagEmUso = ProdutoTag::where('tag_id', $tag->id)->get();

            //2º
            if (count($tagEmUso) > 0) {
                return redirect()->route('painel.tag.listar')->with(['ErrorDashboard'=>'Tag selecionada em uso não pode remover.']);
            }
            
            //3º Tag não está em uso Remover a TAG Remove
            $tag->delete();


            alert()->success('Atenção','Tag removida com sucesso !');


            //6-Recarrega Listagem
            return redirect()->route('painel.tag.listar');
        }
        else
        {
            return redirect()->route('painel.tag.listar')->with(['ErrorDashboard'=>'Tag selecionada não existe.']);
        }
    }
    

}
