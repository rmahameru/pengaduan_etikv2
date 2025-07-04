@extends('layouts.apps')

@section('title', 'Home')

@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>View PDF</title>
</head>
<body>
    <h1>PDF Viewer</h1>
    <iframe src="{{ asset('storage/assets/SOP/SOP%20Penanganan%20Pelanggaran%20Kode%20Etik%20Tendik.pdf') }}" width="100%" height="600px"></iframe>
</body>
</html>

@endsection