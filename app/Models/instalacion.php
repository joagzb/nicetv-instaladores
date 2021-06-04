<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instalacion extends Model
{
    use HasFactory;

    protected $table = "instalacion";
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;


    /*
     * relaciones
     * */
    public function instalador()
    {
        return $this->belongsTo(instalador::class);
    }
}
