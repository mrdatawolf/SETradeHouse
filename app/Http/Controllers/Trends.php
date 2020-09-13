<?php

namespace App\Http\Controllers;

use App\Components;
use App\InActiveTransactions;
use App\Ingots;
use App\Ores;
use App\Tools;
use Carbon\Carbon;

class Trends extends Controller
{
    public function ironOreIndex() {
        $pageTitle = "Iron Ore Trends";
        $dataPoints = $this->gatherDataPoints(1, 3);
        $trendHourlyAvg = $this->trendingHourlyAvg($dataPoints);
        $trendHourlyAvgLabels = $this->trendingHourlyAvgLabels($dataPoints);
        $trendDailyAvg = $this->trendingDailyAvg($dataPoints);
        $trendDailyAvgLabels = $this->trendingDailyAvgLabels($dataPoints);

        $jsonDataPoints = json_encode($dataPoints);
        $jsonHourlyAvg        = json_encode($trendHourlyAvg, true);
        $jsonHourlyAvgLabels  = json_encode($trendHourlyAvgLabels);
        $jsonDailyAvg        = json_encode($trendDailyAvg, true);
        $jsonDailyAvgLabels  = json_encode($trendDailyAvgLabels);

        return view('trends.ores.iron', compact('pageTitle','jsonDataPoints', 'jsonHourlyAvg', 'jsonHourlyAvgLabels', 'jsonDailyAvg', 'jsonDailyAvgLabels'));
    }


    public function oreIndex() {
        $pageTitle              = "Ore Trends";
        $dataPoints             = $this->gatherDataPoints(1);
        $trendHourlyAvg         = $this->trendingHourlyAvg($dataPoints);
        $trendHourlyAvgLabels   = $this->trendingHourlyAvgLabels($dataPoints);
        $trendDailyAvg          = $this->trendingDailyAvg($dataPoints);
        $trendDailyAvgLabels    = $this->trendingDailyAvgLabels($dataPoints);

        return view('trends.general.all', compact('pageTitle', 'trendHourlyAvg', 'trendHourlyAvgLabels', 'trendDailyAvg', 'trendDailyAvgLabels'));
    }

    public function ingotIndex() {
        $pageTitle              = "Ingot Trends";
        $dataPoints             = $this->gatherDataPoints(2);
        $trendHourlyAvg         = $this->trendingHourlyAvg($dataPoints);
        $trendHourlyAvgLabels   = $this->trendingHourlyAvgLabels($dataPoints);
        $trendDailyAvg          = $this->trendingDailyAvg($dataPoints);
        $trendDailyAvgLabels    = $this->trendingDailyAvgLabels($dataPoints);

        return view('trends.general.all', compact('pageTitle', 'trendHourlyAvg', 'trendHourlyAvgLabels', 'trendDailyAvg', 'trendDailyAvgLabels'));
    }

    public function componentIndex() {
        $pageTitle              = "Component Trends";
        $dataPoints             = $this->gatherDataPoints(3);
        $trendHourlyAvg         = $this->trendingHourlyAvg($dataPoints);
        $trendHourlyAvgLabels   = $this->trendingHourlyAvgLabels($dataPoints);
        $trendDailyAvg          = $this->trendingDailyAvg($dataPoints);
        $trendDailyAvgLabels    = $this->trendingDailyAvgLabels($dataPoints);

        return view('trends.general.all', compact('pageTitle', 'trendHourlyAvg', 'trendHourlyAvgLabels', 'trendDailyAvg', 'trendDailyAvgLabels'));
    }

    public function toolIndex() {
        $pageTitle              = "Tools Trends";
        $dataPoints             = $this->gatherDataPoints(4);
        $trendHourlyAvg         = $this->trendingHourlyAvg($dataPoints);
        $trendHourlyAvgLabels   = $this->trendingHourlyAvgLabels($dataPoints);
        $trendDailyAvg          = $this->trendingDailyAvg($dataPoints);
        $trendDailyAvgLabels    = $this->trendingDailyAvgLabels($dataPoints);

        return view('trends.general.all', compact('pageTitle', 'trendHourlyAvg', 'trendHourlyAvgLabels', 'trendDailyAvg', 'trendDailyAvgLabels'));
    }


    /**
     * @param $dataPoints
     *
     * @return array
     */
    private function trendingHourlyAvg($dataPoints) {
        $trendHourlyAvg = [];
        if(!empty($dataPoints)) {
            foreach ($dataPoints->all() as $title => $oreData) {
                foreach ($oreData as $month => $monthValue) {
                    if((int)$month === Carbon::now()->month) {
                        foreach ($monthValue as $day => $dayValue) {
                            if ((int)$day === Carbon::now()->day) {
                                $trendDailyAvgLabels[$title][] = $month."/".$day;
                                foreach ($dayValue as $hour => $hourValue) {
                                    $avg                      = round($hourValue->average / $hourValue->amount, 2);
                                    $trendHourlyAvg[$title][] = $avg;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $trendHourlyAvg;
    }


    /**
     * @param $dataPoints
     *
     * @return array
     */
    private function trendingHourlyAvgLabels($dataPoints) {
        $trendHourlyAvgLabels = [];
        if(!empty($dataPoints)) {
            foreach ($dataPoints as $title => $oreData) {
                foreach ($oreData as $month => $monthValue) {
                    if((int)$month === Carbon::now()->month) {
                        foreach ($monthValue as $day => $dayValue) {
                            if ((int)$day === Carbon::now()->day) {
                                $trendDailyAvgLabels[$title][] = $month."/".$day;
                                foreach ($dayValue as $hour => $hourValue) {
                                    $trendHourlyAvgLabels[$title][] = [$hour];;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $trendHourlyAvgLabels;
    }


    private function trendingDailyAvg($dataPoints) {
        $trendDailyAvg = [];
        if(!empty($dataPoints)) {
            foreach ($dataPoints as $title => $oreData) {
                foreach ($oreData as $month => $monthValue) {
                    foreach ($monthValue as $day => $dayValue) {
                        $trendDailyRawAvg              = 0;
                        $trendDailyAmount              = 0;
                        $trendDailyAvgLabels[$title][] = $month."/".$day;
                        foreach ($dayValue as $hour => $hourValue) {
                            $avg              = round($hourValue->average / $hourValue->amount, 2);
                            $trendDailyRawAvg += $avg;
                            $trendDailyAmount++;
                        }
                        $trendDailyAvg[$title][] = $trendDailyRawAvg / $trendDailyAmount;
                    }
                }
            }
        }

        return $trendDailyAvg;
    }


    private function trendingDailyAvgLabels($dataPoints) {
        $trendDailyAvgLabels = [];
        if(!empty($dataPoints)) {
            foreach ($dataPoints as $title => $oreData) {
                foreach ($oreData as $month => $monthValue) {
                    foreach ($monthValue as $day => $dayValue) {
                        $trendDailyAvgLabels[$title][] = $month."/".$day;
                    }
                }
            }
        }

        return $trendDailyAvgLabels;
    }


    /**
     * note: take the inactive transactions and get a collection to work with.
     * @param      $goodTypeId
     * @param null $goodId
     *
     * @return mixed
     */
    private function gatherDataPoints($goodTypeId, $goodId = null)
    {
        $dataPoints          = [];
        $inActiveTransactons = InActiveTransactions::where('good_type_id', $goodTypeId)->where('updated_at', '>', Carbon::now()->subDays(30));
        if ( ! empty($goodId)) {
            $inActiveTransactons->where('good_id', $goodId);
        }
        $transactons = $inActiveTransactons->get();
        if(! empty($transactons)) {
            foreach ($transactons as $transacton) {
                switch ($goodTypeId) {
                    case 1:
                        $title = Ores::find($transacton->good_id)->title;
                        break;
                    case 2:
                        $title = Ingots::find($transacton->good_id)->title;
                        break;
                    case 3:
                        $title = Components::find($transacton->good_id)->title;
                        break;
                    case 4:
                        $title = Tools::find($transacton->good_id)->title;
                        break;
                    default:
                        die('Invalid type');
                }
                $title = str_replace(' ','',$title);
                $title = str_replace('.','',$title);
                $title = str_replace('-','',$title);
                $title = str_replace('[','',$title);
                $title = str_replace(']','',$title);
                $title = str_replace('(','',$title);
                $title = str_replace(')','',$title);
                $hour  = $transacton->updated_at->hour;
                $day   = $transacton->updated_at->day;
                $month = $transacton->updated_at->month;

                if (empty($dataPoints[$month][$day][$hour])) {
                    $dataPoints[$title][$month][$day][$hour]['value']   = $transacton->value;
                    $dataPoints[$title][$month][$day][$hour]['amount']  = $transacton->amount;
                    $dataPoints[$title][$month][$day][$hour]['average'] = $transacton->value * $transacton->amount;
                    $dataPoints[$title][$month][$day][$hour]['count']   = 0;
                } else {
                    $dataPoints[$title][$month][$day][$hour]['value']   += $transacton->value;
                    $dataPoints[$title][$month][$day][$hour]['amount']  += $transacton->amount;
                    $dataPoints[$title][$month][$day][$hour]['average'] += $transacton->value * $transacton->amount;
                    $dataPoints[$title][$month][$day][$hour]['count']   += 1;
                }
            }
        }
        $dataPointsJson = json_encode($dataPoints);
        $dataPointsObject = json_decode($dataPointsJson);

        return collect($dataPointsObject);
    }
}
