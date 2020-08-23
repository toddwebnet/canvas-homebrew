@extends('layouts.template')
@section('body')
    <div class="row">
        @foreach($students as $student)
            <div class="col-6">
                <h2>{{ $student->name }}</h2>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Class</th>
                    </tr>
                    @foreach($student->courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                        </tr>
                    @endforeach

                </table>
                <?php
                ?>
            </div>
        @endforeach
    </div>
@endsection
