@extends('adminlte::page')

@section('title', \Route::getCurrentRoute()->getName() === 'quiz.create' ? 'Add New Quiz' : 'Edit Quiz')

@section('content_header')
    <h1 class="col-md-6">Edit Quiz</h1>
    {!! session()->flash('previous-route', Route::current()->getName()); !!}
@stop

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body typerocket-container">
                    <div class="bod-body">
                        @if (\Route::getCurrentRoute()->getName() === 'quiz.create')
                            {!! Form::model($quiz, ['route' => ['quiz.store'], 'files' => false, 'method' => 'POST', 'id' => 'quiz-form']) !!}
                        @else
                            {!! Form::model($quiz, ['route' => ['quiz.update', $quiz], 'files' => false, 'method' => 'PATCH', 'id' => 'quiz-form']) !!}
                        @endif
                        <div class="form-group{{ $errors->has('title') ? 'has-error' : '' }}">
                            {!! Form::label('title', 'Quiz Name') !!}
                            {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('name') }}</small>
                        </div>
                        @foreach($quiz->questions as $question)
                            <div class="question-container col-xs-offset-1 col-xs-10" style="background-color: #ecf0f5; padding: 20px 50px;">
                                <div class="form-group{{ $errors->has('question['.$question->id.'][question_text]') ? 'has-error' : '' }} question">
                                    <div class="question-top-container">
                                        {!! Form::label('question['.$question->id.'][question_text]', 'Question Text', ['class' => 'col-6 pull-left', 'style' => 'font-size: 15pt']) !!}
                                        <button class="question-delete btn btn-danger btn-sm pull-right" style="margin-bottom: 10px">Delete</button>
                                    </div>
                                    {!! Form::text('question['.$question->id.'][question_text]', $question->question_text, ['class' => 'form-control', 'required' => 'required']) !!}
                                    <small class="text-danger">{{ $errors->first('question['.$question->id.'][question_text]') }}</small>
                                </div>
                                @foreach($question->answers as $answer)
                                    <div class="answer-container col-xs-offset-1 col-xs-10" style="background-color: white">
                                        <div class="form-group{{ $errors->has('question['.$question->id.'][answers]['.$answer->id.'][answer_text]') ? 'has-error' : '' }} answer">
                                            <div class="label-container col-12">
                                                {!! Form::label('question['.$question->id.'][answers]['.$answer->id.'][answer_text]', 'Answer Text', ['class' => 'col-8']) !!}
                                                {!! Form::label('question['.$question->id.'][answers]['.$answer->id.'][correct]', 'Correct Answer?', ['class' => 'col-1 pull-right']) !!}

                                            </div>
                                            <div class="input-container pull-left" style="width: 50%; margin-bottom: 20px">
                                                {!! Form::text('question['.$question->id.'][answers]['.$answer->id.'][answer_text]', $answer->text, ['class' => 'form-control', 'required' => 'required']) !!}
                                            </div>
                                            <div class="input-container pull-right col-1" style="width: 40%">
                                                {!! Form::checkbox('question['.$question->id.'][answers]['.$answer->id.'][correct]', null, $answer->correct, ['class' => 'correct-check col-1 pull-right']) !!}
                                            </div>
                                            <small class="text-danger">{{ $errors->first('question['.$question->id.'][answers]['.$answer->id.'][answer_text]') }}</small>
                                            <small class="text-danger">{{ $errors->first('question['.$question->id.'][answers]['.$answer->id.'][correct]') }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                            <div class="button-holders col-xs-12" style="margin-top: 20px">
                                @if (\Route::getCurrentRoute()->getName() === 'quiz.create')
                                    {!! Form::submit('Create Quiz', ['class'=>'btn btn-primary btn-action pull-right']) !!}
                                @else
                                    {!! Form::submit('Update Quiz', ['class'=>'btn btn-primary btn-action pull-right']) !!}
                                @endif
                                <a href="/admin/quizzes" class="btn btn-default btn-action pull-right cancelbutton" style="margin-right: 10px">Cancel</a>
                                {!! Form::close() !!}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('footer')
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script type="text/javascript">
        $('.question-delete').click(function(event) {
            event.preventDefault();
            let questions = $('.content').find('.question-container').length;

            if (questions === 1) {
                alert('A quiz must have at least one question');
            } else {
                $(this).closest('.question-container').remove();
            }
        });

        $('.btn-primary').click(function(event) {
            let questions = $('.content').find('.question-container');
            questions.each(function(question) {
                let selectedCorrect = $(this).find('.correct-check:checked').length;
                if (selectedCorrect === 0){
                    alert('One or more questions does not have a correct answer selected.');
                    event.preventDefault();
                    return false;
                }
            });
        })
    </script>
@stop
