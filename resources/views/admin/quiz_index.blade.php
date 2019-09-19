@extends('adminlte::page')

@section('title', 'Quizzes')

@section('content_header')
    <h1 class="col-md-6">Quizzes</h1>
    <div class="col-md-6">
        {!! Form::open(['method' => 'GET', 'route' => 'quiz.create', 'class' => 'form-horizontal']) !!}
        <div class="btn-group pull-right">
            {!! Form::submit('Add New Quiz', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-striped table-bordered admin-table">
                            <thead>
                            <tr><th>Quiz Title</th><th></th></tr>
                            </thead>
                            @include('includes.errors')
                            <tbody>
                            @foreach($quizzes as $quiz)
                                <tr>
                                    <td>{{ $quiz->title }}</td>
                                    <td class="action-btns">
                                        <div>
                                            {!! Form::open(['method' => 'GET', 'route' => ['quiz.edit', $quiz->id], 'class' => 'index-btn form-horizontal pull-left']) !!}
                                            {!! Form::submit('Edit', ['class'=>'btn btn-xs btn-primary']) !!}
                                            {!! Form::close() !!}
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['quiz.destroy', $quiz->id], 'class' => 'index-btn form-horizontal pull-left delete-category']) !!}
                                            {!! Form::submit('Delete', ['class'=>'btn btn-xs btn-default']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
