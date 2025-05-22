<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Linhas de linguagem de validação
    |--------------------------------------------------------------------------
    |
    | As seguintes linhas de idioma contêm as mensagens de erro padrão usadas
    | pelo validador. Algumas dessas regras têm várias versões, como as regras
    | de tamanho. Sinta-se à vontade para ajustar essas mensagens conforme necessário.
    |
    */

    'required' => 'O campo :attribute é obrigatório.',
    'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'url' => 'O campo :attribute deve ser uma URL válida.',
    'string' => 'O campo :attribute deve ser uma sequência de caracteres.',
    'max' => [
        'string' => 'O campo :attribute não pode ter mais que :max caracteres.',
    ],
    'min' => [
        'string' => 'O campo :attribute deve ter no mínimo :min caracteres.',
    ],
    'unique' => 'O :attribute informado já está em uso.',
    'confirmed' => 'A confirmação do campo :attribute não confere.',
    'date' => 'O campo :attribute deve ser uma data válida.',
    'in' => 'O campo :attribute contém um valor inválido.',

    /*
    |--------------------------------------------------------------------------
    | Atributos personalizados
    |--------------------------------------------------------------------------
    |
    | As linhas a seguir são usadas para trocar os nomes dos atributos pelos
    | nomes mais amigáveis aos usuários.
    |
    */

    'attributes' => [
        'nome' => 'nome',
        'email' => 'e-mail',
        'telefone' => 'telefone',
        'data_nascimento' => 'data de nascimento',
        'sexo' => 'sexo',
        'disability_type' => 'tipo de deficiência',
        'password' => 'senha',
        'interest_area' => 'área de interesse',
        'linkedin' => 'LinkedIn',
        'work_availability' => 'disponibilidade para trabalho',
    ],

];
