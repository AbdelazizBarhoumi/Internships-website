<!DOCTYPE html>
<html>
<head>
    <title>Account Appeal Submitted</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        h1 { color: #2d3748; }
        h2 { color: #4a5568; font-size: 18px; margin-top: 20px; }
        .button { display: inline-block; background-color: #4299e1; color: white !important; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .footer { margin-top: 30px; padding-top: 15px; border-top: 1px solid #edf2f7; font-size: 0.9em; color: #718096; }
    </style>
</head>
<body>
    <h1>Account Appeal Submitted</h1>
    
    <p>Hello {{ $user->name }},</p>
    
    <p>We have received your appeal regarding your suspended account on {{ config('app.name') }}.</p>
    
    <p>Your appeal will be reviewed by our administration team. Please allow 1-2 business days for processing.</p>
    
    <h2>Appeal Details</h2>
    <ul>
        <li><strong>User</strong>: {{ $user->name }} ({{ $user->email }})</li>
        <li><strong>Submitted</strong>: {{ now()->format('F j, Y \a\t g:i A') }}</li>
        <li><strong>Appeal Reason</strong>: {!! nl2br(e($appealReason)) !!}</li>
        @if($additionalInfo)
            <li><strong>Additional Information</strong>: {!! nl2br(e($additionalInfo)) !!}</li>
        @endif
    </ul>
    
    <p>While your appeal is being processed, your account will remain in suspended status. We will notify you via email once a decision has been made.</p>
    
    <a href="{{ config('app.url') }}" class="button">Return to Website</a>
    
    <p>Thank you for your patience.</p>
    
    <p>Regards,<br>
    The {{ config('app.name') }} Team</p>
    
    <div class="footer">
        <p>If you did not submit this appeal, please contact our support team immediately.</p>
    </div>
</body>
</html>