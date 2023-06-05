<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    //RELACIONAMENTOS
    public function procedimento()
    {
        return $this->belongsTo(Procedimento::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

}
