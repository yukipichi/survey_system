<!DOCTYPE html>
<html lang="ja">
@extends('layouts.app')

@section('body_contents')

	<body>
		<form action="{{ route('system.answer.index') }}" method="GET">
			@csrf
			<div class="container mt-5">
				<div class="d-flex justify-content-center">
					<h2>アンケート管理システム</h2>
				</div>

				<div class="form-group row align-items-center mb-3">
					<label for="fullname" class="col-sm-2 col-form-label text-center">ID</label>
					<div class="col-sm-4 text-center">
						{{ $answer->id }}
					</div>
				</div>
				<div class="form-group row align-items-center mb-3">
					<label for="fullname" class="col-sm-2 col-form-label text-center">氏名</label>
					<div class="col-sm-4 text-center">
						{{ $answer->fullname }}
					</div>
				</div>
				{{-- 性別の選択肢を作る --}}
				<div class="form-group row align-items-center mb-3">
					<label for="gender" class="col-sm-2 col-form-label text-center">性別</label>
					<div class="col-sm-4 text-center">
						{{-- {{ $answer->gender }} --}}
						{{ $answer->gender == 1 ? '男性' : ($answer->gender == 2 ? '女性' : 'その他') }}
					</div>
				</div>
			</div>
			<div class="form-group row align-items-center mb-3">
				<label for="age_id" class="col-sm-2 col-form-label text-center">年代</label>
				<div class="col-sm-4 text-center">
					{{ match ($answer->age_id) {
					    1 => '10代以下',
					    2 => '20代',
					    3 => '30代',
					    4 => '40代',
					    5 => '50代',
					    6 => '60代以上',
					    default => '不明',
					} }}
				</div>
			</div>
			<div class="form-group row align-items-center mb-3">
				<label for="email" class="col-sm-2 col-form-label text-center">メールアドレス</label>
				<div class="col-sm-4 text-center">
					{{ $answer->email }}
				</div>
			</div>
			<div class="form-group row align-items-center mb-3">
				<label for="is_send_email"class="col-sm-2 col-form-label text-center">メール送信可否</label>
				<div class="col-sm-4 text-center">
					<div class="form-check">
						{{ $answer->is_send_email ? '送信可能' : '送信不可' }}
					</div>
				</div>
			</div>
			<div class="form-group row align-items-center mb-3">
				<label for="feedback" class="col-sm-2 col-form-label text-center">ご意見</label>
				<div class="col-sm-4 text-center">
					{!! nl2br(e($answer->feedback)) !!}
				</div>
			</div>
			<div class="form-group row align-items-center mb-3">
				<label for="feedback" class="col-sm-2 col-form-label text-center">登録日時</label>
				<div class="col-sm-4 text-center">
					{{ $answer->created_at }}
				</div>
			</div>
			<div class="d-flex justify-content-center gap-3">
				<button type="submit" class="btn btn-success">一覧に戻る</button>
		</form>
		<form action="{{ route('system.answer.destroy', ['id' => $answer->id]) }}" method=POST>
			@csrf
			<button type="submit" class="btn btn-danger" onclick='return confirm("本当に削除しますか？")'>削除</button>
		</form>
		</div>
	</body>
@endsection

</html>
