@extends('templates.main')

@section('title', 'Home')

@section('content')
    <div>
        <h1>Halaman Home</h1>
    </div>
@endsection

@section('js')
    <script>
        console.log('Home base url = ', baseUrl);
        console.log('Home csrf token = ', csrfToken);
    </script>
@endsection
