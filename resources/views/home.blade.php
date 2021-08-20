@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 mb-5">
			<div class="card">
				<div class="card-header"><b>{{ __('Кабинет') }}</b></div>

				<div class="card-body">
					E-Mail: {{ Auth::user()->email }}<br>
					Компания: {{ Auth::user()->company }}
				</div>
			</div>
		</div>
		<div class="col-md-8 mb-5">
			<my-contracts></my-contracts>
		</div>
	</div>
</div>
@endsection
