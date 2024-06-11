<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Classes Language Lines
    |--------------------------------------------------------------------------
    */

    'title' => 'RICERCA AVANZATA',
    'subtitle-1' => 'FUNZIONALITÀ DI CORRISPONDENZA ESATTA',
    'subtitle-1-description' => '<p>Il Monitoraggio Legale del Marchio estrae anche le varianti delle parole chiave nei risultati. Non perdere le marche simili è una funzionalità desiderata nella maggior parte dei casi, ma talvolta potresti voler visualizzare solo le corrispondenze esatte senza attivare le caratteristiche di similitudine nella marca cercata. Puoi utilizzare la funzionalità di corrispondenza esatta per questo scopo.<br><br>Il sistema interpreta la funzionalità di corrispondenza esatta utilizzando i doppi apici (" "). Quando viene inserita un\'espressione tra due doppi apici, viene interpretata come corrispondenza esatta e vengono inclusi nei risultati solo i marchi che corrispondono esattamente all\'espressione inserita. Puoi utilizzare due paia di virgolette doppie nella tua marca o puoi fare clic sulla casella di controllo "corrispondenza esatta" durante l\'inserimento del marchio.</p>',
    'subtitle-2' => 'Corrispondenza esatta per la ricerca esatta',
    'subtitle-2-description' => '<p>Alcuni proprietari di marchi non sono interessati a contestare marchi simili e desiderano visualizzare solo i marchi che corrispondono esattamente. In questo caso, utilizzare la funzionalità di corrispondenza esatta per l\'intero marchio è una scelta appropriata.</p>',
    'subtitle-2-description-2' => '<p>Puoi impostare questa opzione inserendo il nostro marchio nel campo di inserimento del marchio e selezionando la casella di controllo "corrispondenza esatta".</p>',
    'subtitle-3' => 'Corrispondenza esatta per la presenza obbligatoria delle parole',
    'subtitle-3-description' => '<p>Alcuni marchi sono composti da più parole. Per i marchi che contengono tre o più parole, il sistema non richiede che tutte le parole siano presenti nei risultati. In alcuni casi, tuttavia, potrebbero esserci alcune parole che desideri che siano presenti nella corrispondenza. Ad esempio, considera un marchio composto da tre parole: <strong>elektrik ticaret sanayi</strong>. Se non siamo interessati solo a quelli che contengono <strong>ticaret sanayi</strong> nei risultati, possiamo richiedere che la parola <strong>elektrik</strong> sia presente nei risultati.</p>',
    'subtitle-3-description-2' => '<p>Modifichiamo la ricerca in <strong>"elektrik" ticaret sanayi</strong>.</p>',
    'subtitle-4' => 'Corrispondenza esatta per la filtrazione delle corrispondenze delle parole',
    'subtitle-4-description' => '<p>Alcune parole, specialmente quelle brevi, possono essere simili a molte altre parole. Ad esempio, considera la parola "marka". Se viene abbinata frequentemente ad altre parole simili come "market" nelle newsletter, ma non siamo interessati a nessuna di queste corrispondenze simili, possiamo filtrare tutte le corrispondenze non rilevanti impostando la parola "marka" come corrispondenza esatta.</p>',
    'subtitle-4-description-2' => '<p>Ora proviamo a cercare nuovamente inserendo la parola "marka" come corrispondenza esatta.</p>',
    'subtitle-5' => 'Corrispondenza esatta per escludere solo determinate similitudini',
    'subtitle-5-description' => '<p>La funzionalità di corrispondenza esatta può essere applicata solo a determinati caratteri all\'interno di una parola. In questo caso, i risultati che non hanno esattamente l\'espressione specificata tra virgolette non vengono visualizzati.</p>',
    'subtitle-5-description-2' => '<p>A seconda della parola chiave che stai cercando, talvolta includere un carattere nella corrispondenza esatta può produrre i risultati desiderati.</p>',
    'subtitle-5-description-3' => '<p>Ora cerchiamo la parola chiave "okulları" e vediamo i risultati.</p>',
    'subtitle-5-description-4' => '<p>Abbiamo ottenuto risultati indesiderati a causa della somiglianza tra "okullar-oğullar". Questo è dovuto alla somiglianza tra "k" e "ğ".</p>',
    'subtitle-5-description-5' => '<p>Modifichiamo la nostra parola chiave in "o"k"ullar" e cerchiamo di nuovo.</p>',
    'subtitle-5-description-6' => '<p>Come puoi vedere nei risultati, i risultati indesiderati sono stati filtrati a causa della somiglianza tra "k" e "ğ".</p>',
    'subtitle-6' => 'PAROLE ESCLUSE',
    'subtitle-6-description' => '<p class="mt-4">Potresti voler escludere alcune parole che appaiono o potrebbero apparire nei risultati della ricerca. Puoi utilizzare il filtro delle parole escluse per questo scopo.</p>',
    'subtitle-6-description-2' => '<p>Se la parola esclusa che hai aggiunto è identica alla parola chiave cercata nei risultati, verrà filtrata e non verrà mostrata.</p>',
    'subtitle-6-description-3' => '<p>Puoi utilizzare le parole escluse senza il rischio di perdere il marchio che stai monitorando. Poiché le parole escluse vengono prese in considerazione solo per la corrispondenza tra la parola chiave e la parola corrispondente, la parola corrispondente deve corrispondere esattamente alla parola esclusa per filtrare i risultati.</p>',
    'subtitle-6-description-4' => '<p>Quando fai la ricerca con la corrispondenza esatta, il testo che stai cercando verrà visualizzato esattamente nei risultati. Anche se viene soddisfatta la corrispondenza esatta, la parola corrispondente può avere prefissi e suffissi.</p>',
    'subtitle-6-description-5' => '<p class="mt-4">Cerchiamo i risultati per la parola chiave "arteng" senza aggiungere alcuna parola esclusa.</p>',
    'subtitle-6-description-6' => '<p>Aggiungiamo ora una parola esclusa per ottenere risultati più precisi.</p>',
    'subtitle-6-description-7' => '<p>In questo esempio abbiamo aggiunto una parola esclusa. Quando aggiungi una parola esclusa, deve essere identica alla parola chiave corrispondente.</p>',
    'subtitle-6-description-8' => '<p>Nel caso dell\'elemento 2 nell\'esempio, la parola "garden" è stata filtrata perché è una corrispondenza esatta.</p>',
];
