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
    "validation" => [
        "required" => "La valeure est requise",
        'string' => "La valeure doit etre de type string",
        'unique' => "La valeur existe déjà",
        'email' => "Ceci n'est pas une email",
        'min' => "La valeur entrée est trop petite",
        'confirmed' => "La valeur entrée n'est pas identique"
    ]

];
