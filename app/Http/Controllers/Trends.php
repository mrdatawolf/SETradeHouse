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
        $dataPoints             = $this->getDataPoints(1,3);
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
        $dataPoints = $this->getDataPoints(1);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }

    public function ingotIndex() {
        $pageTitle  = "Ingot Trends";
        $dataPoints = $this->getDataPoints(2);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }

    public function componentIndex() {
        $pageTitle  = "Component Trends";
        $dataPoints = $this->getDataPoints(3);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }

    public function toolIndex() {
        $pageTitle  = "Tools Trends";
        $dataPoints = $this->getDataPoints(4);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }


    public function getTrends($goodTypeId, $goodId, $usetitle) {
        return $this->gatherDataPoints($goodTypeId, $goodId, $usetitle);
    }


    private function getDataPoints($goodTypeId, $goodId = 0) {
        $dataPoints = [];
        if($goodId > 0) {
            $trends = \App\Trends::where(['goodTypeId' => $goodTypeId, 'goodId' => $goodId])->get();
        } else {
            $trends = \App\Trends::where(['goodTypeId' => $goodTypeId])->get();
        }
        foreach($trends as $trend) {
            $title = $this->goodTitleById($goodTypeId, $trend->goodId);
            $dataPoints[$title][$trend->month][$trend->day][$trend->hour] = [
                'value'                     => $trend->value,
                'amount'                    => $trend->amount,
                'orderAmount'               => $trend->orderAmount,
                'offerAmount'               => $trend->offerAmount,
                'average'                   => $trend->average,
                'count'                     => $trend->count,
                'orderAmountLatestMinute'   => $trend->orderAmountLatestMinute,
                'offerAmountLatestMinute'   => $trend->offerAmountLatestMinute
                ];
        }

        return $this->dataPointsToCollection($dataPoints);
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
    private function gatherInActiveTransactions($goodTypeId, $goodId = null, $useTitle)
    {
        $dataPoints          = [];
        $inActiveTransactons = InActiveTransactions::where('good_type_id', $goodTypeId)->where('updated_at', '>', Carbon::now()->subDays(30));
        if ( ! empty($goodId)) {
            $inActiveTransactons->where('good_id', $goodId);
        }
        $transactions = $inActiveTransactons->get();
        if(! empty($transactions)) {
            foreach ($transactions as $transaction) {
                $dataPoints = $this->addDataPointRow($dataPoints, $goodTypeId, $transaction, $useTitle);
            }
        }
        return $dataPoints;
    }


    /**
     * note: take the active transactions and get a collection to work with.
     * @param      $goodTypeId
     * @param null $goodId
     * @param bool $useTitle
     *
     * @return mixed
     */
    private function gatherTransactions($goodTypeId, $goodId = null, $useTitle = true)
    {
        $dataPoints          = [];
        $inActiveTransactons = Transactions::where('good_type_id', $goodTypeId)->where('updated_at', '>', Carbon::now()->subDays(30));
        if ( ! empty($goodId)) {
            $inActiveTransactons->where('good_id', $goodId);
        }
        $transactions = $inActiveTransactons->get();
        if(! empty($transactions)) {
            foreach ($transactions as $transaction) {
                $dataPoints = $this->addDataPointRow($dataPoints, $goodTypeId, $transaction, $useTitle);
            }
        }
        return $dataPoints;
    }


    /**
     * @param $dataPoints
     * @param $goodTypeId
     * @param $transaction
     * @param $useTitle
     *
     * @return array
     */
    private function addDataPointRow($dataPoints, $goodTypeId, $transaction, $useTitle) {
        $identifier = ($useTitle) ? $this->goodTitleById($goodTypeId, $transaction->good_id) : $transaction->good_id;
        $minute     = $transaction->updated_at->minute;
        $hour       = $transaction->updated_at->hour;
        $day        = $transaction->updated_at->day;
        $month      = $transaction->updated_at->month;
        $amountType = ($transaction->transaction_type_id === 1) ? 'orderAmount' : 'offerAmount';
        if (empty($dataPoints[$identifier][$month][$day][$hour])) {
            $dataPoints[$identifier][$month][$day][$hour]['value']                   = 0;
            $dataPoints[$identifier][$month][$day][$hour]['amount']                  = 0;
            $dataPoints[$identifier][$month][$day][$hour]['orderAmount']             = 0;
            $dataPoints[$identifier][$month][$day][$hour]['offerAmount']             = 0;
            $dataPoints[$identifier][$month][$day][$hour]['average']                 = 0;
            $dataPoints[$identifier][$month][$day][$hour]['count']                   = 0;
            $dataPoints[$identifier][$month][$day][$hour]['orderAmountLatestMinute'] = 0;
            $dataPoints[$identifier][$month][$day][$hour]['offerAmountLatestMinute'] = 0;
        }
        $dataPoints[$identifier][$month][$day][$hour]['value']   += $transaction->value;
        $dataPoints[$identifier][$month][$day][$hour]['amount']  += $transaction->amount;
        if($dataPoints[$identifier][$month][$day][$hour][$amountType . 'LatestMinute'] === 0
            ||
            ($minute > $dataPoints[$identifier][$month][$day][$hour][$amountType . 'LatestMinute'] && $transaction->amount > 0 )
        ) {
            $dataPoints[$identifier][$month][$day][$hour][$amountType . 'LatestMinute']  = $minute;
            $dataPoints[$identifier][$month][$day][$hour][$amountType]                   = $transaction->amount;
        } else {
            $dataPoints[$identifier][$month][$day][$hour][$amountType] += $transaction->amount;
        }

        $dataPoints[$identifier][$month][$day][$hour]['average'] += $transaction->value * $transaction->amount;
        $dataPoints[$identifier][$month][$day][$hour]['count']   += 1;

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


    private function gatherDataPoints($goodTypeId, $goodId = null, $useTitle = true) {
        $dataPoints = $this->gatherInActiveTransactions($goodTypeId, $goodId, $useTitle);
        $active = $this->gatherTransactions($goodTypeId, $goodId, $useTitle);
        foreach($active as $title => $goodData) {
            $identifier = ($useTitle) ? $title : $goodId;
            foreach($goodData as $month => $monthData) {
                foreach ($monthData as $day => $dayData) {
                    foreach($dayData as $hour => $hourData) {
                        if (empty($dataPoints[$identifier][$month][$day][$hour])) {
                            $dataPoints[$identifier][$month][$day][$hour]['value']       = 0;
                            $dataPoints[$identifier][$month][$day][$hour]['amount']      = 0;
                            $dataPoints[$identifier][$month][$day][$hour]['orderAmount'] = 0;
                            $dataPoints[$identifier][$month][$day][$hour]['offerAmount'] = 0;
                            $dataPoints[$identifier][$month][$day][$hour]['average']     = 0;
                            $dataPoints[$identifier][$month][$day][$hour]['count']       = 0;
                        }
                        $dataPoints[$identifier][$month][$day][$hour]['value']       += $hourData['value'];
                        $dataPoints[$identifier][$month][$day][$hour]['amount']      += $hourData['amount'];
                        $dataPoints[$identifier][$month][$day][$hour]['orderAmount'] += $hourData['offerAmount'];
                        $dataPoints[$identifier][$month][$day][$hour]['orderAmount'] += $hourData['orderAmount'];
                        $dataPoints[$identifier][$month][$day][$hour]['average']     += $hourData['value'] * $hourData['amount'];
                        $dataPoints[$identifier][$month][$day][$hour]['count']       += $hourData['count'];
                    }
                }
            }
        }

        return $this->dataPointsToCollection($dataPoints);
    }
}
