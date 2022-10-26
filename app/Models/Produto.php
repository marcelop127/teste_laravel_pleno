<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'loja_id',
        'nome',
        'valor',
        'ativo',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function loja() {
        return $this->belongsTo(Loja::class);
    }
}
