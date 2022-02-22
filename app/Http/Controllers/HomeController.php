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

}
