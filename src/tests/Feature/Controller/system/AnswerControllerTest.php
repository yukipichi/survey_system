<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Answer;
use App\Services\AnswerService;

class AnswerControllerTest extends TestCase
{
    /**
     * A basic test example.
     */

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testSuccessIndex(): void
    {
        $response = $this->get('/system/answers');

        $response->assertStatus(200);

        $response->assertViewIs('system.answer.index');
    }

    public function testSuccessFetchList(): void
    {
        $mockResponse = [
            'data' => [
                [
                    'id' => 1,
                    'fullname' => '山田太郎',
                    'gender' => 1,
                    'age_id' => 2,
                    'email' => 'taro@example.com',
                    'feedback' => 'フィードバックテスト',
                    'is_send_email' => 1,
                ]
            ],
            'current_page' => 1,
            'last_page' => 1,
            'per_page' => 10,
            'total' => 1
        ];

        $this->mock(AnswerService::class, function ($mock) use ($mockResponse) {
            $mock->shouldReceive('getPaginatedAnswers')
                ->once()
                ->andReturn($mockResponse);
        });

        $response = $this->postJson(route('system.answer.fetchList'), []);

        $response->assertStatus(200);

        $response->assertJson($mockResponse);
    }

    // fetchListの検索の処理
    public function testSuccessFetchListSearch(): void
    {
        $search = [
            'fullname' => '山田太郎',
            'email' => 'taro@example.com',
            'gender' => 1,
            'age_id'  => 2,
            'is_send_email' => 1,
            'limit' => 10,
            'offset' => 0,
            'sort' => 'id',
            'order' => 'asc',
        ];

        $mockResponse = [
            'data' => [
                [
                    'id' => 1,
                    'fullname' => '山田太郎',
                    'gender' => 1,
                    'age_id' => 2,
                    'email' => 'taro@example.com',
                    'feedback' => 'フィードバックテスト',
                    'is_send_email' => 1,
                    'gender_label' => '男性',
                    'age_label' => '20代',
                    'isSendEmail_label' => '送信する',
                    'feedback_limit' => 'フィードバックテスト',
                ]
            ],
            'current_page' => 1,
            'last_page' => 1,
            'per_page' => 10,
            'total' => 1
        ];

        $this->mock(AnswerService::class, function ($mock) use ($mockResponse) {
            $mock->shouldReceive('getPaginatedAnswers')
                ->once()
                ->andReturn($mockResponse);
        });

        $response = $this->postJson(route('system.answer.fetchList'), $search);

        $response->assertStatus(200);
        $response->assertJson($mockResponse);
    }

    public function testSuccessDetails(): void
    {
        $answerId = 1;

        $answer = Answer::factory()->make([
            'id' => 1,
            'fullname' => 'テスト太郎',
            'gender' => 1,
            'age_id' => 2,
            'email' => 'test@example.com',
            'feedback' => 'テスト内容',
            'is_send_email' => 1,
        ]);

        $this->mock(AnswerService::class, function ($mock) use ($answer) {
            $mock->shouldReceive('getAnswerDetails')
                ->once()
                ->with($answer->id)
                ->andReturn([
                    'answer' => $answer,
                    'genderLabel' => Answer::getGenderLabel($answer->gender),
                    'ageLabel' => Answer::getAgeLabel($answer->age_id),
                    'isSendEmailLabel' => Answer::getIsSendEmailLabel($answer->is_send_email),
                ]);
        });

        $response = $this->get(route('system.answer.details', ['id' => $answerId]));

        $response->assertStatus(200);
        $response->assertViewIs('system.answer.details');
        $response->assertViewHas('answer');
    }

    public function testSuccessDestroy(): void
    {
        $answer = Answer::factory()->create();

        $this->mock(AnswerService::class, function ($mock) use ($answer) {
            $mock->shouldReceive('deleteAnswer')
                ->once()
                ->with($answer->id)
                ->andReturnTrue();
        });

        $response = $this->post("/system/answers/destroy/{$answer->id}");

        $response->assertRedirect(route('system.answer.index'));
        $response->assertSessionHas('success', '削除しました');
    }

    public function testSuccessDeleteSelected(): void
    {
        $answers = Answer::factory()->count(3)->create();

        $ids = $answers->pluck('id')->toArray();

        $this->mock(AnswerService::class, function ($mock) use ($ids) {
            $mock->shouldReceive('deleteAnswerByIds')
                ->once()
                ->with($ids)
                ->andReturn(['deleted' => count($ids)]);
        });

        $response = $this->postJson('/system/answers/deleteSelected', ['ids' => $ids]);

        $response->assertOk();
        $response->assertJson([
            'deleted' => count($ids),
        ]);
    }
}
