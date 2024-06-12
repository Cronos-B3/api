<?php

return [
    "http_responses" => [
        'unauthorized' => 'Non autorisé',
        'not_found' => 'Non trouvé',
        'method_not_allowed' => 'Méthode non autorisée',
        'forbidden' => 'Interdit',
        'bad_request' => 'Mauvaise requête',
        'unprocessable_entity' => 'Entité non traitable',
        'internal_server_error' => 'Quelque chose a mal tourné'
    ],
    "auth" => [
        "invalid_credentials" => "Identifiant/Mot de passe invalide"
    ],
    "validation"  => [
        'required' => 'Ce champ est obligatoire.',
        'string' => 'Ce champ doit être une chaîne de caractères.',
        'unique' => 'Cette valeur est déjà utilisée.',
        'email' => 'Cette adresse email n\'est pas valide.',
        'confirmed' => 'La confirmation ne correspond pas.',
        'min' => 'Ce champ doit contenir au moins :min caractères.',
        'regex' => 'Ce champ ne respecte pas le format requis.',
        'mixed_case' => 'Le mot de passe doit contenir des lettres majuscules et minuscules.',
        'letters' => 'Le mot de passe doit contenir au moins une lettre.',
        'numbers' => 'Le mot de passe doit contenir au moins un chiffre.',
    ]

];
