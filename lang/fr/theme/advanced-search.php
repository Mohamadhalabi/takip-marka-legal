<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Classes Language Lines
    |--------------------------------------------------------------------------
    */

    'title' => 'RECHERCHE AVANCÉE',
    'subtitle-1' => 'FONCTION DE CORRESPONDANCE EXACTE',
    'subtitle-1-description' => '<p>Le suivi légal de marque recherche également des mots-clés similaires dans les résultats. Ne pas manquer de marques similaires est une fonctionnalité souhaitée dans la plupart des cas, mais parfois il peut être préférable que le système n\'affiche que les correspondances exactes et ne déclenche pas les caractéristiques de similarité pour cette marque spécifique. Pour cela, vous pouvez utiliser la fonction de correspondance exacte.<br><br>Le système interprète la fonction de correspondance exacte entre guillemets (" ") et inclut uniquement dans les résultats les marques qui correspondent exactement à l\'expression placée entre guillemets. Vous pouvez utiliser la fonction de correspondance exacte en incluant deux paires de guillemets dans votre marque ou en cochant la case "correspondance exacte" lors de la saisie de la marque.</p>',
    'subtitle-2' => 'Recherche exacte pour correspondance exacte',
    'subtitle-2-description' => '<p>Certains propriétaires de marques sont seulement intéressés à contester les marques qui correspondent exactement et souhaitent voir uniquement s\'il y a une correspondance exacte. Dans ce cas, utiliser la fonction de correspondance exacte pour l\'ensemble de la marque est une option appropriée.</p>',
    'subtitle-2-description-2' => '<p>En ajoutant la marque et en cochant la case correspondance exacte, nous pouvons effectuer cette configuration.</p>',
    'subtitle-3' => 'Obliger le mot-clé à apparaître avec la fonction de correspondance exacte',
    'subtitle-3-description' => '<p>Certaines marques sont composées de plusieurs mots. Pour les marques contenant trois mots ou plus, le système n\'exige pas que tous les mots apparaissent dans les résultats. Cependant, il peut y avoir des occasions où vous souhaitez vous assurer que certains mots apparaissent dans la correspondance exacte. Par exemple, considérons la marque de trois mots "électronique commerce industrie". Si nous ne sommes pas intéressés par les résultats contenant uniquement "commerce industrie", nous pouvons rendre le mot "électronique" obligatoire dans les résultats.</p>',
    'subtitle-3-description-2' => '<p>Modifions la recherche en "électronique commerce industrie".</p>',
    'subtitle-4' => 'Filtrer la correspondance des mots avec la fonction de correspondance exacte',
    'subtitle-4-description' => '<p>Certains mots, notamment les mots courts, peuvent être similaires à de nombreux autres mots. Par exemple, considérons le mot "marque". S\'il est fréquemment trouvé avec des mots similaires comme "market" dans les bulletins, mais que nous ne sommes intéressés par aucun d\'eux, nous pouvons filtrer le mot "marque" en utilisant la correspondance exacte et exclure toutes les correspondances non pertinentes.</p>',
    'subtitle-4-description-2' => '<p>Faisons maintenant la recherche à nouveau avec le mot "marque" inclus en correspondance exacte.</p>',
    'subtitle-4-description-3' => '<p>Nous avons filtré toutes les correspondances non pertinentes qui ne correspondaient pas exactement au mot "marque".</p>',
    'subtitle-5' => 'COINCIDENCE EXACTE PARTIELLE',
    'subtitle-5-description' => '<p>La fonction de correspondance exacte peut également s\'appliquer uniquement à certains caractères à l\'intérieur d\'un mot. Cela signifie que les résultats qui ne contiennent pas une correspondance exacte de l\'expression entre guillemets spécifiques ne seront pas affichés.</p>',
    'subtitle-5-description-2' => '<p>Parfois, lors de la recherche d\'un mot-clé spécifique, inclure un caractère dans la correspondance exacte peut ajuster les résultats selon vos besoins.</p>',
    'subtitle-5-description-3' => '<p>Recherchons maintenant le mot "écoles" et voyons les résultats.</p>',
    'subtitle-5-description-4' => '<p>Nous avons obtenu des résultats indésirables en raison de la similarité "écoles-oğullar". Cela est dû à la similarité entre "k" et "ğ".</p>',
    'subtitle-5-description-5' => '<p>Modifions notre mot-clé en "o"k"ullar" et effectuons à nouveau la recherche.</p>',
    'subtitle-5-description-6' => '<p>Comme on peut le voir dans les résultats, les résultats indésirables ont été filtrés en raison de la similarité entre "k" et "ğ".</p>',
    'subtitle-6' => 'MOTS EXCLUS',
    'subtitle-6-description' => '<p>Lors de la réalisation d\'une recherche, vous pouvez souhaiter exclure certains mots qui apparaissent dans les résultats ou qui pourraient apparaître. Pour cela, vous pouvez utiliser le filtre de mots exclus.</p>',
    'subtitle-6-description-2' => '<p>Si le mot exclu que vous avez ajouté correspond exactement à un mot dans les résultats correspondant au mot-clé, le filtre sera appliqué et cette correspondance ne vous sera pas montrée.</p>',
    'subtitle-6-description-3' => '<p>Vous pouvez utiliser les mots exclus sans risquer de manquer la marque que vous suivez. Cela est dû au fait que les mots exclus ne sont pris en compte qu\'en relation avec le mot-clé correspondant et une correspondance exacte avec le mot exclu est requise pour filtrer le résultat.</p>',
    'subtitle-6-description-4' => '<p>Lorsque vous effectuez une recherche avec une correspondance exacte, le texte que vous recherchez apparaîtra exactement dans les résultats. La correspondance exacte permet au mot correspondant d\'avoir des préfixes et des suffixes.</p>',
    'subtitle-6-description-5' => '<p>Réalisant une recherche de résultats pour le mot-clé "arteng" sans ajouter de mot exclu.</p>',
    'subtitle-6-description-6' => '<p>Ajoutons maintenant un mot exclu pour obtenir des résultats plus précis.</p>',
    'subtitle-6-description-7' => '<p>Dans cet exemple, nous avons ajouté un mot exclu. En ajoutant un mot exclu, il doit correspondre exactement au mot correspondant pour que le filtre fonctionne. Les résultats affichés ne contiennent pas le mot exclu "craft".</p>',
    'subtitle-7' => 'Définition de la priorité des mots-clés',
    'subtitle-7-description' => '<p>Lorsque vous effectuez une recherche, vous pouvez définir la priorité des mots-clés en les incluant dans des guillemets doubles (" "). De cette manière, les mots entre guillemets seront recherchés en premier et auront une priorité plus élevée dans les résultats. Cela signifie que les résultats qui contiennent une correspondance exacte des mots entre guillemets apparaîtront en premier.</p>',
    'subtitle-7-description-2' => '<p>Supposons que nous recherchions le mot-clé "marque de commerce" sans utiliser de guillemets.</p>',
    'subtitle-7-description-3' => '<p>Les résultats affichent les marques contenant soit "marque", soit "commerce", sans donner la priorité aux marques contenant les deux mots ensemble.</p>',
    'subtitle-7-description-4' => '<p>Maintenant, effectuons la recherche avec les guillemets pour donner la priorité à la correspondance exacte de "marque de commerce".</p>',
    'subtitle-7-description-5' => '<p>Les résultats montrent maintenant les marques qui correspondent exactement à l\'expression "marque de commerce". Les marques contenant uniquement "marque" ou "commerce" ne sont pas affichées car elles ne correspondent pas exactement à l\'expression entre guillemets.</p>',

];