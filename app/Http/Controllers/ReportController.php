<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Market;
use App\Models\Payment;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Jimmyjs\ReportGenerator\ReportMedia\CSVReport;
use Jimmyjs\ReportGenerator\ReportMedia\ExcelReport;
use Jimmyjs\ReportGenerator\ReportMedia\PdfReport;

class ReportController extends Controller
{
    public function marketsReport()
    {
        return view('reports.markets_report');
    }
    public function customersReport()
    {
        $markets = Market::all();
        return view('reports.customers_report', compact('markets'));
    }
    public function paymentsReport()
    {
        $markets = Market::all();
        $customers = Customer::all();
        return view('reports.payments_report', compact('markets', 'customers'));
    }
    public function generateMarketsReport(Request $request)
    {
        $sortBy = $request->sort_by;
        $orientation = $request->input('orientation');
        $ward = $request->input('ward');
        $fileType = $request->input('file_type');

        $heading = 'Kinondoni Municipal Council';
        $title = $heading;
        $subtitle = $request->title ?? 'Markets Reports';
        $meta = [
            // 'Year' => date('Y'),
            'Sorted By' => $sortBy,
        ];

        try {
            $columns = [
                'Code' => 'code',
                'Name' => 'name',
                'Manager Name' => function ($market) {
                    if (
                        $market
                            ->users()
                            ->where('is_manager', true)
                            ->first() == null
                    ) {
                        return 'No Manager';
                    } else {
                        return $market
                            ->users()
                            ->where('is_manager', true)
                            ->first()->name;
                    }
                },
                'Manager Phone' => function ($market) {
                    if (
                        $market
                            ->users()
                            ->where('is_manager', true)
                            ->first() == null
                    ) {
                        return 'No Manager';
                    } else {
                        return $market
                            ->users()
                            ->where('is_manager', true)
                            ->first()->mobile;
                    }
                },
                'Ward' => 'ward',
                'Sub-Ward' => 'sub_ward',
                'Frame Price (TZS)' => function ($market) {
                    return number_format($market->frame_price, 0, '.', ',');
                },
                'Stall Price (TZS)' => function ($market) {
                    return number_format($market->stall_price, 0, '.', ',');
                },
                'Size' => 'size',
            ];

            if ($request->has('total_frames')) {
                $columns['Total Frames'] = function ($market) {
                    return $market->frames()->count();
                };
            }
            if ($request->has('empty_frames')) {
                $columns['Empty Frames'] = function ($market) {
                    return $market
                        ->frames()
                        ->where('customer_id', null)
                        ->count();
                };
            }
            if ($request->has('total_stalls')) {
                $columns['Total Stalls'] = function ($market) {
                    return $market->stalls()->count();
                };
            }
            if ($request->has('empty_stalls')) {
                $columns['Empty Stalls'] = function ($market) {
                    return $market
                        ->stalls()
                        ->where('customer_id', null)
                        ->count();
                };
            }
            if ($ward != 'All') {
                $markets = Market::where(['ward' => $ward])->orderBy($sortBy);
                $columns['Ward'] = function ($result) {
                    return $result->ward;
                };
            } else {
                $markets = Market::orderBy($sortBy);
            }

            if ($fileType == 'PDF') {
                $reportInstance = new PdfReport();
                return $reportInstance
                    ->of($title, $subtitle, $meta, $markets, $columns)
                    ->setOrientation($orientation)
                    ->stream();
            } elseif ($fileType == 'CSV') {
                $reportInstance = new CSVReport();
                return $reportInstance
                    ->of($title, $subtitle, $meta, $markets, $columns)
                    ->setOrientation($orientation)
                    ->download($subtitle);
            } else {
                $reportInstance = new ExcelReport();
                return $reportInstance
                    ->of($title, $subtitle, $meta, $markets, $columns)
                    ->setOrientation($orientation)
                    ->download($subtitle);
            }
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function generateCustomersReport(Request $request)
    {
        $sortBy = $request->sort_by;
        $orientation = $request->input('orientation');
        $marketId = $request->input('market_id');
        $fileType = $request->input('file_type');

        $heading = 'Kinondoni Municipal Council';
        $title = $heading;
        $subtitle = $request->title ?? 'Markets Reports';
        $meta = [
            // 'Year' => date('Y'),
            'Sorted By' => $sortBy,
        ];

        try {
            $columns = [
                'NIDA' => 'nida',
                'First Name' => 'first_name',
                'Middle Name' => 'middle_name',
                'Last Name' => 'last_name',
                'Mobile Number' => 'mobile',
                'Physical Address' => 'address',
                'Market' => function ($customer) {
                    foreach ($customer->markets as $market) {
                        return $market->name . ", \n";
                    }
                },
            ];

            if ($request->has('with_frames')) {
                $columns['Frames'] = function ($customer) {
                    $frameList = [];
                    foreach ($customer->frames as $frame) {
                        $frameList[] = $frame->code;
                    }
                    $frameString = implode(",\n", $frameList);
                    return htmlspecialchars($frameString);
                };
            }
            if ($request->has('with_stalls')) {
                $columns['Stalls'] = function ($customer) {
                    $stallList = [];
                    foreach ($customer->stalls as $stall) {
                        $stallList[] = $stall->code;
                    }
                    $stallString = implode(",\n", $stallList);
                    return htmlspecialchars($stallString);
                };
            }
            if ($marketId != 'All') {
                $customers = Customer::whereHas('markets', function ($markets) use ($sortBy, $marketId) {
                    $markets->where('markets.id', $marketId)->orderBy($sortBy);
                });
            } else {
                $customers = Customer::orderBy($sortBy);
            }

            if ($fileType == 'PDF') {
                $reportInstance = new PdfReport();
                return $reportInstance
                    ->of($title, $subtitle, $meta, $customers, $columns)
                    ->setOrientation($orientation)
                    ->stream();
            } elseif ($fileType == 'CSV') {
                $reportInstance = new CSVReport();
                return $reportInstance
                    ->of($title, $subtitle, $meta, $customers, $columns)
                    ->setOrientation($orientation)
                    ->download($subtitle);
            } else {
                $reportInstance = new ExcelReport();
                return $reportInstance
                    ->of($title, $subtitle, $meta, $customers, $columns)
                    ->setOrientation($orientation)
                    ->download($subtitle);
            }
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function generatePaymentsReport(Request $request)
    {
        $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date, 'UTC')->setTimezone('Africa/Dar_es_salaam');
        $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date, 'UTC')->setTimezone('Africa/Dar_es_salaam');
        $orientation = $request->input('orientation');
        $sortBy = $request->sort_by;
        $groupBy = null;

        $fileType = $request->input('file_type');

        $heading = 'Kinondoni Municipal Council';
        $title = $heading;
        $subtitle = $request->title ?? 'Markets Reports';
        $meta = [
            'From' => Carbon::parse($fromDate)->format('d M Y') . ' ---- ' . Carbon::parse($toDate)->format('d M Y'),
            'Sorted By' => $sortBy,
        ];

        $payments = null;
        try {
            $columns = [
                'Created Date' => function ($payment) {
                    return Carbon::parse($payment->date)->format('d M, Y');
                },
                'Receipt Number' => 'receipt_number',
                'Amount (TZS)' => 'amount',

                'Paid For' => function ($payment) {
                    if ($payment->frame_id) {
                        return $payment->frame->code;
                    } elseif ($payment->stall_id) {
                        return $payment->stall->code;
                    }
                },
            ];

            if ($request->market_id != 'All' && $request->customer_id != 'All') {
                $payments = Payment::where(['market_id' => $request->market_id, 'customer_id' => $request->customer_id])->whereBetween('date', [$fromDate, $toDate]);
                // ->orderBy($sortBy);
                $columns['Market'] = function ($payment) {
                    return $payment->market->name;
                };
                $columns['Customer'] = function ($payment) {
                    return $payment->customer->first_name . ' ' . $payment->customer->middle_name . ' ' . $payment->customer->last_name;
                };
            } elseif ($request->market_id != 'All') {
                $payments = Payment::where(['market_id' => $request->market_id])->whereBetween('date', [$fromDate, $toDate]);
                // ->orderBy($sortBy);
                $columns['Market'] = function ($payment) {
                    return $payment->market->name;
                };
                $columns['Customer'] = function ($payment) {
                    return $payment->customer->first_name . ' ' . $payment->customer->middle_name . ' ' . $payment->customer->last_name;
                };
            } elseif ($request->customer_id != 'All') {
                $payments = Payment::where(['customer_id' => $request->customer_id])->whereBetween('date', [$fromDate, $toDate]);
                // ->orderBy($sortBy);
                $columns['Market'] = function ($payment) {
                    return $payment->market->name;
                };
                $columns['Customer'] = function ($payment) {
                    return $payment->customer->first_name . ' ' . $payment->customer->middle_name . ' ' . $payment->customer->last_name;
                };
            } elseif ($request->market_id == 'All' && $request->customer_id == 'All') {
                $payments = Payment::whereBetween('date', [$fromDate, $toDate]);
                $columns['Market'] = function ($payment) {
                    return $payment->market->name;
                };
                $columns['Customer'] = function ($payment) {
                    return $payment->customer->first_name . ' ' . $payment->customer->middle_name . ' ' . $payment->customer->last_name;
                };
            }
            if ($request->month != 'All' && $request->year != 'All') {
                $payments = $payments->where(['month' => $request->month, 'year' => $request->year])->whereBetween('date', [$fromDate, $toDate]);
                // ->orderBy($sortBy);
                $columns['Month'] = function ($payment) {
                    return $payment->month;
                };
                $columns['Year'] = function ($payment) {
                    return $payment->year;
                };
            } elseif ($request->month != 'All') {
                $payments = $payments
                    ->where(['month' => $request->month])
                    // ->whereBetween('date', [$fromDate, $toDate])
                    ->orderBy($sortBy);
                $columns['Month'] = function ($payment) {
                    return $payment->month;
                };
                $columns['Year'] = function ($payment) {
                    return $payment->year;
                };
            } elseif ($request->year != 'All') {
                $payments = $payments
                    ->where(['year' => $request->year])
                    // ->whereBetween('date', [$fromDate, $toDate])
                    ->orderBy($sortBy);
                $columns['Month'] = function ($payment) {
                    return $payment->month;
                };
                $columns['Year'] = function ($payment) {
                    return $payment->year;
                };
            } elseif ($request->month == 'All' && $request->year == 'All') {
                $payments = $payments
                    // ->where()->whereBetween('date', [$fromDate, $toDate])
                    ->orderBy($sortBy);
                $columns['Month'] = function ($payment) {
                    return $payment->month;
                };
                $columns['Year'] = function ($payment) {
                    return $payment->year;
                };
            }
            $columns['Issued By'] = function ($payment) {
                if ($payment->frameIn) {
                    return $payment->frameIn->user->name;
                } elseif ($payment->stallIn) {
                    return $payment->stallIn->user->name;
                } {
                    return '-';
                }
            };
            if ($fileType == 'PDF') {
                $reportInstance = new PdfReport();
                if ($request->has('show_total')) {
                    return $reportInstance
                        ->of($title, $subtitle, $meta, $payments, $columns)
                        ->setOrientation($orientation)
                        ->editColumns(
                            ['Amount (TZS)'],
                            [
                                'class' => 'right',
                            ],
                        )
                        ->showTotal([
                            'Amount (TZS)' => 'point',
                        ])
                        ->stream();
                } else {
                    return $reportInstance
                        ->of($title, $subtitle, $meta, $payments, $columns)
                        ->setOrientation($orientation)
                        ->editColumns(
                            ['Amount (TZS)'],
                            [
                                'class' => 'right',
                            ],
                        )
                        ->stream();
                }
            } elseif ($fileType == 'CSV') {
                $reportInstance = new CSVReport();
                if ($request->has('show_total')) {
                    return $reportInstance
                        ->of($title, $subtitle, $meta, $payments, $columns)
                        ->setOrientation($orientation)
                        ->editColumns(
                            ['Amount (TZS)'],
                            [
                                'class' => 'right',
                            ],
                        )
                        ->showTotal([
                            'Amount (TZS)' => 'point',
                        ])

                        ->download($subtitle);
                } else {
                    return $reportInstance
                        ->of($title, $subtitle, $meta, $payments, $columns)
                        ->setOrientation($orientation)
                        ->editColumns(
                            ['Amount (TZS)'],
                            [
                                'class' => 'right',
                            ],
                        )

                        ->download($subtitle);
                }
            } else {
                $reportInstance = new ExcelReport();
                if ($request->has('show_total')) {
                    return $reportInstance
                        ->of($title, $subtitle, $meta, $payments, $columns)
                        ->setOrientation($orientation)
                        ->editColumns(
                            ['Amount (TZS)'],
                            [
                                'class' => 'right',
                            ],
                        )
                        ->showTotal([
                            'Amount (TZS)' => 'point',
                        ])
                        ->download($subtitle);
                } else {
                    return $reportInstance
                        ->of($title, $subtitle, $meta, $payments, $columns)
                        ->setOrientation($orientation)
                        ->editColumns(
                            ['Amount (TZS)'],
                            [
                                'class' => 'right',
                            ],
                        )

                        ->download($subtitle);
                    }
            }
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
