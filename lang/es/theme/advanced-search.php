<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Classes Language Lines
    |--------------------------------------------------------------------------
    */

    'title' => 'BÚSQUEDA AVANZADA',
    'subtitle-1' => 'FUNCIÓN DE COINCIDENCIA EXACTA',
    'subtitle-1-description' => '<p>La Seguimiento Legal de Marca busca también las palabras clave similares en los resultados. No perderse marcas similares es una característica deseada en la mayoría de los casos, pero a veces puede ser preferible que el sistema muestre solo las coincidencias exactas y no active las características de similitud en esa marca específica. Para ello, puedes utilizar la función de coincidencia exacta.<br><br>El sistema interpreta la función de coincidencia exacta entre comillas (" ") y solo incluye en los resultados las marcas que coinciden exactamente con la expresión colocada entre comillas. Puedes usar la función de coincidencia exacta al incluir dos pares de comillas en tu marca o al hacer clic en la casilla de "coincidencia exacta" durante la entrada de la marca.</p>',
    'subtitle-2' => 'Búsqueda exacta para coincidencia exacta',
    'subtitle-2-description' => '<p>Algunos propietarios de marcas solo están interesados en objetar marcas que coincidan exactamente y desean ver solo si hay una coincidencia exacta. En este caso, utilizar la función de coincidencia exacta para toda la marca es una opción adecuada.</p>',
    'subtitle-2-description-2' => '<p>Al agregar la marca y marcar la casilla de coincidencia exacta, podemos realizar esta configuración.</p>',
    'subtitle-3' => 'Obligar a la palabra clave a aparecer con la función de coincidencia exacta',
    'subtitle-3-description' => '<p>Algunas marcas consisten en varias palabras. Para marcas que contienen tres o más palabras, el sistema no requiere que todas las palabras aparezcan en los resultados. Sin embargo, puede haber ocasiones en las que quieras asegurarte de que ciertas palabras aparezcan en la coincidencia exacta. Por ejemplo, consideremos la marca de tres palabras "electrónica comercio industria". Si no estamos interesados ​​en los resultados que solo contienen "comercio industria", podemos hacer que la palabra "electrónica" sea obligatoria en los resultados.</p>',
    'subtitle-3-description-2' => '<p>Vamos a modificar la búsqueda a "electrónica comercio industria".</p>',
    'subtitle-4' => 'Filtrar la coincidencia de palabras con la función de coincidencia exacta',
    'subtitle-4-description' => '<p>Algunas palabras, especialmente las palabras cortas, pueden ser similares a muchas otras palabras. Por ejemplo, consideremos la palabra "marca". Si se encuentra frecuentemente con palabras similares como "market" en los boletines, pero no estamos interesados en ninguna de ellas, podemos filtrar la palabra "marca" utilizando la coincidencia exacta y excluir todas las coincidencias irrelevantes.</p>',
    'subtitle-4-description-2' => '<p>Ahora hagamos la búsqueda nuevamente con la palabra "marca" incluida como coincidencia exacta.</p>',
    'subtitle-5' => 'Excluir solo ciertas similitudes con la función de coincidencia exacta',


    'subtitle-5-description' => '<p>La función de coincidencia exacta también se puede aplicar solo a ciertos caracteres dentro de una palabra. Esto significa que los resultados que no contienen una coincidencia exacta de la expresión entre comillas específicas no se mostrarán.</p>',
    'subtitle-5-description-2' => '<p>A veces, al buscar una palabra clave específica, incluir un carácter en la coincidencia exacta puede ajustar los resultados según tus necesidades.</p>',
    'subtitle-5-description-3' => '<p>Ahora busquemos la palabra "escuelas" y veamos los resultados.</p>',
    'subtitle-5-description-4' => '<p>Obtuvimos resultados no deseados debido a la similitud "escuelas-oğullar". Esto se debe a la similitud entre "k" y "ğ".</p>',
    'subtitle-5-description-5' => '<p>Cambiemos nuestra palabra clave a "o"k"ullar" y hagamos la búsqueda nuevamente.</p>',
    'subtitle-5-description-6' => '<p>Como se puede ver en los resultados, se filtraron los resultados no deseados debido a la similitud entre "k" y "ğ".</p>',
    'subtitle-6' => 'PALABRAS EXCLUIDAS',
    'subtitle-6-description' => '<p class="mt-4">Al realizar una búsqueda, es posible que desees excluir ciertas palabras que aparezcan en los resultados o puedan aparecer. Para ello, puedes utilizar el filtro de palabras excluidas.</p>',
    'subtitle-6-description-2' => '<p>Si la palabra excluida que agregaste coincide exactamente con alguna palabra dentro de los resultados coincidentes con la palabra clave, se aplicará el filtro y no se te mostrará esa coincidencia.</p>',
    'subtitle-6-description-3' => '<p>Puedes utilizar las palabras excluidas sin el riesgo de perder la marca que estás siguiendo. Esto se debe a que las palabras excluidas solo se consideran en relación con la palabra clave coincidente y se requiere una coincidencia exacta con la palabra excluida para filtrar el resultado.</p>',
    'subtitle-6-description-4' => '<p>Cuando realizas una búsqueda con coincidencia exacta, el texto que buscas aparecerá exactamente en los resultados. La coincidencia exacta permite que la palabra coincidente tenga prefijos y sufijos.</p>',
    'subtitle-6-description-5' => '<p class="mt-4">Realicemos una búsqueda de resultados para la palabra clave "arteng" sin agregar ninguna palabra excluida.</p>',
    'subtitle-6-description-6' => '<p>Ahora agreguemos una palabra excluida para obtener resultados más precisos.</p>',
    'subtitle-6-description-7' => '<p>En este ejemplo, hemos agregado una palabra excluida. Al agregar una palabra excluida, debe coincidir exactamente con la palabra coincidente en la palabra clave.</p>',
    'subtitle-6-description-8' => '<p>El resultado número 2 en el ejemplo no se muestra porque la palabra "garden" coincide exactamente.</p>',
];
