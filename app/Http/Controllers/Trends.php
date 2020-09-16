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
    public function ironOreIndex()
    {
        $pageTitle            = "Iron Ore Trends";
        $dataPoints           = $this->gatherTrends(1, 3);
        $trendHourlyAvg       = $this->trendingHourlyAvg($dataPoints);
        $trendHourlyAvgLabels = $this->trendingHourlyAvgLabels($dataPoints);
        $trendDailyAvg        = $this->trendingDailyAvg($dataPoints);
        $trendDailyAvgLabels  = $this->trendingDailyAvgLabels($dataPoints);
        $jsonDataPoints       = json_encode($dataPoints);
        $jsonHourlyAvg        = json_encode($trendHourlyAvg, true);
        $jsonHourlyAvgLabels  = json_encode($trendHourlyAvgLabels);
        $jsonDailyAvg         = json_encode($trendDailyAvg, true);
        $jsonDailyAvgLabels   = json_encode($trendDailyAvgLabels);

        return view('trends.ores.iron',
            compact('pageTitle', 'jsonDataPoints', 'jsonHourlyAvg', 'jsonHourlyAvgLabels', 'jsonDailyAvg',
                'jsonDailyAvgLabels'));
    }


    public function oreIndex()
    {
        $pageTitle  = "Ore Trends";
        $dataPoints = $this->gatherTrends(1);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }


    public function ingotIndex()
    {
        $pageTitle  = "Ingot Trends";
        $dataPoints = $this->gatherTrends(2);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }


    public function componentIndex()
    {
        $pageTitle  = "Component Trends";
        $dataPoints = $this->gatherTrends(3);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }


    public function toolIndex()
    {
        $pageTitle  = "Tools Trends";
        $dataPoints = $this->gatherTrends(4);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }


    public function getRawTrends($goodTypeId, $goodId, $usetitle)
    {
        $array = $this->gatherSimplifiedDataPoints($goodTypeId, $goodId, $usetitle);
        return $this->dataPointsToCollection($array);
    }


    private function gatherTrends($goodTypeId, $goodId = 0)
    {
        $dataPoints = [];
        $whereArray = ($goodId > 0) ? ['goodTypeId' => $goodTypeId, 'goodId' => $goodId]
            : ['goodTypeId' => $goodTypeId];
        $trends     = \App\Trends::where($whereArray)->get();
        foreach ($trends as $trend) {
            $title                                                        = $this->goodTitleById($goodTypeId,
                $trend->goodId);
            $dataPoints[$title][$trend->month][$trend->day][$trend->hour] = [
                'sum'               => $trend->sum,
                'amount'            => $trend->amount,
                'orderAmount'       => $trend->orderAmount,
                'offerAmount'       => $trend->offerAmount,
                'average'           => $trend->average,
                'count'             => $trend->count,
                'orderLatestMinute' => $trend->orderLatestMinute,
                'offerLatestMinute' => $trend->offerLatestMinute
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
    private function makeGeneralCompact($dataPoints, $pageTitle)
    {
        $trendHourlyAvg       = $this->trendingHourlyAvg($dataPoints);
        $trendHourlyAvgLabels = $this->trendingHourlyAvgLabels($dataPoints);
        $trendDailyAvg        = $this->trendingDailyAvg($dataPoints);
        $trendDailyAvailable  = $this->trendingDailyAvailable($dataPoints);
        $trendDailyAvgLabels  = $this->trendingDailyAvgLabels($dataPoints);

        return compact('pageTitle', 'trendHourlyAvg', 'trendHourlyAvgLabels', 'trendDailyAvg', 'trendDailyAvgLabels',
            'trendDailyAvailable');
    }


    /**
     * @param $dataPoints
     *
     * @return array
     */
    private function trendingHourlyAvg($dataPoints)
    {
        $averages = [];
        if ( ! empty($dataPoints)) {
            foreach ($dataPoints as $title => $data) {
                $carbon = Carbon::now();
                $month  = $carbon->month;
                $day    = $carbon->day;
                if(! empty($data->$month->$day)) {
                    foreach ($data->$month->$day as $hour => $hourData) {
                        $averages[$title][] = round($hourData->average, 2);
                    }
                }
            }
        }

        return $averages;
    }


    /**
     * @param $dataPoints
     *
     * @return array
     */
    private function trendingHourlyAvgLabels($dataPoints)
    {
        $labels = [];
        if ( ! empty($dataPoints)) {
            foreach ($dataPoints as $title => $data) {
                $carbon = Carbon::now();
                $month  = $carbon->month;
                $day    = $carbon->day;
                if(! empty($data->$month->$day)) {
                    foreach ($data->$month->$day as $hour => $hourData) {
                        $labels[$title][] = $hour;
                    }
                }
            }
        }

        return $labels;
    }


    private function trendingDailyAvg($dataPoints)
    {
        $averages = [];
        $carbon = Carbon::now();
        $month  = $carbon->month;
        if ( ! empty($dataPoints)) {
            foreach ($dataPoints as $title => $data) {
                foreach ($data->$month as $day => $dayData) {
                    $currentDaysArray = ['sum' => 0, 'amount' => 0];
                    foreach ($dayData as $hourData) {
                        $currentDaysArray['sum']    += $hourData->sum;
                        $currentDaysArray['amount'] += $hourData->amount;
                    }
                    $averages[$title][] = round($currentDaysArray['sum'] / $currentDaysArray['amount'], 2);
                }
            }
        }

        return $averages;
    }


    private function trendingDailyAvailable($dataPoints)
    {
        $trendDailyAmount = [];
        $carbon = Carbon::now();
        $month  = $carbon->month;
        if ( ! empty($dataPoints)) {
            foreach ($dataPoints as $title => $data) {
                foreach ($data->$month as $day => $dayData) {
                    $currentDaysArray = ['count' => 0, 'amount' => 0];
                    foreach ($dayData as $hour => $hourData) {
                        $currentDaysArray['amount'] += $hourData->offerAmount;
                        $currentDaysArray['count'] += 1;
                    }
                    $trendDailyAmount[$title][] = round($currentDaysArray['amount']/$currentDaysArray['count'], 2);
                }
            }
        }

        return $trendDailyAmount;
    }


    private function trendingDailyAvgLabels($dataPoints)
    {
        $trendDailyAvgLabels = [];
        $carbon = Carbon::now();
        $month  = $carbon->month;
        if ( ! empty($dataPoints)) {
            foreach ($dataPoints as $title => $data) {
                foreach ($data->$month as $day => $dayData) {
                    $trendDailyAvgLabels[$title][] = $month."/".$day;
                }
            }
        }

        return $trendDailyAvgLabels;
    }


    /**
     * note: take the inactive transactions and get a collection to work with.
     *
     * @param      $goodTypeId
     * @param null $goodId
     * @param bool $useTitle
     *
     * @return mixed
     */
    private function gatherInActiveTransactions($goodTypeId, $goodId = null, $useTitle = true)
    {
        $dataPoints          = [];
        $inActiveTransactionModel = InActiveTransactions::where('good_type_id', $goodTypeId)
                                                   ->where('updated_at', '>', Carbon::now()->subDays(30));
        if ( ! empty($goodId)) {
            $inActiveTransactionModel->where('good_id', $goodId);
        }
        $transactions = $inActiveTransactionModel->get();
        if ( ! empty($transactions)) {
            foreach ($transactions as $transaction) {
                $dataPoints = $this->alignDataPoint($dataPoints, $goodTypeId, $transaction, $useTitle);
            }
        }

        return $dataPoints;
    }


    /**
     * note: take the active transactions and get a collection to work with.
     *
     * @param      $goodTypeId
     * @param null $goodId
     * @param bool $useTitle
     *
     * @return mixed
     */
    private function gatherTransactions($goodTypeId, $goodId = null, $useTitle = true)
    {
        $dataPoints          = [];
        $transactonsModel = Transactions::where('good_type_id', $goodTypeId)
                                           ->where('updated_at', '>', Carbon::now()->subDays(30));
        if ( ! empty($goodId)) {
            $transactonsModel->where('good_id', $goodId);
        }
        $transactions = $transactonsModel->get();
        if ( ! empty($transactions)) {
            foreach ($transactions as $transaction) {
                $dataPoints = $this->alignDataPoint($dataPoints, $goodTypeId, $transaction, $useTitle);
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
    private function alignDataPoint($dataPoints, $goodTypeId, $transaction, $useTitle)
    {
        $identifier                                   = ($useTitle) ? $this->goodTitleById($goodTypeId,
            $transaction->good_id) : $transaction->good_id;
        $hour                                         = $transaction->updated_at->hour;
        $day                                          = $transaction->updated_at->day;
        $month                                        = $transaction->updated_at->month;
        $currentData                                  = $this->setDataPoints($dataPoints, $hour, $day, $month,
            $identifier, $transaction);
        $dataPoints[$identifier][$month][$day][$hour] = $currentData;

        return $dataPoints;
    }


    private function setDataPoints($dataPoints, $hour, $day, $month, $identifier, $transaction)
    {
        if (empty($dataPoints[$identifier][$month][$day][$hour])) {
            $currentData = [
                'sum'               => 0,
                'amount'            => 0,
                'count'             => 0,
                'orderSum'          => 0,
                'orderAmount'       => 0,
                'orderCount'        => 0,
                'offerSum'          => 0,
                'offerAmount'       => 0,
                'offerCount'        => 0,
                'orderLatestMinute' => 0,
                'offerLatestMinute' => 0,
            ];
        } else {
            $currentData = $dataPoints[$identifier][$month][$day][$hour];
        }

        $currentData = $this->setLatestMinute($currentData, $transaction);
        $currentData = $this->setSums($currentData, $transaction);
        $currentData = $this->setAmounts($currentData, $transaction);
        $currentData = $this->setCounts($currentData, $transaction);

        return $currentData;
    }


    private function setSums($currentData, $transaction)
    {
        $amountType               = ((int)$transaction->transaction_type_id === 1) ? 'orderSum' : 'offerSum';
        $currentData['sum']       += $transaction->value*$transaction->amount;
        $currentData[$amountType] += $transaction->value*$transaction->amount;
        return $currentData;
    }


    private function setAmounts($currentData, $transaction)
    {
        $amountType               = ((int)$transaction->transaction_type_id === 1) ? 'orderAmount' : 'offerAmount';
        $currentData['amount']    += $transaction->amount;
        $currentData[$amountType] += $transaction->amount;

        return $currentData;
    }


    private function setCounts($currentData, $transaction)
    {
        $amountType               = ((int)$transaction->transaction_type_id === 1) ? 'orderCount' : 'offerCount';
        $currentData['count']     += 1;
        $currentData[$amountType] += 1;

        return $currentData;
    }


    private function setLatestMinute($currentData, $transaction)
    {
        $amountType = ((int)$transaction->transaction_type_id === 1) ? 'order' : 'offer';
        $minute     = $transaction->updated_at->minute;
        if ($currentData[$amountType.'LatestMinute'] === 0 || ($minute > $currentData[$amountType.'LatestMinute'] && $transaction->amount > 0)) {
            $currentData[$amountType.'LatestMinute'] = $minute;
        }

        return $currentData;
    }


    private function dataPointsToCollection($dataPoints)
    {
        $dataPointsJson   = json_encode($dataPoints);
        $dataPointsObject = json_decode($dataPointsJson);

        return collect($dataPointsObject);
    }


    private function goodTitleById($goodTypeId, $goodId)
    {
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
        $title = str_replace(' ', '', $title);
        $title = str_replace('.', '', $title);
        $title = str_replace('-', '', $title);
        $title = str_replace('[', '', $title);
        $title = str_replace(']', '', $title);
        $title = str_replace('(', '', $title);
        $title = str_replace(')', '', $title);

        return $title;
    }


    private function gatherSimplifiedDataPoints($goodTypeId, $goodId = null, $useTitle = true)
    {
        $dataPoints = $this->gatherInActiveTransactions($goodTypeId, $goodId = null, $useTitle = true);
        $dataPoints = $this->addTransactions($dataPoints, $goodTypeId, $goodId, $useTitle);

        return $dataPoints;
    }


    private function addTransactions($dataPoints, $goodTypeId, $goodId = null, $useTitle = true) {
        $transactonsModel = Transactions::where('good_type_id', $goodTypeId)
                                        ->where('updated_at', '>', Carbon::now()->subDays(30));
        if ( ! empty($goodId)) {
            $transactonsModel->where('good_id', $goodId);
        }
        $transactions = $transactonsModel->get();
        if ( ! empty($transactions)) {
            foreach ($transactions as $transaction) {
                $dataPoints = $this->alignDataPoint($dataPoints, $goodTypeId, $transaction, $useTitle);
            }
        }

        return $dataPoints;
    }


    private function gatherDataPoints($goodTypeId, $goodId = null, $useTitle = true)
    {
        $dataPoints = $this->gatherInActiveTransactions($goodTypeId, $goodId, $useTitle);
        $active     = $this->gatherTransactions($goodTypeId, $goodId, $useTitle);
        foreach ($active as $title => $goodData) {
            $identifier = ($useTitle) ? $title : $goodId;
            foreach ($goodData as $month => $monthData) {
                foreach ($monthData as $day => $dayData) {
                    foreach ($dayData as $hour => $hourData) {
                        if (empty($dataPoints[$identifier][$month][$day][$hour])) {
                            $dataPoints[$identifier][$month][$day][$hour] = [
                                'sum'       => 0,
                                'amount'      => 0,
                                'count'       => 0,
                                'orderSum'  => 0,
                                'orderAmount' => 0,
                                'orderCount'  => 0,
                                'offerSum'  => 0,
                                'offerAmount' => 0,
                                'offerCount'  => 0
                            ];
                        }
                        $dataPoints[$identifier][$month][$day][$hour]['sum']       += $hourData['sum'];
                        $dataPoints[$identifier][$month][$day][$hour]['amount']      += $hourData['amount'];
                        $dataPoints[$identifier][$month][$day][$hour]['count']       += $hourData['count'];
                        $dataPoints[$identifier][$month][$day][$hour]['orderSum']  += $hourData['orderSum'];
                        $dataPoints[$identifier][$month][$day][$hour]['orderAmount'] += $hourData['orderAmount'];
                        $dataPoints[$identifier][$month][$day][$hour]['orderCount']  += $hourData['orderCount'];
                        $dataPoints[$identifier][$month][$day][$hour]['offerSum']  += $hourData['offerSum'];
                        $dataPoints[$identifier][$month][$day][$hour]['offerAmount'] += $hourData['offerAmount'];
                        $dataPoints[$identifier][$month][$day][$hour]['offerCount']  += $hourData['offerCount'];
                    }
                }
            }
        }

        return $this->dataPointsToCollection($dataPoints);
    }
}
