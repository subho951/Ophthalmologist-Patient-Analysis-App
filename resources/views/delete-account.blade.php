<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delete Account</title>
</head>
<body>
    <h1 style="text-align: center;">Delete Account</h1>
    @if(session('success_message'))
    <div>{{ session('success_message') }}</div>
@endif
    <form method="POST" action="{{ route('delete-account.store') }}">
    @csrf
    <label>Entity Name:</label>
    <input type="text" name="entity_name" required><br>

    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Phone:</label>
    <input type="text" name="phone" required><br>

    <label>Comments:</label>
    <textarea name="comments"></textarea><br>

    <button type="submit">Submit Request</button>
</form>
</body>
</html>