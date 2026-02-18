# Certificates Directory

Place your `.pem` certificates here for the WSS client.

## Example: Generating a Self-Signed Certificate for testing
If you need to generate a self-signed certificate for testing purposes, you can use OpenSSL:

```bash
openssl req -x509 -newkey rsa:4096 -keyout key.pem -out cert.pem -days 365 -nodes
cat cert.pem key.pem > client.pem
```

Then update `wss_client.php` to point to `client.pem`.
