<?php

namespace App\Concerns\CustomStopWords;

use voku\helper\StopWords;

/**
 * Check the GitHub repository before adding new words
 *
 * https://github.com/voku/stop-words
 */

trait EnglishStopWords
{
    protected function englishStopwords(StopWords $stopWords)
    {
        return [
            ...$stopWords->getStopWordsFromLanguage('en'),
            'republic', 'iraq', 'ministry', 'education', 'general', 'directorate',
            'educational', 'mail', 'email', 'phone', 'com', 'org'
        ];
    }
}
