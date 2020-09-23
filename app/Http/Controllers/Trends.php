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
        $array = $this->gatherTransactionData($transactionTypeId, $goodTypeId, $goodId, $usetitle);

        return $this->dataPointsToCollection($array);
    }


    public function gatherTrends($transactionType, $hoursAgo, $goodTypeId = 0, $goodId = 0)
    {
        //todo: trends should be storing the carbon date so the year is made correctly.
        $transactionTypeId =(is_int($transactionType)) ? $transactionType : TransactionTypes::where('title', $transactionType)->first()->id;
        $trends = \App\Trends::where('dated_at', '>', Carbon::now()->subHours($hoursAgo));
        if($transactionTypeId !== 0) {
            $trends = $trends->where('transaction_type_id', $transactionTypeId);
            $trends = $trends->where('good_type_id', $goodTypeId);
            if($goodId > 0) {
                $trends = $trends->where('good_id', $goodId);
            }
        }
        $dataPoints        = [];
        $trends = $trends->orderBy('transaction_type_id')->orderBy('dated_at');
        foreach ($trends->get() as $trend) {
            $title        = $this->goodTitleById($trend->good_type_id, $trend->good_id);
            $dataPoints[] = [
                'title'      => $title,
                'transaction_type_id' => $trend->transaction_type_id,
                'good_type_id' => $trend->good_type_id,
                'good_id' => $trend->good_id,
                'updated_at' => $trend->dated_at,
                'sum'        => $trend->sum,
                'amount'     => $trend->amount,
                'average'    => $trend->average,
                'count'      => $trend->count,
            ];
        }

        return $this->dataPointsToCollection($dataPoints);
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
                die('Invalid type: ' . $goodTypeId . ' on good id' . $goodId);
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


    private function dataPointsToCollection($dataPoints)
    {
        $dataPointsJson   = json_encode($dataPoints);
        $dataPointsObject = json_decode($dataPointsJson);

        return collect($dataPointsObject);
    }


    /**
     * @param $dataPoints
     * @param $pageTitle
     *
     * @return array
     */
    private function makeGeneralCompact($dataPoints, $pageTitle)
    {
        $hourly = $this->trendingHourly($dataPoints);
        $daily  = $this->trendingDaily($dataPoints);
        $trendHourlyAvg       = $hourly[0];
        $trendHourlyAvgLabels = $hourly[1];
        $trendDailyAvg        = $daily[0];
        $trendDailyAvailable  = $daily[1];
        $trendDailyAvgLabels  = $daily[2];

        return compact('pageTitle', 'trendHourlyAvg', 'trendHourlyAvgLabels', 'trendDailyAvg', 'trendDailyAvgLabels',
            'trendDailyAvailable');
    }


    /**
     * @param $dataPoints
     *
     * @return array
     */
    private function trendingHourly($dataPoints)
    {
        $averages = [];
        $labels = [];
        if ( ! empty($dataPoints)) {
            foreach ($dataPoints->where('updated_at', '>=', Carbon::now()->subHours(24)) as $data) {
                $updatedAt = Carbon::createFromDate($data->updated_at);
                $day = $updatedAt->day;
                $hour = $updatedAt->hour;
                $averages[$data->title][] = round($data->average, 2);
                $labels[$data->title][] = "d:".$day." h:".$hour;
            }
        }

        return [$averages, $labels];
    }


    private function trendingDaily($dataPoints)
    {
        $averages = [];
        $trendDailyAmount = [];
        $trendDailyAvgLabels = [];
        $current = [];
        $carbon   = Carbon::now();
        $month    = (int)$carbon->month;
        if ( ! empty($dataPoints)) {
            foreach ($dataPoints->where('updated_at', '>=', Carbon::now()->subDays(30)) as $data) {
                $updatedAt = Carbon::createFromDate($data->updated_at);
                $day = $updatedAt->day;
                if(empty($current[$day])) {
                    $current[$data->title][$day] = ['title' => $month."/".$day, 'internalTitle' => '', 'sum' => 0, 'amount' => 0, 'count' => 0];
                }
                $current[$data->title][$day]['sum']    += $data->sum;
                $current[$data->title][$day]['amount'] += $data->amount;
                $current[$data->title][$day]['count']  ++;
            }
            foreach($current as $title => $currentData) {
                foreach($currentData as $day => $data) {
                    $averages[$title][]            = ($data['amount'] > 0)
                        ? round($data['sum'] / $data['amount'], 2) : 0;
                    $trendDailyAmount[$title][]    = round($data['amount'] / $data['count'], 2);
                    $trendDailyAvgLabels[$title][] = $data['title'];
                }
            }
        }

        return [$averages, $trendDailyAmount, $trendDailyAvgLabels];
    }


    /**
     * note: we are working with 2 tables of data. the historic (inactive) and the current (transactions)  so we get
     * all the inactives and then add the active onto it.
     *
     * @param      $transactionTypeId
     * @param      $goodTypeId
     * @param null $goodId
     * @param bool $useTitle
     *
     * @return array
     */
    private function gatherTransactionData($transactionTypeId, $goodTypeId, $goodId = null, $useTitle = true)
    {
        $array      = $this->gatherInActiveTransactions($transactionTypeId, $goodTypeId, $goodId, $useTitle);
        $array      = $this->addTransactions($transactionTypeId, $array, $goodTypeId, $goodId, $useTitle);
        $dataPoints = [];
        foreach ($array as $transactionTypeId => $data) {
            foreach ($data as $month => $monthData) {
                foreach ($monthData as $day => $dayData) {
                    foreach ($dayData as $hour => $hourdata) {
                        $dataPoints[] = [
                            'transactionTypeId' => $transactionTypeId,
                            'month'             => $month,
                            'day'               => $day,
                            'hour'              => $hour,
                            'dated_at'          => $hourdata['dated_at'],
                            'sum'               => $hourdata['sum'],
                            'amount'            => $hourdata['amount'],
                            'count'             => $hourdata['count']
                        ];
                    }
                }
            }
        }

        return $dataPoints;
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
     * @param $dataPoints
     * @param $goodTypeId
     * @param $transaction
     * @param $useTitle
     *
     * @return array
     */
    private function alignDataPoint($dataPoints, $goodTypeId, $transaction, $useTitle)
    {
        $id          = ($useTitle) ? $this->goodTitleById($goodTypeId, $transaction->good_id) : $transaction->good_id;
        $hour        = $transaction->updated_at->hour;
        $day         = $transaction->updated_at->day;
        $month       = $transaction->updated_at->month;
        $currentData = [
            'sum'          => 0,
            'amount'       => 0,
            'count'        => 0,
            'dated_at'   => $transaction->updated_at
        ];
        if ( ! empty($dataPoints[$id][$month][$day][$hour])) {
            $currentData = $dataPoints[$id][$month][$day][$hour];
        }

        $currentData                          = $this->setSums($currentData, $transaction);
        $currentData                          = $this->setAmounts($currentData, $transaction);
        $currentData                          = $this->setCounts($currentData);
        $currentData                          = $this->setDatedAt($currentData, $transaction);
        $dataPoints[$id][$month][$day][$hour] = $currentData;

        return $dataPoints;
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


    private function setDatedAt($currentData, $transaction) {
        if($transaction->updated_at->gt($currentData['dated_at'])) {
            $currentData['dated_at'] = $transaction->updated_at;
        }

        return $currentData;
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
}
