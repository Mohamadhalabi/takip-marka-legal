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

    'accepted' => ':attribute muss akzeptiert werden.',
    'accepted_if' => ':attribute muss akzeptiert werden, wenn :other den Wert :value hat.',
    'active_url' => ':attribute muss eine gültige URL sein.',
    'after' => ':attribute muss nach dem Datum :date liegen.',
    'after_or_equal' => ':attribute muss nach oder gleich dem Datum :date liegen.',
    'alpha' => ':attribute darf nur Buchstaben enthalten.',
    'alpha_dash' => ':attribute darf nur Buchstaben, Zahlen und Bindestriche enthalten.',
    'alpha_num' => ':attribute darf nur Buchstaben und Zahlen enthalten.',
    'array' => ':attribute muss ein Array sein.',
    'before' => ':attribute muss vor dem Datum :date liegen.',
    'before_or_equal' => ':attribute muss vor oder gleich dem Datum :date liegen.',
    'between' => [
        'numeric' => ':attribute muss zwischen :min und :max liegen.',
        'file' => ':attribute muss zwischen :min und :max Kilobytes groß sein.',
        'string' => ':attribute muss zwischen :min und :max Zeichen lang sein.',
        'array' => ':attribute muss zwischen :min und :max Elemente enthalten.',
    ],
    'boolean' => ':attribute muss entweder wahr oder falsch sein.',
    'confirmed' => ':attribute stimmt nicht mit der Bestätigung überein.',
    'current_password' => 'Das Passwort ist ungültig.',
    'date' => ':attribute muss ein gültiges Datum sein.',
    'date_equals' => ':attribute muss dem Datum :date entsprechen.',
    'date_format' => ':attribute entspricht nicht dem Format :format.',
    'declined' => ':attribute muss abgelehnt werden.',
    'declined_if' => ':attribute muss abgelehnt werden, wenn :other den Wert :value hat.',
    'different' => ':attribute und :other müssen unterschiedlich sein.',
    'digits' => ':attribute muss :digits Ziffern lang sein.',
    'digits_between' => ':attribute muss zwischen :min und :max Ziffern lang sein.',
    'dimensions' => ':attribute hat ungültige Abmessungen.',
    'distinct' => ':attribute hat einen doppelten Wert.',
    'doesnt_end_with' => ':attribute darf nicht mit folgenden Werten enden: :values.',
    'doesnt_start_with' => ':attribute darf nicht mit folgenden Werten beginnen: :values.',
    'email' => ':attribute muss eine gültige E-Mail-Adresse sein.',
    'ends_with' => ':attribute muss mit einem der folgenden Werte enden: :values.',
    'enum' => 'Der ausgewählte Wert für :attribute ist ungültig.',
    'exists' => 'Der ausgewählte Wert für :attribute ist ungültig.',
    'file' => ':attribute muss eine Datei sein.',
    'filled' => ':attribute ist erforderlich.',
    'gt' => [
        'numeric' => ':attribute muss größer sein als :value.',
        'file' => ':attribute muss größer sein als :value Kilobytes.',
        'string' => ':attribute muss länger sein als :value Zeichen.',
        'array' => ':attribute muss mehr als :value Elemente enthalten.',
    ],

    'gte' => [
        'numeric' => ':attribute muss größer oder gleich :value sein.',
        'file'    => ':attribute muss :value Kilobyte oder größer sein.',
        'string'  => ':attribute muss :value Zeichen oder länger sein.',
        'array'   => ':attribute muss :value Elemente oder mehr enthalten.',
    ],
    'image' => ':attribute muss ein Bild sein.',
    'in' => ':attribute ist ungültig.',
    'in_array' => ':attribute existiert nicht in :other.',
    'integer' => ':attribute muss eine Ganzzahl sein.',
    'ip' => ':attribute muss eine gültige IP-Adresse sein.',
    'ipv4' => ':attribute muss eine gültige IPv4-Adresse sein.',
    'ipv6' => ':attribute muss eine gültige IPv6-Adresse sein.',
    'json' => ':attribute muss eine gültige JSON-Zeichenkette sein.',
    'lt' => [
        'numeric' => ':attribute muss kleiner als :value sein.',
        'file'    => ':attribute muss kleiner als :value Kilobyte sein.',
        'string'  => ':attribute muss kürzer als :value Zeichen sein.',
        'array'   => ':attribute muss weniger als :value Elemente enthalten.',
    ],
    'lte' => [
        'numeric' => ':attribute muss kleiner oder gleich :value sein.',
        'file'    => ':attribute muss :value Kilobyte oder kleiner sein.',
        'string'  => ':attribute muss :value Zeichen oder kürzer sein.',
        'array'   => ':attribute darf nicht mehr als :value Elemente enthalten.',
    ],
    'mac_address' => ':attribute muss eine gültige MAC-Adresse sein.',
    'max' => [
        'array' => ':attribute darf nicht mehr als :max Elemente enthalten.',
        'file' => ':attribute darf nicht größer als :max Kilobyte sein.',
        'numeric' => ':attribute darf nicht größer als :max sein.',
        'string' => ':attribute darf nicht länger als :max Zeichen sein.',
    ],
    'mimes' => ':attribute muss den Dateityp :values haben.',
    'mimetypes' => ':attribute muss den Dateityp :values haben.',
    'min' => [
        'array' => ':attribute muss mindestens :min Elemente enthalten.',
        'file' => ':attribute muss mindestens :min Kilobyte groß sein.',
        'numeric' => ':attribute muss größer oder gleich :min sein.',
        'string' => ':attribute muss mindestens :min Zeichen lang sein.',
    ],
    'min_digits' => ':attribute muss mindestens :min Ziffern enthalten.',
    'multiple_of' => ':attribute muss ein Vielfaches von :value sein.',
    'not_in' => 'Der ausgewählte Wert für :attribute ist ungültig.',
    'not_regex' => ':attribute hat ein ungültiges Format.',
    'numeric' => ':attribute muss eine Zahl sein.',
    'password' => [
        'letters' => ':attribute muss mindestens einen Buchstaben enthalten.',
        'mixed' => ':attribute muss mindestens einen Großbuchstaben und einen Kleinbuchstaben enthalten.',
        'numbers' => ':attribute muss mindestens eine Zahl enthalten.',
        'symbols' => ':attribute muss mindestens ein Symbol enthalten.',
        'uncompromised' => 'Das eingegebene :attribute wurde in einem Datenleck entdeckt. Bitte wählen Sie ein neues :attribute.',
    ],
    'present' => ':attribute muss vorhanden sein.',
    'prohibited' => ':attribute ausfüllen ist verboten.',
    'prohibited_if' => ':attribute ist nicht erlaubt, wenn :other den Wert :value hat.',
    'prohibited_unless' => ':attribute ist nur erlaubt, wenn :other einen der Werte :values hat.',
    'prohibits' => ':attribute verhindert das Vorhandensein von :other.',
    'regex' => ':attribute hat ein ungültiges Format.',
    'required' => ':attribute ist erforderlich.',
    'required_array_keys' => ':attribute muss die folgenden Schlüssel enthalten: :values.',
    'required_if' => ':attribute ist erforderlich, wenn :other den Wert :value hat.',
    'required_if_accepted' => ':attribute ist erforderlich, wenn :other akzeptiert wurde.',
    'required_unless' => ':attribute ist erforderlich, wenn :other nicht einen der Werte :values hat.',
    'required_with' => ':attribute ist erforderlich, wenn :values vorhanden ist.',
    'required_with_all' => ':attribute ist erforderlich, wenn :values vorhanden ist.',
    'required_without' => ':attribute ist erforderlich, wenn :values nicht vorhanden ist.',
    'required_without_all' => ':attribute ist erforderlich, wenn keines der :values vorhanden ist.',
    'same' => ':attribute und :other müssen übereinstimmen.',
    'size' => [
        'array' => ':attribute muss genau :size Elemente enthalten.',
        'file' => ':attribute muss genau :size Kilobyte groß sein.',
        'numeric' => ':attribute muss genau :size sein.',
        'string' => ':attribute muss genau :size Zeichen lang sein.',
    ],
    'starts_with' => ':attribute muss mit einem der folgenden Werte beginnen: :values',
    'string' => ':attribute muss eine Zeichenkette sein.',
    'timezone' => ':attribute muss eine gültige Zeitzone sein.',
    'unique' => ':attribute wurde bereits verwendet.',
    'uploaded' => ':attribute konnte nicht hochgeladen werden.',
    'url' => ':attribute hat ein ungültiges Format.',
    'uuid' => ':attribute muss ein gültiger UUID sein.',

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
            'regex' => 'Veri alanı x için "a-b.c" formatında olmalıdır.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Attribute Names
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    | Example: 'email' => 'E-Mail Address',
    |          'password' => 'Password',
    |
    */

    'attributes' => [
        'password' => 'Passwort',
        'email' => 'E-Mail-Adresse',
        'name' => 'Name',
        'checkbox' => 'Bestätigungskästchen',
    ],

    'required' => 'Dieses Feld ist erforderlich.',
    'email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
    'name.required' => 'Bitte geben Sie Ihren Namen ein.',
    'email.required' => 'Bitte geben Sie Ihre E-Mail-Adresse ein.',
    'message.required' => 'Bitte geben Sie Ihre Nachricht ein.',

];
