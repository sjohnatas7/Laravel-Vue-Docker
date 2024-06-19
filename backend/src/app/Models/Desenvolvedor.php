<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desenvolvedor extends Model
{
    use HasFactory;
    protected $table = "desenvolvedores";
    protected $fillable = [
        'nivel_id',
        'nome',
        'sexo',
        'data_nascimento',
        'idade',
        'hobby'
    ];

    // Definindo o relacionamento com Nivel
    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'nivel_id');
    }

}
