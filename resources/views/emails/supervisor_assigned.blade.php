<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Instrument Sans', sans-serif; color: #001f3f; }
        .header { background: #001f3f; color: white; padding: 20px; text-align: center; }
        .content { padding: 30px; border: 1px solid #f1f1f1; }
        .footer { font-size: 10px; color: #999; margin-top: 20px; text-align: center; }
        .highlight { color: #EF4023; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Trainee Assigned</h1>
    </div>
    <div class="content">
        <p>Hello <span class="highlight">{{ $supervisor->name }}</span>,</p>
        
        <p>The HR Department has assigned a new trainee to your supervision:</p>
        
        <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <tr>
                <td style="font-weight: bold; width: 150px;">Trainee Name:</td>
                <td>{{ $trainee->name }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Trainee Email:</td>
                <td>{{ $trainee->email }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Start Date:</td>
                <td>{{ $trainee->start_date }}</td>
            </tr>
        </table>

        <p style="margin-top: 20px;">
            You can now view this trainee's clock-in/out records in your 
            <strong>Attendance Approvals</strong> dashboard.
        </p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Fibrecomm Network (M) Sdn Bhd | HR Management System
    </div>
</body>
</html>