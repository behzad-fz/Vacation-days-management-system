<?php

namespace App\Traits;

use Carbon\Carbon;

trait ContentFormatter
{
    /**
     * @param array $data
     * @return string
     */
    public function prepareContent(array $data): string
    {
        $content = "\n";
        $content .= "Report Date and Time: " . Carbon::now();
        $content .= "\nPowered by Ottonova";
        $content .= "\n";
        $content .= "|".str_repeat("-", 72)."|";
        $content .= "\n|";

        if (count($data) < 1) {
            $content .=  " \tNo data available for given year !".str_repeat(" ", 31)."|\n";
            $content .="|".str_repeat("-", 72)."|\n";

            $content .= "\n";
            $content .= "© Copyright 2015-2022 - Works Copyright - All rights reserved ";
            $content .= "\n\n";

            return $content;
        }

        $content .= str_repeat(" ", 14 ).'Name'.str_repeat(" ", 14 )."|";
        $content .= str_repeat(" ", 10 ).'Vacations Days'.str_repeat(" ", 15 )."|";

        $content .= "\n";
        $content .= "|".str_repeat("-", 72)."|";


        $result = "\n";
        foreach ($data as $item) {
            $result .= '|';
            $result .= str_repeat(" ", 10);
            $result .= $item['name'];
            $result .= str_repeat(" ",22 - mb_strlen($item['name']));
            $result .= '|';
            $result .= str_repeat(" ", 10);
            $result .= round($item['vacation_days'],1).' days';
            $result .= str_repeat(" ", 24 - strlen((string) round($item['vacation_days'],1)));
            $result .= '|';
            $result .= "\n";
            $result .= "|";
            $result .= str_repeat(" ",32);
            $result .= "|";
            $result .= str_repeat(" ",39);
            $result .= "|";
            $result .="\n";
        }

        $content .= $result;

        $content .= "|".str_repeat("-", 72)."|";
        $content .= "\n";
        $content .= "© Copyright 2015-2022 - Works Copyright - All rights reserved ";
        $content .= "\n\n";

        return $content;
    }
}