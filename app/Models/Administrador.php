<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Administrador extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'administradores';
    protected $guard = 'admin';
    protected $fillable = [
        'nome', 
        'email', 
        'senha'
    ];

    protected $hidden = [
        'senha',
        'remember_token'
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function setSenhaAttribute($value)
    {
        $this->attributes['senha'] = bcrypt($value);
    }

}