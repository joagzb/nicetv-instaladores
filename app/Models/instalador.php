<?php

namespace App\Models;

use App\Traits\clienteTrait;
use App\Traits\instaladorTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class instalador extends Model
{
    use HasFactory;
    use instaladorTrait;
    use clienteTrait;

    protected $table = "instalador";
    protected $primaryKey = 'id';
    public $incrementing = false; //Indicates if the IDs are auto-incrementing.
    public $timestamps = true;    //Indicates if the model should be timestamped. expects created_at and updated_at tables

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'id',
        'habilitado',
        'updated_at',
        'id_admin_responsable_alta',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     */
    protected $casts = [
        'ultimo_reintegro_recaudacion' => 'datetime',
    ];

    /*
     * relaciones
     * */
    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function atenciones()
    {
        return $this->hasMany(Atencion::class);
    }

    public function historial_arreglos()
    {
        return $this->hasMany(historial_arreglos::class);
    }
    public function instalaciones()
    {
        return $this->hasMany(instalacion::class);
    }

    /*
     * obtener el instalador actual
     * */
    public static function getCurrentInstalador()
    {
            $usuario =DB::table('users')->where('id','=',Auth::user()->id)->first();
            $instalador=instalador::all()->find(Auth::user()->id);
            $instalador->usuario=$usuario;
            return $instalador;
    }

    /*
     * obtener los reclamos que ha guardado el instaldor actual
     * */
    public function getCurrentReclamos()
    {
        return $this->allReclamos();
    }

    /*
     * obtener el historial de reclamos atendidos del instalador actual
     * */
    public function getCurrentHistorial()
    {
        return $this->getHistorialInstalador(Auth::user()->id);
    }

    /*
     * obtener el historial de reclamos atendidos del instalador actual
     * */
    public function getDetalleReclamoHistorial($idreclamo)
    {
        return $this->getDetalleHistorial(Auth::user()->id, $idreclamo);
    }

    /*
     * determinar si el instalador actual esta habilitado para continuar sus actividades
     * */
    public function habilitado()
    {
        return $this->isHabilitado(Auth::user()->id);
    }
}
