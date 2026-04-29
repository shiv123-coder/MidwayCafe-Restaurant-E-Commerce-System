<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reservation Confirmation</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            background: #ffffff;
        }

        .container {
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .header {
            text-align: right;
            font-size: 18px;
            color: red;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background: #f2f2f2;
            width: 30%;
            text-align: left;
        }

        .no-border td {
            border: none;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- Header -->
    <table class="no-border">
        <tr>
            <td>
                <strong>Restaurant Management System</strong><br>
                Reservation Confirmation
            </td>
            <td class="header">
                INVOICE
            </td>
        </tr>
    </table>

    <hr>

    <!-- Customer Message -->
    <p>
        Hello <strong>{{ $name }}</strong>,<br>
        Your reservation has been successfully placed.
    </p>

    <!-- Reservation Details -->
    <h2>Reservation Details</h2>

    <table>
        <tr>
            <th>Name</th>
            <td>{{ $name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $email }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $phone }}</td>
        </tr>
        <tr>
            <th>No. of Guests</th>
            <td>{{ $no_guest }}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ $date }}</td>
        </tr>
        <tr>
            <th>Time</th>
            <td>{{ $time }}</td>
        </tr>
        <tr>
            <th>Message</th>
            <td>{{ $user_message ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        Thank you for choosing us!<br>
        Have a great day.
    </div>

</div>

</body>
</html>
