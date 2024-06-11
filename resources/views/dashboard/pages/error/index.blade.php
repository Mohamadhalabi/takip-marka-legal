@extends('layouts.dashboard.app')
@section('page-header', 'HATA')
@section('content')
    <section>
        <div class="card card-table mb-4">
            <div class="card-header">
                <h5 class="card-heading"> KUYRUK SORUNLARI</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th>SIRA</th>
                            <th class="report-date-header">OLUŞTURULMA TARİH</th>
                            <th>GÖRÜNTÜLE</th>
                        </tr>
                        </thead>
                        <tbody class="reports-table">
                        @foreach ($errors as $key=>$error)
                            <tr class="align-middle">
                                <td>#{{$key+1}}</td>
                                <td class="report-release-date">{{Carbon\Carbon::parse($error->created_at) }}</td>
                                <td><td>{{ $error->message }}</td></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
