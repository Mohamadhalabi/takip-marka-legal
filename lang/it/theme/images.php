<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Language Lines
    |--------------------------------------------------------------------------
    */
    'title' => 'LE MIE IMMAGINI',
    'warning' => 'Fai attenzione ai seguenti avvisi e riprova.',
    'add' => 'AGGIUNGI IMMAGINE',
    'follow-info' => 'Aggiungi l\'immagine che desideri monitorare',
    'info' => 'Le immagini che aggiungi verranno scansionate in tutti i bollettini dei marchi pubblicati a partire dalla data di aggiunta, e i risultati saranno inclusi nei futuri rapporti.',

    'input' => [
        'title' => 'Titolo',
        'placeholder' => 'Titolo dell\'immagine',
        'file-label' => 'Immagine',
        'add' => 'Aggiungi Immagine',
    ],

    'list' => 'LISTA IMMAGINI (:count)',

    'items' => [
        'actions' => [
            'edit' => 'Aggiorna Titolo',
            'delete' => 'Elimina Immagine',
        ],
        'created-at' => 'Data Aggiunta: :date',
    ],

    'models' => [
        'update' => [
            'title' => 'Aggiorna Titolo Immagine',
            'label' => 'TITOLO IMMAGINE',
            'placeholder' => 'Titolo dell\'immagine',
            'close' => 'Chiudi',
            'save' => 'Aggiorna',
        ],
        'delete' => [
            'title' => 'Elimina Immagine',
            'info' => 'Sei sicuro di voler eliminare l\'immagine intitolata?',
            'close' => 'Chiudi',
            'delete' => 'Elimina',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Search Language Lines
    |--------------------------------------------------------------------------
    */

    'search' => [
        'title' => 'RICERCA PER IMMAGINE',
        'info' => 'Seleziona un\'immagine per cercare in tutti i bollettini dei marchi pubblicati.',
        'alert' => 'L\'immagine caricata deve essere in formato <strong>jpg/jpeg</strong>.',
        'form' => [
            'label' => 'Immagine da cercare',
            'button' => 'Cerca per Immagine',
        ],
        'limit' => 'Limite ricerche rimanenti: <strong>:count</strong>',
        'search-history' => 'Cronologia Ricerche (Ultimi 20)',
        'search-history-info' => 'Qui puoi vedere le immagini che hai cercato in precedenza.',

        'result' => [
            'main-image' => [
                'title' => 'Immagine Ricercata',
                'dominant-color' => 'Scala di Similarità del Colore Dominante',
            ],
            'main-title' => 'LISTA IMMAGINI',

            'similarity' => 'Similarità',
            'similarity-not-found' => 'Similarità non trovata.',
            'phash' => 'Corrispondenza Colore',
            'histogram' => 'Similarità Immagine',
            'dominant-color' => 'Similarità Colore Dominante',
            'phash-info' => 'Confronta la similarità della tua immagine cercata con i marchi presenti nei bollettini utilizzando componenti di frequenza che rappresentano il contenuto dell\'immagine.',
            'histogram-info' => 'Estrae la scala di similarità dell\'immagine della tua immagine cercata e la confronta con la similarità dell\'immagine delle immagini dei marchi nei bollettini per presentarti i risultati più simili.',
            'dominant-color-info' => 'Rileva la scala di intensità del colore della tua immagine cercata e la confronta con l\'intensità del colore delle immagini dei marchi nei bollettini per presentarti i risultati più simili.'
        ]
    ]
];