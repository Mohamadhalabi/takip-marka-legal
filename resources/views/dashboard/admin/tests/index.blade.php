@extends('layouts.dashboard.app')
@section('page-header', 'Test Cases')
@section('content')
    <section id="loadTable">
        <div class="card card-table mb-4">
            <div class="card-header">
                <h5 class="card-heading"> Test Cases ({{ $success . '/' . count($csv) }})</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="text-align: center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Keyword</th>
                                <th>String</th>
                                <th>Type</th>
                                <th>Match</th>
                                <th>Must</th>
                                <th>Note 1</th>
                                <th>Note 2</th>
                                <th>Status</th>
                                <th>Score</th>
                                <th>Reverse Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($csv as $key => $case)
                                <tr class="align-middle {{ $case['result'] ? '' : 'bg-danger' }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $case['keyword'] }}</td>
                                    <td>{{ $case['string'] }}</td>
                                    <td>{{ $case['type'] }}</td>
                                    <td>{{ $case['match'] }}</td>
                                    <td>{{ $case['must'] }}</td>
                                    <td>{{ $case['note'] }}</td>
                                    <td>{{ $case['note 2'] }}</td>
                                    <td>{{ $case['result'] }}</td>
                                    <td>{{ $case['score'] }}</td>
                                    <td>{{ $case['reverse_score'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
