<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Answer;
use Illuminate\Support\Carbon;

class AnswerTest extends TestCase
{
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
        Answer::factory()->count(10)->create();

        $response = $this->postJson(route('system.answer.fetchList'), []);

        $response->assertStatus(200);

        $responseData = $response->json('data');

        $this->assertCount(10, $responseData);

        $firstAnswer = Answer::orderBy('id')->first();
        $response->assertJsonFragment([
            'id' => $firstAnswer->id,
            'fullname' => $firstAnswer->fullname,
        ]);
    }

    /**
     * fetchListの名前検索の処理
     */
    public function testSuccessFetchListFullnameSearch(): void
    {
        Answer::factory()->create([
            'fullname'  => '山田太郎',
        ]);

        Answer::factory()->create([
            'fullname' => '佐藤花子',
        ]);

        $response = $this->postJson(route('system.answer.fetchList'), [
            'fullname' => '山田',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json('data');

        $this->assertCount(1, $responseData);

        $response->assertJsonFragment([
            'fullname' => '山田太郎',
        ]);

        $this->assertFalse(
            collect($responseData)->contains(fn($item) => $item['fullname'] === '佐藤花子')
        );
    }

    /**
     * fetchListの性別検索の処理
     */
    public function testSuccessFetchListGenderSeach(): void
    {
        Answer::factory()->create([
            'gender' => 1,
        ]);

        Answer::factory()->create([
            'gender' => 2,
        ]);

        $response = $this->postJson(route('system.answer.fetchList'), [
            'gender' => 1,
        ]);

        $response->assertStatus(200);

        $responseData = $response->json('data');

        $this->assertCount(1, $responseData);

        $response->assertJsonFragment([
            'gender' => 1,
            'gender_label' => '男性',
        ]);

        $this->assertFalse(
            collect($responseData)->contains(fn($item) => $item['gender'] === 2)
        );
    }

    /**
     * fetchListの年代検索の処理
     */
    public function testSuccessFetchListAgeIdSearch(): void
    {
        Answer::factory()->create([
            'age_id' => 3
        ]);

        Answer::factory()->create([
            'age_id' => 4
        ]);

        $response = $this->postJson(route('system.answer.fetchList'), [
            'age_id' => 3,
        ]);

        $response->assertStatus(200);

        $responseData = $response->json('data');

        $this->assertCount(1, $responseData);

        $response->assertJsonFragment([
            'age_id' => 3,
            'age_label' => '30代',
        ]);

        $this->assertFalse(
            collect($responseData)->contains(fn($item) => $item['age_id'] === 4)
        );
    }

    /**
     * fetchListのメール送信可否検索の処理
     */
    public function testSuccessFetchListIsSendEmailSearch(): void
    {
        Answer::factory()->create([
            'is_send_email' => 1
        ]);

        Answer::factory()->create([
            'is_send_email' => 0
        ]);

        $response = $this->postJson(route('system.answer.fetchList'), [
            'is_send_email' => 1,
        ]);

        $response->assertStatus(200);

        $responseData = $response->json('data');

        $this->assertCount(1, $responseData);

        $response->assertJsonFragment([
            'is_send_email' => 1,
            'isSendEmail_label' => '送信可能',
        ]);

        $this->assertFalse(
            collect($responseData)->contains(fn($item) => $item['is_send_email'] === 0)
        );
    }

    /**
     * fetchListの登録日検索のテスト
     */
    public function testSuccessFetchListCreatedDaySearch()
    {
        Answer::factory()->create([
            'created_at' => Carbon::parse('2025-03-01'),
        ]);

        Answer::factory()->create([
            'created_at' => Carbon::parse('2025-05-01'),
        ]);

        $response = $this->postJson(route('system.answer.fetchList'), [
            'created_from' => '2025-03-01',
            'created_to' => '2025-03-20',
        ]);

        $response->assertStatus(200);
        $responseData = $response->json('data');

        $this->assertCount(1, $responseData);
        $response->assertJsonFragment([
            'created_at' => Carbon::parse('2025-03-01'),
        ]);
    }

    /**
     * fetchListのキーワード検索のテスト
     */
    public function testSuccessFetchListKeywordSearch()
    {
        Answer::factory()->create([
            'feedback' => 'abcd',
            'email' => 'example.com',
        ]);

        Answer::factory()->create([
            'feedback' => 'xyz',
            'email' => 'example.com',
        ]);

        Answer::factory()->create([
            'feedback' => 'xyz',
            'email' => 'example.com',
        ]);

        Answer::factory()->create([
            'feedback' => 'xyz',
            'email' => 'xxabc.jp',
        ]);

        $response = $this->postJson(route('system.answer.fetchList'), [
            'keyword' => 'abc',
        ]);

        $response->assertStatus(200);
        $responseData = $response->json('data');

        $this->assertCount(2, $responseData);
        // 1つ目のデータの assertチェック
        $this->assertEquals('abcd', $responseData[0]['feedback']);
        $this->assertEquals('example.com', $responseData[0]['email']);
        // 2つ目のデータの assertチェック
        $this->assertEquals('xyz', $responseData[1]['feedback']);
        $this->assertEquals('xxabc.jp', $responseData[1]['email']);
    }

    /**
     * アンケート詳細取得のテスト
     */
    public function testSuccessDetails(): void
    {
        $answer = Answer::factory()->create([
            'fullname' => 'テスト太郎',
            'gender' => 1,
            'age_id' => 2,
            'email' => 'test@example.com',
            'feedback' => 'テスト内容',
            'is_send_email' => 1,
        ]);

        $response = $this->get(route('system.answer.details', ['id' => $answer->id]));

        $response->assertStatus(200);
        $response->assertViewIs('system.answer.details');
        $response->assertViewHas('answer');
    }

    /**
     * アンケート削除のテスト
     */
    public function testSuccessDestroy(): void
    {
        $answer = Answer::factory()->create([
            'fullname' => 'テスト太郎',
            'gender' => 1,
            'age_id' => 2,
            'email' => 'test@example.com',
            'feedback' => 'テスト内容',
            'is_send_email' => 1,
        ]);

        $response = $this->post(route('system.answer.destroy', ['id' => $answer->id]));
        $response->assertRedirect(route('system.answer.index'));
        $response->assertSessionHas('success', '削除しました');
    }

    /**
     * アンケート選択削除のテスト
     */
    public function testSuccessDeleteSelected(): void
    {
        $answers = Answer::factory()->count(10)->create();

        $ids = $answers->random(3)->pluck('id')->toArray();

        $response = $this->postJson(route('system.answer.deleteSelected'), [
            'ids' => $ids
        ]);

        $response->assertStatus(200);
        $this->assertSoftDeleted('answers', ['id' => $ids[0]]);
        $this->assertSoftDeleted('answers', ['id' => $ids[1]]);
        $this->assertSoftDeleted('answers', ['id' => $ids[2]]);
    }
}
