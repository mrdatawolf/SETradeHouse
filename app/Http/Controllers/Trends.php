<?php

namespace App\Http\Controllers;

use App\InActiveTransactions;

class Trends extends Controller
{

    public function ironOreIndex() {
        $title          = "Iron Ore Trends";
        $transactons    = InActiveTransactions::where('good_type_id',1)->where('good_id', 3)->get();
        $dataPoints     = [];
        $trendAvg       = [];
        $trendAvgLabels = [];
        foreach($transactons as $transacton) {
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
        foreach ($dataPoints as $month => $monthValue) {
            foreach($monthValue as $day => $dayValue) {
                foreach ($dayValue as $hour => $hourValue) {
                    $trendAvg[]       = round($hourValue['average'] / $hourValue['amount'], 2);
                    $trendAvgLabels[] = [$month . "/" . $day . ":" . $hour];
                }
            }
        }
        $jsonAvg        = json_encode($trendAvg, true);
        $jsonDataPoints = json_encode($dataPoints);
        $jsonAvgLabels  = json_encode($trendAvgLabels);

        return view('trends.ores.iron', compact('title','jsonDataPoints', 'jsonAvg', 'jsonAvgLabels'));
    }
}
