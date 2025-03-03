<?php

namespace backend\models;

use common\models\Client;


class JournalChart
{
    /**
     * @return array
     */
    public static function journal()
    {
        $allData = [];

        $defaultBeginDay = strtotime(date('01.m.Y 00:00:00'));
        $defaultEndDay = strtotime(date('t.m.Y 00:00:00'));
        $day = $defaultBeginDay;
        $days = [];
        $journal = [];

        while ($day <= $defaultEndDay) {

            $days[] = date('d.m.Y', $day);

            $oldDay = $day;
            $day = strtotime('+1 day', $day);

            $journalDateCount = Client::find()
                ->andFilterWhere(['>=', 'created_at', $oldDay])
                ->andFilterWhere(['<', 'created_at', $day])
                ->count();

            $journal[] = $journalDateCount;
        }

        $allData['days'] = $days;
        $allData['journalDateCount'] = $journal;

//        VarDumper::dump();
        return $allData;

    }

}