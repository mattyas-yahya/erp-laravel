<div class="row">
    <div class="col-sm-12">
        <div class="mt-2">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['report.marketing'], 'method' => 'GET', 'id' => 'sales_order_report_filter']) }}
                    <div class="row align-items-center justify-content-start">
                        <div class="col-xl-10">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        {{ Form::label('month', __('Month'), ['class' => 'form-label']) }}
                                        {{ Form::select('month', $filterValues['months'], isset($_GET['month']) ? $_GET['month'] : date('m'), ['class' => 'form-control select']) }}
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        {{ Form::label('year', __('Year'), ['class' => 'form-label']) }}
                                        {{ Form::select('year', $filterValues['years'], isset($_GET['year']) ? $_GET['year'] : date('Y'), ['class' => 'form-control select']) }}
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        {{ Form::label('marketingEmployee', __('Marketing Employee'), ['class' => 'form-label']) }}
                                        <select class="form-control select2" name="employee_id" id="marketing-employee">
                                            <option value=""></option>
                                            @foreach ($filterValues['marketingEmployees'] as $employee)
                                                <option value="{{ $employee->id }}"
                                                    @if ($employee->id == ($_GET['employee_id'] ?? null)) selected @endif>
                                                    {{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="row float-end">
                                <div class="col-auto mt-4">
                                    <a href="#" class="btn btn-sm btn-primary"
                                        onclick="document.getElementById('sales_order_report_filter').submit(); return false;"
                                        data-bs-toggle="tooltip" title="{{ __('Apply Filter') }}"
                                        data-original-title="{{ __('Apply Filter') }}">
                                        <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                    </a>

                                    <a href="{{ route('report.marketing') }}" class="btn btn-sm btn-danger "
                                        data-bs-toggle="tooltip" title="{{ __('Reset') }}"
                                        data-original-title="{{ __('Reset') }}">
                                        <span class="btn-inner--icon"><i
                                                class="ti ti-trash-off text-white-off "></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
