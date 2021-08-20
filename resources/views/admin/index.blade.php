@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active" aria-current="page">{{ __('Вход в панель управления') }}</li>
				</ol>
			</nav>
			<div class="card">
				<div class="card-body">
					@if (isset($error))
					<div class="alert alert-danger">Пароль неверный</div>
					@endisset
					<form method="POST" action="{{ route('admin.indexPost') }}">
						@csrf
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
						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button type="submit" class="btn btn-primary">
									{{ __('Войти') }}
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
