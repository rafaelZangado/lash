<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('validCpf', function ($attribute, $value, $parameters, $validator) {
            // Remove pontos e hífens do CPF
            $cpf = str_replace(['.', '-'], '', $value);

            // Realize a validação do CPF aqui (pode usar alguma biblioteca de validação)
            // Retorne true se o CPF for válido e false caso contrário

            return true; // Altere isso com sua lógica de validação real
        });

    }
}
