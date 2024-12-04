<?php

namespace App\Helper;

class Censurator
{
    public function __construct(array $censuredWords) {
        $this->censuredWords = $censuredWords;
    }

    const BAN_WORDS = ['amour', 'joie', 'cuisine'];

    public function purify(string $text): string {

        $text = str_ireplace(self::BAN_WORDS, '*+%$*%', $text);
//        foreach($this->censuredWords as $word) {
//            $text = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', '****', $string);
//        }
        return $text;
    }
}