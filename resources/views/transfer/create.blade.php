@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Form Transfer') }}</div>

                <div class="card-body">
                    @foreach (['danger', 'success'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <div class="alert alert-{{ $msg }} alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ Session::get('alert-' . $msg) }}
                            </div>
                        @endif
                    @endforeach
                    <form method="POST" action="{{ route('transaction.transfer-store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="phone-number" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }} <label class="text-danger">*</label></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" required autocomplete="phone-number">

                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }} <label class="text-danger">*</label></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" required autocomplete="amount">

                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="name" class="form-control" name="description" autocomplete="description"></textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
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