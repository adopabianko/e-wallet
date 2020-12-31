@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Form Withdraw') }}</div>

                <div class="card-body">
                    @foreach (['danger', 'success'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <div class="alert alert-{{ $msg }} alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ Session::get('alert-' . $msg) }}
                            </div>
                        @endif
                    @endforeach
                    <form method="POST" action="{{ route('transaction.withdraw-store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="bank-name" class="col-md-4 col-form-label text-md-right">{{ __('Bank Name') }} <label class="text-danger">*</label></label>

                            <div class="col-md-6">
                                <select id="name" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" required autocomplete="bank-name">
                                    <option disabled selected>Choose</option>
                                    <option value="bni">BNI</option>
                                    <option value="bca">BCA</option>
                                    <option value="bri">BRI</option>
                                    <option value="mandiri">Mandiri</option>
                                    <option value="bni">BNI</option>
                                    <option value="btn">BTN</option>
                                    <option value="mega">Mega</option>
                                </select>

                                @error('bank_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="account-number" class="col-md-4 col-form-label text-md-right">{{ __('Account Number') }} <label class="text-danger">*</label></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('account_number') is-invalid @enderror" name="account_number" required autocomplete="account-number">

                                @error('account_number')
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