<?php

namespace App\Models\Traits;

use App\Models\Scopes\TenantScope;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait BelongsToTenant
{
    // O Laravel chama esse método "boot" automaticamente
    protected static function bootBelongsToTenant(): void
    {
        // 1. Ativa o filtro global
        static::addGlobalScope(new TenantScope);

        // 2. Antes de criar qualquer registro, pega o ID da empresa do usuário logado
        static::creating(function ($model) {
            if (Auth::check() && Auth::user()->tenant_id) {
                $model->tenant_id = Auth::user()->tenant_id;
            }
        });
    }

    // Cria a relação para você poder fazer $produto->tenant->name
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
