@extends('layouts.test')
@section('content')
<h1 class="test-results-header">
    Test Report
</h1>

<table class="test-result-table" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            <td class="test-result-table-header-cell">
                Test Case
            </td>
            <td class="test-result-table-header-cell">
                Description
            </td>
        </tr>
    </thead>
    <tbody>
        <tr class="test-result-step-row test-result-step-row-altone">
            <td class="test-result-step-command-cell">
                Search function test
            </td>
            <td class="test-result-step-description-cell">
                Try the test cases in the CSV file.
            </td>
        </tr>
        <tr class="test-result-step-row">
            <td>created_at</td>
            <td>{{ $results['summary']['created_at'] }}</td>
        </tr>
        <tr class="test-result-step-row">
            <td>Total case</td>
            <td>{{ $results['summary']['total'] }}</td>
        </tr>
        <tr class="test-result-step-row">
            <td>Stats</td>
            <td>{{ $results['summary']['matched'] }}/{{ $results['summary']['total'] }}</td>
        </tr>
        <tr class="test-result-step-row">
            <td>Matched case</td>
            <td>{{ $results['summary']['matched'] }}</td>
        </tr>
        <tr class="test-result-step-row">
            <td>unmatched case</td>
            <td>{{ $results['summary']['unmatched'] }}</td>
        </tr>
        <tr class="test-result-step-row">
            <td>Result</td>
            @if ($results['summary']['unmatched'] == 0)
                <td class="test-result-step-result-cell-ok">
                    OK
                </td>
            @else
                <td class="test-result-step-result-cell-failure">
                    FAILURE
                </td>
            @endif
        </tr>
        <tr class="test-result-step-row test-result-comment-row">
            <td class="test-result-describe-cell" colspan="6">
                Describe: All test cases are queried from the csv file.
            </td>
        </tr>
    </tbody>

</table>

<h1 class="test-results-header" style="margin-bottom:0">
    Cases
</h1>
<table id="test" class="test-result-table" cellspacing="0">
    <thead>
        <tr>
            <td class="test-result-table-header-cell">
                No
            </td>
            <td class="test-result-table-header-cell">
                Keyword
            </td>
            <td class="test-result-table-header-cell">
                String
            </td>

            <td class="test-result-table-header-cell">
                Bulletin
            </td>
            <td class="test-result-table-header-cell">
                Note
            </td>
            <td class="test-result-table-header-cell">
                Media
            </td>
            <td class="test-result-table-header-cell">
                Type
            </td>
            <td class="test-result-table-header-cell">
                Must
            </td>
            <td class="test-result-table-header-cell">
                Match
            </td>
            <td class="test-result-table-header-cell">
                Success
            </td>
        </tr>
    </thead>
    <tbody>
        @foreach ($results['testLines'] as $result)
            <tr class="test-result-step-row test-result-step-row-alttwo">
                <td class="test-result-step-command-cell">
                    {{ $result['test_no'] }}
                </td>
                <td class="test-result-step-command-cell">
                    {{ $result['keyword'] }}
                </td>
                <td class="test-result-step-description-cell">
                    {{ $result['string'] }}
                </td>
                <td class="test-result-step-description-cell text-center">
                    {{ $result['trademark'] }}
                </td>
                <td class="test-result-step-description-cell">
                    {{ $result['note'] }}
                </td>
                <td class="test-result-step-description-cell text-center">
                    {{ $result['bulletin'] }}
                </td>
                <td class="test-result-step-description-cell text-center">
                    {{ $result['type'] }}
                </td>
                <td class="test-result-step-description-cell text-center">
                    {{ $result['is_must'] }}
                </td>
                <td class="test-result-step-description-cell text-center">
                    {{ $result['is_match'] }}
                </td>
                @if ($result['matched'])
                    <td class="test-result-step-result-cell-ok text-center">
                        OK
                    </td>
                @else
                    <td class="test-result-step-result-cell-failure text-center">
                        FAILURE
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
