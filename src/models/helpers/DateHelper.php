<?php

namespace App\models\helpers;

use App\models\entities\Topic;
use App\models\entities\Vote;
use App\core\Session;  


class DateHelper
{
    public static function dateToTime(string $date)
    {
        $currentDate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $currentDate->format('d-m-Y H:i:s');

        $date = \DateTime::createFromFormat('d-m-Y H:i:s', $date,  new \DateTimeZone('Europe/Paris'));

        $difference = $currentDate->diff($date);
        $time = '';
        
        if($difference->format('%y')){
            $time = self::returnTimeSentence($difference->format('%y'), 'an');
        } elseif ($difference->format('%m')) {
            $time = self::returnTimeSentence($difference->format('%m'), 'mois');
        } elseif ($difference->format('%d')) {
            $time = self::returnTimeSentence($difference->format('%d'), 'jour');
        } elseif ($difference->format('%h')) {
            $time = self::returnTimeSentence($difference->format('%h'), 'heure');
        } elseif ($difference->format('%i')) {
            $time = self::returnTimeSentence($difference->format('%i'), 'minute');
        } elseif ($difference->format('%s')) {
            $time = self::returnTimeSentence($difference->format('%s'), 'seconde');
        } else {
            $time = "a l'instant";
        }

        return $time;
    }

    // unit = format de temps Y, m, d, h, i, s
    private static function returnTimeSentence($unit, $unitOutput)
{
        $sentence = 'Il y a ' . $unit . ' ' . $unitOutput;
        if($unit > 1 && $unitOutput != 'mois') $sentence .= 's'; 

        return $sentence;
    }

}