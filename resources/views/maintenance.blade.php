<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="{{ $retryAfter ?? 60 }}">
    <title>Maintenance Mode</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        .container {
            text-align: center;
            background: #fff;
            padding: 60px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            max-width: 480px;
            width: 90%;
        }
        .icon {
            font-size: 64px;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #1a202c;
        }
        p {
            font-size: 16px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 8px;
        }
        .retry {
            margin-top: 24px;
            font-size: 13px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">🔧</div>
        <h1>Under Maintenance</h1>
        <p>{{ $message ?? 'The API is temporarily unavailable.' }}</p>
        <p>We are working hard to get things back up. Please try again shortly.</p>
        @if(isset($retryAfter))
            <p class="retry">Retry in {{ $retryAfter }} seconds.</p>
        @endif
    </div>
</body>
</html>
