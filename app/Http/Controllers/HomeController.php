<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Numero;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $field = 'titulo';
        $order = 'ASC';

        $banner = Banner::orderBy('id', 'desc')->limit('1')->first();
        $bannerImagem = '';
        if($banner){
            $bannerImagem = Storage::url($banner->imagem);
        }

        return Inertia::render('Home', [
            'filters' => $request->all('search', 'order'),
            'banner' => $bannerImagem,
            'produtos' => Produto::orderByName()
                ->orderBy($field, $order)
                ->filter($request->only('search', 'order'))
                ->paginate(20)
                ->withQueryString()
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

    public function detalhes($id)
    {

        return Inertia::render('Detalhes', [
            'projeto' => Produto::where('id', $id)->get()->map(function ($projeto) {
                return [
                    'id' => $projeto->id,
                    'capa' => Storage::url($projeto->capa),
                    'titulo' => $projeto->titulo,
                    'instituicao' => $projeto->instituicao,
                    'cidade' => $projeto->cidade,
                    'coordenador' => $projeto->coordenador,
                    'bolsistas' => $projeto->bolsistas,
                    'ano' => $projeto->ano,
                    'resumo' => $projeto->resumo,
                    'url_video' => $projeto->url_video,
                    'url_foto' => $projeto->url_foto,
                ];

            }),

        ]);
    }

}
