@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Role') }}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Role') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="lg" data-url="{{ route('roles.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip"
            title="{{ __('Create New Role') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Role') }} </th>
                                    <th>{{ __('Permissions') }} </th>
                                    <th width="150">{{ __('Action') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    @if ($role->name != 'client')
                                        <tr class="font-style">
                                            <td class="Role align-top">{{ $role->name }}</td>
                                            <td class="Permission align-top">
                                                @php
                                                    $modules = ['user', 'role', 'client', 'product & service', 'constant unit', 'constant tax', 'constant category', 'company settings', 'lead', 'pipeline', 'lead stage', 'source', 'label', 'deal', 'stage', 'task', 'form builder', 'form response', 'contract', 'contract type', 'project dashboard', 'project', 'milestone', 'grant chart', 'project stage', 'timesheet', 'expense', 'project task', 'activity', 'CRM activity', 'project task stage', 'bug report', 'bug status', 'hrm dashboard', 'employee', 'employee profile', 'department', 'designation', 'branch', 'document type', 'document', 'payslip type', 'allowance', 'commission', 'allowance option', 'loan option', 'deduction option', 'loan', 'saturation deduction', 'other payment', 'overtime', 'set salary', 'pay slip', 'company policy', 'appraisal', 'goal tracking', 'goal type', 'indicator', 'event', 'meeting', 'training', 'trainer', 'training type', 'award', 'award type', 'resignation', 'travel', 'promotion', 'complaint', 'warning', 'termination', 'termination type', 'job application', 'job application note', 'job onBoard', 'job category', 'job', 'job stage', 'custom question', 'interview schedule', 'estimation', 'holiday', 'transfer', 'announcement', 'leave', 'leave type', 'attendance', 'account dashboard', 'proposal', 'invoice', 'bill', 'revenue', 'payment', 'proposal product', 'invoice product', 'bill product', 'goal', 'credit note', 'debit note', 'bank account', 'bank transfer', 'transaction', 'customer', 'vender', 'constant custom field', 'assets', 'chart of account', 'journal entry', 'report', 'warehouse', 'purchase', 'pos', 'barcode', 'purchase request', 'purchase order', 'sales order', 'goods receipt', 'production', 'payment term', 'purchase approval'];
                                                @endphp

                                                @foreach ($modules as $module)
                                                    @php
                                                    $modulePermissions = $role->permissions()->pluck('name')->filter(function ($item, $key) use ($module) {
                                                            return strpos($item, $module);
                                                        })->all();
                                                    @endphp

                                                    @if (count($modulePermissions) > 0)
                                                        {{ $module }}
                                                        <br />
                                                        @foreach  ($modulePermissions as $permission)
                                                        <span
                                                            class="badge rounded-pill bg-primary">{{ $permission }}</span>
                                                        <br />
                                                        @endforeach
                                                        <br />
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="Action align-top">
                                                <span>
                                                    @can('edit role')
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="#"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-url="{{ route('roles.edit', $role->id) }}"
                                                                data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                                                                title="{{ __('Edit') }}"
                                                                data-title="{{ __('Role Edit') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    @can('delete role')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'route' => ['roles.destroy', $role->id],
                                                                'id' => 'delete-form-' . $role->id,
                                                            ]) !!}
                                                            <a href="#"
                                                                class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                                data-bs-toggle="tooltip" title="{{ __('Delete') }}"><i
                                                                    class="ti ti-trash text-white"></i></a>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    @endcan
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
