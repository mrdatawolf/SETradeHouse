<?php

namespace App\Http\Controllers;

use App\Components;
use App\InActiveTransactions;
use App\Ingots;
use App\Ores;
use App\Tools;
use App\Transactions;
use App\TransactionTypes;
use Carbon\Carbon;

class Trends extends Controller
{
    public function oreOrderIndex()
    {
        $pageTitle  = "Ore Order Trends";
        $dataPoints = $this->gatherTrends('buy', 1);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }


    public function oreOfferIndex()
    {
        $pageTitle  = "Ore Offer Trends";
        $dataPoints = $this->gatherTrends('sell', 1);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }


    public function ingotOrderIndex()
    {
        $pageTitle  = "Ingot Order Trends";
        $dataPoints = $this->gatherTrends('buy', 2);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }


    public function ingotOfferIndex()
    {
        $pageTitle  = "Ingot Offer Trends";
        $dataPoints = $this->gatherTrends('sell', 2);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }


    public function componentOrderIndex()
    {
        $pageTitle  = "Component Order Trends";
        $dataPoints = $this->gatherTrends('buy', 3);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }


    public function componentOfferIndex()
    {
        $pageTitle  = "Component Offer Trends";
        $dataPoints = $this->gatherTrends('sell', 3);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }


    public function toolOrderIndex()
    {
        $pageTitle  = "Tools Order Trends";
        $dataPoints = $this->gatherTrends('buy', 4);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }


    public function toolOfferIndex()
    {
        $pageTitle  = "Tools Offer Trends";
        $dataPoints = $this->gatherTrends('sell', 4);
        $compacted  = $this->makeGeneralCompact($dataPoints, $pageTitle);

        return view('trends.general.all', $compacted);
    }


    public function getRawTrends($transactionTypeId, $goodTypeId, $goodId, $usetitle)
    {
        $array = $this->gatherSimplifiedDataPoints($transactionTypeId, $goodTypeId, $goodId, $usetitle);

        return $this->dataPointsToCollection($array);
    }


    private function gatherTrends($transactionType, $goodTypeId, $goodId = 0)
    {
        $transactionId = TransactionTypes::where('title', $transactionType)->first()->id;
        $dataPoints    = [];
        $whereArray    = ($goodId > 0) ? [
            'transaction_type_id' => $transactionId,
            'type_id'             => $goodTypeId,
            'good_id'             => $goodId
        ] : ['transaction_type_id' => $transactionId, 'type_id' => $goodTypeId];
        $trends        = \App\Trends::where($whereArray)->orderBy('month')
            ->orderBy('day')
            ->orderBy('hour')
            ->get();
        foreach ($trends as $trend) {
            $title                                                        = $this->goodTitleById($goodTypeId,
                $trend->good_id);
            $dataPoints[$title][$trend->month][$trend->day][$trend->hour] = [
                'sum'     => $trend->sum,
                'amount'  => $trend->amount,
                'average' => $trend->average,
                'count'   => $trend->count,
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
                if ( ! empty($data->$month->$day)) {
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
                if ( ! empty($data->$month->$day)) {
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
        $carbon   = Carbon::now();
        $month    = $carbon->month;
        if ( ! empty($dataPoints)) {
            foreach ($dataPoints as $title => $data) {
                foreach ($data->$month as $day => $dayData) {
                    $currentDaysArray = ['sum' => 0, 'amount' => 0];
                    foreach ($dayData as $hourData) {
                        $currentDaysArray['sum']    += $hourData->sum;
                        $currentDaysArray['amount'] += $hourData->amount;
                    }
                    $averages[$title][] = ($currentDaysArray['sum'] > 0 && $currentDaysArray['amount'] > 0)
                        ? round($currentDaysArray['sum'] / $currentDaysArray['amount'], 2) : 0;
                }
            }
        }

        return $averages;
    }


    private function trendingDailyAvailable($dataPoints)
    {
        $trendDailyAmount = [];
        $carbon           = Carbon::now();
        $month            = $carbon->month;
        if ( ! empty($dataPoints)) {
            foreach ($dataPoints as $title => $data) {
                foreach ($data->$month as $day => $dayData) {
                    $currentDaysArray = ['count' => 0, 'amount' => 0];
                    foreach ($dayData as $hour => $hourData) {
                        $currentDaysArray['amount'] += $hourData->amount;
                        $currentDaysArray['count']  += 1;
                    }
                    $trendDailyAmount[$title][] = round($currentDaysArray['amount'] / $currentDaysArray['count'], 2);
                }
            }
        }

        return $trendDailyAmount;
    }


    private function trendingDailyAvgLabels($dataPoints)
    {
        $trendDailyAvgLabels = [];
        $carbon              = Carbon::now();
        $month               = $carbon->month;
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
     * @param      $transactionTypeId
     * @param      $goodTypeId
     * @param null $goodId
     * @param bool $useTitle
     *
     * @return mixed
     */
    private function gatherInActiveTransactions($transactionTypeId, $goodTypeId, $goodId = null, $useTitle = true)
    {
        $dataPoints               = [];
        $inActiveTransactionModel = InActiveTransactions::where('good_type_id', $goodTypeId)
                                                        ->where('updated_at', '>', Carbon::now()->subDays(30))
                                                        ->where('transaction_type_id', $transactionTypeId);
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
     * @param      $transactionTypeId
     * @param      $goodTypeId
     * @param null $goodId
     * @param bool $useTitle
     *
     * @return mixed
     */
    private function gatherTransactions($transactionTypeId, $goodTypeId, $goodId = null, $useTitle = true)
    {
        $dataPoints       = [];
        $transactonsModel = Transactions::where('good_type_id', $goodTypeId)
                                        ->where('updated_at', '>', Carbon::now()->subDays(30))
                                        ->where('transaction_type_id', $transactionTypeId);
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
        $identifiers                                  = [
            'hour'       => $hour,
            'day'        => $day,
            'month'      => $month,
            'identifier' => $identifier
        ];
        $currentData                                  = $this->setDataPoints($dataPoints, $transaction, $identifiers);
        $dataPoints[$identifier][$month][$day][$hour] = $currentData;

        return $dataPoints;
    }


    private function setDataPoints($dataPoints, $transaction, $identifiers)
    {
        $hour       = $identifiers['hour'];
        $day        = $identifiers['day'];
        $month      = $identifiers['month'];
        $identifier = $identifiers['identifier'];
        if (empty($dataPoints[$identifier][$month][$day][$hour])) {
            $currentData = [
                'sum'          => 0,
                'amount'       => 0,
                'count'        => 0,
                'latestMinute' => 0,
            ];
        } else {
            $currentData = $dataPoints[$identifier][$month][$day][$hour];
        }

        $currentData = $this->setLatestMinute($currentData, $transaction);
        $currentData = $this->setSums($currentData, $transaction);
        $currentData = $this->setAmounts($currentData, $transaction);
        $currentData = $this->setCounts($currentData);

        return $currentData;
    }


    private function setSums($currentData, $transaction)
    {
        $currentData['sum'] += $transaction->value * $transaction->amount;

        return $currentData;
    }


    private function setAmounts($currentData, $transaction)
    {
        $currentData['amount'] += $transaction->amount;

        return $currentData;
    }


    private function setCounts($currentData)
    {
        $currentData['count'] += 1;

        return $currentData;
    }


    private function setLatestMinute($currentData, $transaction)
    {
        $minute = $transaction->updated_at->minute;
        if ($minute > $currentData['latestMinute'] && $transaction->amount > 0) {
            $currentData['latestMinute'] = $minute;
        }

        return $currentData;
    }


    private function dataPointsToCollection($dataPoints)
    {
        dd($dataPoints);
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


    private function gatherSimplifiedDataPoints($transactionTypeId, $goodTypeId, $goodId = null, $useTitle = true)
    {
        $dataPoints = $this->gatherInActiveTransactions($transactionTypeId, $goodTypeId, $goodId = null,
            $useTitle = true);
        $dataPoints = $this->addTransactions($transactionTypeId, $dataPoints, $goodTypeId, $goodId, $useTitle);

        return $dataPoints;
    }


    private function addTransactions($transactionTypeId, $dataPoints, $goodTypeId, $goodId = null, $useTitle = true)
    {
        $transactonsModel = Transactions::where('good_type_id', $goodTypeId)
                                        ->where('updated_at', '>', Carbon::now()->subDays(30))
                                        ->where('transaction_type_id', $transactionTypeId);
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
                                'sum'    => 0,
                                'amount' => 0,
                                'count'  => 0
                            ];
                        }
                        $dataPoints[$identifier][$month][$day][$hour]['sum']    += $hourData['sum'];
                        $dataPoints[$identifier][$month][$day][$hour]['amount'] += $hourData['amount'];
                        $dataPoints[$identifier][$month][$day][$hour]['count']  += $hourData['count'];
                    }
                }
            }
        }

        return $this->dataPointsToCollection($dataPoints);
    }
}
