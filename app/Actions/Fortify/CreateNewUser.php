<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, mixed>  $input
     */
    public function create(array $input): User
    {
        // Validação dos dados
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:10'],
            'address' => ['required', 'string', 'max:255'],
            'sexo' => ['required', 'in:M,F'],
            'data_nascimento' => ['required', 'date', 'before:' . now()->subYears(16)->format('Y-m-d')],
            'blood_type' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ], [
            'data_nascimento.before' => 'Você precisa ter pelo menos 16 anos para se registrar.',
            'sexo.required' => 'O campo sexo é obrigatório.',
        ])->validate();

        // Upload da imagem de perfil (se existir)
        $imageName = null;
        if (request()->hasFile('image') && request()->file('image')->isValid()) {
            $image = request()->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('donorphotos'), $imageName);
        }

        // Criação do usuário
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'sexo' => $input['sexo'],
            'data_nascimento' => $input['data_nascimento'],
            'blood_type' => $input['blood_type'],
            'password' => Hash::make($input['password']),
            'image' => $imageName,
            'usertype' => '0', // paciente/doador
        ]);
    }
}
