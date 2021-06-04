<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atencion extends Model
{
    use HasFactory;

    protected $table ="atencion";
    protected $primaryKey = 'id';
    public $incrementing = true; //Indicates if the IDs are auto-incrementing.
    public $timestamps = true;

    /*
     * relaciones
     * */
    public function instalador()
    {
        return $this->belongsTo(instalador::class);
    }


}
