<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Filament\Facades\Filament;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        // Só aplica o filtro se tiver alguém logado no painel
        // E se não for um comando rodando no terminal (para evitar erros em migrations)
        if (Auth::hasUser()) {
            $user = Auth::user();

            // Se o usuário tiver uma empresa, filtra tudo por ela
            if ($user->tenant_id) {
                $builder->where('tenant_id', $user->tenant_id);
            }
        }
    }
}
