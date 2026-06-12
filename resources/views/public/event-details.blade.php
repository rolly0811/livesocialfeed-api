<!DOCTYPE html>
<html lang="en">
<head>
    <meta property="og:title" content="{{ $subscription->event_code }}">
    <meta property="og:description" content="Live Social Feed">
    <meta property="og:image" content="https://livesocialfeed.com/uploads/subscriptions/{{ $subscription->id }}/{{ $subscription->banner }}">
    <meta property="og:image:width" content="1200" />
    <meta property="og:url" content="https://livesocialfeed.com/view-event/{{$subscription->event_code}}" />
    <meta property="og:image:height" content="630">
    <meta property="og:type" content="website">
    <title>Live Social Feed</title>
</head>
<body>
    <script>
        window.location.href = "https://livesocialfeed.com/ui/#/{{$subscription->event_code}}/post";
    </script>
</body>
</html>