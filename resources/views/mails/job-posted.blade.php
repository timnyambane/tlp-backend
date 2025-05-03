<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Posted Confirmation</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen,
                Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: #f3f3f3;
            color: #2d2d2d;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border: 1px solid #e1e4e8;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }
        .email-header {
            background-color: #f48024;
            color: white;
            padding: 20px;
            font-size: 22px;
            font-weight: bold;
        }
        .email-body {
            padding: 30px;
        }
        .email-footer {
            background-color: #fafafa;
            color: #6a737c;
            font-size: 12px;
            text-align: center;
            padding: 20px;
        }
        .label {
            font-weight: bold;
            color: #333;
        }
        .value {
            margin-bottom: 16px;
        }
        .highlight {
            background-color: #fdf3e7;
            padding: 15px;
            border-left: 4px solid #f48024;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        a.button {
            display: inline-block;
            margin-top: 20px;
            background-color: #f48024;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            ✅ Your Job Has Been Posted
        </div>
        <div class="email-body">
            <p>Hi {{ $jobPost->customer->user->first_name }},</p>

            <div class="highlight">
                Thanks for posting your job! Our team and service providers will be reviewing it shortly.
            </div>

            <div class="value"><span class="label">Title:</span> {{ $jobPost->title }}</div>
            <div class="value"><span class="label">Description:</span> {{ $jobPost->description }}</div>
            <div class="value"><span class="label">Urgency:</span> {{ ucfirst($jobPost->urgency) }}</div>

            @if($jobPost->specific_date)
                <div class="value"><span class="label">Preferred Date:</span> {{ \Carbon\Carbon::parse($jobPost->specific_date)->format('F j, Y') }}</div>
            @endif

            <a href="{{ url('/job-posts/' . $jobPost->id) }}" class="button">
                View Your Job
            </a>
        </div>
        <div class="email-footer">
            Thanks for using {{ config('app.name') }}. You’ll be notified when a service provider responds.
        </div>
    </div>
</body>
</html>
