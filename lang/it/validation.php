<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Doğrulama Mesajları
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki öğeler doğrulama sınıfı tarafından kullanılan varsayılan hata
    | mesajlarını içermektedir. `size` gibi bazı kuralların birden çok çeşidi
    | bulunmaktadır. Her biri ayrı ayrı düzenlenebilir.
    |
    */

    'accepted' => 'Il campo :attribute deve essere accettato.',
    'active_url' => 'Il campo :attribute non è un URL valido.',
    'after' => 'Il campo :attribute deve essere una data successiva a :date.',
    'after_or_equal' => 'Il campo :attribute deve essere una data successiva o uguale a :date.',
    'alpha' => 'Il campo :attribute può contenere solo lettere.',
    'alpha_dash' => 'Il campo :attribute può contenere solo lettere, numeri e trattini.',
    'alpha_num' => 'Il campo :attribute può contenere solo lettere e numeri.',
    'array' => 'Il campo :attribute deve essere un array.',
    'before' => 'Il campo :attribute deve essere una data precedente a :date.',
    'before_or_equal' => 'Il campo :attribute deve essere una data precedente o uguale a :date.',
    'between' => [
        'numeric' => 'Il campo :attribute deve essere compreso tra :min e :max.',
        'file' => 'Il campo :attribute deve avere una dimensione compresa tra :min e :max kilobyte.',
        'string' => 'Il campo :attribute deve contenere tra :min e :max caratteri.',
        'array' => 'Il campo :attribute deve avere tra :min e :max elementi.',
    ],
    'boolean' => 'Il campo :attribute deve essere vero o falso.',
    'confirmed' => 'La conferma del campo :attribute non corrisponde.',
    'date' => 'Il campo :attribute non è una data valida.',
    'date_equals' => 'Il campo :attribute deve essere una data uguale a :date.',
    'date_format' => 'Il campo :attribute non corrisponde al formato :format.',
    'different' => 'I campi :attribute e :other devono essere diversi.',
    'digits' => 'Il campo :attribute deve contenere :digits cifre.',
    'digits_between' => 'Il campo :attribute deve contenere tra :min e :max cifre.',
    'dimensions' => "Le dimensioni dell'immagine :attribute non sono valide.",
'distinct' => "Il campo :attribute ha un valore duplicato.",
'email' => 'Il campo :attribute deve essere un indirizzo email valido.',
'ends_with' => 'Il campo :attribute deve terminare con uno dei seguenti valori: :values',
'exists' => 'Il campo :attribute selezionato non è valido.',
'file' => 'Il campo :attribute deve essere un file.',
'filled' => 'Il campo :attribute deve avere un valore.',
'gt' => [
'numeric' => 'Il campo :attribute deve essere maggiore di :value.',
'file' => 'Il campo :attribute deve avere una dimensione maggiore di :value kilobyte.',
'string' => 'Il campo :attribute deve contenere più di :value caratteri.',
'array' => 'Il campo :attribute deve avere più di :value elementi.',
],
'gte' => [
'numeric' => 'Il campo :attribute deve essere maggiore o uguale a :value.',
'file' => 'Il campo :attribute deve avere una dimensione maggiore o uguale a :value kilobyte.',
'string' => 'Il campo :attribute deve contenere almeno :value caratteri.',
'array' => 'Il campo :attribute deve avere almeno :value elementi.',
],
'image' => "Il campo :attribute deve essere un'immagine.",
'in' => 'Il campo :attribute selezionato non è valido.',
'in_array' => 'Il campo :attribute non esiste in :other.',
'integer' => 'Il campo :attribute deve essere un numero intero.',
'ip' => 'Il campo :attribute deve essere un indirizzo IP valido.',
'ipv4' => 'Il campo :attribute deve essere un indirizzo IPv4 valido.',
'ipv6' => 'Il campo :attribute deve essere un indirizzo IPv6 valido.',
'json' => 'Il campo :attribute deve essere una stringa JSON valida.',
'lt' => [
    'numeric' => 'Il campo :attribute deve essere minore di :value.',
    'file' => 'Il campo :attribute deve avere una dimensione inferiore a :value kilobyte.',
    'string' => 'Il campo :attribute deve contenere meno di :value caratteri.',
    'array' => 'Il campo :attribute deve avere meno di :value elementi.',
],
'lte' => [
    'numeric' => 'Il campo :attribute deve essere minore o uguale a :value.',
    'file' => 'Il campo :attribute deve avere una dimensione inferiore o uguale a :value kilobyte.',
    'string' => 'Il campo :attribute non deve contenere più di :value caratteri.',
    'array' => 'Il campo :attribute non deve avere più di :value elementi.',
],
'max' => [
    'numeric' => 'Il campo :attribute non può essere maggiore di :max.',
    'file' => 'Il campo :attribute non può essere maggiore di :max kilobyte.',
    'string' => 'Il campo :attribute non può contenere più di :max caratteri.',
    'array' => 'Il campo :attribute non può avere più di :max elementi.',
],
'mimes' => 'Il campo :attribute deve essere un file di tipo: :values.',
'mimetypes' => 'Il campo :attribute deve essere un file di tipo: :values.',
'min' => [
    'numeric' => 'Il campo :attribute deve essere almeno :min.',
    'file' => 'Il campo :attribute deve avere una dimensione di almeno :min kilobyte.',
    'string' => 'Il campo :attribute deve contenere almeno :min caratteri.',
    'array' => 'Il campo :attribute deve avere almeno :min elementi.',
],
'not_in' => 'Il campo :attribute selezionato non è valido.',
'not_regex' => 'Il formato del campo :attribute non è valido.',
'numeric' => 'Il campo :attribute deve essere un numero.',
'password' => 'La password non è corretta.',
'present' => 'Il campo :attribute deve essere presente.',
'regex' => 'Il formato del campo :attribute non è valido.',
'required' => 'Il campo :attribute è obbligatorio.',
'required_if' => 'Il campo :attribute è obbligatorio quando :other è :value.',
'required_unless' => 'Il campo :attribute è obbligatorio a meno che :other sia presente in :values.',
'required_with' => 'Il campo :attribute è obbligatorio quando :values è presente.',
'required_with_all' => 'Il campo :attribute è obbligatorio quando :values sono presenti.',
'required_without' => 'Il campo :attribute è obbligatorio quando :values non è presente.',
'required_without_all' => 'Il campo :attribute è obbligatorio quando nessuno dei campi :values è presente.',
'same' => 'I campi :attribute e :other devono corrispondere.',
'size' => [
    'numeric' => 'Il campo :attribute deve essere :size.',
    'file' => 'Il campo :attribute deve avere una dimensione di :size kilobyte.',
    'string' => 'Il campo :attribute deve contenere :size caratteri.',
    'array' => 'Il campo :attribute deve contenere :size elementi.',
],
'starts_with' => 'Il campo :attribute deve iniziare con uno dei seguenti valori: :values',
'string' => 'Il campo :attribute deve essere una stringa.',
'timezone' => 'Il campo :attribute deve essere un fuso orario valido.',
'unique' => 'Il campo :attribute è stato già utilizzato.',
'uploaded' => 'Il caricamento del campo :attribute è fallito.',
'url' => 'Il formato del campo :attribute non è valido.',
'uuid' => 'Il campo :attribute deve essere un UUID valido.',
    /*
    |--------------------------------------------------------------------------
    | Özelleştirilmiş Doğrulama Mesajları
    |--------------------------------------------------------------------------
    |
    | Bu alanda her niteleyici (attribute) ve kural (rule) ikilisine özel hata
    | mesajları tanımlayabilirsiniz. Bu özellik, son kullanıcıya daha gerçekçi
    | metinler göstermeniz için oldukça faydalıdır.
    |
    | Örnek olarak:
    |
    | 'email.email': 'Girdiğiniz e-posta adresi geçerli değil.'
    | 'x.regex': 'x alanı için "a-b.c" formatında veri girmelisiniz.'
    |
    */

    'custom' => [
        'x' => [
            'regex' => 'x alanı için "a-b.c" formatında veri girmelisiniz.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Özelleştirilmiş Niteleyici İsimleri
    |--------------------------------------------------------------------------
    |
    | Bu alandaki bilgiler "email" gibi niteleyici isimlerini "e-posta adresi"
    | gibi daha okunabilir metinlere çevirmek için kullanılır. Bu bilgiler
    | hata mesajlarının daha temiz olmasını sağlar.
    |
    | Örnek olarak:
    |
    | 'email' => 'e-posta adresi',
    | 'password' => 'parola',
    |
    */

    'attributes' => [
        'password' => 'Şifre',
        'email' => 'E-posta adresi',
        'name' => 'İsim',
        'checkbox' => 'Onay kutusu',
    ],

    'required' => 'Questo campo è obbligatorio.',
    'email' => 'Inserisci un indirizzo email valido.',
    'name.required' => 'Inserisci il tuo nome.',
    'email.required' => 'Inserisci il tuo indirizzo email.',
    'message.required' => 'Inserisci il tuo messaggio.',


];
