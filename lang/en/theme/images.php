<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Language Lines
    |--------------------------------------------------------------------------
    */
    'title' => 'MY IMAGES',
    'warning' => 'Please take note of the following warnings and try again.',
    'add' => 'ADD IMAGE',
    'follow-info' => 'Add the image you want to monitor',
    'rules-info' => 'You can follow the suggestions below for the clearest matches',
    'info' => 'The images you add will be scanned in every published trademark bulletin starting from the date of addition, and the results will be included in future reports.',

    'input' => [
        'title' => 'Title',
        'placeholder' => 'Image Title',
        'file-label' => 'Image',
        'add' => 'Add Image',
    ],

    'list' => 'IMAGE LIST (:count)',

    'items' => [
        'actions' => [
            'edit' => 'Update Title',
            'delete' => 'Delete Image',
        ],
        'created-at' => 'Added Date : :date',
    ],

    'models' => [
        'update' => [
            'title' => 'Update Image Title',
            'label' => 'IMAGE TITLE',
            'placeholder' => 'Image Title',
            'close' => 'Close',
            'save' => 'Update',
        ],
        'delete' => [
            'title' => 'Delete Image',
            'info' => 'Are you sure you want to delete the image titled?',
            'close' => 'Close',
            'delete' => 'Delete',
        ]
    ],

    'validation' => [
        'image' => [
            'required' => 'Please select an image.',
            'image' => 'The selected file must be an image.',
            'max' => 'The selected file may not be greater than 255 kilobytes.',
            'mimes' => 'The selected file must be a file of type: jpg/jpeg.',
        ],
        'title' => [
            'required' => 'Please enter a title.',
            'max' => 'The title may not be greater than 255 characters.',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Search Language Lines
    |--------------------------------------------------------------------------
    */

    'search' => [
        'title' => 'SEARCH WITH IMAGE',
        'info' => 'Select a image to search in all published brand bulletins.',
        'alert' => 'The uploaded image should be in <strong>jpg/jpeg</strong> format.',
        'form' => [
            'label' => 'Image to Search',
            'button' => 'Search By Image',
        ],
        'limit' => 'Remaining search limit: <strong>:count</strong>',
        'search-history' => 'Search History (Last 20)',
        'search-history-info' => 'You can see the images you previously searched for here.',

        'result' => [
            'main-image' => [
                'title' => 'Searched Image',
                'dominant-color' => 'Dominant Color Similarity Scale',
            ],
            'main-title' => 'IMAGE LIST',

            'similarity' => 'Similarity',
            'similarity-not-found' => 'Similarity not found.',
            'phash' => 'Color Match',
            'histogram' => 'Image Similarity',
            'dominant-color' => 'Dominant Color Similarity',
            'order' => 'ORDER',
            'title' => 'TITLE',
            'image' => 'IMAGE',
            'searched-bulletin' => 'SEARCHED BULLETIN',
            'phash-info' => 'Compares the similarity of your searched image with the brands in the bulletins using frequency components representing the content of the image.',
            'histogram-info' => 'Extracts the image similarity scale of your searched image and compares it with the image similarity of images of brands in the bulletins to present you with the most similar results.',
            'dominant-color-info' => 'Detects the color intensity scale of your searched image and compares it with the color intensity of images of brands in the bulletins to present you with the most similar results.',
            'beta-text' => 'This feature is in <strong>beta</strong>.',
            'beta-contact-text' => 'Please report any errors you encounter in the search results with this feature.',
            'result-text' => 'As a result of the search, a total of <strong>:count</strong> trademarks have been matched, and results have been compiled under <strong>3</strong> different titles.'
        ]
    ]
];
