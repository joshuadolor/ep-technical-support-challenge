@extends('layouts.app')

@section('content')
<div class="container">
    <journals-list :client='@json($client)' :journals='@json($journals)'></journals-list>
</div>
@endsection
