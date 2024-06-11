@extends('layouts.dashboard.app')
@section('page-header', 'KULLANICI DETAYLARI')
@section('content')
    <section>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>
            @endforeach
        @endif
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif
        @if (\Session::has('info'))
            <div class="alert alert-info">
                <ul>
                    <li>{!! \Session::get('info') !!}</li>
                </ul>
            </div>
        @endif
        @if (\Session::has('error'))
            <div class="alert alert-error">
                <ul>
                    <li>{!! \Session::get('error') !!}</li>
                </ul>
            </div>
        @endif
        <div class="card card-table">
            <div class="card-header">
              <h5 class="card-heading"> Raporlar</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover mb-0">
                  <thead>
                    <tr>
                      <th>SIRA</th>
                      <th>RAPOR TARİHİ</th>
                      <th>GÖRÜNTÜLE</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($user->reports as $key=>$report)
                    <tr class="align-middle">
                        <td>#{{$key+1}}</td>
                        <td>{{ $report->created_at->format('d-m-Y') }}</strong></td>
                        <td><a href="{{ route('report.show', ['language' => app()->getLocale(), 'report' => $report]) }}">RAPORU GÖRÜNTÜLE</a></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
    </section>
    <section class="mt-3">
        <div class="card card-table">
            <div class="card-header">
                <h5 class="card-heading"> ANAHTAR KELİMELER</h5>
                <br>
                <form action="{{ route('keywords.import', ['language' => app()->getLocale(), 'id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control" required>
                    <br>
                    <button class="btn btn-primary">Anahtar kelimeleri içe aktar</button>
                </form>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover mb-0">
                  <thead>
                    <tr>
                      <th>SIRA</th>
                      <th>ANAHTAR KELİME</th>
                      <th>Exclusion Keyword</th>
                      <th>Classes</th>
                      <th>EKLENME TARİHİ</th>
                      <th>SİL</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($user->keywords as $key=>$keyword)
                    @php
                    @endphp
                    <tr class="align-middle">
                        <td>#{{$key+1}}</td>
                        <td>{{ $keyword->keyword }}</td>
                        <td>{!! $keyword->exclusion_keywords !!}</td>
                        <td>
                        @php
                                            $classes = $keyword->classes ?? [];
                                            sort($classes);
                                            $classes = implode(',', $classes);
                                        @endphp
                                        {{ $classes }}
                        </td>
                        <td>{{ $keyword->created_at->format('d-m-Y') }}</td>
                        <td>
                            <form action="{{ route('keyword-admin.destroy', ['language' => app()->getLocale(), 'keyword' => $keyword]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm" type="submit">ANAHTAR KELİMEYİ SİL</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
    </section>

    <section class="mt-3">
      <div class="card card-table mb-4">
          <div class="card-header">
            <h5 class="card-heading"> KULLANICI AKTİVİTELERİ</h5>
                <div class="card-header-more">
                  <button class="btn-header-more" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                  <div class="dropdown-menu dropdown-menu-end text-sm"><a class="dropdown-item" href="#!"><i class="fas fa-expand-arrows-alt opacity-5 me-2"></i>Expand</a><a class="dropdown-item" href="#!"><i class="far fa-window-minimize opacity-5 me-2"></i>Minimize</a><a class="dropdown-item" href="#!"><i class="fas fa-redo opacity-5 me-2"></i> Reload</a><a class="dropdown-item" href="#!"><i class="far fa-trash-alt opacity-5 me-2"></i> Remove        </a></div>
                </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>AKTİVİTE</th>
                    <th></th>
                    <th>TARİH</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($user->userActivities->reverse() as $key=>$activity)
                  <tr class="align-middle">
                    <td>
                      <strong>
                      {{ $activity->event }}
                      </strong>
                      <td>
                        @if($activity->data != null && $activity->old_data != null)
                        {{ $activity->data }} <strong>-></strong> {{ $activity->old_data }}
                        @else
                        {{ $activity->data }} <strong>
                        @endif
                      </td>
                    </td>
                    <td>{{ $activity->created_at }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
  </section>
@endsection
