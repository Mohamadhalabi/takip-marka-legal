@extends('layouts.dashboard.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">İLETİŞİM FORMU</h1>
            </div>
            <div class="col-md-12">
                <h5>Tarih : {{ $contact->created_at }}</h5>
                <h5>İsim : {{ $contact->name }}</h5>
                <h5>Email : {{ $contact->email }}</h5>
                <p class="p-5">{{ $contact->message }}</p>
            </div>
        </div>
    </div>
@endsection
