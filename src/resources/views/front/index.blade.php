<!DOCTYPE html>
<html lang="ja">
@extends('layouts.app')

@section('body_contents')

	<body>
		<div class="container mt-5">
			<div class="d-flex justify-content-center">
				<h2>システムへのご意見をお聞かせください</h2>
			</div>
			<form method="POST" action="{{ route('front.confirm') }}">
				@csrf
				<div class="form-group row align-items-center mb-3">
					<label for="fullname" class="col-sm-2 col-form-label">氏名<span class="text-danger">※</span></label>
					<div class="col-sm-10">
						<input type="fullname" name="fullname" class="form-control" id="fullname" value="{{ old('fullname') }}"
							placeholder="入力してください">
						@if ($errors->has('fullname'))
							<div class="text-danger">
								<strong>{{ $errors->first('fullname') }}</strong>
							</div>
						@endif
					</div>
				</div>
				{{-- 性別の選択肢を作る --}}
				<div class="form-group row align-items-center mb-3">
					<label for="gender" class="col-sm-2 col-form-label">性別<span class="text-danger">※</span></label>
					<div class="col-sm-10">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="1"
								{{ old('gender') == 1 ? 'checked' : '' }}>
							<label class="form-check-label" for="inlineRadio1">男性</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="2"
								{{ old('gender') == 2 ? 'checked' : '' }}>
							<label class="form-check-label" for="inlineRadio2">女性</label>
						</div>
						@if ($errors->has('gender'))
							<div class="text-danger">
								<strong>{{ $errors->first('gender') }}</strong>
							</div>
						@endif
					</div>
				</div>
				<div class="form-group row align-items-center mb-3">
					<label for="age_id" name="age_id" class="col-sm-2 col-form-label">年代<span class="text-danger">※</span></label>
					<div class="col-sm-10">
						<select name="age_id" class="form-control">
							<option value="">選択してください</option>
							<option value="1" {{ old('age_id') == 1 ? 'selected' : '' }}>10代以下</option>
							<option value="2" {{ old('age_id') == 2 ? 'selected' : '' }}>20代</option>
							<option value="3" {{ old('age_id') == 3 ? 'selected' : '' }}>30代</option>
							<option value="4" {{ old('age_id') == 4 ? 'selected' : '' }}>40代</option>
							<option value="5" {{ old('age_id') == 5 ? 'selected' : '' }}>50代</option>
							<option value="6" {{ old('age_id') == 6 ? 'selected' : '' }}>60代</option>
						</select>
						@if ($errors->has('age_id'))
							<div class="text-danger">
								<strong>{{ $errors->first('age_id') }}</strong>
							</div>
						@endif
					</div>
				</div>
				<div class="form-group row align-items-center mb-3">
					<label for="email" class="col-sm-2 col-form-label">メールアドレス<span class="text-danger">※</span></label>
					<div class="col-sm-10">
						<input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}"
							placeholder="メールアドレス">
						@if ($errors->has('email'))
							<div class="text-danger">
								<strong>{{ $errors->first('email') }}</strong>
							</div>
						@endif
					</div>
				</div>
				<div class="form-group row align-items-center mb-3">
					<label for="is_send_email" class="col-sm-2 col-form-label">メール送信可否</label>
					<div class="col-sm-10">
						<br>登録したメールアドレスにメールマガジンをお送りしてもよろしいですか？
						<div class="form-check">
							<input class="form-check-input" name="is_send_email" type="checkbox" value="1"
								{{ old('is_send_email') == 1 ? 'checked' : '' }}>
							<label class="form-check-label" for="gridCheck">
								送信を許可します。
							</label>
						</div>
					</div>
					<div class="form-group row align-items-center mb-3">
						<label for="feedback" class="col-sm-2 col-form-label">ご意見</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="feedback" id="feedback" rows="3" placeholder="入力してください">{{ old('feedback') }}</textarea>
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-center">
					<button type="submit" class="btn btn-primary">確認する</button>
				</div>
			</form>
		</div>
	</body>
@endsection

</html>
