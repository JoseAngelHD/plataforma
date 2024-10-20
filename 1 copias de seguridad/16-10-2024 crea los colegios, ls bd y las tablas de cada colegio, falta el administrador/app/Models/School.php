<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    // Especificar la tabla en la base de datos principal
    protected $table = 'schools'; // Asegúrate de que el nombre de la tabla coincide con la de la base de datos principal

    protected $fillable = [
        'name',
        'email',
        'subdomain',
        'address',
        'phone',
    ];

    // Relación con el administrador del colegio
    public function admin()
    {
        return $this->hasOne(User::class, 'school_id');
    }
}

