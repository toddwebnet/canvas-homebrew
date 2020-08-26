@extends('layouts.template')
@section('body')
    <h1>Assignments for:
        <br>
        Student: {{ $student->name }}
        @if ($viewType == "Course")
            <br> Course: {{ $course->name }} ({{ $course->code }})
        @endif
    </h1>
    <div class="row">
        @foreach($weeks as $label=> $dates)
            <div class="col-4">
                <h3>{{ $label }} Week</h3>
                <table class="table table-bordered">
                    @foreach($dates as $date)
                        <tr>
                            <td>{{date("l", strtotime($date))}}</td>
                            <td>
                                @if(array_key_exists($label, $assignmentList) && array_key_exists($date, $assignmentList[$label]))
                                    @foreach($assignmentList[$label][$date] as $assignment)
                                        {{ $assignment->name }}<BR>
                                    @endforeach

                                @endif

                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endforeach
    </div>
@endsection
