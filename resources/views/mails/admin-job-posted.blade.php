<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Job Posted</title>
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
            font-size: 24px;
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
            margin-bottom: 20px;
        }
        .highlight {
            background-color: #fdf3e7;
            padding: 15px;
            border-left: 4px solid #f48024;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            🚀 New Job Posted
        </div>
        <div class="email-body">
            <div class="highlight">
                A new job has just been posted by a customer. Details are below.
            </div>

            <div class="value"><span class="label">Title:</span> {{ $jobPost->title }}</div>
            <div class="value"><span class="label">Description:</span> {{ $jobPost->description }}</div>
            <div class="value"><span class="label">Urgency:</span> {{ ucfirst($jobPost->urgency) }}</div>
            <div class="value"><span class="label">Location:</span> {{ ucfirst($jobPost->location->location) }}</div>

            <hr style="margin: 30px 0; border: none; border-top: 1px solid #e1e4e8;">

            <h3 style="margin-bottom: 10px;">👤 Posted By</h3>
            <div class="value">
                {{ $jobPost->customer->user->first_name }} {{ $jobPost->customer->user->last_name }}<br>
                <a href="mailto:{{ $jobPost->customer->user->email }}">{{ $jobPost->customer->user->email }}</a>
            </div>
        </div>
        <div class="email-footer">
            You're receiving this notification because you're an admin on {{ config('app.name') }}.
        </div>
    </div>
</body>
</html>
