<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* Corporate Branding Colors */
        :root {
            --brand-red: #E30613; /* Fibrecomm Red */
            --brand-navy: #002B49; /* Professional Navy */
        }

        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            text-transform: uppercase; 
            font-size: 11px; 
            color: #333;
            line-height: 1.4;
            margin: 20px;
        }

        /* Header Styling */
        .header { 
            text-align: center; 
            border-bottom: 3px solid #E30613; 
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 { 
            color: #002B49; 
            font-size: 24px; 
            margin: 0;
            letter-spacing: -1px;
        }

        .header p { 
            color: #E30613; 
            font-weight: bold; 
            margin: 5px 0 0 0;
            font-size: 14px;
            letter-spacing: 2px;
        }

        /* Section Styling */
        .section { 
            margin-top: 25px; 
            background: #002B49; 
            color: white;
            padding: 8px 12px; 
            font-weight: bold; 
            font-size: 12px;
            border-left: 5px solid #E30613;
        }

        /* Data Grid */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        .label { 
            color: #888; 
            font-size: 9px; 
            font-weight: bold;
            width: 30%;
        }

        .value {
            color: #002B49;
            font-weight: bold;
            width: 70%;
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 8px;
            color: #aaa;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INTERNSHIP APPLICATION FORM</h1>
        <p>FIBRECOMM NETWORK SDN BHD</p>
    </div>

    <div class="section">Personal Information</div>
    <table>
        <tr>
            <td class="label">Full Name</td>
            <td class="value">{{ $applicant->full_name }}</td>
        </tr>
        <tr>
            <td class="label">Email Address</td>
            <td class="value">{{ $applicant->email }}</td>
        </tr>
        <tr>
            <td class="label">Phone Number</td>
            <td class="value">{{ $applicant->phone }}</td>
        </tr>
        <tr>
            <td class="label">Permanent Address</td>
            <td class="value">{{ $applicant->address }}</td>
        </tr>
    </table>

    <div class="section">Academic Details</div>
    <table>
        <tr>
            <td class="label">Institution</td>
            <td class="value">{{ $applicant->institution }}</td>
        </tr>
        <tr>
            <td class="label">Major / Course of Study</td>
            <td class="value">{{ $applicant->major }}</td>
        </tr>
        <tr>
            <td class="label">Study Level</td>
            <td class="value">{{ $applicant->study_level }}</td>
        </tr>
    </table>

    <div class="section">Internship Request</div>
    <table>
        <tr>
            <td class="label">Proposed Start Date</td>
            <td class="value">{{ $applicant->start_date }}</td>
        </tr>
        <tr>
            <td class="label">Duration</td>
            <td class="value">{{ $applicant->duration }} Months</td>
        </tr>
        <tr>
            <td class="label">Area of Interest</td>
            <td class="value">{{ $applicant->interest }}</td>
        </tr>
    </table>

    <div class="footer">
        Generated via Fibrecomm Network - Trainee Management System &bull; {{ date('Y-m-d H:i:s') }}
    </div>
</body>
</html>