@extends('layouts.dashboard.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">İLETİŞİM FORMU</h1>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">İSİM</th>
                            <th scope="col">EMAİL</th>
                            <th scope="col">TARİH</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($messages as $message)
                          <tr>
                              <td><a href="{{ route('contact.show', ['language' => app()->getLocale(), 'contact' => $message]) }}">{{ $message->name }}</a></td>
                              <td>{{ $message->email }}</td>
                              <td>{{ $message->created_at->format('d-m-Y H:i:s') }}</td>
                          </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
