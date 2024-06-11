<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Language Lines
    |--------------------------------------------------------------------------
    */
    'title' => 'MEINE BILDER',
    'warning' => 'Bitte beachten Sie die folgenden Warnungen und versuchen Sie es erneut.',
    'add' => 'BILD HINZUFÜGEN',
    'follow-info' => 'Fügen Sie das Bild hinzu, das Sie überwachen möchten.',
    'info' => 'Die von Ihnen hinzugefügten Bilder werden in jedem veröffentlichten Markenbulletin ab dem Hinzufügedatum gescannt und die Ergebnisse werden in zukünftigen Berichten enthalten sein.',

    'input' => [
        'title' => 'Titel',
        'placeholder' => 'Bildtitel',
        'file-label' => 'Bild',
        'add' => 'Bild hinzufügen',
    ],

    'list' => 'BILDERLISTE (:count)',

    'items' => [
        'actions' => [
            'edit' => 'Titel aktualisieren',
            'delete' => 'Bild löschen',
        ],
        'created-at' => 'Hinzufügedatum: :date',
    ],

    'models' => [
        'update' => [
            'title' => 'Bildtitel aktualisieren',
            'label' => 'BILD TITEL',
            'placeholder' => 'Bildtitel',
            'close' => 'Schließen',
            'save' => 'Aktualisieren',
        ],
        'delete' => [
            'title' => 'Bild löschen',
            'info' => 'Möchten Sie das Bild mit dem Titel wirklich löschen?',
            'close' => 'Schließen',
            'delete' => 'Löschen',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Search Language Lines
    |--------------------------------------------------------------------------
    */

    'search' => [
        'title' => 'MIT BILD SUCHEN',
        'info' => 'Wählen Sie ein Bild aus, um in allen veröffentlichten Markenbulletins zu suchen.',
        'alert' => 'Das hochgeladene Bild sollte im <strong>jpg/jpeg</strong>-Format sein.',
        'form' => [
            'label' => 'Bild zur Suche',
            'button' => 'Nach Bild suchen',
        ],
        'limit' => 'Verbleibendes Suchlimit: <strong>:count</strong>',
        'search-history' => 'Suchverlauf (Letzte 20)',
        'search-history-info' => 'Hier können Sie die Bilder sehen, nach denen Sie zuvor gesucht haben.',

        'result' => [
            'main-image' => [
                'title' => 'Gesuchtes Bild',
                'dominant-color' => 'Dominanzfarbskala',
            ],
            'main-title' => 'BILDERLISTE',

            'similarity' => 'Ähnlichkeit',
            'similarity-not-found' => 'Ähnlichkeit nicht gefunden.',
            'phash' => 'Farbübereinstimmung',
            'histogram' => 'Bildähnlichkeit',
            'dominant-color' => 'Dominanzfarbähnlichkeit',
            'phash-info' => 'Vergleicht die Ähnlichkeit Ihres gesuchten Bildes mit den Marken in den Bulletins unter Verwendung von Frequenzkomponenten, die den Inhalt des Bildes darstellen.',
            'histogram-info' => 'Extrahiert die Bildähnlichkeitsskala Ihres gesuchten Bildes und vergleicht sie mit der Bildähnlichkeit von Bildern von Marken in den Bulletins, um Ihnen die ähnlichsten Ergebnisse zu präsentieren.',
            'dominant-color-info' => 'Erfasst die Farbstärkeskala Ihres gesuchten Bildes und vergleicht sie mit der Farbstärke von Bildern von Marken in den Bulletins, um Ihnen die ähnlichsten Ergebnisse zu präsentieren.'
        ]
    ]
];