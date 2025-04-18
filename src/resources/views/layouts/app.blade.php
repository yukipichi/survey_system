<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Styles -->
	@vite(['resources/sass/app.scss', 'resources/js/app.js'])

	<!-- Bootstrap CSS from CDN -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
	<link href="https://unpkg.com/bootstrap-table@1.24.1/dist/bootstrap-table.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">

</head>

<body>
	<div class="container mt-4">
		@if (session('success'))
			<div class="alert d-flex align-items-center justify-content-center text-center"
				style="background-color: #f9fcff; border: 2px solid #90caf9; color: #080808;">
				{{ session('success') }}
			</div>
		@endif

		<!-- Load Bootstrap first if not using jQuery -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
		<!-- Optionally include jQuery if required -->
		<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap Table -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.1/dist/bootstrap-table.min.js"></script>

		@yield('body_contents')
	</div>

	@yield('btn-dell') <!--削除確認処理-->
	@yield('js-validation') <!--入力チェック処理-->
</body>

</html>
