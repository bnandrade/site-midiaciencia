<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoImageStoreRequest;
use App\Http\Requests\ProdutoStoreRequest;
use App\Http\Requests\ProdutoUpdateRequest;
use App\Models\Categoria;
use App\Models\Foto;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
                    'fotos' => $produto->fotos,
                    'categoria' => $produto->categoria
                ]),
            'categorias' => Categoria::paginate(20)
                ->through(fn ($categoria) => [
                    'id' => $categoria->id,
                    'capa' => Storage::url($categoria->capa),
                    'slug' => $categoria->slug,
                    'titulo' => $categoria->titulo,
                    'ordem' => $categoria->ordem,
                ]),
        ]);
    }


    public function store(ProdutoStoreRequest $request)
    {
        $data = $request->validated();
        if( !empty($data['capa']) ){
            $data['capa'] = $request->capa->store('public/produtos');
        }

        $data['slug'] = Str::slug($data['titulo'], '-');

        $verificaSlug = Produto::where('slug', $data['slug'])->count();

        if($verificaSlug > 0)
            $data['slug'] = Str::slug($data['titulo'].'-'.date('Y-m-d H:i:s'), '-');

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


    public function store_image(ProdutoImageStoreRequest $request)
    {
        $data = $request->validated();

        foreach ($data['imagem'] as $image){
            $data['imagem'] = Storage::url($image->store('public/produtos/imagens'));
            $produtoImagemStore = Foto::create($data);
        }

        if($produtoImagemStore){
            $request->session()->flash('toast.message', 'Imagem do produto cadastrada com sucesso!');
            $request->session()->flash('toast.style', 'success');
        }else{
            $request->session()->flash('toast.message', 'Ops! Erro ao cadastrar iamgem do produto!');
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

        $produtoUp['categoria_id'] = $data['categoria_id'];
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

    public function destroyImage(Request $request, Foto $produtoImage)
    {
        $produtoImageDestroy = $produtoImage->delete();

        if($produtoImageDestroy){
            $request->session()->flash('toast.message', 'Foto do produto excluído com sucesso!');
            $request->session()->flash('toast.style', 'success');
        }else{
            $request->session()->flash('toast.message', 'Ops! Erro ao excluir foto do produto!');
            $request->session()->flash('toast.style', 'danger');
        }

        return back(303);
    }
}
