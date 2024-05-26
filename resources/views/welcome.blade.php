<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Event Reminder App</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 100px;
            text-align: center;
        }
        .jumbotron {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.1);
            padding: 40px;
        }
        h1 {
            font-size: 36px;
            color: #007bff;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            color: #6c757d;
        }
    </style>
</head>
<body style="background-color: beige;">

<div class="container">
    <div class="jumbotron">
        <h1>Welcome to Event Reminder App</h1>
        <p>This is a simple event reminder application to help you manage your events and never miss any important dates.</p>
        <p>Start organizing your events now!</p>
        <p>Check Events ==> <a class="btn btn-primary" href="{{route('events.index')}}">Events</a></p>
    </div>
</div>

<!-- Bootstrap JS (optional, if you need JavaScript features) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
