<?php

namespace App\Concerns\CustomStopWords;

trait EnglishStopWords
{
    protected function getEnglishStopwords()
    {
        return [
            'republic', 'iraq', 'ministry', 'education', 'general', 'directorate',
            'educational', 'mail', 'email', 'phone', 'com', 'org'
        ];
    }
}
