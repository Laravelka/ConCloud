@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 mb-5">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active" aria-current="page">{{ __('Панель управления') }}</li>
				</ol>
			</nav>
			<div class="card">
				<ul class="list-group list-group-flush">
					<a href="{{ route('admin.users') }}" class="list-group-item">Пользователи</a>
					<a href="{{ route('admin.settings') }}" class="list-group-item">Настройки</a>
					<a href="{{ route('admin.exit') }}" class="list-group-item">Выход</a>
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection
