<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Styles -->
	@vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
	<div class="container mt-4">
		@if (session('success'))
			<div class="alert d-flex align-items-center justify-content-center text-center"
				style="background-color: #e3f2fd; border: 2px solid #90caf9; color: #000;">
				{{ session('success') }}
			</div>
		@endif
		@yield('body_contents')
	</div>
	@yield('btn-dell') <!--削除確認処理-->
	@yield('js-validation') <!--入力チェック処理-->
</body>

</html>
