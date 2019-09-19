<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Quartz Assessment Quiz</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- jQuery import -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                margin-top: 100px;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .question {
                color: #636b6f;
                padding: 0 25px;
                font-size: 35px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .card {
                color: #636b6f;
                font-size: 20px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                border: 1px solid #636b6f;
                border-radius: 5px;
                margin-top: 50px;
                margin-bottom: 20px;
                padding: 20px;
            }

            .card:hover {
                background-color: #636b6f;
                color: white;
            }

            .hidden {
                visibility: hidden;
            }

            .card:active {
                background-color: gray;
            }

            .left {
                float: left;
                width: 40%;
            }

            .right {
                float: right;
                width: 40%;
            }

            .start-quiz {
                margin-top: 100px;
            }

            .results-text {
                color: #636b6f;
                font-size: 20px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                margin-bottom: 20px;
                padding: 20px;
                display: inherit;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Quartz Assessment Quiz
                </div>

                <div class="question">
                    Test Question
                </div>

                <div class="start-quiz">
                    <div class="card">
                        <span>Start Quiz</span>
                    </div>
                </div>

                <div class="answers hidden">
                    <div class="card answer-card left">
                        <span class="answer-text">First Answer</span>
                    </div>
                    <div class="card answer-card right">
                        <span class="answer-text">Second Answer</span>
                    </div>
                    <div class="card answer-card left">
                        <span class="answer-text">Third Answer</span>
                    </div>
                    <div class="card answer-card right">
                        <span class="answer-text">Fourth Answer</span>
                    </div>
                </div>
                <div class="results hidden">
                    <span class="results-text"></span>
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    let state = {
        quiz_id: null,
        questions: null,
        currentQuestion: 0,
        totalQuestions: null,
        totalCorrectAnswers: null
    };

    $( ".start-quiz" ).click(function() {
        let data = $.getValues('/quiz?quiz_id=1');
        state.quiz_id = data.id;
        state.questions = data.questions;
        state.currentQuestion = 0;
        state.totalQuestions = data.questions.length;
        state.totalCorrectAnswers = 0;
        populateQuestion(state.questions[0]);
        $(this).hide();
        $(".answers").removeClass('hidden');
    });

    $( ".answer-card" ).click(function() {
        let answerStatus = $(this).find(".answer-text").attr('correct');
        if(answerStatus === '1'){
            state.totalCorrectAnswers = state.totalCorrectAnswers + 1;
        }
        state.currentQuestion = state.currentQuestion + 1;

        if (state.questions[state.currentQuestion] === undefined){
            finishQuiz()
        } else {
            populateQuestion(state.questions[state.currentQuestion]);
        }
    });

    function populateQuestion(question)
    {
        let questionDiv = $( ".question" );
        questionDiv.text(question.question_text);

        $( '.answer-text').each(function(element) {
            $(this).attr('correct', question.answers[element].correct);
            $(this).text(question.answers[element].text);
        })
    }

    function finishQuiz()
    {
        $(".answers").addClass('hidden');
        let questionDiv = $(".question");
        questionDiv.text("Results");
        $( '.results-text').text("You correctly answered " + state.totalCorrectAnswers + " out of " + state.totalQuestions + " total questions.");
        $(".results").removeClass('hidden');
    }

    jQuery.extend({
        getValues: function(url) {
            var result = null;
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {
                    result = data;
                }
            });
            return result;
        }
    });
</script>
