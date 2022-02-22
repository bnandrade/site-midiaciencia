<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'capa',
        'resumo',
        'titulo',
        'slug',
        'texto',
        'ordem',
    ];

    public function scopeOrderByName($query)
    {
        $query->orderBy('titulo');
    }


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('titulo', 'like', '%'.$search.'%');
            });
        });
    }

    public function fotos()
    {
        return $this->hasMany(Foto::class,'produto_id');
    }
}
