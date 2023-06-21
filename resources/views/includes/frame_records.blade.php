<div class="card px-0 mx-2 mt-4">
    <div class="card-header">
        Records
    </div>
    <div class="card-body px-1 py-1">
        <div class="row  my-2">
            <div class="col" style="color:rgb(2, 2, 111)">
                <label class="p-2" style="border-radius:5px; background-color:rgb(245, 237, 220)">
                    {{ App\Models\Frame::find($selectedFrameId)->code }}
                </label>
            </div>
            <div class="col py-0 text-end">
                <form action="{{ route('customers.show') }}"
                    method="get">
                    <input type="number" name="market_id" value="{{ $market->id }}" hidden>
                    <input type="number" name="customer_id" value="{{ $customer->id }}" hidden>
                    <input type="number" value="{{ $selectedFrameId }}" name="selectedFrameId" hidden>
                    <input type="number" value="{{ $selectedStallId }}" name="selectedStallId" hidden>
                    <input type="number" value="{{ $stallSelectedYear }}" name="stallSelectedYear" hidden>
                    Year &nbsp;&nbsp; <select onchange="this.form.submit()"
                        class=" js-example-basic-single form-control" required name="frameSelectedYear"
                        style="width: 40%;">
                        @php
                            $currentYear = date('Y');
                            $years = range($currentYear, $currentYear - 50);
                        @endphp
                        @foreach ($years as $year)
                            <option value="{{ $year }}"{{ $frameSelectedYear == $year ? 'selected' : '' }}>
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
                        $frameRecord = App\Models\FrameIn::where('frame_id', $selectedFrameId)
                            ->where('customer_id', $customer->id)
                            ->whereHas('payment', function ($query) use ($monthName, $frameSelectedYear) {
                                $query->where('month', $monthName)->where('year', $frameSelectedYear);
                            })
                            ->first();
                    @endphp
                    <tr>
                        <td>{{ $monthName }}</td>
                        <td class="text-center">
                            @if ($frameRecord)
                                <label class="p-1 m-0 text-white text-center bg-success" style="width:80px;"> PAID
                                </label>
                            @else
                                <label class="p-1 m-0 text-white text-center bg-danger" style="width:80px;"> NOT PAID
                                </label>
                            @endif
                        </td>
                        <td>{{ $frameRecord->user->name ?? '' }}</td>
                        <td class="text-center">
                            @if ($frameRecord)
                                <label class="p-1 m-0 mdi mdi-check text-success ">
                                    {{ number_format($frameRecord->payment->amount, 0, '.', ',') }} TZS </label>
                            @else
                                <a href="#" data-toggle="modal" data-target="#payFrameModal-{{ $monthName }}"
                                    class="btn btn-outline-primary">PAY</a>
                            @endif
                        </td>
                        <div class="modal fade" id="payFrameModal-{{ $monthName }}" tabindex="-1"
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
                                        <form action="{{ route('frames.renew_frame') }}" method="post">
                                            @csrf
                                            <input type="text" name="customer_id" value="{{ $customer->id }}"
                                                hidden>
                                            <input type="text" name="year"
                                                value="{{ $frameSelectedYear }}"hidden>
                                            <input type="text" name="frame_id" value="{{ $selectedFrameId }}"hidden>
                                            <div class=" ">
                                                Payment for:
                                                {{ $customer->first_name }} {{ $customer->middle_name }}
                                                {{ $customer->last_name }},
                                            </div>
                                            <div class=" ">
                                                Frame:
                                                {{ App\Models\Frame::find($selectedFrameId)->code }}
                                            </div>
                                            <div class="pb-1 ">Month: {{ $monthName }}, {{ $frameSelectedYear }}
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
                                                        &nbsp;&nbsp;{{ $frameSelectedYear }}
                                                    </option>
                                                    <option
                                                        value="February"{{ $monthName == 'February' ? 'selected' : '' }}>
                                                        February
                                                        &nbsp;&nbsp;{{ $frameSelectedYear }}</option>
                                                    <option
                                                        value="March"{{ $monthName == 'March' ? 'selected' : '' }}>
                                                        March &nbsp;&nbsp;{{ $frameSelectedYear }}
                                                    </option>
                                                    <option
                                                        value="April"{{ $monthName == 'April' ? 'selected' : '' }}>
                                                        April &nbsp;&nbsp;{{ $frameSelectedYear }}
                                                    </option>
                                                    <option value="May"{{ $monthName == 'May' ? 'selected' : '' }}>
                                                        May
                                                        &nbsp;&nbsp;{{ $frameSelectedYear }}
                                                    </option>
                                                    <option value="June"{{ $monthName == 'June' ? 'selected' : '' }}>
                                                        June &nbsp;&nbsp;{{ $frameSelectedYear }}
                                                    </option>
                                                    <option value="July"{{ $monthName == 'July' ? 'selected' : '' }}>
                                                        July &nbsp;&nbsp;{{ $frameSelectedYear }}
                                                    </option>
                                                    <option
                                                        value="August"{{ $monthName == 'August' ? 'selected' : '' }}>
                                                        August &nbsp;&nbsp;{{ $frameSelectedYear }}
                                                    </option>
                                                    <option
                                                        value="September"{{ $monthName == 'September' ? 'selected' : '' }}>
                                                        September
                                                        &nbsp;&nbsp;{{ $frameSelectedYear }}</option>
                                                    <option
                                                        value="October"{{ $monthName == 'October' ? 'selected' : '' }}>
                                                        October
                                                        &nbsp;&nbsp;{{ $frameSelectedYear }}
                                                    </option>
                                                    <option
                                                        value="November"{{ $monthName == 'November' ? 'selected' : '' }}>
                                                        November
                                                        &nbsp;&nbsp;{{ $frameSelectedYear }}</option>
                                                    <option
                                                        value="December"{{ $monthName == 'December' ? 'selected' : '' }}>
                                                        December
                                                        &nbsp;&nbsp;{{ $frameSelectedYear }}</option>
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
