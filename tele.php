<?php
$botToken1 = 'YOUR_BOT_TOKEN'; // Replace with your Bot 1 token
$botToken2 = 'YOUR_BOT2_TOKEN'; // Replace with your Bot 2 token

// Get the incoming update as JSON
$update = file_get_contents('php://input');

if ($update) {
    // Forward the update to Bot 2
    $url = "https://api.telegram.org/bot$botToken2/sendMessage";
    $data = [
        'chat_id' => 'CHAT_ID_OF_BOT2',  // Replace with the chat ID where you want to forward the message
        'text' => $update
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
}

// Set up the webhook URL for Bot 1
if (isset($_GET['set_webhook'])) {
    $webhookURL = 'https://your-cpanel-url/tele.php';  // Replace with the actual URL of this script
    $setWebhookURL = "https://api.telegram.org/bot$botToken1/setWebhook?url=$webhookURL";
    $response = file_get_contents($setWebhookURL);
    echo 'Webhook set up: ' . $response;
}

