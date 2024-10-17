<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alert - Campaign Monitoring</title>
</head>
<body>
    <div style="width: 100%; min-height: 100vh; text-align: center;">
        <h3 style="color: black;">Low Acquisitions for Campaign: 
            <span style="color: blue;">{{ $campaign->name }}</span> from source <span style="color: blue;">{{ $campaign->source }}</span> 
        </h3>
        <p style="color: black;">The Acquisitions for this campaign are below the defined threshold.</p>
        <p style="color: black;">Total Acquisitions in the last 5 Minutes: <strong>{{ $userCount }}</strong></p>
        <p style="color: black;">Threshold Defined: <strong>{{ $campaign->threshold }}</strong></p>
        <a href="" style="background-color: #2575fc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 13px;">Analyse Campaign</a>
    </div>
</body>
</html>
