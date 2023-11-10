@extends('layouts.app')

@section('content')
    <script>
        window.isAuthenticated = @json(auth()->check());
    </script>

    <div id="app">
        <router-view></router-view>
    </div>
@endsection
