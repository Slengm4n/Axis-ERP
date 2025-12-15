<?php

namespace App\Filament\Pages\Auth;

use App\Models\Tenant;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                // Campo Novo: Nome da Empresa
                TextInput::make('company_name')
                    ->label('Nome da Empresa')
                    ->required()
                    ->maxLength(255),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function handleRegistration(array $data): User
    {
        return DB::transaction(function () use ($data) {
            // 1. Cria a Empresa
            $tenant = Tenant::create([
                'name' => $data['company_name'],
                'subscription_status' => 'Active', // Valor padrão do seu Enum
                'cnpj_cpf' => '00000000000', // Valor temporário para não quebrar (ou adicione campo no form)
                'trade_name' => $data['company_name'],
            ]);

            // 2. Cria o Dono
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'tenant_id' => $tenant->id,
                'role' => 'owner',
            ]);
        });
    }
}
