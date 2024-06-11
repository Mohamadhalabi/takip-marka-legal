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

    'accepted' => ':attribute debe ser aceptado.',
    'accepted_if' => ':attribute debe ser aceptado si el campo :other tiene el valor :value.',
    'active_url' => ':attribute debe ser una URL válida.',
    'after' => ':attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => ':attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => ':attribute solo puede contener letras.',
    'alpha_dash' => ':attribute solo puede contener letras, números y guiones.',
    'alpha_num' => ':attribute solo puede contener letras y números.',
    'array' => ':attribute debe ser un arreglo.',
    'before' => ':attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => ':attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => ':attribute debe estar entre :min y :max.',
        'file' => ':attribute debe tener un tamaño entre :min y :max kilobytes.',
        'string' => ':attribute debe tener entre :min y :max caracteres.',
        'array' => ':attribute debe tener entre :min y :max elementos.',
    ],
    'boolean' => ':attribute debe ser verdadero o falso.',
    'confirmed' => ':attribute no coincide con la confirmación.',
    'current_password' => 'La contraseña actual es incorrecta.',
    'date' => ':attribute debe ser una fecha válida.',
    'date_equals' => ':attribute debe ser igual a :date.',
    'date_format' => ':attribute no coincide con el formato :format.',
    'declined' => ':attribute debe ser rechazado.',
    'declined_if' => ':attribute debe ser rechazado si el campo :other tiene el valor :value.',
    'different' => ':attribute y :other deben ser diferentes.',
    'digits' => ':attribute debe tener :digits dígitos.',
    'digits_between' => ':attribute debe tener entre :min y :max dígitos.',
    'dimensions' => ':attribute tiene dimensiones de imagen inválidas.',
    'distinct' => ':attribute tiene un valor duplicado.',
    'doesnt_end_with' => ':attribute no debe terminar con ninguno de los siguientes: :values.',
    'doesnt_start_with' => ':attribute no debe comenzar con ninguno de los siguientes: :values.',
    'email' => ':attribute debe ser una dirección de correo electrónico válida.',
    'ends_with' => ':attribute debe terminar con alguno de los siguientes: :values.',
    'enum' => ':attribute seleccionado es inválido.',
    'exists' => ':attribute seleccionado es inválido.',
    'file' => ':attribute debe ser un archivo.',
    'filled' => ':attribute es obligatorio.',
    'gt' => [
        'numeric' => ':attribute debe ser mayor que :value.',
        'file' => ':attribute debe tener un tamaño mayor que :value kilobytes.',
        'string' => ':attribute debe tener más de :value caracteres.',
        'array' => ':attribute debe tener más de :value elementos.',
    ],
    'gte' => [
        'numeric' => ':attribute debe ser mayor o igual que :value.',
        'file' => ':attribute debe tener un tamaño mayor o igual que :value kilobytes.',
        'string' => ':attribute debe tener al menos :value caracteres.',
        'array' => ':attribute debe tener al menos :value elementos.',
    ],
    'image' => ':attribute debe ser una imagen.',
    'in' => ':attribute seleccionado es inválido.',
    'in_array' => ':attribute no existe en :other.',
    'integer' => ':attribute debe ser un número entero.',
    'ip' => ':attribute debe ser una dirección IP válida.',
    'ipv4' => ':attribute debe ser una dirección IPv4 válida.',
    'ipv6' => ':attribute debe ser una dirección IPv6 válida.',
    'json' => ':attribute debe ser una cadena JSON válida.',
    'lt' => [
        'numeric' => ':attribute debe ser menor que :value.',
        'file' => ':attribute debe tener un tamaño menor que :value kilobytes.',
        'string' => ':attribute debe tener menos de :value caracteres.',
        'array' => ':attribute debe tener menos de :value elementos.',
    ],
    'lte' => [
        'numeric' => ':attribute debe ser menor o igual que :value.',
        'file' => ':attribute debe tener un tamaño menor o igual que :value kilobytes.',
        'string' => ':attribute debe tener como máximo :value caracteres.',
        'array' => ':attribute no debe tener más de :value elementos.',
    ],
    'mac_address' => ':attribute debe ser una dirección MAC válida.',
    'max' => [
        'array' => ':attribute no debe tener más de :max elementos.',
        'file' => ':attribute no debe ser mayor que :max kilobytes.',
        'numeric' => ':attribute no debe ser mayor que :max.',
        'string' => ':attribute no debe tener más de :max caracteres.',
    ],
    'mimes' => ':attribute debe ser un archivo de tipo: :values.',
    'mimetypes' => ':attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'array' => ':attribute debe tener al menos :min elementos.',
        'file' => ':attribute debe ser al menos :min kilobytes.',
        'numeric' => ':attribute debe ser al menos :min.',
        'string' => ':attribute debe tener al menos :min caracteres.',
    ],
    'min_digits' => ':attribute debe tener al menos :min dígitos.',
    'multiple_of' => ':attribute debe ser un múltiplo de :value.',
    'not_in' => 'El valor seleccionado para :attribute es inválido.',
    'not_regex' => 'El formato de :attribute es inválido.',
    'numeric' => ':attribute debe ser un número.',
    'password' => [
        'letters' => ':attribute debe contener al menos una letra.',
        'mixed' => ':attribute debe contener al menos una letra mayúscula y una letra minúscula.',
        'numbers' => ':attribute debe contener al menos un número.',
        'symbols' => ':attribute debe contener al menos un símbolo.',
        'uncompromised' => ':attribute ha sido comprometido en una filtración de datos. Por favor, elige una nueva :attribute.',
    ],
    'present' => ':attribute debe estar presente.',
    'prohibited' => 'No se permite ingresar :attribute.',
    'prohibited_if' => 'No se permite ingresar :attribute cuando :other es :value.',
    'prohibited_unless' => 'No se permite ingresar :attribute a menos que :other esté en :values.',
    'prohibits' => ':attribute prohíbe que :other esté presente.',
    'regex' => 'El formato de :attribute es inválido.',
    'required' => ':attribute es obligatorio.',
    'required_array_keys' => ':attribute debe tener las siguientes claves: :values.',
    'required_if' => ':attribute es obligatorio cuando :other es :value.',
    'required_if_accepted' => ':attribute es obligatorio cuando :other es aceptado.',
    'required_unless' => ':attribute es obligatorio a menos que :other esté en :values.',
    'required_with' => ':attribute es obligatorio cuando :values está presente.',
    'required_with_all' => ':attribute es obligatorio cuando :values están presentes.',
    'required_without' => ':attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => ':attribute es obligatorio cuando ninguno de los :values está presente.',
    'same' => ':attribute y :other deben coincidir.',
    'size' => [
        'array' => ':attribute debe contener :size elementos.',
        'file' => ':attribute debe tener un tamaño de :size kilobytes.',
        'numeric' => ':attribute debe ser :size.',
        'string' => ':attribute debe tener :size caracteres.',
    ],
    'starts_with' => ':attribute debe comenzar con uno de los siguientes valores: :values',
    'string' => ':attribute debe ser una cadena de texto.',
    'timezone' => ':attribute debe ser una zona horaria válida.',
    'unique' => ':attribute ya ha sido tomado.',
    'uploaded' => ':attribute no se pudo subir.',
    'url' => 'El formato de :attribute es inválido.',
    'uuid' => ':attribute debe ser un UUID válido.',
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
    'required' => 'Este campo es obligatorio.',
    'email' => 'Por favor, ingrese una dirección de correo electrónico válida.',
    'name.required' => 'Por favor, ingrese su nombre.',
    'email.required' => 'Por favor, ingrese su dirección de correo electrónico.',
    'message.required' => 'Por favor, ingrese su mensaje.',


];
