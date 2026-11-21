<?php

namespace App\Concerns\CustomStopWords;

use voku\helper\StopWords;

/**
 * Check the GitHub repository before adding new words
 *
 * https://github.com/voku/stop-words
 */

trait ArabicStopWords
{
    protected function arabicStopWords(StopWords $stopWords)
    {
        return [
            ...$stopWords->getStopWordsFromLanguage('ar'),
            'تحيه', 'طيبه', 'موعد', 'اخر', 'يرجى', 'الخاصه', 'التقدير', 'للعلم', 'دقه', 'تاريخ',
            'التاريخ', 'بتاريخ', 'العدد', 'عدد', 'علما', 'المرقم', 'العنوان', 'الحاصل', 'اقسام', 'كافه',
            'قسم', 'كتاب', 'ادناه', 'للتفضل', 'بالعلم', 'واجراء', 'نسخه', 'منه', 'استنادا', 'مكتب',
            'عالي', 'الصادره', 'الوارده', 'عدا', 'لاجراء', 'اجراء', 'اللازم', 'لازم', 'بنسخه', 'والذي'
        ];
    }
}
