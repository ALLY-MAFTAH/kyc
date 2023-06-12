<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Frame;
use App\Models\Market;
use App\Models\Payment;
use App\Models\Stall;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $currentYear = date('Y');
        $allMarkets = Market::all();
        $allFrames = Frame::all();
        $allStalls = Stall::all();
        $allCustomers = Customer::all();
        $allUsers = User::all();

        $graphData = [
            'labels' => [],
            'data' => [],
        ];

        $totalMarketsCollection = 0;
        foreach ($allMarkets as $market) {
            $collectionAmount = $market->payments()
                ->where('year', $currentYear)
                ->sum('amount');
            $totalMarketsCollection = $totalMarketsCollection + $collectionAmount;
            $graphData['labels'][] = $market->name;
            $graphData['data'][] = $collectionAmount;
        }

        $totalFramesCollection=0;
        foreach ($allFrames as $frame) {
            $frameCollectionAmount = $frame->payments()
                ->where('year', $currentYear)
                ->sum('amount');
            $totalFramesCollection = $totalFramesCollection + $frameCollectionAmount;

        }
        $totalStallsCollection=0;
        foreach ($allStalls as $stall) {
            $stallCollectionAmount = $stall->payments()
                ->where('year', $currentYear)
                ->sum('amount');
            $totalStallsCollection = $totalStallsCollection + $stallCollectionAmount;

        }

        $topFiveCustomers = Customer::withSum(['payments' => function ($query) use ($currentYear) {
        $query->where('year', $currentYear);
          }], 'amount')
          ->having('payments_sum_amount', '>', 0)
          ->orderByDesc('payments_sum_amount')
          ->take(5)
          ->get();

          $frameMarkets = Market::withCount(['frames as empty_frames_count' => function ($query) {
            $query->whereNull('customer_id');
        }])->get();
          $stallMarkets = Market::withCount(['stalls as empty_stalls_count' => function ($query) {
            $query->whereNull('customer_id');
        }])->get();

        $frameChartData = [
            ['Market', 'Empty Frames'],
        ];
        $stallChartData = [
            ['Market', 'Empty Stalls'],
        ];

        foreach ($frameMarkets as $market) {
            $frameChartData[] = [$market->name, $market->empty_frames_count];

        }
        foreach ($stallMarkets as $market) {
            $stallChartData[] = [$market->name, $market->empty_stalls_count];
        }
        return view('home', compact(
            'allMarkets',
            'allUsers',
            'allFrames',
            'allStalls',
            'allCustomers',
            'totalMarketsCollection',
            'totalFramesCollection',
            'totalStallsCollection',
            'graphData',
            'frameChartData',
            'stallChartData',
            'topFiveCustomers',
        ));
    }
}
