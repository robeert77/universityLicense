@extends('layouts.app')

@section('content')
    <div class="row my-5">
        <div class="col-12 col-xl-6">
            <div class="row">
                <div class="col-sm-6 mb-4">
                    <x-dashboard.total-interventions />
                </div>

                <div class="col-sm-6 mb-4">
                    <x-dashboard.total-duration-interventions-per-month />
                </div>
            </div>

            <div class="col-xl-12 mb-4 mb-xxl-0">
                <x-dashboard.new-companies-this-year />
            </div>
        </div>

        <div class="col-12 col-xl-6 mb-4 mb-xxl-0">
            <div class="row">
                <div class="col-sm-4 mb-4">
                    <x-dashboard.nr-upcoming-tasks />
                </div>

                <div class="col-sm-4 mb-4">
                    <x-dashboard.nr-completed-tasks />
                </div>

                <div class="col-sm-4 mb-4">
                    <x-dashboard.nr-missed-tasks />
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 mb-4">
                    <x-dashboard.my-upcoming-tasks />
                </div>

                <div class="col-xl-12 mb-4">
                    <x-dashboard.companies-with-most-interventions />
                </div>
            </div>
        </div>
    </div>
@endsection
