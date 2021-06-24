<?php

namespace App\Http\Controllers;

use App\Mail\passwordRecovery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    /*
     * POST - envia el email de recuperacion
     * */
    public function passwordReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        // check if email belongs to an existing account
        $user = User::where('email', '=', $request->input('email'))->first();
        if (!isset($user)) {
            $request->session()->flash('error', 'no existe una cuenta asociada al email ' . $request->input('email'));
        } else {
            $request->session()->flash('ok', 'Se ha enviado un enlace de recuperación a la dirección ' . $request->input('email'));
        }

        //send email
        Mail::to($request->input('email'))
            ->send(new passwordRecovery($user));

        return redirect('/');
    }

    /*
     * VISTA - muestra un formulario para ingresar la nueva contrasena
     * */
    public function showNewPasswordForm(Request $request, $idusuario)
    {
        return view('auth.new_password_input', ['id' => $idusuario]);
    }

    /*
     * POST - guardar la contrasena nueva
     * */
    public function saveNewPassword(Request $request, $idusuario)
    {
        $request->validate([
            'password' => 'required|string|confirmed',
        ]);
        $id = decrypt($idusuario);

        $usuario = User::all()->find($id);
        $usuario->password = Hash::make($request->input('password'));
        $usuario->save();

        $request->session()->flash('ok', 'Se ha establecido una nueva contraseña con éxito');

        return redirect()->route('userProfileSettings');
    }
}
