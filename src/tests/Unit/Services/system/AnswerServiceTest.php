<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\Answer;
use Illuminate\Http\Request;
use App\Services\AnswerService;
use App\Repositories\AnswerRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class AnswerServiceTest extends TestCase
{
    protected $answerRepository;
    protected $answerService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->answerRepository = Mockery::mock(AnswerRepository::class);
        $this->answerService = new AnswerService($this->answerRepository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * ページネートされたアンケート一覧の表示のテスト
     * AnswerServiceのgetPaginatedAnswersメソッドが1ページにつき10件ずつ
     * 正しくAnswerデータを取得して返す事を確認するテスト
     * Answerデータが正しく指定したラベルに変換されるかどうかの確認
     *
     * @return void
     */
    public function testSuccessGetPaginatedAnswers(): void
    {
        $request = new Request([
            'limit' => 10,
            'offset' => 0,
            'sort' => 'id',
            'order' => 'asc',
        ]);

        $answer = new Answer([
            'gender' => 1,
            'age_id' => 2,
            'is_send_email' => 1,
            'feedback' => 'これはフィードバックです。'
        ]);

        // ページネーション形式のダミーデータを作成
        $paginator = new LengthAwarePaginator(
            [$answer], // items
            1, // total件数
            10, // 1ページの件数
            1, // 現在のページ
        );

        $this->answerRepository
            ->shouldReceive('paginateWithFilters')
            ->with($request->all(), 10, 1)
            ->once()
            ->andReturn($paginator);

        $result = $this->answerService->getPaginatedAnswers($request);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertCount(1, $result);

        $answer = $result->first();
        $this->assertEquals('男性', $answer->gender_label);
        $this->assertEquals('20代', $answer->age_label);
        $this->assertEquals('送信可能', $answer->isSendEmail_label);
        $this->assertEquals('これはフィードバックです。', $answer->feedback_limit);
    }

    /**
     * アンケートの詳細表示のテスト
     * AnswerServiceのgetAnswerDetailsメソッドにおいて、
     * 選択されたAnswerの詳細を表示できるかどうかのテスト
     * Answerデータが正しくラベルに変換されるかの確認
     *
     * @return void
     */
    public function testSuccessGetAnswerDetails(): void
    {
        $answer = new Answer([
            'gender' => 1,
            'age_id' => 2,
            'is_send_email' => 0,
        ]);

        $this->answerRepository
            ->shouldReceive('find')
            ->with(1)
            ->once()
            ->andreturn($answer);

        $result = $this->answerService->getAnswerDetails(1);

        $this->assertEquals($answer, $result['answer']);
        $this->assertEquals('男性', $result['genderLabel']);
        $this->assertEquals('20代', $result['ageLabel']);
        $this->assertEquals('送信不可', $result['isSendEmailLabel']);
    }

    /**
     * アンケートの削除のテスト
     * AnswerServiceのdeleteAnswerメソッドにおいて
     * 指定されたIDのアンケートを正しく削除することを確認するテスト
     *
     * @return void
     */
    public function testSuccessDeleteAnswer(): void
    {
        $this->answerRepository
            ->shouldReceive('delete')
            ->with(5)
            ->once()
            ->andReturn(true);

        $result = $this->answerService->deleteAnswer(5);

        $this->assertTrue($result);
    }

    /**
     * アンケートの複数件削除のテスト
     * AnswerServiceのdeleteAnswerByIdsメソッドにおいて
     * 指定された複数のIDのアンケートを正しく削除することを確認するテスト
     *
     * 成功なら成功メッセージを返すかどうか確認する
     *
     * @return void
     */
    public function testSuccessDeleteAnswerByIds(): void
    {
        $ids = [1, 2, 3];

        $this->answerRepository
            ->shouldReceive('deleteMultiple')
            ->with($ids)
            ->once()
            ->andReturn(true);

        $result = $this->answerService->deleteAnswerByIds($ids);

        $this->assertTrue($result['success']);
    }

    /**
     * アンケートの複数件削除が空の配列だった場合のテスト
     * AnswerServiceのdeleteAnswerByIdsメソッドにおいて
     * 空のID配列を渡した場合にエラーメッセージを出すことを確認するテスト
     *
     * @return void
     */
    public function testSuccessDeleteAnswerByIdsIsEmpty(): void
    {
        $result = $this->answerService->deleteAnswerByIds([]);

        $this->assertFalse($result['success']);
        $this->assertEquals('IDが不正です。', $result['message']);
    }
}
