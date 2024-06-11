@extends('layouts.dashboard.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h5>Toplam Resmi Marka Bülteni : {{ $bulletins->count() }}</h5>
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th scope="col">Bülten NO</th>
                    <th scope="col">Tür</th>
                    <th scope="col">Yayın Tarihi</th>
                    <th scope="col">Kayıt</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($bulletins as $bulletin)
                  <tr>
                    <td>{{ $bulletin->id }}</td>
                    <td>{{ $bulletin->bulletin_no }}</td>
                    <td>{{ $bulletin->is_official ? 'Resmi Marka Bülteni' : '' }}</td>
                    <td>{{ $bulletin->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $bulletin->is_saved ? 'Veritabanına Kaydedildi' : 'Henüz Kaydedilmedi' }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
</div>
@endsection
