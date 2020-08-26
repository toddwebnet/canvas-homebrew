@extends('layouts.template')
@section('body')
    <div class="row">
        @foreach($students as $student)
            <div class="col-6">
                <a href="/assignments/{{ $student->id }}"
                   class="float-right"
                >assignments</a>
                <h2>{{ $student->name }}</h2>

                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Class</th>
                        <th>Code</th>
                        <th>&nbsp;</th>
                    </tr>
                    @foreach($student->courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->code }}</td>
                            <td>
                                <a href="/assignments/{{ $course->course_id }}/{{ $student->id }}">assignments</a>
                            </td>
                        </tr>
                    @endforeach

                </table>
                <?php
                ?>
            </div>
        @endforeach
    </div>
@endsection
