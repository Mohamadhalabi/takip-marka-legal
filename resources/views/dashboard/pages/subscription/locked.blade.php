@extends('layouts.dashboard.app')
@section('page-header', 'Kilitli Sayfa')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 d-flex align-items-center justify-content-center">
                <img src="{{ asset('assets/dashboard') }}/img/image22.png" alt="logo"
                     style="max-width: 250px">
            </div>
            <div class="col-md-12 d-flex align-items-center justify-content-center" style="margin-top: 35px">
                <div class="text-center">
                    <h1>Sadece Aboneli Kullanıcılara Özel</h1>
                    <p>Bu sayfa yalnızca aboneli kullanıcılara özeldir. Abone olmak isterseniz, aşağıdaki düğmeye tıklayın:</p>
                    <a href="{{ route('subscription.list') }}" class="btn btn-primary">Şimdi Abone Ol</a>
                </div>
            </div>
        </div>
    </div>

@endsection
