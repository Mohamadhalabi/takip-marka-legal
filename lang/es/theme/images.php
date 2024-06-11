<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Language Lines
    |--------------------------------------------------------------------------
    */
    'title' => 'MIS IMÁGENES',
    'warning' => 'Tenga en cuenta las siguientes advertencias y vuelva a intentarlo.',
    'add' => 'AGREGAR IMAGEN',
    'follow-info' => 'Agregue la imagen que desea monitorear',
    'info' => 'Las imágenes que agregue se escanearán en cada boletín de marcas publicado a partir de la fecha de adición, y los resultados se incluirán en informes futuros.',

    'input' => [
        'title' => 'Título',
        'placeholder' => 'Título de la imagen',
        'file-label' => 'Imagen',
        'add' => 'Agregar imagen',
    ],

    'list' => 'LISTA DE IMÁGENES (:count)',

    'items' => [
        'actions' => [
            'edit' => 'Actualizar título',
            'delete' => 'Eliminar imagen',
        ],
        'created-at' => 'Fecha de adición: :date',
    ],

    'models' => [
        'update' => [
            'title' => 'Actualizar título de imagen',
            'label' => 'TÍTULO DE LA IMAGEN',
            'placeholder' => 'Título de la imagen',
            'close' => 'Cerrar',
            'save' => 'Actualizar',
        ],
        'delete' => [
            'title' => 'Eliminar imagen',
            'info' => '¿Está seguro de que desea eliminar la imagen titulada?',
            'close' => 'Cerrar',
            'delete' => 'Eliminar',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Search Language Lines
    |--------------------------------------------------------------------------
    */

    'search' => [
        'title' => 'BÚSQUEDA CON IMAGEN',
        'info' => 'Seleccione una imagen para buscar en todos los boletines de marcas publicados.',
        'alert' => 'La imagen cargada debe estar en formato <strong>jpg/jpeg</strong>.',
        'form' => [
            'label' => 'Imagen para buscar',
            'button' => 'Buscar por imagen',
        ],
        'limit' => 'Límite de búsqueda restante: <strong>:count</strong>',
        'search-history' => 'Historial de búsqueda (últimos 20)',
        'search-history-info' => 'Aquí puede ver las imágenes que ha buscado anteriormente.',

        'result' => [
            'main-image' => [
                'title' => 'Imagen buscada',
                'dominant-color' => 'Escala de similitud de color dominante',
            ],
            'main-title' => 'LISTA DE IMÁGENES',

            'similarity' => 'Similitud',
            'similarity-not-found' => 'No se encontró similitud.',
            'phash' => 'Coincidencia de color',
            'histogram' => 'Similitud de imagen',
            'dominant-color' => 'Similitud de color dominante',
            'phash-info' => 'Compara la similitud de su imagen buscada con las marcas en los boletines utilizando componentes de frecuencia que representan el contenido de la imagen.',
            'histogram-info' => 'Extrae la escala de similitud de imagen de su imagen buscada y la compara con la similitud de imagen de las imágenes de marcas en los boletines para presentarle los resultados más

 similares.',
            'dominant-color-info' => 'Detecta la escala de intensidad de color de su imagen buscada y la compara con la intensidad de color de las imágenes de marcas en los boletines para presentarle los resultados más similares.'
        ]
    ]
];