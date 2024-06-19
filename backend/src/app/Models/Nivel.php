<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;

    protected $fillable = ['nivel'];

    protected $table = "niveis";

    public function desenvolvedores()
    {
        return $this->hasMany(Desenvolvedor::class, 'nivel_id');
    }
}


