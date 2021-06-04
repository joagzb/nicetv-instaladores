<?php

namespace App\Console\Commands;

use App\Models\admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class createAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'crea un nuevo administrador en la plataforma';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = new User();
        $user->name = $this->ask('Ingrese el nombre');
        $user->telefono = '37040000000';
        $user->email = $this->ask('Ingrese el email');
        $nivel = $this->anticipate('Ingrese el nivel del administrador (1:controlador, 2:Gestor , 3:superusuario', [
            '1', '2', '3'
        ]);
        $password_aux = $this->ask('Ingrese el password');
        $user->password = Hash::make($password_aux);
        $user->type = User::USER_ADMIN_TYPE;
        $user->created_at = Carbon::now()->toDateTime();

        $this->info('Resumen de los datos ingresados:');
        $this->info('nombre: ' . $user->name);
        $this->info('email: ' . $user->email);
        $this->info('nivel: ' . $nivel);
        $this->info('contraseña: ' . $password_aux);

        if ($this->confirm('¿Son estos datos correctos?', true)) {
            DB::beginTransaction();
            try {
                $user->saveOrFail();
                $admin = new admin();
                $admin->id = $user->id;
                $admin->nivel = $nivel;
                $admin->created_at = Carbon::now()->toDateTime();
                $admin->saveOrFail();
                DB::commit();
                $this->info('Administrador creado correctamente');
            } catch (Throwable $e) {
                DB::rollBack();
                $this->error("Error. No se ha podido crear al usuario. \n \n");
                $this->error($e->getMessage());
            }
        }
    }
}
