@extends('layouts.app')

@section('body_contents')
	<div style="display: flex; justify-content: space-between; align-items: center;">
		<h3>アンケート管理システム</h3>
		<form method="POST" action="{{ route('system.auth.logout') }}">
			@csrf
			<button type="submit" class="btn btn-sm btn-outline-secondary">ログアウト</button>
		</form>
	</div>

	<form id="searchForm">
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
								<input class="form-check-input" id="is_send_email" name="is_send_email" type="checkbox" value="1" checked
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
				<button onclick="doSearch()" class="btn btn-sm btn-success text-white" type="button">検索</button>
			</div>
		</div>
	</form>

		<button type="button" class="btn btn-danger my-4" onclick="deleteSelected()">選択したアンケートを削除</button>

	<table id="table"></table>

	<script type="text/javascript">
		$('#table').bootstrapTable({
			pagination: true,
			paginationParts: ['pageList', 'pagination'],
			sidePagination: 'server',
			totalField: 'total',
			dataField: 'data',
			sortable: true,
			ajax: function(params) {
				const form = document.getElementById('searchForm');
				const formData = new FormData(form);

				const queryParams = {};
				formData.forEach((value, key) => {
					queryParams[key] = value;
				});

				let limit = params.data.limit;
				let offset = params.data.offset;
				let sort = params.data.sort;
				let order = params.data.order;

				fetch('/system/answers/fetchList', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json',
							'X-Requested-With': 'XMLHttpRequest',
							'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
								'content')
						},
						body: JSON.stringify({
							limit,
							offset,
							sort,
							order,
							...queryParams
						})
					})
					.then(res => res.json())
					.then(response => {
						params.success(response);
					})
					.catch(error => console.error("Error:", error));
			},

			columns: [{
					field: 'state',
					checkbox: true,

				},
				{
					field: 'id',
					title: 'ID',
					sortable: true
				},
				{
					field: 'fullname',
					title: '氏名',
					sortable: true
				},
				{
					field: 'gender',
					title: '性別',
					sortable: true,
					formatter: (value, row) => row.gender_label

				},
				{
					field: 'age_id',
					title: '年齢',
					sortable: true,
					formatter: (value, row) => row.age_label
				},
				{
					field: 'feedback_limit',
					title: '内容'
				},
				{
					field: 'actions',
					title: '',
					formatter: function(value, row) {
						return `<a href="/system/answers/${row.id}" class="btn btn-sm btn-outline-primary">詳細</a>`;
					}
				}
			]
		});
	</script>

	<script type="text/javascript">
		function resetSearch() {
			window.location.href = "{{ route('system.answer.index') }}";
		}

		function doSearch() {
			$('#table').bootstrapTable('refresh', {
				pageNumber: 1
			});
		}

		function deleteSelected() {
			const selected = $('#table').bootstrapTable('getSelections');

			if (selected.length === 0) {
				alert('削除するアンケートを選択してください。');
				return;
			}

			if (!confirm('選択したアンケートを削除してもよろしいですか？')) {
				return;
			}

			const ids = selected.map(row => row.id);

			fetch('/system/answers/deleteSelected', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-Requested-With': 'XMLHttpRequest',
						'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
					},
					body: JSON.stringify({
						ids: ids
					})
				})
				.then(res => res.json())
				.then(response => {
					if (response.success) {
						alert('削除が完了しました。');
						$('#table').bootstrapTable('refresh');
					} else {
						alert('削除に失敗しました。');
					}
				})
				.catch(error => {
					console.error("Error:", error);
					alert('エラーが発生しました。');
				});
		}
	</script>
@endsection
