<?php

/*
 * Turkish messages for the validation rules the app uses. Any rule missing
 * here falls back to Laravel's English message.
 */

return [
    'confirmed' => ':Attribute ve tekrarı birbirini tutmuyor.',
    'current_password' => 'Parola hatalı.',
    'email' => ':Attribute geçerli bir e-posta adresi olmalı.',
    'enum' => 'Seçilen :attribute geçersiz.',
    'lowercase' => ':Attribute küçük harflerle yazılmalı.',
    'max' => [
        'string' => ':Attribute en fazla :max karakter olabilir.',
    ],
    'min' => [
        'string' => ':Attribute en az :min karakter olmalı.',
    ],
    'password' => [
        'letters' => ':Attribute en az bir harf içermeli.',
        'mixed' => ':Attribute en az bir büyük ve bir küçük harf içermeli.',
        'numbers' => ':Attribute en az bir rakam içermeli.',
        'symbols' => ':Attribute en az bir sembol içermeli.',
        'uncompromised' => 'Bu parola bir veri sızıntısında görülmüş. Başka bir parola seç.',
    ],
    'required' => ':Attribute alanı boş bırakılamaz.',
    'string' => ':Attribute metin olmalı.',
    'unique' => 'Bu :attribute ile kayıtlı bir hesap zaten var.',
];
