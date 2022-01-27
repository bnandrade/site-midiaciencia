<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoStoreRequest;
use App\Http\Requests\ProdutoUpdateRequest;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProdutoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Super.Admin|produto-listar|produto-editar|produto-criar|produto-deletar']);
    }

    public function index(Request $request)
    {
        $field = 'titulo';
        $order = 'ASC';


        return Inertia::render('Produtos/Index', [
            'filters' => $request->all('search', 'order'),
            'produtos' => Produto::paginate(20)
                ->through(fn ($produto) => [
                    'id' => $produto->id,
                    'capa' => Storage::url($produto->capa),
                    'titulo' => $produto->titulo,
                    'resumo' => $produto->resumo,
                    'texto' => $produto->texto,
                    'ordem' => $produto->ordem,
                ]),
        ]);
    }


    public function store(ProdutoStoreRequest $request)
    {
        $data = $request->validated();
        if( !empty($data['capa']) ){
            $data['capa'] = $request->capa->store('public/produtos');
        }

        $produtoStore = Produto::create($data);

        if($produtoStore){
            $request->session()->flash('toast.message', 'produto cadastrado com sucesso!');
            $request->session()->flash('toast.style', 'success');
        }else{
            $request->session()->flash('toast.message', 'Ops! Erro ao cadastrar produto!');
            $request->session()->flash('toast.style', 'danger');
        }

        return back(303);
    }

    public function update(ProdutoUpdateRequest $request, Produto $produto)
    {
        $data = $request->validated();
        $produtoUp = [];

        if( !empty($data['capa']) && $data['capa']){
            $produtoUp['capa'] = $request->capa->store('public/produtos');
        }

        $produtoUp['titulo'] = $data['titulo'];
        $produtoUp['resumo'] = $data['resumo'];
        $produtoUp['texto'] = $data['texto'];
        $produtoUp['ordem'] = $data['ordem'];


        $produtoUpdate = $produto->update($produtoUp);


        if($produtoUpdate){
            $request->session()->flash('toast.message', 'produto atualizado com sucesso!');
            $request->session()->flash('toast.style', 'success');
        }else{
            $request->session()->flash('toast.message', 'Ops! Erro ao atualizar produto!');
            $request->session()->flash('toast.style', 'danger');
        }

        return Inertia::location(route('produtos'));
    }

    public function destroy(Request $request, Produto $produto)
    {
        $produtoDestroy = $produto->delete();

        if($produtoDestroy){
            $request->session()->flash('toast.message', 'produto excluído com sucesso!');
            $request->session()->flash('toast.style', 'success');
        }else{
            $request->session()->flash('toast.message', 'Ops! Erro ao excluir produto!');
            $request->session()->flash('toast.style', 'danger');
        }

        return Redirect::route('produtos');
    }
}
