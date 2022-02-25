<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Categoria;
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
        $bannerTitulo = '';
        $bannerSubtitulo = '';
        $bannerUrl = '';
        if($banner){
            $bannerImagem = Storage::url($banner->imagem);
            $bannerTitulo = $banner->titulo;
            $bannerSubtitulo = $banner->subtitulo;
            $bannerUrl = $banner->url;
        }

        return Inertia::render('Home', [
            'filters' => $request->all('search', 'order'),
            'bannerImagem' => $bannerImagem,
            'bannerTitulo' => $bannerTitulo,
            'bannerSubtitulo' => $bannerSubtitulo,
            'bannerUrl' => $bannerUrl,
            'categorias' => Categoria::orderBy('ordem', 'asc')->get()->map(function ($categoria) {
                return [
                    'id' => $categoria->id,
                    'capa' => Storage::url($categoria->capa),
                    'titulo' => $categoria->titulo,
                    'resumo' => $categoria->resumo,
                    'texto' => $categoria->texto,
                    'slug' => $categoria->slug,
                    'ordem' => $categoria->ordem,
                    'produtos' => $categoria->produtos,
                ];

            }),
            'produtos' => Produto::orderBy('ordem', 'asc')->get()->map(function ($produto) {
                return [
                    'id' => $produto->id,
                    'capa' => Storage::url($produto->capa),
                    'titulo' => $produto->titulo,
                    'slug' => $produto->slug,
                    'resumo' => $produto->resumo,
                    'texto' => $produto->texto,
                    'ordem' => $produto->ordem,
                    'fotos' => $produto->fotos,
                ];

            }),
        ]);
    }

    public function detalhes($slug)
    {

        return Inertia::render('Detalhes', [
            'categoria' => Categoria::where('slug', $slug)->get()->map(function ($categoria) {
                return [
                    'id' => $categoria->id,
                    'capa' => Storage::url($categoria->capa),
                    'titulo' => $categoria->titulo,
                    'resumo' => $categoria->resumo,
                    'texto' => $categoria->texto,
                    'slug' => $categoria->slug,
                    'ordem' => $categoria->ordem,
                    'produtos' => $categoria->produtos,
                ];

            }),
            'produto' => Produto::where('slug', $slug)->get()->map(function ($produto) {
                return [
                    'id' => $produto->id,
                    'capa' => Storage::url($produto->capa),
                    'titulo' => $produto->titulo,
                    'slug' => $produto->slug,
                    'resumo' => $produto->resumo,
                    'texto' => $produto->texto,
                    'ordem' => $produto->ordem,
                    'fotos' => $produto->fotos,
                ];

            }),

        ]);
    }

    public function detalhes_produto($slug)
    {

        return Inertia::render('DetalhesProduto', [

            'produto' => Produto::where('slug', $slug)->get()->map(function ($produto) {
                return [
                    'id' => $produto->id,
                    'categoria' => $produto->categoria,
                    'capa' => Storage::url($produto->capa),
                    'titulo' => $produto->titulo,
                    'slug' => $produto->slug,
                    'resumo' => $produto->resumo,
                    'texto' => $produto->texto,
                    'ordem' => $produto->ordem,
                    'fotos' => $produto->fotos,
                ];

            }),

        ]);
    }


}
