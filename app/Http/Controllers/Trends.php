<?php

namespace App\Http\Controllers;

use App\InActiveTransactions;
use App\Ores;
use Carbon\Carbon;

class Trends extends Controller
{

    public function ironOreIndex() {
        $title                  = "Iron Ore Trends";
        $inActiveTransactons    = InActiveTransactions::where('good_type_id',1)->where('good_id', 3)->get();
        $dataPoints             = [];
        foreach($inActiveTransactons as $transacton) {
            $hour   = $transacton->updated_at->hour;
            $day    = $transacton->updated_at->day;
            $month  = $transacton->updated_at->month;
            if(empty($dataPoints[$month][$day][$hour])) {
                $dataPoints[$month][$day][$hour]['value']    = $transacton->value;
                $dataPoints[$month][$day][$hour]['amount']   = $transacton->amount;
                $dataPoints[$month][$day][$hour]['average']  = $transacton->value*$transacton->amount;
                $dataPoints[$month][$day][$hour]['count']  = 0;
            } else {
                $dataPoints[$month][$day][$hour]['value']    += $transacton->value;
                $dataPoints[$month][$day][$hour]['amount']   += $transacton->amount;
                $dataPoints[$month][$day][$hour]['average']  += $transacton->value*$transacton->amount;
                $dataPoints[$month][$day][$hour]['count']    += 1;
            }
        }
        $trendHourlyAvg = [];
        $trendHourlyAvgLabels = [];
        $trendDailyAvg = [];
        $trendDailyAvgLabels = [];
        foreach ($dataPoints as $month => $monthValue) {
            foreach($monthValue as $day => $dayValue) {
                $trendDailyRawAvg = 0;
                $trendDailyAmount = 0;
                $trendDailyAvgLabels[] = $month . "/" . $day;
                foreach ($dayValue as $hour => $hourValue) {
                    $avg = round($hourValue['average'] / $hourValue['amount'], 2);
                    $trendHourlyAvg[]       = $avg;
                    $trendHourlyAvgLabels[] = [$month . "/" . $day . ":" . $hour];
                    $trendDailyRawAvg += $avg;
                    $trendDailyAmount++;
                }
               $trendDailyAvg[] = $trendDailyRawAvg/$trendDailyAmount;
            }
        }

        $jsonDataPoints = json_encode($dataPoints);
        $jsonHourlyAvg        = json_encode($trendHourlyAvg, true);
        $jsonHourlyAvgLabels  = json_encode($trendHourlyAvgLabels);
        $jsonDailyAvg        = json_encode($trendDailyAvg, true);
        $jsonDailyAvgLabels  = json_encode($trendDailyAvgLabels);

        return view('trends.ores.iron', compact('title','jsonDataPoints', 'jsonHourlyAvg', 'jsonHourlyAvgLabels', 'jsonDailyAvg', 'jsonDailyAvgLabels'));
    }


    public function oreIndex() {
        $title                  = "Iron Ore Trends";
        $inActiveTransactons    = InActiveTransactions::where('good_type_id',1)->where('updated_at', '>', Carbon::now()->subDays(30))->get();
        $dataPoints             = [];
        foreach($inActiveTransactons as $transacton) {
            $hour       = $transacton->updated_at->hour;
            $day        = $transacton->updated_at->day;
            $month      = $transacton->updated_at->month;
            $oreTitle   = Ores::find($transacton->good_id)->title;
            if(empty($dataPoints[$month][$day][$hour])) {
                $dataPoints[$oreTitle][$month][$day][$hour]['value']    = $transacton->value;
                $dataPoints[$oreTitle][$month][$day][$hour]['amount']   = $transacton->amount;
                $dataPoints[$oreTitle][$month][$day][$hour]['average']  = $transacton->value*$transacton->amount;
                $dataPoints[$oreTitle][$month][$day][$hour]['count']    = 0;
            } else {
                $dataPoints[$oreTitle][$month][$day][$hour]['value']    += $transacton->value;
                $dataPoints[$oreTitle][$month][$day][$hour]['amount']   += $transacton->amount;
                $dataPoints[$oreTitle][$month][$day][$hour]['average']  += $transacton->value*$transacton->amount;
                $dataPoints[$oreTitle][$month][$day][$hour]['count']    += 1;
            }
        }
        $trendHourlyAvg = [];
        $trendHourlyAvgLabels = [];
        $trendDailyAvg = [];
        $trendDailyAvgLabels = [];
        foreach($dataPoints as $oreTitle => $oreData) {
            foreach ($oreData as $month => $monthValue) {
                foreach ($monthValue as $day => $dayValue) {
                    $trendDailyRawAvg      = 0;
                    $trendDailyAmount      = 0;
                    $trendDailyAvgLabels[$oreTitle][] = $month."/".$day;
                    foreach ($dayValue as $hour => $hourValue) {
                        $avg                    = round($hourValue['average'] / $hourValue['amount'], 2);
                        $trendHourlyAvg[$oreTitle][]       = $avg;
                        $trendHourlyAvgLabels[$oreTitle][] = [$month."/".$day.":".$hour];
                        $trendDailyRawAvg       += $avg;
                        $trendDailyAmount++;
                    }
                    $trendDailyAvg[$oreTitle][] = $trendDailyRawAvg / $trendDailyAmount;
                }
            }
        }

        return view('trends.ores.all', compact('title', 'trendHourlyAvg', 'trendHourlyAvgLabels', 'trendDailyAvg', 'trendDailyAvgLabels'));
    }
}
