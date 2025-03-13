<?php

namespace App\Models;

use App\Models\Age;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['fullname', 'gender', 'age_id', 'email', 'is_send_email', 'feedback',];

     // 名前でフィルタリング
    public function scopeFullname($query, $fullname)
    {
        return $query->when(filled($fullname), fn($q) => $q->where('fullname', 'LIKE', "%{$fullname}%"));
    }

    // 年齢IDでフィルタリング
    public function scopeAgeId($query, $age_id)
    {
        return $query->when(filled($age_id), fn($q) => $q->where('age_id', $age_id));
    }

    // 性別でフィルタリング
    public function scopeGender($query, $gender)
    {
        return $query->when(filled($gender), fn($q) => $q->where('gender', $gender));
    }

    // 作成日からフィルタリング
    public function scopeCreatedFrom($query, $created_from)
    {
        return $query->when(filled($created_from), fn($q) => $q->whereDate('created_at', '>=', $created_from));
    }

    // 作成日までフィルタリング
    public function scopeCreatedTo($query, $created_to)
    {
        return $query->when(filled($created_to), fn($q) => $q->whereDate('created_at', '<=', $created_to));
    }

    // メール送信可否でフィルタリング
    public function scopeIsSendEmail($query, $is_send_email)
    {
        return $query->when(filled($is_send_email), fn($q) => $q->where('is_send_email', 1));
    }

    // キーワードでフィルタリング
    public function scopeKeyword($query, $keyword)
    {
        return $query->when(filled($keyword), function ($q) use ($keyword) {
            $q->where(fn($q) => $q->where('feedback', 'LIKE', "%{$keyword}%")
                ->orWhere('email', 'LIKE', "%{$keyword}%"));
        });
    }

    // 性別ラベルを取得する
    public static function getGenderLabel($value)
    {
        return match ($value) {
            1 => '男性',
            2 => '女性',
            default => '不明',
        };
    }

    // 性別ラベルからIDを取得
    public static function getGenderId($gender)
    {
        return match ($gender) {
            '男性' => 1,
            '女性' => 2,
            default => null,
        };
    }

    // 年齢ラベルをIDから取得
    public static function getAgeLabel($age_id)
    {
        return match ($age_id) {
            1 => '10代以下',
            2 => '20代',
            3 => '30代',
            4 => '40代',
            5 => '50代',
            6 => '60代',
            default => '不明',
        };
    }

    // 年齢IDを取得
    public static function getAgeId($age_id)
    {
        return match ($age_id) {
            '1' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '6' => 6,
            default => null,
        };
    }

    // メール送信可否をラベルで返す
    public static function getIsSendEmailLabel($value)
    {
        return $value == '1' ? '送信可能' : '送信不可';
    }

    // is_send_emailの値を変換
    public static function getIsSendEmailStatus($value)
    {
        return $value ? 1 : 0;
    }

    // Ageモデルのリレーション
    public function age()
    {
        return $this->belongsTo(Age::class);
    }
}
