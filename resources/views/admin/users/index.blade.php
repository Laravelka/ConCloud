@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 mb-5">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('Панель управления') }}</a></li>
					<li class="breadcrumb-item active" aria-current="page">{{ __('Пользователи') }}</li>
				</ol>
			</nav>
			<div class="card">
				<ul class="list-group list-group-flush">
					@foreach($users as $user) 
						<li class="list-group-item">
							<div class="row">
								<div class="col-10">
									<b>{{ $user->name }}</b><br>
									E-Mail: {{ $user->email }}<br>
									Компания: {{ $user->company }}<br>
									Зарегистрирован: {{ $user->created_at }}<br>
								</div>
								<div class="col-2 d-flex justify-content-end">
									<a href="/admin/users/edit/{{ $user->id }}">
										<i class="bi bi-pencil custom-size"></i>
									</a>
								</div>
							</div>

						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection
