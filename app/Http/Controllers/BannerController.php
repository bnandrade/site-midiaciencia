<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerStoreRequest;
use App\Http\Requests\BannerUpdateRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Super.Admin|banner-listar|banner-criar|banner-deletar']);
    }

    public function index(Request $request)
    {
        return Inertia::render('Banners/Index', [
            'banners' => Banner::paginate(10)
                ->through(fn ($banner) => [
                    'id' => $banner->id,
                    'imagem' => Storage::url($banner->imagem),
                    'titulo' => $banner->titulo,
                    'subtitulo' => $banner->subtitulo,
                    'url' => $banner->url,
                ]),
        ]);
    }


    public function store(BannerStoreRequest $request)
    {
        $data = $request->validated();

        if( !empty($data['imagem']) ){
            $data['imagem'] = $request->imagem->store('public/banners');
        }

        $bannerStore = Banner::create($data);

        if($bannerStore){
            $request->session()->flash('toast.message', 'Banner cadastrado com sucesso!');
            $request->session()->flash('toast.style', 'success');
        }else{
            $request->session()->flash('toast.message', 'Ops! Erro ao cadastrar Banner!');
            $request->session()->flash('toast.style', 'danger');
        }

        return back(303);
    }

    public function update(BannerUpdateRequest $request, Banner $banner)
    {
        $data = $request->validated();
        $bannerUp = [];

        if( !empty($data['imagem']) && $data['imagem']){
            $bannerUp['imagem'] = $request->imagem->store('public/banners');
        }

        $bannerUp['titulo'] = $data['titulo'];
        $bannerUp['subtitulo'] = $data['subtitulo'];
        $bannerUp['url'] = $data['url'];


        $bannerUpdate = $banner->update($bannerUp);


        if($bannerUpdate){
            $request->session()->flash('toast.message', 'Banner atualizado com sucesso!');
            $request->session()->flash('toast.style', 'success');
        }else{
            $request->session()->flash('toast.message', 'Ops! Erro ao atualizar banner!');
            $request->session()->flash('toast.style', 'danger');
        }

        return Inertia::location(route('banners'));
    }

    public function destroy(Request $request, Banner $banner)
    {
        $bannerDestroy = $banner->delete();

        if($bannerDestroy){
            $request->session()->flash('toast.message', 'Banner excluído com sucesso!');
            $request->session()->flash('toast.style', 'success');
        }else{
            $request->session()->flash('toast.message', 'Ops! Erro ao excluir banner!');
            $request->session()->flash('toast.style', 'danger');
        }

        return Inertia::location(route('banners'));
    }


}
