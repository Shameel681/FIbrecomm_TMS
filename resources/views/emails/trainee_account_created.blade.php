<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; border: 1px solid #eee; padding: 20px; border-radius: 10px; }
        .header { border-bottom: 2px solid #e11d48; padding-bottom: 10px; margin-bottom: 20px; }
        .credentials { background: #f9fafb; padding: 15px; border-radius: 5px; border: 1px solid #e5e7eb; }
        .button { display: inline-block; padding: 10px 20px; background-color: #0f172a; color: #ffffff !important; text-decoration: none; border-radius: 5px; margin-top: 20px; }
        .footer { margin-top: 30px; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #0f172a; margin: 0;">Internship Onboarding</h2>
        </div>
        
        {{-- Use $user->name or $trainee_form->full_name --}}
        <p>Hello <strong>{{ $user->name }}</strong>,</p>
        
        <p>Congratulations! Your official trainee account has been created. You can now log in to the portal to track your progress and submit reports.</p>
        
        <div class="credentials">
            <p style="margin: 0;"><strong>Login Email:</strong> {{ $user->email }}</p>
            <p style="margin: 0;"><strong>Temporary Password:</strong> <span style="color: #e11d48; font-family: monospace; font-weight: bold;">{{ $password }}</span></p>
        </div>

        <p>Please log in and change your password immediately upon your first visit.</p>

        <a href="{{ url('/login') }}" class="button">Log In to Portal</a>

        <div class="footer">
            <p>This is an automated message from the HR Department. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>