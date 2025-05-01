<!DOCTYPE html>
<html>
<head>
    <title>New Account Appeal Notification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 25px;
        }
        .header {
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        h1 {
            color: #1e293b;
            margin-top: 0;
            font-size: 24px;
        }
        h2 {
            color: #334155;
            font-size: 18px;
            margin-top: 25px;
            margin-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 8px;
        }
        .user-details {
            background-color: #fff;
            border-left: 4px solid #4f46e5;
            padding: 15px;
            margin: 15px 0;
        }
        .appeal-text {
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 15px;
            margin: 15px 0;
        }
        .buttons {
            margin: 25px 0;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-right: 10px;
            margin-bottom: 10px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
        }
        .approve {
            background-color: #22c55e;
            color: white;
        }
        .review {
            background-color: #3b82f6;
            color: white;
        }
        .reject {
            background-color: #ef4444;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            background-color: #f1f5f9;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            font-size: 0.9em;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Account Appeal Submitted</h1>
            <p>A user has submitted an appeal for their suspended account. This requires your attention and review.</p>
        </div>
        
        <h2>User Details</h2>
        <div class="user-details">
            <table>
                <tr>
                    <th style="width: 30%;">Name:</th>
                    <td>{{ $userName }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $userEmail }}</td>
                </tr>
                <tr>
                    <th>Account Type:</th>
                    <td>{{ isset($user->student) ? 'Student' : (isset($user->employer) ? 'Employer' : 'User') }}</td>
                </tr>
                <tr>
                    <th>Appeal ID:</th>
                    <td>#{{ $appealId }}</td>
                </tr>
                <tr>
                    <th>Submitted:</th>
                    <td>{{ now()->format('F j, Y \a\t g:i A') }}</td>
                </tr>
            </table>
        </div>
        
        <h2>Appeal Reason</h2>
        <div class="appeal-text">
            {!! nl2br(e($appealReason)) !!}
        </div>
        
        @if($additionalInfo)
        <h2>Additional Information</h2>
        <div class="appeal-text">
            {!! nl2br(e($additionalInfo)) !!}
        </div>
        @endif
        
        <h2>Actions</h2>
        <p>Please review this appeal and take appropriate action in the admin dashboard.</p>
        
        <div class="buttons">
            <a href="{{ route('admin.dashboard') }}" class="button review">Go to Admin Dashboard</a>
        </div>
        
        <p>You can also respond to the user with additional questions or information through the admin dashboard.</p>
        
        <div class="footer">
            <p>This is an automated message from {{ config('app.name') }}. Please do not reply directly to this email.</p>
            <p>For security purposes, this login request will expire in 24 hours.</p>
        </div>
    </div>
</body>
</html>