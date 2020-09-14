<?php

namespace App\Http\Controllers;

use App\Components;
use App\InActiveTransactions;
use App\Ingots;
use App\Ores;
use App\Tools;
use App\Transactions;
use Carbon\Carbon;

class Trends extends Controller
{
    public function ironOreIndex() {
        $pageTitle              = "Iron Ore Trends";
        $dataPoints             = $this->sessionDataPoints(1,3);
        $trendHourlyAvg         = $this->trendingHourlyAvg($dataPoints);
        $trendHourlyAvgLabels   = $this->trendingHourlyAvgLabels($dataPoints);
        $trendDailyAvg          = $this->trendingDailyAvg($dataPoints);
        $trendDailyAvgLabels    = $this->trendingDailyAvgLabels($dataPoints);
        $jsonDataPoints         = json_encode($dataPoints);
        $jsonHourlyAvg          = json_encode($trendHourlyAvg, true);
        $jsonHourlyAvgLabels    = json_encode($trendHourlyAvgLabels);
        $jsonDailyAvg           = json_encode($trendDailyAvg, true);
        $jsonDailyAvgLabels     = json_encode($trendDailyAvgLabels);

        return view('trends.ores.iron', compact('pageTitle','jsonDataPoints', 'jsonHourlyAvg', 'jsonHourlyAvgLabels', 'jsonDailyAvg', 'jsonDailyAvgLabels'));
    }


    public function oreIndex() {
        $pageTitle  = "Ore Trends";
        $dataPoints = $this->sessionDataPoints(1);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }

    public function ingotIndex() {
        $pageTitle  = "Ingot Trends";
        $dataPoints = $this->sessionDataPoints(2);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }

    public function componentIndex() {
        $pageTitle  = "Component Trends";
        $dataPoints = $this->sessionDataPoints(3);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }

    public function toolIndex() {
        $pageTitle  = "Tools Trends";
        $dataPoints = $this->sessionDataPoints(4);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }


    private function sessionDataPoints($goodTypeId, $goodId = 0) {

        if(! \Session::has('dataPoints_' . $goodTypeId . '_' . $goodId)) {
            $dataPoints = $this->gatherDataPoints($goodTypeId, $goodId);
            \Session::put('dataPoints_' . $goodTypeId . '_' . $goodId);
        } else {
            $dataPoints = \Session::get('dataPoints_' . $goodTypeId . '_' . $goodId);
        }

        return $dataPoints;
    }


    /**
     * @param $dataPoints
     * @param $pageTitle
     *
     * @return array
     */
    private function makeGeneralCompact($dataPoints, $pageTitle) {
        $trendHourlyAvg         = $this->trendingHourlyAvg($dataPoints);
        $trendHourlyAvgLabels   = $this->trendingHourlyAvgLabels($dataPoints);
        $trendDailyAvg          = $this->trendingDailyAvg($dataPoints);
        $trendDailyAvailable    = $this->trendingDailyAvailable($dataPoints);
        $trendDailyAvgLabels    = $this->trendingDailyAvgLabels($dataPoints);

        return compact('pageTitle', 'trendHourlyAvg', 'trendHourlyAvgLabels', 'trendDailyAvg', 'trendDailyAvgLabels', 'trendDailyAvailable');
    }


    /**
     * @param $dataPoints
     *
     * @return array
     */
    private function trendingHourlyAvg($dataPoints) {
        $trendHourlyAvg = [];
        if(!empty($dataPoints)) {
            foreach ($dataPoints as $title => $oreData) {
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


    private function trendingDailyAvailable($dataPoints) {
        $trendDailyAmount = [];
        if(!empty($dataPoints)) {
            foreach ($dataPoints as $title => $oreData) {
                foreach ($oreData as $month => $monthValue) {
                    foreach ($monthValue as $day => $dayValue) {
                        $rawAmount                      = 0;
                        foreach ($dayValue as $hour => $hourValue) {
                            $rawAmount = $hourValue->offerAmount;
                        }
                        $trendDailyAmount[$title][] = round($rawAmount, 2);
                    }
                }
            }
        }

        return $trendDailyAmount;
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
    private function gatherInActiveTransactions($goodTypeId, $goodId = null)
    {
        $dataPoints          = [];
        $inActiveTransactons = InActiveTransactions::where('good_type_id', $goodTypeId)->where('updated_at', '>', Carbon::now()->subDays(30));
        if ( ! empty($goodId)) {
            $inActiveTransactons->where('good_id', $goodId);
        }
        $transactions = $inActiveTransactons->get();
        if(! empty($transactions)) {
            foreach ($transactions as $transaction) {
                $dataPoints = $this->addDataPointRow($dataPoints, $goodTypeId, $transaction);
            }
        }
        return $dataPoints;
    }


    /**
     * note: take the active transactions and get a collection to work with.
     * @param      $goodTypeId
     * @param null $goodId
     *
     * @return mixed
     */
    private function gatherTransactions($goodTypeId, $goodId = null)
    {
        $dataPoints          = [];
        $inActiveTransactons = Transactions::where('good_type_id', $goodTypeId)->where('updated_at', '>', Carbon::now()->subDays(30));
        if ( ! empty($goodId)) {
            $inActiveTransactons->where('good_id', $goodId);
        }
        $transactions = $inActiveTransactons->get();
        if(! empty($transactions)) {
            foreach ($transactions as $transaction) {
                $dataPoints = $this->addDataPointRow($dataPoints, $goodTypeId, $transaction);
            }
        }
        return $dataPoints;
    }


    /**
     * @param $dataPoints
     * @param $goodTypeId
     * @param $transaction
     *
     * @return array
     */
    private function addDataPointRow($dataPoints, $goodTypeId, $transaction) {
        $title      = $this->goodTitleById($goodTypeId, $transaction->good_id);
        $minute     = $transaction->updated_at->minute;
        $hour       = $transaction->updated_at->hour;
        $day        = $transaction->updated_at->day;
        $month      = $transaction->updated_at->month;
        $amountType = ($transaction->transaction_type_id === 1) ? 'orderAmount' : 'offerAmount';
        if (empty($dataPoints[$title][$month][$day][$hour])) {
            $dataPoints[$title][$month][$day][$hour]['value']                   = 0;
            $dataPoints[$title][$month][$day][$hour]['amount']                  = 0;
            $dataPoints[$title][$month][$day][$hour]['orderAmount']             = 0;
            $dataPoints[$title][$month][$day][$hour]['offerAmount']             = 0;
            $dataPoints[$title][$month][$day][$hour]['average']                 = 0;
            $dataPoints[$title][$month][$day][$hour]['count']                   = 0;
            $dataPoints[$title][$month][$day][$hour]['orderAmountLatestMinute'] = 0;
            $dataPoints[$title][$month][$day][$hour]['offerAmountLatestMinute'] = 0;
        }
        $dataPoints[$title][$month][$day][$hour]['value']   += $transaction->value;
        $dataPoints[$title][$month][$day][$hour]['amount']  += $transaction->amount;
        if($dataPoints[$title][$month][$day][$hour][$amountType . 'LatestMinute'] === 0
            ||
            ($minute > $dataPoints[$title][$month][$day][$hour][$amountType . 'LatestMinute'] && $transaction->amount > 0 )
        ) {
            $dataPoints[$title][$month][$day][$hour][$amountType . 'LatestMinute']  = $minute;
            $dataPoints[$title][$month][$day][$hour][$amountType]                   = $transaction->amount;
        } else {
            $dataPoints[$title][$month][$day][$hour][$amountType] += $transaction->amount;
        }

        $dataPoints[$title][$month][$day][$hour]['average'] += $transaction->value * $transaction->amount;
        $dataPoints[$title][$month][$day][$hour]['count']   += 1;

        return $dataPoints;
    }

    private function dataPointsToCollection($dataPoints) {
        $dataPointsJson = json_encode($dataPoints);
        $dataPointsObject = json_decode($dataPointsJson);

        return collect($dataPointsObject);
    }


    private function goodTitleById($goodTypeId, $goodId) {
        switch ($goodTypeId) {
            case 1:
                $title = Ores::find($goodId)->title;
                break;
            case 2:
                $title = Ingots::find($goodId)->title;
                break;
            case 3:
                $title = Components::find($goodId)->title;
                break;
            case 4:
                $title = Tools::find($goodId)->title;
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

        return $title;
    }


    private function gatherDataPoints($goodTypeId, $goodId = null) {
        $dataPoints = $this->gatherInActiveTransactions($goodTypeId, $goodId);
        $active = $this->gatherTransactions($goodTypeId, $goodId);

        foreach($active as $title => $goodData) {
            foreach($goodData as $month => $monthData) {
                foreach ($monthData as $day => $dayData) {
                    foreach($dayData as $hour => $hourData) {
                        if (empty($dataPoints[$title][$month][$day][$hour])) {
                            $dataPoints[$title][$month][$day][$hour]['value']       = 0;
                            $dataPoints[$title][$month][$day][$hour]['amount']      = 0;
                            $dataPoints[$title][$month][$day][$hour]['orderAmount'] = 0;
                            $dataPoints[$title][$month][$day][$hour]['offerAmount'] = 0;
                            $dataPoints[$title][$month][$day][$hour]['average']     = 0;
                            $dataPoints[$title][$month][$day][$hour]['count']       = 0;
                        }
                        $dataPoints[$title][$month][$day][$hour]['value']       += $hourData['value'];
                        $dataPoints[$title][$month][$day][$hour]['amount']      += $hourData['amount'];
                        $dataPoints[$title][$month][$day][$hour]['orderAmount'] += $hourData['offerAmount'];
                        $dataPoints[$title][$month][$day][$hour]['orderAmount'] += $hourData['orderAmount'];
                        $dataPoints[$title][$month][$day][$hour]['average']     += $hourData['value'] * $hourData['amount'];
                        $dataPoints[$title][$month][$day][$hour]['count']       += $hourData['count'];
                    }
                }
            }
        }

        return $this->dataPointsToCollection($dataPoints);
    }
}
