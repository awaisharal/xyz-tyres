<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Shopkeeper</title>
</head>
<body>
    <h1>Register as Shopkeeper</h1>
    <form method="POST" action="{{ route('shopkeeper.store') }}">
        @csrf
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <button type="submit">Register</button>
    </form>
</body>
</html>