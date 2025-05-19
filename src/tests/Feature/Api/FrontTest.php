<?php

namespace Tests\Feature\Api;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testSuccessIndex(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertViewIs('front.index');
    }

    public function testSuccessBackToIndex(): void
    {
        $response = $this->followingRedirects()->post('/back-to-index');

        $response->assertStatus(200);

        $response->assertViewIs('front.index');
    }

    public function testSuccessConfirm(): void
    {
        $formData = [
            'fullname' => '山田太郎',
            'gender' => 1,
            'age_id' => 3,
            'email' => 'taro@example.com',
            'is_send_email' => 1,
            'feedback' => 'これはテスト投稿です。',
        ];

        $response = $this->post('/confirm', $formData);

        $response->assertStatus(200);

        $response->assertViewIs('front.confirm');

        $response->assertSee('山田太郎');
        $response->assertSee('男性');
        $response->assertSee('30代');
        $response->assertSee('送信可能');
        $response->assertSee('これはテスト投稿です。');
    }

    public function testSuccessStore(): void
    {
        $formData = [
            'fullname' => '山田太郎',
            'gender' => 1,
            'age_id' => 3,
            'email' => 'taro@example.com',
            'is_send_email' => 1,
            'feedback' => 'これはテスト投稿です。',
        ];

        $response = $this->post('/store', $formData);

        $response->assertStatus(302);

        $response->assertRedirect(route('front.index'));
        $this->assertDatabaseHas('answers', [
            'fullname' => '山田太郎',
            'email' => 'taro@example.com',
            'feedback' => 'これはテスト投稿です。',
        ]);

        $response->assertSessionHas('success', 'アンケートを送信しました');
    }
}
