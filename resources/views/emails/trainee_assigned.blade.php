<h2>Hello, {{ $trainee->name }}!</h2>
<p>You have been assigned to a supervisor for your internship at Fibrecomm.</p>
<p><strong>Supervisor:</strong> {{ $supervisor->name }}</p>
<p><strong>Department:</strong> {{ $supervisor->department ?? 'General' }}</p>
<p>You can now start submitting your attendance for approval.</p>