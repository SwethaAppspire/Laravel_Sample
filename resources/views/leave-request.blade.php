<!DOCTYPE html>
<html>
<head>
    <title>Leave Request</title>
</head>
<body>

    <h1>Leave Request Page</h1>

    <form method="POST" action="/leave-request">
        @csrf

        <input type="text" name="reason" placeholder="Reason">

        <button type="submit">Submit Leave</button>
    </form>

</body>
</html>