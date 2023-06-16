<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Frame;
use App\Models\Market;
use App\Models\Payment;
use App\Models\Report;
use App\Models\Stall;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Jimmyjs\ReportGenerator\ReportMedia\CSVReport;
use Jimmyjs\ReportGenerator\ReportMedia\ExcelReport;
use Jimmyjs\ReportGenerator\ReportMedia\PdfReport;

class ManagerReportController extends Controller
{
    public function marketsReport()
    {
        return view('reports.manager.markets_report');
    }
    public function customersReport()
    {
        $markets = Market::all();
        return view('reports.manager.customers_report', compact('markets'));
    }
    public function paymentsReport()
    {
        $markets = Market::all();
        $customers = Customer::all();
        return view('reports.manager.payments_report', compact('markets', 'customers'));
    }
    public function customerPaymentsReport()
    {
        $markets = Market::all();
        $customers = Customer::all();
        return view('reports.manager.frame_stall_report', compact('markets', 'customers'));
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
        $meta = [];

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
                $markets = Market::where(['ward' => $ward])
                    ->orderBy($sortBy)
                    ->get();
                $columns['Ward'] = function ($result) {
                    return $result->ward;
                };
            } else {
                $markets = Market::orderBy($sortBy)->get();
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
        $meta = [];

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
                    $markets
                        ->where('markets.id', $marketId)
                        ->orderBy($sortBy)
                        ->get();
                });
            } else {
                $customers = Customer::orderBy($sortBy)->get();
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
                $columns['Market'] = function ($payment) {
                    return $payment->market->name;
                };
                $columns['Customer'] = function ($payment) {
                    return $payment->customer->first_name . ' ' . $payment->customer->middle_name . ' ' . $payment->customer->last_name;
                };
            } elseif ($request->market_id != 'All') {
                $payments = Payment::where(['market_id' => $request->market_id])->whereBetween('date', [$fromDate, $toDate]);
                $columns['Market'] = function ($payment) {
                    return $payment->market->name;
                };
                $columns['Customer'] = function ($payment) {
                    return $payment->customer->first_name . ' ' . $payment->customer->middle_name . ' ' . $payment->customer->last_name;
                };
            } elseif ($request->customer_id != 'All') {
                $payments = Payment::where(['customer_id' => $request->customer_id])->whereBetween('date', [$fromDate, $toDate]);
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
                $columns['Month'] = function ($payment) {
                    return $payment->month;
                };
                $columns['Year'] = function ($payment) {
                    return $payment->year;
                };
            } elseif ($request->month != 'All') {
                $payments = $payments
                    ->where(['month' => $request->month])
                    ->orderBy($sortBy)
                    ->get();
                $columns['Month'] = function ($payment) {
                    return $payment->month;
                };
                $columns['Year'] = function ($payment) {
                    return $payment->year;
                };
            } elseif ($request->year != 'All') {
                $payments = $payments
                    ->where(['year' => $request->year])
                    ->orderBy($sortBy)
                    ->get();
                $columns['Month'] = function ($payment) {
                    return $payment->month;
                };
                $columns['Year'] = function ($payment) {
                    return $payment->year;
                };
            } elseif ($request->month == 'All' && $request->year == 'All') {
                $payments = $payments->orderBy($sortBy)->get();
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
                }
                return '-';
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
                                'class' => 'right td-bordered',
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
                            'class' => 'right td-bordered',
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
                                'class' => 'right td-bordered',
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
                                'class' => 'right td-bordered',
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
                                'class' => 'right  td-bordered',
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
                                'class' => 'right  td-bordered',
                            ],
                        )

                        ->download($subtitle);
                }
            }
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function generateFrameStallReport(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $sortBy = $request->sort_by;
        $orientation = $request->input('orientation');
        $marketId = $request->input('market_id');
        $customerId = $request->input('customer_id');
        $fileType = $request->input('file_type');

        $heading = 'Kinondoni Municipal Council';
        $title = $heading;
        $subtitle = $request->title ?? 'Markets Reports';
        $meta = [
            'Year' => $request->year,
            'Month' => $request->month,
        ];

        try {
            $columns = [
                'NIDA' => function ($data) {
                    // dd($data);
                    return $data->customer->nida;
                },
                'Customer Name' => function ($data) {
                    return $data->customer->first_name . ' ' . $data->customer->middle_name . ' ' . $data->customer->last_name;
                },
            ];

            if ($request->has('frames') && $request->has('stalls')) {
                $columns['Frame/Stall'] = function ($data) {
                    return $data->code;
                };
            }
            elseif ($request->has('frames')) {
                $columns['Frame'] = function ($data) {
                    return $data->code;
                };
            } elseif ($request->has('stalls')) {
                $columns['Stall'] = function ($data) {
                    return $data->code;
                };
            }

            if ($month != 'All Months') {
                $columns[$month] = function ($data) use ($year, $month) {
                    foreach ($data->payments as $payment) {
                        if ($payment->year == $year && $payment->month == $month) {
                            return $payment->amount;
                        } else {
                            return '-';
                        }
                    }
                };
            } else {
                $columns['January'] = function ($data) use ($year) {
                    foreach ($data->payments as $payment) {
                        if ($payment->year == $year && $payment->month == 'January') {
                            return $payment->amount;
                        } else {
                            return '-';
                        }
                    }
                };
                $columns['February'] = function ($data) use ($year) {
                    foreach ($data->payments as $payment) {
                        if ($payment->year == $year && $payment->month == 'February') {
                            return $payment->amount;
                        } else {
                            return '-';
                        }
                    }
                };
                $columns['March'] = function ($data) use ($year) {
                    foreach ($data->payments as $payment) {
                        if ($payment->year == $year && $payment->month == 'March') {
                            return $payment->amount;
                        } else {
                            return '-';
                        }
                    }
                };
                $columns['April'] = function ($data) use ($year) {
                    foreach ($data->payments as $payment) {
                        if ($payment->year == $year && $payment->month == 'April') {
                            return $payment->amount;
                        } else {
                            return '-';
                        }
                    }
                };
                $columns['May'] = function ($data) use ($year) {
                    foreach ($data->payments as $payment) {
                        if ($payment->year == $year && $payment->month == 'May') {
                            return $payment->amount;
                        } else {
                            return '-';
                        }
                    }
                };
                $columns['June'] = function ($data) use ($year) {
                    foreach ($data->payments as $payment) {
                        if ($payment->year == $year && $payment->month == 'June') {
                            return $payment->amount;
                        } else {
                            return '-';
                        }
                    }
                };
                $columns['July'] = function ($data) use ($year) {
                    foreach ($data->payments as $payment) {
                        if ($payment->year == $year && $payment->month == 'July') {
                            return $payment->amount;
                        } else {
                            return '-';
                        }
                    }
                };
                $columns['August'] = function ($data) use ($year) {
                    foreach ($data->payments as $payment) {
                        if ($payment->year == $year && $payment->month == 'August') {
                            return $payment->amount;
                        } else {
                            return '-';
                        }
                    }
                };
                $columns['September'] = function ($data) use ($year) {
                    foreach ($data->payments as $payment) {
                        if ($payment->year == $year && $payment->month == 'September') {
                            return $payment->amount;
                        } else {
                            return '-';
                        }
                    }
                };
                $columns['October'] = function ($data) use ($year) {
                    foreach ($data->payments as $payment) {
                        if ($payment->year == $year && $payment->month == 'October') {
                            return $payment->amount;
                        } else {
                            return '-';
                        }
                    }
                };
                $columns['November'] = function ($data) use ($year) {
                    foreach ($data->payments as $payment) {
                        if ($payment->year == $year && $payment->month == 'November') {
                            return $payment->amount;
                        } else {
                            return '-';
                        }
                    }
                };
                $columns['December'] = function ($data) use ($year) {
                    foreach ($data->payments as $payment) {
                        if ($payment->year == $year && $payment->month == 'December') {
                            return $payment->amount;
                        } else {
                            return '-';
                        }
                    }
                };
            }

            if ($marketId != 'All' && $customerId != 'All') {
                if ($request->has('frames') && $request->has('stalls')) {
                    $frames = Frame::where(['market_id' => $marketId, 'customer_id' => $customerId])
                        ->orderBy($sortBy)
                        ->get();
                    $stalls = Stall::where(['market_id' => $marketId, 'customer_id' => $customerId])
                        ->orderBy($sortBy)
                        ->get();
                    $framesOrStallsData = $frames->concat($stalls);
                }
                elseif ($request->has('frames')) {
                    $framesOrStallsData = Frame::where(['market_id' => $marketId, 'customer_id' => $customerId])
                        ->orderBy($sortBy)
                        ->get();
                } elseif ($request->has('stalls')) {
                    $framesOrStallsData = Stall::where(['market_id' => $marketId, 'customer_id' => $customerId])
                        ->orderBy($sortBy)
                        ->get();
                }
            } elseif ($marketId != 'All') {
                if ($request->has('frames') && $request->has('stalls')) {
                    $frames = Frame::where(['market_id' => $marketId])->whereNotNull('customer_id')
                        ->orderBy($sortBy)
                        ->get();
                    $stalls = Stall::where(['market_id' => $marketId])->whereNotNull('customer_id')
                        ->orderBy($sortBy)
                        ->get();
                        $framesOrStallsData = $frames->concat($stalls);
                } elseif ($request->has('frames')) {
                    $framesOrStallsData = Frame::where(['market_id' => $marketId])->whereNotNull('customer_id')
                        ->orderBy($sortBy)
                        ->get();
                } elseif ($request->has('stalls')) {
                    $framesOrStallsData = Stall::where(['market_id' => $marketId])->whereNotNull('customer_id')
                        ->orderBy($sortBy)
                        ->get();
                }
            } elseif ($customerId != 'All') {
                if ($request->has('frames') && $request->has('stalls')) {
                    $frames = Frame::where(['customer_id' => $customerId])
                        ->orderBy($sortBy)
                        ->get();
                    $stalls = Stall::where(['customer_id' => $customerId])
                        ->orderBy($sortBy)
                        ->get();

                    $framesOrStallsData = $frames->concat($stalls);
                } elseif ($request->has('frames')) {
                    $framesOrStallsData = Frame::where(['customer_id' => $customerId])
                        ->orderBy($sortBy)
                        ->get();
                } elseif ($request->has('stalls')) {
                    $framesOrStallsData = Stall::where(['customer_id' => $customerId])
                        ->orderBy($sortBy)
                        ->get();
                }
            } else {
                if ($request->has('frames') && $request->has('stalls')) {
                    $frames = Frame::whereNotNull('customer_id')
                        ->orderBy($sortBy)
                        ->get();
                    $stalls = Stall::whereNotNull('customer_id')
                        ->orderBy($sortBy)
                        ->get();

                    $framesOrStallsData = $frames->concat($stalls);
                } elseif ($request->has('frames')) {
                    $framesOrStallsData = Frame::whereNotNull('customer_id')
                        ->orderBy($sortBy)
                        ->get();
                } elseif ($request->has('stalls')) {
                    $framesOrStallsData = Stall::whereNotNull('customer_id')
                        ->orderBy($sortBy)
                        ->get();
                }
            }

            if ($fileType == 'PDF') {
                $reportInstance = new PdfReport();
                return $reportInstance
                    ->of($title, $subtitle, $meta, $framesOrStallsData, $columns)
                    ->setOrientation($orientation)
                    ->editColumns(
                        ['January','February','March','April','May','June','July','August','September','October','November','December'],
                        [
                            'class' => 'middle td-bordered',
                        ],
                    )
                    ->stream();
            } elseif ($fileType == 'CSV') {
                $reportInstance = new CSVReport();
                return $reportInstance
                    ->of($title, $subtitle, $meta, $framesOrStallsData, $columns)
                    ->setOrientation($orientation)
                    ->download($subtitle);
            } else {
                $reportInstance = new ExcelReport();
                return $reportInstance
                    ->of($title, $subtitle, $meta, $framesOrStallsData, $columns)
                    ->setOrientation($orientation)
                    ->download($subtitle);
            }
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
