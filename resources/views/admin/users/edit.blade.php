@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('Панель управления') }}</a></li>
					<li class="breadcrumb-item"><a href="{{ route('admin.users') }}">{{ __('Пользователи') }}</a></li>
					<li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
				</ol>
			</nav>
			<div class="card">
				<div class="card-header">
					<a href="{{ route('admin.users.files', ['id' => $user->id]) }}">{{ __('Договора') }}</a>
				</div>
				<div class="card-body">
					<form method="POST" action="{{ route('admin.users.editPost',  ['id' => $user->id]) }}">
						@csrf

						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Имя и Фамилия') }}</label>

							<div class="col-md-6">
								<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

								@error('name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>

								@error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<label for="company" class="col-md-4 col-form-label text-md-right">{{ __('Компания') }}</label>

							<div class="col-md-6">
								<input id="company" type="text" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ $user->company }}" required autocomplete="company" autofocus>

								@error('company')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>

						<!--
						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Пароль') }}</label>

							<div class="col-md-6">
								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

								@error('password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
						-->
						
						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button type="submit" class="btn btn-primary">
									{{ __('Редактировать') }}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
