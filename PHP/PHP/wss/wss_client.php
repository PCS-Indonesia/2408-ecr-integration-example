<?php

require __DIR__ . '/vendor/autoload.php';

use WebSocket\Client;
use Phrity\Net\Context;

/**
 * Modern PHP WSS Client Example with Certificate Authentication
 * 
 * This example uses the 'phrity/websocket' library, which is the 
 * maintained successor to the archived 'textalk/websocket'.
 */

// 1. Configuration
$wss_url = "wss://192.168.1.23:6047"; // Replace with your target WSS endpoint
$cert_path = __DIR__ . '/certificates/pcsindonesia.pem'; // Path to your PEM certificate
$cert_passphrase = 'tanyaale'; // Passphrase if your cert is encrypted

// 2. Setup SSL Context
// We use Phrity\Net\Context for a more structured approach than raw stream_context_create
$context = new Context();
$context->setOption('ssl', 'local_cert', $cert_path);

// If your certificate has a passphrase, set it here
if ($cert_passphrase) {
    $context->setOption('ssl', 'passphrase', $cert_passphrase);
}

// Additional SSL settings (adjust for your security requirements)
$context->setOption('ssl', 'verify_peer', true);
$context->setOption('ssl', 'allow_self_signed', false);

// 3. Initialize WebSocket Client
$client = new Client($wss_url);
$client->setContext($context);
$client->setTimeout(30);

echo "--- WSS Client Started ---\n";
echo "Connecting to: {$wss_url}\n";
echo "Using certificate: {$cert_path}\n\n";

try {
    // The connection is established on the first send() or receive() call
    echo "Sending ping message...\n";
    $client->text("Hello from PHP WSS Client with Cert!");

    echo "Waiting for response...\n";
    $message = $client->receive();

    echo "Received from server: " . $message->getContent() . "\n";

    // Gracefully close
    $client->close();
    echo "\nConnection closed successfully.\n";

} catch (\WebSocket\Exception\ClientException $e) {
    echo "Connection Error: " . $e->getMessage() . "\n";
    echo "Tip: Ensure your certificate matches the server's requirements and the URL is correct.\n";
} catch (\Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
}
