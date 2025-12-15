<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Tenant extends Model
{
    use HasUuids;

    protected $guarded = []; // Libera salvar tudo

    // Relação: Uma empresa tem muitos usuários
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
