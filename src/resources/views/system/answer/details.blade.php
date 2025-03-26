<!DOCTYPE html>
<html lang="ja">
@extends('layouts.app')

@section('body_contents')

	<body>
		<form method="GET" action="{{ route('system.answer.index') }}">
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
				<div class="form-group row align-items-center mb-3">
					<label for="gender" class="col-sm-2 col-form-label text-center">性別</label>
					<div class="col-sm-4 text-center">
						{{ $genderLabel }}
					</div>
				</div>
			</div>
			<div class="form-group row align-items-center mb-3">
				<label for="age_id" class="col-sm-2 col-form-label text-center">年代</label>
				<div class="col-sm-4 text-center">
					{{ $ageLabel }}
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
						{{ $isSendEmailLabel }}
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
		<form action="{{ route('system.answer.destroy', $answer->id) }}" method=POST>
			@csrf
			<button type="submit" class="btn btn-danger" onclick='return confirm("本当に削除しますか？")'>削除</button>
		</form>
		</div>
	</body>
@endsection

</html>
