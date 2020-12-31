@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Report Mutasi') }}</div>

                <div class="card-body">
                    @foreach (['danger', 'success'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <div class="alert alert-{{ $msg }} alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ Session::get('alert-' . $msg) }}
                            </div>
                        @endif
                    @endforeach
                    <form method="POST" action="{{ route('report.mutasi-download') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="start-date" class="col-md-4 col-form-label text-md-right">{{ __('Start date') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="start_date" class="datepicker" id="start-date" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end-date" class="col-md-4 col-form-label text-md-right">{{ __('End date') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="end_date" class="datepicker" id="end-date" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button class="btn btn-primary" id="btn-download">
                                    {{ __('Download') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
    });
</script>
@endsection