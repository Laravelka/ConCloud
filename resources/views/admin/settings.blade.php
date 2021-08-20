@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 mb-5">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('Панель управления') }}</a></li>
					<li class="breadcrumb-item active" aria-current="page">{{ __('Настройки') }}</li>
				</ol>
			</nav>
			@if (isset($message))
				<div class="alert alert-success">{{ $message }}</div>
			@endisset
			<div class="card mb-3">
				<div class="card-body">
					<form method="POST" action="{{ route('admin.settingsPost') }}">
						@csrf
						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Пароль') }}</label>

							<div class="col-md-6">
								<input id="password" type="text" value="{{ config('app.pw') }}" class="form-control" name="password" required autocomplete="current-password">
							</div>
						</div>
                        <div class="form-group row">
							<label for="folder_id" class="col-md-4 col-form-label text-md-right">{{ __('ID папки') }}</label>
							<div class="col-md-6">
								<input id="folder_id" type="text" value="{{ config('app.folder_id') }}" class="form-control" name="folder_id" required autocomplete="folder_id">
							</div>
						</div>
						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button type="submit" class="btn btn-primary">
									{{ __('Сохранить') }}
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
