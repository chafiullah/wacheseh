<!DOCTYPE html>
<html lang="en">

<head>
    <title>Report Card of {{ $student->student_id . ' - ' . $student->name }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap4.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Carattere&family=Lato" rel="stylesheet">
    @include('academic.components.style')
</head>

<body>
    <div class="container-fluid page-break">
        <div class="row mt-2">
            {{-- banner --}}
            @include('academic.components.banner')
            {{-- Marking and Others --}}
            @include('academic.components.marks')
            {{-- Last page of the transcript --}}
            @include('academic.components.last_page')
        </div>
    </div>
    {{-- honors and behavior details --}}
    @include('academic.components.honor')
    {{-- Signatures --}}
    @include('academic.components.signatures')
    {{-- scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
