<?php

namespace App\Http\Controllers;


use App\Models\Produto;
use App\Models\ProdutoTag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        //Carrega Painel Dasboard com Dados de Tags Estatisticas
        return view('painel.dashboard');
    }


    public function showFormNovoProduto()
    {
        return view('painel.produto.novo');
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

        return redirect()->route('painel.dashboard');

    }

    public function showFormEditarProduto($idProd)
    {
        $produto = Produto::where('id', $idProd)->where('user_id', Auth::user()->id)->first();
       
        if($produto)
        {
            //Existe            
            return view('painel.produto.editar', ['produto'=>$produto]);
        }
        else
        {
            return redirect()->route('painel.dashboard')->with(['ErrorDashboard'=>'Produto selecionado não existe.']);
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

            return redirect()->route('painel.dashboard');
        }
        else
        {
            return redirect()->route('painel.dashboard')->with(['ErrorDashboard'=>'Produto selecionado não existe.']);
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
                return redirect()->route('painel.dashboard')->with(['ErrorDashboard'=>'Produto selecionado em uso não pode remover.']);
            }
            
            //3º Tag não está em uso Remover a TAG Remove
            $produto->delete();


            alert()->success('Atenção','Produto removido com sucesso !');


            //6-Recarrega Listagem
            return redirect()->route('painel.dashboard');
        }
        else
        {
            return redirect()->route('painel.dashboard')->with(['ErrorDashboard'=>'Produto selecionado não existe.']);
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

        return redirect()->route('painel.dashboard');

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
            return redirect()->route('painel.dashboard')->with(['ErrorDashboard'=>'Tag selecionado não existe.']);
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

            return redirect()->route('painel.dashboard');
        }
        else
        {
            return redirect()->route('painel.dashboard')->with(['ErrorDashboard'=>'Tag selecionado não existe.']);
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
                return redirect()->route('painel.dashboard')->with(['ErrorDashboard'=>'Tag selecionada em uso não pode remover.']);
            }
            
            //3º Tag não está em uso Remover a TAG Remove
            $tag->delete();


            alert()->success('Atenção','Tag removida com sucesso !');


            //6-Recarrega Listagem
            return redirect()->route('painel.dashboard');
        }
        else
        {
            return redirect()->route('painel.dashboard')->with(['ErrorDashboard'=>'Tag selecionada não existe.']);
        }
    }
    

}
