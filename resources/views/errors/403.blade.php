<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            text-align: center;
            padding: 50px;
        }
        h1 {
            font-size: 5em;
            color: #ff6f61;
        }
        p {
            font-size: 1.2em;
            margin: 20px 0;
        }
        a {
            text-decoration: none;
            color: white;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>403</h1>
    <p>{{ $exception->getMessage() ?: 'You do not have permission to access this page.' }}</p>
    @if(has_permission('view', 'dashboard'))
    <a href="{{ route('dashboard') }}">Go Back Home</a>
    @elseif(has_permission('view', 'pos'))
    <a href="{{ route('pos.home') }}">Go Back Home</a>
    @else
    <a href="/">Go Back Home</a>
    @endif
</body>
</html>
