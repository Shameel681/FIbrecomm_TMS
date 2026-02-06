<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Trainee Attendance Records</title>
    <style>
        @page { margin: 30px 25px; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 10px; }
        .header-title {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
        }
        .small-text {
            font-size: 9px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 0.6px solid #000;
            padding: 3px 4px;
        }
        th {
            text-transform: uppercase;
            font-size: 8px;
            background: #f5f5f5;
        }
        .center { text-align: center; }
        .right { text-align: right; }
        .signature-row td {
            border-top: none;
            border-left: none;
            border-right: none;
        }
    </style>
</head>
<body>

    <table style="margin-bottom: 5px;">
        <tr>
            <td class="header-title">FIBRECOMM NETWORK (M) SDN. BHD.</td>
        </tr>
        <tr>
            <td class="header-title">TRAINEE'S ATTENDANCE RECORDS</td>
        </tr>
    </table>

    <table style="margin-bottom: 5px;">
        <tr>
            <td class="small-text">NAME: <strong>{{ $trainee->name }}</strong></td>
            <td class="small-text right">MONTH: <strong>{{ $selectedDate->format('F Y') }}</strong></td>
        </tr>
        <tr>
            <td class="small-text">DEPARTMENT: ____________________________</td>
            <td class="small-text right">SUPERVISOR: <strong>{{ $trainee->supervisor->name ?? 'N/A' }}</strong></td>
        </tr>
        <tr>
            <td class="small-text">
                BANK: 
                <strong>{{ $trainee->bank_name ?? '________________' }}</strong>
            </td>
            <td class="small-text right">
                ACCOUNT NO: 
                <strong>{{ $trainee->account_number ?? '________________' }}</strong>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No.</th>
                <th style="width: 18%;">Date</th>
                <th style="width: 14%;">Time In</th>
                <th style="width: 18%;">SV Signature</th>
                <th>Remarks / Task / Activity</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach($records as $record)
                <tr>
                    <td class="center">{{ $i++ }}</td>
                    <td class="center">{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
                    <td class="center">
                        {{ $record->clock_in ? \Carbon\Carbon::parse($record->clock_in)->format('h:i A') : '-' }}
                    </td>
                    <td class="center">
                        {{-- Place for supervisor initials / signature --}}
                    </td>
                    <td>
                        {{ $record->trainee_remark ?? '_________________________________________' }}
                    </td>
                </tr>
            @endforeach

            {{-- Fill remaining rows up to 31 for consistent layout --}}
            @for($row = $i; $row <= 31; $row++)
                <tr>
                    <td class="center">{{ $row }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            @endfor
        </tbody>
    </table>

    @php
        $workingDays = $records->where('status','approved')->count();
        $rate = isset($allowanceRate) ? (float) $allowanceRate : 30;
        $totalAllowance = $workingDays * $rate;
    @endphp
    <table style="margin-top: 8px;">
        <tr>
            <td class="small-text">
                No. of working days: <strong>{{ $workingDays }}</strong><br>
                Allowance rate per day: <strong>RM {{ number_format($rate, 2) }}</strong><br>
                Total allowance for month: <strong>RM {{ number_format($totalAllowance, 2) }}</strong>
            </td>
            <td class="small-text right">
                Verified by HR: ______________________
            </td>
        </tr>
    </table>

    <table style="margin-top: 25px;">
        <tr>
            <td class="center small-text">
                ________________________________<br>
                ({{ $trainee->name }})<br>
                Trainee
            </td>
            <td class="center small-text">
                ________________________________<br>
                ({{ $trainee->supervisor->name ?? '________________' }})<br>
                Supervisor
            </td>
        </tr>
    </table>

</body>
</html>

