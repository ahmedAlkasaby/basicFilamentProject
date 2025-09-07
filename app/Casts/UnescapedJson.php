<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class UnescapedJson implements CastsAttributes
{
    /**
     * استرجاع القيمة من قاعدة البيانات.
     * نحول السلسلة المخزنة إلى مصفوفة.
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return json_decode($value, true);
    }

    /**
     * تعيين القيمة في قاعدة البيانات.
     * نحول المصفوفة إلى JSON باستخدام JSON_UNESCAPED_UNICODE
     * حتى تُخزن النصوص العربية بشكل واضح.
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
