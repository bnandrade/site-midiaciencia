<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'capa',
        'titulo',
        'slug',
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

    public function produtos()
    {
        return $this->hasMany(Produto::class,'categoria_id');
    }

}
