# PHP WSS Client Certificate Example

This project demonstrates how to create a secure WebSocket (WSS) client in PHP that authenticates using a client-side certificate.

## Features
- Uses the modern and maintained `phrity/websocket` library.
- Demonstrates SSL/TLS context configuration for client-side certificates.
- Robust error handling for connection and protocol issues.

## Prerequisites
- PHP 8.1 or higher.
- [Composer](https://getcomposer.org/) installed.

## Setup
1. **Install Dependencies:**
   ```bash
   composer install
   ```

2. **Add your Certificate:**
   Place your `client.pem` file in the `certificates/` directory.
   
   If you have a .pfx file, you can convert it to a .pem file using OpenSSL:
   ```bash
   openssl pkcs12 -in certificates/client.pfx -out certificates/client.pem -nodes -passin pass:<your-password>
   ```

3. **Configure:**
   Open `wss_client.php` and update the `$wss_url` and `$cert_path` variables to match your environment.

## Running the Example
```bash
php wss_client.php
```

## Troubleshooting
If you encounter SSL handshake errors:
- Ensure `verify_peer` is appropriately set in `wss_client.php`.
- Check if your certificate includes both the certificate and the private key (`cat cert.pem key.pem > client.pem`).
- Verify that the target server supports the SSL/TLS version and cipher suites provided by your PHP installation.
