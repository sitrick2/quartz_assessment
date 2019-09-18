<?php

namespace Tests\Feature;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_quiz_can_be_created() :void
    {
        $this->post('/quiz', $this->data());

        $quizzes = Quiz::all();

        $this->assertCount(1, $quizzes);
    }

    /** @test */
    public function a_quiz_can_be_updated() :void
    {
        $quiz = $this->initializeTestQuiz();

        $this->patch($quiz->path(), array_merge($this->data(), ['title' => 'New Title']));
        $quiz = $quiz->fresh();

        $this->assertCount(1, Quiz::all());
        $this->assertEquals('New Title', $quiz->title);
    }

    /** @test */
    public function a_quiz_requires_a_title_on_create() :void
    {
        $request = $this->post('/quiz', array_merge($this->data(), ['title' => null]));

        $request->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_quiz_requires_a_title_on_update() :void
    {
        $quiz = $this->initializeTestQuiz();

        $request = $this->patch($quiz->path(), array_merge($this->data(), ['title' => null]));

        $request->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_quiz_can_be_deleted() :void
    {
        $this->withoutExceptionHandling();

        $quiz = $this->initializeTestQuiz();

        $request = $this->delete($quiz->path());

        $this->assertCount(0, Quiz::all());
    }

    /** @test */
    public function a_quiz_has_a_default_question_with_default_answers() :void
    {
        $quiz = $this->initializeTestQuiz();

        $this->assertInstanceOf(Collection::class, $quiz->questions);
        $this->assertCount(1, $quiz->questions);
        $this->assertEquals('Default Question', $quiz->questions->first()->question_text);

        $answers = $quiz->questions->first()->answers;

        $this->assertInstanceOf(Collection::class, $answers);
        $this->assertCount(4, $answers);
        $this->assertCount(1, $answers->where('correct', true));
        $this->assertCount(3, $answers->where('correct', false));
    }

    /** @test */
    public function a_question_can_be_updated() :void
    {
        $this->withoutExceptionHandling();
        $quiz = $this->initializeTestQuiz();

        $question = $quiz->questions->first();
        $this->patch($question->path(), [
            'question_text' => 'New Question Text'
        ]);

       $question = $question->fresh();
        $this->assertEquals('New Question Text', $question->question_text);
    }

    /** @test */
    public function a_question_cannot_be_blank() :void
    {
        $quiz = $this->initializeTestQuiz();

        $question = $quiz->questions->first();
        $request = $this->patch($question->path(), ['question_text' => null]);

        $request->assertSessionHasErrors('question_text');
    }

    /**
     * @return array
     */
    private function data(): array
    {
        return [
            'title' => 'Test Quiz'
        ];
    }

    private function initializeTestQuiz() :Quiz
    {
        $this->post('/quiz', $this->data());
        return Quiz::first();
    }
}
