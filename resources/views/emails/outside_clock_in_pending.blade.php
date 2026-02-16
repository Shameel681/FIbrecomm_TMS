<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Instrument Sans', sans-serif; color: #001f3f; }
        .header { background: #001f3f; color: white; padding: 20px; text-align: center; }
        .content { padding: 30px; border: 1px solid #f1f1f1; }
        .footer { font-size: 10px; color: #999; margin-top: 20px; text-align: center; }
        .highlight { color: #EF4023; font-weight: bold; }
        .btn { display: inline-block; background: #001f3f; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; margin-top: 16px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Outside clock-in – approval needed</h1>
    </div>
    <div class="content">
        <p>Hello <span class="highlight">{{ $supervisor->name }}</span>,</p>

        <p><strong>{{ $trainee->name }}</strong> has submitted an attendance request from outside the company network and it is pending your approval.</p>

        <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <tr>
                <td style="font-weight: bold; width: 140px;">Date:</td>
                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('l, d F Y') }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Clock-in time:</td>
                <td>{{ \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A') }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Trainee remarks:</td>
                <td>{{ $attendance->trainee_remark ?? '—' }}</td>
            </tr>
        </table>

        <p style="margin-top: 20px;">Please review and approve or reject this request in your Attendance Approvals dashboard.</p>
        <a href="{{ route('supervisor.attendance.approvals') }}" class="btn">Go to Attendance Approvals</a>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Fibrecomm Network (M) Sdn Bhd | Trainee Management System
    </div>
</body>
</html>
