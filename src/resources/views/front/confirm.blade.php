<!DOCTYPE html>
<html lang="ja">
@extends('layouts.app')

@section('body_contents')

	<body>
		<div class="container mt-5">
			<div class="d-flex justify-content-center">
				<h2>内容確認</h2>
			</div>
			<form action="{{ route('front.store') }}" method="POST">
				@csrf
				<div class="form-group row align-items-center mb-3">
					<label for="fullname" class="col-sm-2 col-form-label text-center">氏名<span class="text-danger">※</span></label>
					<div class="col-sm-4 text-center">
						{{ $fullname }}
						<input type="hidden" name="fullname" value="{{ $fullname }}">
					</div>
				</div>
				{{-- //性別の選択肢を作る --}}
				<div class="form-group row align-items-center mb-3">
					<label for="gender" class="col-sm-2 col-form-label text-center">性別<span class="text-danger">※</span></label>
					<div class="col-sm-4 text-center">
						{{ $gender }}
						<input type="hidden" name="gender" value="{{ $gender == '男性' ? 1 : ($gender == '女性' ? 2 : '') }}">
					</div>
				</div>

				<div class="form-group row align-items-center mb-3">
					<label for="age_id" class="col-sm-2 col-form-label text-center">年代<span class="text-danger">※</span></label>
					<div class="col-sm-4 text-center">
						{{ $age_id }}
						{{-- <input type="hidden" name="ages" value="{{ $ages  }}"> --}}
						<input type="hidden" name="age_id"
							value="{{ $age_id == '10代以下'
							    ? 1
							    : ($age_id == '20代'
							        ? 2
							        : ($age_id == '30代'
							            ? 3
							            : ($age_id == '40代'
							                ? 4
							                : ($age_id == '50代'
							                    ? 5
							                    : ($age_id == '60代'
							                        ? 6
							                        : ''))))) }}">
					</div>
				</div>
				<div class="form-group row align-items-center mb-3">
					<label for="email" class="col-sm-2 col-form-label text-center">メールアドレス<span class="text-danger">※</span></label>
					<div class="col-sm-4 text-center">
						{{ $email }}
						<input type="hidden" name="email" value="{{ $email }}">
					</div>
				</div>
				<div class="form-group row align-items-center mb-3">
					<label for="is_send_email"class="col-sm-2 col-form-label text-center">メール送信可否</label>
					<div class="col-sm-4 text-center">
						<div class="form-check">
							{{ $is_send_email }}
							<input type="hidden" name="is_send_email" value="{{ $is_send_email }}">
						</div>
					</div>
					<div class="form-group row align-items-center mb-3">
						<label for="feedback" class="col-sm-2 col-form-label text-center">ご意見</label>
						<div class="col-sm-4 text-center">
							{!! nl2br(e($feedback)) !!}
							<input type="hidden" name="feedback" value="{{ $feedback }}">
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-center gap-3">
					<button type="submit" class="btn btn-primary" name= "action" formmethod="POST"
						formaction="{{ route('front.backToIndex') }}">再入力</button>
					<button type="submit" class="btn btn-success">送信</button>
				</div>
			</form>
		</div>
	</body>
@endsection

</html>
