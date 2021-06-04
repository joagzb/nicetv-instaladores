<?php

namespace App\Models;

use App\Traits\adminTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class admin extends Model
{
    use HasFactory;
    use adminTrait;

    protected $table ="admin";
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    const LVL_CONTROLADOR = 1;
    const LVL_GESTOR = 2;
    const LVL_SUPERUSUARIO = 3;

    protected $fillable = [
        'id',
        'nivel',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
     * relaciones
     * */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /*
     * obtener el nivel del administrador actual
     * */
    public function getAdminLevel(){
        return admin::find(Auth::user()->id)->nivel;
    }

    /*
     * obtener el administrador actual y sus datos personales
     * */
    public static function getCurrentAdmin(){
        $usuario =Auth::user();
        $admin=admin::all()->find($usuario->id);
        $admin->usuario=$usuario;
        return $admin;
    }
}
