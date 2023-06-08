<div class="card px-0 mx-2 mt-4">
    <div class="card-header">
        Records
    </div>
    <div class="card-body px-1 py-1">
        <div class="row  my-2">
            <div class="col" style="color:rgb(2, 2, 111)">
                <label class="p-2" style="border-radius:5px; background-color:rgb(245, 237, 220)">
                    {{ App\Models\Stall::find($selectedStallId)->code }}
                </label>
            </div>
            <div class="col py-0 text-end">
                <form action="{{ route('customers.show', ['customer' => $customer, 'marketId' => $market->id]) }}"
                    method="get">
                    <input type="number" value="{{ $selectedStallId }}" name="selectedStallId" hidden>
                    <input type="number" value="{{ $selectedFrameId }}" name="selectedFrameId" hidden>
                    <input type="number" value="{{ $frameSelectedYear }}" name="frameSelectedYear" hidden>
                    Year &nbsp;&nbsp; <select onchange="this.form.submit()"
                        class=" js-example-basic-single form-control" required name="stallSelectedYear"
                        style="width: 40%;">
                        @php
                            $currentYear = date('Y');
                            $years = range($currentYear, $currentYear - 50);
                        @endphp
                        @foreach ($years as $year)
                            <option value="{{ $year }}"{{ $stallSelectedYear == $year ? 'selected' : '' }}>
                                {{ $year }}</option>
                        @endforeach

                    </select>
                </form>
            </div>
        </div>
        <table id="" class="dt-responsive nowrap  rounded-3 table table-hover"style="width: 100%">
            <thead class="table-head">
                <tr>
                    <th>Month</th>
                    <th class="text-center">Status</th>
                    <th>Issued By</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $months = [
                        1 => 'January',
                        2 => 'February',
                        3 => 'March',
                        4 => 'April',
                        5 => 'May',
                        6 => 'June',
                        7 => 'July',
                        8 => 'August',
                        9 => 'September',
                        10 => 'October',
                        11 => 'November',
                        12 => 'December',
                    ];
                @endphp
                @foreach ($months as $monthNumber => $monthName)
                    @php
                        $stallRecord = App\Models\StallIn::where('stall_id', $selectedStallId)
                            ->where('customer_id', $customer->id)
                            ->whereHas('payment', function ($query) use ($monthName, $stallSelectedYear) {
                                $query->where('month', $monthName)->where('year', $stallSelectedYear);
                            })
                            ->first();
                    @endphp
                    <tr>
                        <td>{{ $monthName }}</td>
                        <td class="text-center">
                            @if ($stallRecord)
                                <label class="p-1 m-0 text-white text-center bg-success" style="width:80px;"> PAID
                                </label>
                            @else
                                <label class="p-1 m-0 text-white text-center bg-danger" style="width:80px;"> NOT PAID
                                </label>
                            @endif
                        </td>
                        <td>{{ $stallRecord->user->name ?? '' }}</td>
                        <td class="text-center">
                            @if ($stallRecord)
                                <label class="p-1 m-0 mdi mdi-check text-success ">
                                    {{ number_format($stallRecord->payment->amount, 0, '.', ',') }} TZS </label>
                            @else
                                <a href="#" data-toggle="modal" data-target="#payStallModal-{{ $monthName }}"
                                    class="btn btn-outline-primary">PAY</a>
                            @endif
                        </td>
                        <div class="modal fade" id="payStallModal-{{ $monthName }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Payment</h5>
                                        <button type="button" style="background-color:red"
                                            class="btn-close  btn-danger" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <form action="{{ route('stalls.renew_stall') }}" method="post">
                                            @csrf
                                            <input type="text" name="customer_id" value="{{ $customer->id }}"
                                                hidden>
                                            <input type="text" name="year"
                                                value="{{ $stallSelectedYear }}"hidden>
                                            <input type="text" name="stall_id" value="{{ $selectedStallId }}"hidden>
                                            <div class=" ">
                                                Payment for:
                                                {{ $customer->first_name }} {{ $customer->middle_name }}
                                                {{ $customer->last_name }},
                                            </div>
                                            <div class=" ">
                                                Stall:
                                                {{ App\Models\Stall::find($selectedStallId)->code }}

                                            </div>
                                            <div class="pb-1 ">Month: {{ $monthName }}, {{ $stallSelectedYear }}
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label for="">Month</label>
                                                <select class="js-example-basic-multiple form-control"
                                                    multiple="multiple" required name="months[]" style="width: 100%;">
                                                    <option value="">Month</option>
                                                    <option
                                                        value="January"{{ $monthName == 'January' ? 'selected' : '' }}>
                                                        January
                                                        &nbsp;&nbsp;{{ $stallSelectedYear }}
                                                    </option>
                                                    <option
                                                        value="February"{{ $monthName == 'February' ? 'selected' : '' }}>
                                                        February
                                                        &nbsp;&nbsp;{{ $stallSelectedYear }}</option>
                                                    <option
                                                        value="March"{{ $monthName == 'March' ? 'selected' : '' }}>
                                                        March &nbsp;&nbsp;{{ $stallSelectedYear }}
                                                    </option>
                                                    <option
                                                        value="April"{{ $monthName == 'April' ? 'selected' : '' }}>
                                                        April &nbsp;&nbsp;{{ $stallSelectedYear }}
                                                    </option>
                                                    <option value="May"{{ $monthName == 'May' ? 'selected' : '' }}>
                                                        May
                                                        &nbsp;&nbsp;{{ $stallSelectedYear }}
                                                    </option>
                                                    <option value="June"{{ $monthName == 'June' ? 'selected' : '' }}>
                                                        June &nbsp;&nbsp;{{ $stallSelectedYear }}
                                                    </option>
                                                    <option value="July"{{ $monthName == 'July' ? 'selected' : '' }}>
                                                        July &nbsp;&nbsp;{{ $stallSelectedYear }}
                                                    </option>
                                                    <option
                                                        value="August"{{ $monthName == 'August' ? 'selected' : '' }}>
                                                        August &nbsp;&nbsp;{{ $stallSelectedYear }}
                                                    </option>
                                                    <option
                                                        value="September"{{ $monthName == 'September' ? 'selected' : '' }}>
                                                        September
                                                        &nbsp;&nbsp;{{ $stallSelectedYear }}</option>
                                                    <option
                                                        value="October"{{ $monthName == 'October' ? 'selected' : '' }}>
                                                        October
                                                        &nbsp;&nbsp;{{ $stallSelectedYear }}
                                                    </option>
                                                    <option
                                                        value="November"{{ $monthName == 'November' ? 'selected' : '' }}>
                                                        November
                                                        &nbsp;&nbsp;{{ $stallSelectedYear }}</option>
                                                    <option
                                                        value="December"{{ $monthName == 'December' ? 'selected' : '' }}>
                                                        December
                                                        &nbsp;&nbsp;{{ $stallSelectedYear }}</option>
                                                </select>
                                                @error('months[]')
                                                    <span class="error" style="color:red">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class=" form-group">
                                                <label for="">Business</label>
                                                <input type="text" name="business" class="form-control"
                                                    placeholder="Business (Optional)">
                                                @error('business')
                                                    <span class="error" style="color:red">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class=" form-group">
                                                <label for="">Receipt Number</label>
                                                <input type="text" name="receipt_number" class="form-control"
                                                    placeholder="Receipt Number" required>
                                                @error('receipt_number')
                                                    <span class="error" style="color:red">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="row mb-2 mt-2">
                                                <div class="text-center">
                                                    <button type="submit" class="btn  btn-outline-primary">
                                                        {{ __('Submit') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
