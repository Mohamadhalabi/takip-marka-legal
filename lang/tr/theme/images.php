<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Language Lines
    |--------------------------------------------------------------------------
    */
    'title' => 'ŞEKİLLERİM',
    'warning' => 'Lütfen aşağıdaki uyarıları dikkate alın ve tekrar deneyin.',
    'add' => 'ŞEKİL EKLE',
    'follow-info' => 'Takip etmek istediğiniz şekli ekleyin',
    'rules-info' => 'En net eşleşmeler için aşağıdaki yönergeleri takip edebilirsiniz',
    'info' => 'Eklediğiniz şekiller eklenme tarihinden itibaren yayınlanan her resmi marka
    bülteninde taranacak ve sonuçlar raporunuzda yer alacaktır.',

    'input' => [
        'title' => 'Başlık',
        'placeholder' => 'Görsel Başlığı',
        'file-label' => 'Şekil',
        'add' => 'Şekil Ekle',
    ],

    'list' => 'ŞEKİL LİSTESİ (:count)',

    'items' => [
        'actions' => [
            'edit' => 'Başlığı Güncelle',
            'delete' => 'Görseli Sil',
        ],
        'created-at' => 'Eklenme Tarihi : :date',
    ],

    'models' => [
        'update' => [
            'title' => 'Şekil Başlığını Güncelle',
            'label' => 'ŞEKİL BAŞLIĞI',
            'placeholder' => 'Görsel Başlığı',
            'close' => 'Kapat',
            'save' => 'Güncelle',
        ],
        'delete' => [
            'title' => 'Şekli Silme',
            'info' => 'başlıklı şekli silmek istediğinizden emin misiniz?',
            'question' => 'Şekili silmek istediğinize emin misiniz?',
            'close' => 'Kapat',
            'delete' => 'Sil',
        ]
    ],

    'validation' => [
        'image' => [
            'required' => 'Lütfen bir şekil yükleyin.',
            'image' => 'Yüklenen dosya jpg/jpeg formatında olmalıdır.',
            'max' => 'Yüklenen dosya 2MB\'dan büyük olmamalıdır.',
            'mimes' => 'Yüklenen dosya jpg/jpeg formatında olmalıdır.',
        ],
        'title' => [
            'required' => 'Lütfen bir başlık girin.',
            'max' => 'Başlık 255 karakterden büyük olmamalıdır.',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Search Language Lines
    |--------------------------------------------------------------------------
    */

    'search' => [
        'title' => 'ŞEKİL İLE ARAMA',
        'info' => 'Yayınlanan tüm resmi marka bültenlerinde aramak üzere bir şekil seçin ve arayın.',
        'alert' => 'Arama yapacağınız resim <strong>jpg/jpeg</strong> formatında olmadılır.',
        'form' => [
            'label' => 'Aranacak Şekil',
            'button' => 'Şekilli Ara',
        ],
        'limit' => 'Kalan arama limitiniz : <strong>:count</strong>',
        'search-history' => 'Arama Geçmişiniz (Son 20)',
        'search-history-info' => 'Daha önceden aradığınız şekilleri burada görebilirsiniz.',

        'result' => [
            'main-image' => [
                'title' => 'Aranan Görsel',
                'dominant-color' => 'Baskın Renk Benzerlik Skalası',
            ],
            'main-title' => 'ŞEKİL LİSTESİ',

            'similarity' => 'Benzerlik',
            'similarity-not-found' => 'Benzerlik bulunamadı.',
            'phash' => 'Renk Uyumu',
            'histogram' => 'Şekil Benzerliği',
            'dominant-color' => 'Baskın Renk Benzerliği',
            'order' => 'Sıra',
            'title' => 'ŞEKİL BAŞLIĞI',
            'image' => 'ŞEKİL',
            'searched-bulletin' => 'ARANAN BÜLTEN',
            'phash-info' => 'Aradığınız görsellerin içeriğini temsil eden renk bileşenlerini kullanarak ilgili bültendeki markalar ile benzerliklerini karşılaştırır ve en benzer sınırlı sayıdaki sonucu size sunar.',
            'histogram-info' => 'Aradığınız görsellerdeki şekil benzerliği özelliklerini ilgili bültendeki markalara ait görsellerinkilerle karşılaştırma yaparak en benzer sınırlı sayıdaki sonucu size sunar.',
            'dominant-color-info' => 'Aradığınız görsellerdeki renk yoğunluğu skalasını tespit eder ilgil bültendeki markalara ait görsellerin renk yoğunluğu ile karşılaştırma yaparak en benzer sınırlı sayıdaki sonucu size sunar.',
            'beta-text' => 'Şekil ile arama özelliğimiz şu an için <strong>beta</strong> aşamasındadır.',
            'beta-contact-text' => 'Bu özellik ile arama sonuçlarında karşılaşacağınız hataları lütfen bize bildiriniz.',
            'result-text' => 'Yapılan arama sonucunda toplamda <strong>18</strong> marka eşleşmiştir, <strong>3</strong> farklı başlıkta sonuçlar derlenmiştir.'
        ]
    ]
];
