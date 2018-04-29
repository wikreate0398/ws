<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Языковые ресурсы для проверки значений
    |--------------------------------------------------------------------------
    |
    | Последующие языковые строки содержат сообщения по-умолчанию, используемые
    | классом, проверяющим значения (валидатором). Некоторые из правил имеют
    | несколько версий, например, size. Вы можете поменять их на любые
    | другие, которые лучше подходят для вашего приложения.
    |
    */

    'accepted' => 'Вы должны принять <strong>:attribute</strong>.',
    'active_url' => 'Поле <strong>:attribute</strong> содержит недействительный URL.',
    'after' => 'В поле <strong>:attribute</strong> должна быть дата после :date.',
    'after_or_equal' => 'В поле <strong>:attribute</strong> должна быть дата после или равняться :date.',
    'alpha' => 'Поле <strong>:attribute</strong> может содержать только буквы.',
    'alpha_dash' => 'Поле <strong>:attribute</strong> может содержать только буквы, цифры и дефис.',
    'alpha_num' => 'Поле <strong>:attribute</strong> может содержать только буквы и цифры.',
    'array' => 'Поле <strong>:attribute</strong> должно быть массивом.',
    'before' => 'В поле <strong>:attribute</strong> должна быть дата до :date.',
    'before_or_equal' => 'В поле <strong>:attribute</strong> должна быть дата до или равняться :date.',
    'between' => [
        'numeric' => 'Поле <strong>:attribute</strong> должно быть между :min и :max.',
        'file' => 'Размер файла в поле <strong>:attribute</strong> должен быть между :min и :max Килобайт(а).',
        'string' => 'Количество символов в поле <strong>:attribute</strong> должно быть между :min и :max.',
        'array' => 'Количество элементов в поле <strong>:attribute</strong> должно быть между :min и :max.',
    ],
    'boolean' => 'Поле <strong>:attribute</strong> должно иметь значение логического типа.', // калька 'истина' или 'ложь' звучала бы слишком неестественно
    'confirmed' => 'Поле <strong>:attribute</strong> не совпадает с подтверждением.',
    'date' => 'Поле <strong>:attribute</strong> не является датой.',
    'date_format' => 'Поле <strong>:attribute</strong> не соответствует формату :format.',
    'different' => 'Поля <strong>:attribute</strong> и :other должны различаться.',
    'digits' => 'Длина цифрового поля <strong>:attribute</strong> должна быть :digits.',
    'digits_between' => 'Длина цифрового поля <strong>:attribute</strong> должна быть между :min и :max.',
    'dimensions' => 'Поле <strong>:attribute</strong> имеет недопустимые размеры изображения.',
    'distinct' => 'Поле <strong>:attribute</strong> содержит повторяющееся значение.',
    'email' => 'Поле <strong>:attribute</strong> должно быть действительным электронным адресом.',
    'file' => 'Поле <strong>:attribute</strong> должно быть файлом.',
    'filled' => 'Поле <strong>:attribute</strong> обязательно для заполнения.',
    'exists' => 'Выбранное значение для <strong>:attribute</strong> некорректно.',
    'image' => 'Поле <strong>:attribute</strong> должно быть изображением.',
    'in' => 'Выбранное значение для <strong>:attribute</strong> ошибочно.',
    'in_array' => 'Поле <strong>:attribute</strong> не существует в :other.',
    'integer' => 'Поле <strong>:attribute</strong> должно быть целым числом.',
    'ip' => 'Поле <strong>:attribute</strong> должно быть действительным IP-адресом.',
    'ipv4' => 'Поле <strong>:attribute</strong> должно быть действительным IPv4-адресом.',
    'ipv6' => 'Поле <strong>:attribute</strong> должно быть действительным IPv6-адресом.',
    'json' => 'Поле <strong>:attribute</strong> должно быть JSON строкой.',
    'max' => [
        'numeric' => 'Поле <strong>:attribute</strong> не может быть более :max.',
        'file' => 'Размер файла в поле <strong>:attribute</strong> не может быть более :max Килобайт(а).',
        'string' => 'Количество символов в поле <strong>:attribute</strong> не может превышать :max.',
        'array' => 'Количество элементов в поле <strong>:attribute</strong> не может превышать :max.',
    ],
    'mimes' => 'Поле <strong>:attribute</strong> должно быть файлом одного из следующих типов: :values.',
    'mimetypes' => 'Поле <strong>:attribute</strong> должно быть файлом одного из следующих типов: :values.',
    'min' => [
        'numeric' => 'Поле <strong>:attribute</strong> должно быть не менее :min.',
        'file' => 'Размер файла в поле <strong>:attribute</strong> должен быть не менее :min Килобайт(а).',
        'string' => 'Количество символов в поле <strong>:attribute</strong> должно быть не менее :min.',
        'array' => 'Количество элементов в поле <strong>:attribute</strong> должно быть не менее :min.',
    ],
    'not_in' => 'Выбранное значение для <strong>:attribute</strong> ошибочно.',
    'not_regex' => 'Выбранный формат для <strong>:attribute</strong> ошибочный.',
    'numeric' => 'Поле <strong>:attribute</strong> должно быть числом.',
    'present' => 'Поле <strong>:attribute</strong> должно присутствовать.',
    'regex' => 'Поле <strong>:attribute</strong> имеет ошибочный формат.',
    'required' => 'Поле <strong>:attribute</strong> обязательно для заполнения.',
    'required_if' => 'Поле <strong>:attribute</strong> обязательно для заполнения, когда :other равно :value.',
    'required_unless' => 'Поле <strong>:attribute</strong> обязательно для заполнения, когда :other не равно :values.',
    'required_with' => 'Поле <strong>:attribute</strong> обязательно для заполнения, когда :values указано.',
    'required_with_all' => 'Поле <strong>:attribute</strong> обязательно для заполнения, когда :values указано.',
    'required_without' => 'Поле <strong>:attribute</strong> обязательно для заполнения, когда :values не указано.',
    'required_without_all' => 'Поле <strong>:attribute</strong> обязательно для заполнения, когда ни одно из :values не указано.',
    'same' => 'Значение <strong>:attribute</strong> должно совпадать с :other.',
    'size' => [
        'numeric' => 'Поле <strong>:attribute</strong> должно быть равным :size.',
        'file' => 'Размер файла в поле <strong>:attribute</strong> должен быть равен :size Килобайт(а).',
        'string' => 'Количество символов в поле <strong>:attribute</strong> должно быть равным :size.',
        'array' => 'Количество элементов в поле <strong>:attribute</strong> должно быть равным :size.',
    ],
    'string' => 'Поле <strong>:attribute</strong> должно быть строкой.',
    'timezone' => 'Поле <strong>:attribute</strong> должно быть действительным часовым поясом.',
    'unique' => 'Такое значение поля <strong>:attribute</strong> уже существует.',
    'uploaded' => 'Загрузка поля <strong>:attribute</strong> не удалась.',
    'url' => 'Поле <strong>:attribute</strong> имеет ошибочный формат.',

    /*
    |--------------------------------------------------------------------------
    | Собственные языковые ресурсы для проверки значений
    |--------------------------------------------------------------------------
    |
    | Здесь Вы можете указать собственные сообщения для атрибутов.
    | Это позволяет легко указать свое сообщение для заданного правила атрибута.
    |
    | http://laravel.com/docs/validation#custom-error-messages
    | Пример использования
    |
    |   'custom' => [
    |       'email' => [
    |           'required' => 'Нам необходимо знать Ваш электронный адрес!',
    |       ],
    |   ],
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Собственные названия атрибутов
    |--------------------------------------------------------------------------
    |
    | Последующие строки используются для подмены программных имен элементов
    | пользовательского интерфейса на удобочитаемые. Например, вместо имени
    | поля "email" в сообщениях будет выводиться "электронный адрес".
    |
    | Пример использования
    |
    |   'attributes' => [
    |       'email' => 'электронный адрес',
    |   ],
    |
    */

    'attributes' => [
    ],
];
