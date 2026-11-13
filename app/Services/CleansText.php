<?php

namespace App\Services;

use App\Concerns\CustomStopWords\ArabicStopWords;
use App\Concerns\CustomStopWords\EnglishStopWords;
use voku\helper\StopWords;

class CleansText
{
    use EnglishStopWords, ArabicStopWords;

    public function prepareText(string $text): string
    {
        return $this->removeStopWords($this->cleanText($text));
    }


    private function cleanText(string $text): string
    {
        $text = $this->normalize($text);
        $text = preg_replace('/[^\p{L}\p{M}\s]+/u', ' ', $text);
        $text = preg_replace('/\b[a-z]{1,3}\b/u', ' ', $text);

        return trim(preg_replace('/\s+/u', ' ', $text));
    }


    private function removeStopWords(string $text): string
    {
        $lookup = $this->stopWords();
        $words = preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);

        $words = array_filter(
            $words,
            fn($w) => mb_strlen($w) > 2 && !isset($lookup[$w])
        );

        return implode(' ', array_unique($words));
    }


    private function normalize(string $text): string
    {
        $text = mb_scrub($text); // replace invalid UTF-8 so preg_* never returns null
        $text = preg_replace('/[\x{064B}-\x{065F}\x{0670}\x{0640}]/u', '', $text); // diacritics, tatweel
        $text = strtr($text, ['أ' => 'ا', 'إ'  => 'ا', 'آ'  => 'ا', 'اً' => 'ا', 'ة'  => 'ه']);

        return mb_strtolower($text);
    }


    private function stopWords(): array
    {
        static $lookup = null;

        if ($lookup === null) {
            $stopWords = new StopWords();

            $lookup = array_flip(array_map(
                fn($w) => $this->normalize($w),
                [
                    ...$stopWords->getStopWordsFromLanguage('ar'),
                    ...$this->getArabicStopWords(),
                    ...$stopWords->getStopWordsFromLanguage('en'),
                    ...$this->getEnglishStopwords(),
                ]
            ));
        }

        return $lookup;
    }
}
