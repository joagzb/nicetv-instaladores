<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historial_arreglos extends Model
{
    use HasFactory;

    protected $table ="historial_arreglos";
    protected $primaryKey = 'id';
    public $incrementing = true; //Indicates if the IDs are auto-incrementing.
    public $timestamps = false; //Indicates if the model should be timestamped. expects created_at and updated_at tables

    /*
     * relaciones
     * */
    public function instalador()
    {
        return $this->belongsTo(instalador::class);
    }
}
