@extends('layouts.app')

@section('body_contents')
	<div style="display: flex; justify-content: space-between; align-items: center;">
		<h3>アンケート管理システム</h3>
		<form method="POST" action="{{ route('system.auth.logout') }}">
			@csrf
			<button type="submit" class="btn btn-sm btn-outline-secondary">ログアウト</button>
		</form>
	</div>

	<form method="GET" action="{{ route('system.answer.index') }}">
		@csrf
		<div class="card p-4 border">
			<div class="row align-items-center mb-3">
				{{-- 氏名 --}}
				<div class="col-md-4">
					<div class="row align-items-center">
						<label for="fullname" class="col-sm-3 col-form-label text-end">氏名</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="fullname" name="fullname" value="{{ request('fullname') }}"
								placeholder="入力してください">
						</div>
					</div>
				</div>

				{{-- 年代 --}}
				<div class="col-md-4">
					<div class="row align-items-center">
						<label for="age_id" class="col-sm-3 col-form-label text-end">年代</label>
						<div class="col-sm-9">
							<select name="age_id" class="form-control">
								<option value="">選択してください</option>
								<option value="1" {{ request('age_id') == '1' ? 'selected' : '' }}>10代以下</option>
								<option value="2" {{ request('age_id') == '2' ? 'selected' : '' }}>20代</option>
								<option value="3" {{ request('age_id') == '3' ? 'selected' : '' }}>30代</option>
								<option value="4" {{ request('age_id') == '4' ? 'selected' : '' }}>40代</option>
								<option value="5" {{ request('age_id') == '5' ? 'selected' : '' }}>50代</option>
								<option value="6" {{ request('age_id') == '6' ? 'selected' : '' }}>60代</option>
							</select>
						</div>
					</div>
				</div>

				{{-- 性別 --}}
				<div class="col-md-4">
					<div class="row align-items-center">
						<label for="gender" class="col-sm-3 col-form-label text-end">性別</label>
						<div class="col-sm-9">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="gender" value="0" checked
									{{ request('gender', '0') == 0 ? 'checked' : '' }}>
								<label class="form-check-label">すべて</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="gender" value="1"
									{{ request('gender') == 1 ? 'checked' : '' }}>
								<label class="form-check-label">男性</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="gender" value="2"
									{{ request('gender') == 2 ? 'checked' : '' }}>
								<label class="form-check-label">女性</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row align-items-center mb-3">
				{{-- 登録日（created_at 範囲検索） --}}
				<div class="col-md-6">
					<div class="row align-items-center">
						<label for="created_from" class="col-sm-3 col-form-label text-end">登録日</label>
						<div class="col-sm-9 d-flex align-items-center">
							<input type="date" class="form-control me-2" id="created_from" name="created_from"
								value="{{ request('created_from') }}">
							<span class="me-2">～</span>
							<input type="date" class="form-control" id="created_to" name="created_to" value="{{ request('created_to') }}">
						</div>
					</div>
				</div>

				{{-- メール送信許可 --}}
				<div class="col-md-6">
					<div class="row align-items-center">
						<label for="is_send_email" class="col-sm-4 col-form-label text-end">メール送信許可</label>
						<div class="col-sm-8">
							<div class="form-check">
								<input class="form-check-input" name="is_send_email" type="checkbox" value="1"
									{{ request('is_send_email') == 1 ? 'checked' : '' }}>
								<label class="form-check-label" for="is_send_email">送信許可のみ</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			{{-- キーワード（下に配置） --}}
			<div class="row align-items-center mb-3">
				<label for="keyword" class="col-md-2 col-form-label text-end">キーワード</label>
				<div class="col-md-6">
					<input type="text" class="form-control" id="keyword" name="keyword"
						placeholder=""value="{{ request('keyword') }}">
				</div>
			</div>

			{{-- ボタン（中央揃え） --}}
			<div class="text-center">
				<button onclick="resetSearch()" class="btn btn-sm btn-outline-secondary" type="reset">リセット</button>
				<button class="btn btn-sm btn-success text-white" type="submit">検索</button>
			</div>
		</div>
	</form>

	<form id="delete-form" action="{{ route('system.answer.deleteMultiple') }}" method="POST">
		@csrf

		<div class="container mt-3">
			<div class="d-flex justify-content-between align-items-center">
				{{-- 削除ボタン --}}
				<button type="submit" class="btn btn-danger">選択したアンケートを削除</button>

				{{-- 表示件数 / 全体の件数 --}}
				<div class="text-muted">
					<span>全 {{ $answers->total() }} 件中 {{ $answers->firstItem() }} 〜 {{ $answers->lastItem() }} 件表示</span>
				</div>

				{{-- ページネーション --}}
				<nav aria-label="Page navigation example">
					<ul class="pagination mb-0">
						<li class="page-item {{ $answers->onFirstPage() ? 'disabled' : '' }}">
							<a class="page-link" href="{{ $answers->previousPageUrl() }}" tabindex="-1">&lt;</a>
						</li>
						@foreach (range(1, min(8, $answers->lastPage())) as $i)
							<li class="page-item {{ $i == $answers->currentPage() ? 'active' : '' }}">
								<a class="page-link" href="{{ $answers->url($i) }}">{{ $i }}</a>
							</li>
						@endforeach
						<li class="page-item {{ $answers->hasMorePages() ? '' : 'disabled' }}">
							<a class="page-link" href="{{ $answers->nextPageUrl() }}">&gt;</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>

		<table class="table">
			<thead>
				<tr>
					<th>
						<label for ="select_all">
							<input type="checkbox" name="all" id="select_all" onClick="allChecked();">全選択
						</label>
					</th>
					<th>ID</th>
					<th>氏名</th>
					<th>性別</th>
					<th>年齢</th>
					<th>内容</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($answers as $answer)
					<tr>
						<td><input type="checkbox" name="answer[]" value="{{ $answer->id }}" onClick="disChecked();"></td>
						<td>{{ $answer->id }}</td>
						<td>{{ $answer->fullname }}</td>
						<td>{{ $answer->gender_label }}</td>
						<td>{{ $answer->age_label }}</td>
						<td>{{ $answer->feedback_limit }}</td>
						<td>
							<a href="{{ route('system.answer.details', ['id' => $answer->id]) }}" class="btn btn-primary">詳細</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</form>

	@if ($answers->isEmpty())
		<div class="alert alert-warning text-center mt-3">
			該当するアンケートがありません。
		</div>
	@else
	@endif

	<script type="text/javascript">
		function resetSearch() {
			window.location.href = "{{ route('system.answer.index') }}";
		}
	</script>

	<script type="text/javascript">
		function allChecked() {
			var allChecked = document.getElementsByName('all')[0].checked;

			for (var i = 0; i < document.getElementsByName('answer[]').length; i++) {
				document.getElementsByName('answer[]')[i].checked = allChecked;
			}
		}

		function disChecked() {
			var inputCheckboxList = document.getElementsByName('answer[]');
			var a = [...inputCheckboxList];
			var allChecked = document.getElementsByName('all')[0];

			if (![...inputCheckboxList].every(cb => cb.checked)) {
				allChecked.checked = false;
			}
		}
	</script>
@endsection
