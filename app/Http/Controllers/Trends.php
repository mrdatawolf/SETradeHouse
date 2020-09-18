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


    private function gatherTrends($transactionType, $goodTypeId, $goodId = 0)
    {
        $transactionTypeId = TransactionTypes::where('title', $transactionType)->first()->id;
        $dataPoints        = [];
        $whereArray        = ($goodId > 0) ? [
            'transaction_type_id' => $transactionTypeId,
            'type_id'             => $goodTypeId,
            'good_id'             => $goodId
        ] : ['transaction_type_id' => $transactionTypeId, 'type_id' => $goodTypeId];
        $trends            = \App\Trends::where($whereArray)->orderBy('month')->orderBy('day')->orderBy('hour')->get();
        foreach ($trends as $trend) {
            $title        = $this->goodTitleById($goodTypeId, $trend->good_id);
            $dataPoints[] = [
                'title'   => $title,
                'month'   => $trend->month,
                'day'     => $trend->day,
                'hour'    => $trend->hour,
                'sum'     => $trend->sum,
                'amount'  => $trend->amount,
                'average' => $trend->average,
                'count'   => $trend->count,
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
            foreach ($dataPoints as $data) {
                if ($this->isInHourRange($data)) {
                    $averages[$data->title][] = round($data->average, 2);
                }
            }
        }

        return $averages;
    }


    private function isInHourRange($data)
    {
        $carbon   = Carbon::now()->subHours(24);
        $minMonth = (int)$carbon->month;
        $minDay   = (int)$carbon->day;
        $minHour  = (int)$carbon->hour;
        if ((int)$data->month >= $minMonth) {
            if ((int)$data->day >= $minDay) {
                if ((int)$data->day > $minDay || (int)$data->hour >= $minHour) {
                    return true;
                }
            }
        }

        return false;
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
            foreach ($dataPoints as $data) {
                if ($this->isInHourRange($data)) {
                    $labels[$data->title][] = "d:".$data->day." h:".$data->hour;
                }
            }
        }

        return $labels;
    }


    private function trendingDailyAvg($dataPoints)
    {
        $averages = [];
        $carbon   = Carbon::now();
        $month    = (int)$carbon->month;
        if ( ! empty($dataPoints)) {
            $dataRows = $dataPoints->where('month', '>', $month - 1)->groupBy(['title', 'day']);
            foreach ($dataRows as $title => $data) {
                $current = ['sum' => 0, 'amount' => 0];
                foreach ($data as $day => $dayData) {
                    if ($this->isInMonthRange($month, $day)) {
                        foreach ($dayData as $hourData) {
                            $current['sum']    += $hourData->sum;
                            $current['amount'] += $hourData->amount;
                        }
                        $averages[$title][] = ($current['sum'] > 0 && $current['amount'] > 0)
                            ? round($current['sum'] / $current['amount'], 2) : 0;
                    }
                }
            }
        }

        return $averages;
    }


    private function isInMonthRange($month, $day)
    {
        $carbon   = Carbon::now()->subDays(30);
        $minMonth = (int)$carbon->month;
        $minDay   = (int)$carbon->day;

        if ((int)$month >= $minMonth) {
            if ((int)$month > $minMonth || (int)$day >= $minDay) {
                return true;
            }
        }

        return false;
    }


    private function trendingDailyAvailable($dataPoints)
    {
        $trendDailyAmount = [];
        $carbon           = Carbon::now();
        $month            = (int)$carbon->month;

        if ( ! empty($dataPoints)) {
            $dataRows = $dataPoints->where('month', '>', $month - 1)->groupBy(['title', 'day']);
            foreach ($dataRows as $title => $data) {
                $current = ['amount' => 0, 'count' => 0];
                foreach ($data as $day => $dayData) {
                    foreach ($dayData as $hourData) {
                        $current['amount'] += $hourData->amount;
                        $current['count']  += 1;
                    }
                    $trendDailyAmount[$title][] = round($current['amount'] / $current['count'], 2);
                }
            }
        }

        return $trendDailyAmount;
    }


    private function trendingDailyAvgLabels($dataPoints)
    {
        $trendDailyAvgLabels = [];
        $carbon              = Carbon::now();
        $month               = (int)$carbon->month;
        if ( ! empty($dataPoints)) {
            $dataRows = $dataPoints->where('month', '>', $month - 1)->groupBy(['title', 'day']);
            foreach ($dataRows as $title => $data) {
                foreach ($data as $day => $dayData) {
                    $trendDailyAvgLabels[$title][] = $month."/".$day;
                }
            }
        }

        return $trendDailyAvgLabels;
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
            'latestMinute' => 0,
        ];
        if ( ! empty($dataPoints[$id][$month][$day][$hour])) {
            $currentData = $dataPoints[$id][$month][$day][$hour];
        }

        $currentData                          = $this->setLatestMinute($currentData, $transaction);
        $currentData                          = $this->setSums($currentData, $transaction);
        $currentData                          = $this->setAmounts($currentData, $transaction);
        $currentData                          = $this->setCounts($currentData);
        $dataPoints[$id][$month][$day][$hour] = $currentData;

        return $dataPoints;
    }


    private function setLatestMinute($currentData, $transaction)
    {
        $minute = $transaction->updated_at->minute;
        if ($minute > $currentData['latestMinute'] && $transaction->amount > 0) {
            $currentData['latestMinute'] = $minute;
        }

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
