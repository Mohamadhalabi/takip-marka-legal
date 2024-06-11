<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Language Lines
    |--------------------------------------------------------------------------
    */
    'title' => 'MES IMAGES',
    'warning' => 'Veuillez prendre note des avertissements suivants et réessayer.',
    'add' => 'AJOUTER UNE IMAGE',
    'follow-info' => 'Ajoutez l\'image que vous souhaitez surveiller',
    'info' => 'Les images que vous ajoutez seront analysées dans chaque bulletin de marque publié à partir de la date d\'ajout, et les résultats seront inclus dans les rapports futurs.',

    'input' => [
        'title' => 'Titre',
        'placeholder' => 'Titre de l\'image',
        'file-label' => 'Image',
        'add' => 'Ajouter une image',
    ],

    'list' => 'LISTE DES IMAGES (:count)',

    'items' => [
        'actions' => [
            'edit' => 'Mettre à jour le titre',
            'delete' => 'Supprimer l\'image',
        ],
        'created-at' => 'Date d\'ajout : :date',
    ],

    'models' => [
        'update' => [
            'title' => 'Mettre à jour le titre de l\'image',
            'label' => 'TITRE DE L\'IMAGE',
            'placeholder' => 'Titre de l\'image',
            'close' => 'Fermer',
            'save' => 'Mettre à jour',
        ],
        'delete' => [
            'title' => 'Supprimer l\'image',
            'info' => 'Êtes-vous sûr de vouloir supprimer l\'image intitulée?',
            'close' => 'Fermer',
            'delete' => 'Supprimer',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Search Language Lines
    |--------------------------------------------------------------------------
    */

    'search' => [
        'title' => 'RECHERCHE PAR IMAGE',
        'info' => 'Sélectionnez une image pour effectuer une recherche dans tous les bulletins de marque publiés.',
        'alert' => 'L\'image téléchargée doit être au format <strong>jpg/jpeg</strong>.',
        'form' => [
            'label' => 'Image à rechercher',
            'button' => 'Rechercher par image',
        ],
        'limit' => 'Limite de recherche restante : <strong>:count</strong>',
        'search-history' => 'Historique de recherche (20 dernières)',
        'search-history-info' => 'Vous pouvez voir les images que vous avez précédemment recherchées ici.',

        'result' => [
            'main-image' => [
                'title' => 'Image recherchée',
                'dominant-color' => 'Échelle de similarité de couleur dominante',
            ],
            'main-title' => 'LISTE DES IMAGES',

            'similarity' => 'Similarité',
            'similarity-not-found' => 'Similarité non trouvée.',
            'phash' => 'Correspondance des couleurs',
            'histogram' => 'Similarité des images',
            'dominant-color' => 'Similarité des couleurs dominantes',
            'phash-info' => 'Compare la similarité de votre image recherchée avec les marques dans les bulletins en utilisant des composantes de fréquence représentant le contenu de l\'image.',
            'histogram-info' => 'Extrait l\'échelle de similarité d\'image de votre image recherchée et la compare avec la similarité d\'image des images de marques dans les bulletins pour vous présenter les résultats les plus similaires.',
            'dominant-color-info' => 'Détecte l\'échelle d\'intensité des couleurs de votre image recherchée et la compare avec l\'intensité des couleurs des images de marques dans les bulletins pour vous présenter les résultats les plus similaires.'
        ]
    ]
];