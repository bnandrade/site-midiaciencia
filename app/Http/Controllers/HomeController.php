<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Projeto;
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
        $bannerImagem = Storage::url($banner->imagem);

        return Inertia::render('Home', [
            'filters' => $request->all('search', 'order'),
            'banner' => $bannerImagem,
            'projetos' => Projeto::orderByName()
                ->orderBy($field, $order)
                ->filter($request->only('search', 'order'))
                ->paginate(20)
                ->withQueryString()
                ->through(fn ($projeto) => [
                    'id' => $projeto->id,
                    'titulo' => $projeto->titulo,
                    'instituicao' => $projeto->instituicao,
                    'cidade' => $projeto->cidade,
                    'coordenador' => $projeto->coordenador,
                    'bolsistas' => $projeto->bolsistas,
                    'ano' => $projeto->ano,
                    'resumo' => $projeto->resumo,
                    'url_video' => $projeto->url_video,
                    'url_foto' => $projeto->url_foto,
                ]),
        ]);
    }

    public function detalhes($id)
    {
        $projeto = Projeto::where('id', $id)->first();

        return Inertia::render('Detalhes', [
            'projeto' => $projeto,
        ]);
    }

}
