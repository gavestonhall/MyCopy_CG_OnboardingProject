@extends('layout')

@section('content')
<h1>Deployment Requests</h1>
<div>
	<a href="/forms/new">New Deployment Request</a>
</div>

<ol>
	@foreach ($forms as $form)
	<li>
		<a href="/forms/{{ $form->id }}"></a>
	</li>
	@endforeach
</ol>

@endsection
