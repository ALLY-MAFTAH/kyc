<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Market;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $markets=Market::all();
        return view('reports.customers_report',compact('markets'));
    }
    public function paymentsReport()
    {
        return view('reports.payments_report');
    }
    public function generateMarketsReport(Request $request)
    {

        $sortBy = $request->sort_by;
        $orientation = $request->input('orientation');
        $ward = $request->input('ward');

        $heading="Kinondoni Municipal Council";
        $title = $heading;
        $subtitle = $request->title ?? 'Markets Reports';
        $meta = [
            'Year' => date('Y'),
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
                'Frame Price' => 'frame_price',
                'Stall Price' => 'stall_price',
                'Size' => 'size',
            ];

             if ($ward != "All") {
                $markets = Market::where(['ward' => $ward])
                    ->orderBy($sortBy);
                $columns['Ward'] = function ($result) {
                    return $result->ward;
                };
            } else {
                $markets = Market::orderBy($sortBy);
            }

            $reportInstance = new PdfReport();
            // $reportInstance = new ExcelReport();
            // $reportInstance = new CSVReport  ();

            return $reportInstance
                ->of($title,$subtitle, $meta, $markets, $columns)
                ->setOrientation($orientation)
                ->stream(); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
                // ->download("kmc"); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
            // }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
    public function generateCustomersReport(Request $request)
    {
        $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date, 'UTC')->setTimezone('Africa/Dar_es_salaam');
        $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date, 'UTC')->setTimezone('Africa/Dar_es_salaam');
        $sortBy = $request->sort_by;
        $groupBy = null;
        $orientation = $request->input('orientation');
        $ward = $request->input('ward');
        $subWard = $request->input('sub_ward');

        $heading="Kinondoni Municipal Council";
        $title = $heading;
        $subtitle = $heading."\n". $request->title ?? 'Markets Reports';        $meta = [
            'Created from' => Carbon::parse($fromDate)->format('D, d M Y') . ' to ' . Carbon::parse($toDate)->format('D, d M Y'),
            'Sorted By' => $sortBy,
        ];

        try {
            $columns = [
                'Created Date' => function ($result) {
                    return Carbon::parse($result->created_at)->format('d M, Y');
                },
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
                'Frame Price' => 'frame_price',
                'Stall Price' => 'stall_price',
                'Size' => 'size',
            ];
            if ($subWard != null) {
                $markets = Customer::where(['sub_ward' => $subWard])
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->orderBy($sortBy);
                $columns['Sub-Ward'] = function ($result) {
                    return $result->sub_ward;
                };
                // $title = "Customers in " . SubWard::find($subWard)->name;
            } elseif ($ward != null) {
                $markets = Customer::where(['ward' => $ward])
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->orderBy($sortBy);
                // $title = "Customers in " . Ward::find($ward)->name;
                $columns['Ward'] = function ($result) {
                    return $result->ward;
                };
            } else {
                $markets = Customer::whereBetween('created_at', [$fromDate, $toDate])->orderBy($sortBy);
            }
            // dd($title);

            $reportInstance = new PdfReport();
            // $reportInstance = new ExcelReport();
            // $reportInstance = new CSVReport  ();
            // if ($groupBy != null) {
            //     return $reportInstance->of($title, $meta, $markets, $columns)
            //         ->setOrientation($orientation)
            //         ->editColumn('Registered Date', [])
            //         ->groupBy($groupBy)
            //         ->stream(); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
            // } else {
            return $reportInstance
                ->of($title,$subtitle, $meta, $markets, $columns)
                ->setOrientation($orientation)
                ->editColumn('Created Date', [])
                ->stream(); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
            // }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
