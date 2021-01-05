@extends('layouts.app')

@section('content')
<div id="app">
    <navbar></navbar>
        <router-view style="margin-top:5em"></router-view>
</div>
@endsection

