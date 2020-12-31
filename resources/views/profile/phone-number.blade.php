@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

                <div class="card-body">
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        Silahkan lengkapi profil anda dengan memasukkan nomor telepon untuk mengakses aplikasi ini
                    </div>

                    @foreach (['danger', 'success'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <div class="alert alert-{{ $msg }} alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ Session::get('alert-' . $msg) }}
                            </div>
                        @endif
                    @endforeach
                    <form method="POST" action="{{ route('profile.update-phone-number', ['id' => Auth::user()->id]) }}">
                        @method('PUT')
                        @csrf

                        <div class="form-group row">
                            <label for="phone-number" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }} <label class="text-danger">*</label></label>

                            <div class="col-md-6">
                                <input id="phone-number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" required autocomplete="phone-number">

                                @error('phone_number')
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