<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaStoreRequest;
use App\Http\Requests\CategoriaUpdateRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Super.Admin|produto-listar|produto-editar|produto-criar|produto-deletar']);
    }

    public function index(Request $request)
    {
        $field = 'titulo';
        $order = 'ASC';


        return Inertia::render('Produtos/CategoriaIndex', [
            'filters' => $request->all('search', 'order'),
            'categorias' => Categoria::paginate(20)
                ->through(fn ($categoria) => [
                    'id' => $categoria->id,
                    'capa' => Storage::url($categoria->capa),
                    'slug' => $categoria->slug,
                    'titulo' => $categoria->titulo,
                    'ordem' => $categoria->ordem,
                    'produtos' => $categoria->produtos
                ]),
        ]);
    }

    public function store(CategoriaStoreRequest $request)
    {
        $data = $request->validated();
        if( !empty($data['capa']) ){
            $data['capa'] = $request->capa->store('public/categorias');
        }

        $data['slug'] = Str::slug($data['titulo'], '-');

        $verificaSlug = Categoria::where('slug', $data['slug'])->count();

        if($verificaSlug > 0)
            $data['slug'] = Str::slug($data['titulo'].'-'.date('Y-m-d H:i:s'), '-');

        $categoriaStore = Categoria::create($data);

        if($categoriaStore){
            $request->session()->flash('toast.message', 'Categoria cadastrada com sucesso!');
            $request->session()->flash('toast.style', 'success');
        }else{
            $request->session()->flash('toast.message', 'Ops! Erro ao cadastrar categoria!');
            $request->session()->flash('toast.style', 'danger');
        }

        return back(303);
    }

    public function update(CategoriaUpdateRequest $request, Categoria $categoria)
    {
        $data = $request->validated();
        $categoriaUp = [];

        if( !empty($data['capa']) && $data['capa']){
            $categoriaUp['capa'] = $request->capa->store('public/categorias');
        }

        $categoriaUp['titulo'] = $data['titulo'];
        $categoriaUp['ordem'] = $data['ordem'];


        $categoriaUpdate = $categoria->update($categoriaUp);


        if($categoriaUpdate){
            $request->session()->flash('toast.message', 'Categoria atualizada com sucesso!');
            $request->session()->flash('toast.style', 'success');
        }else{
            $request->session()->flash('toast.message', 'Ops! Erro ao atualizar categoria!');
            $request->session()->flash('toast.style', 'danger');
        }

        return back(303);
    }

    public function destroy(Request $request, Categoria $categoria)
    {
        $categoriaDestroy = $categoria->delete();

        if($categoriaDestroy){
            $request->session()->flash('toast.message', 'Categoria excluída com sucesso!');
            $request->session()->flash('toast.style', 'success');
        }else{
            $request->session()->flash('toast.message', 'Ops! Erro ao excluir categoria!');
            $request->session()->flash('toast.style', 'danger');
        }

        return Redirect::route('categorias');
    }


}
