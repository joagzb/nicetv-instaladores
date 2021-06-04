<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class preferencia extends Model
{
    use HasFactory;

    protected $table = "preferencias";
    protected $primaryKey = 'id';
    public $incrementing = false; //Indicates if the IDs are auto-incrementing.
    public $timestamps = true;    //Indicates if the model should be timestamped. expects created_at and updated_at tables

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'comision',
        'idadmin_ultima_modificacion',
        'admin_ultima_modificacion',
    ];

    /*
     * cambiar la comision
     * */
    public function setComision($porcentaje,$idAdmin,$nombreAdmin){
        $this->update([
            'comision'=>$porcentaje/100,
            'idadmin_ultima_modificacion'=>$idAdmin,
            'admin_ultima_modificacion'=>$nombreAdmin,
        ]);
    }
}
