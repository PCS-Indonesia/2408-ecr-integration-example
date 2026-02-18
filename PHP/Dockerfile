# Multi-stage Dockerfile for ECR Integration Example

# Stage 1: SerialUSB
FROM php:8.2-cli AS serialusb
WORKDIR /app
COPY PHP/SerialUSB/SerialUSB.php /app/

# Stage 2: Bluetooth
FROM php:8.2-cli AS bluetooth
RUN apt-get update && apt-get install -y \
    bluez \
    libbluetooth-dev \
    && rm -rf /var/lib/apt/lists/*
WORKDIR /app
COPY PHP/bluetooth/BluetoothServer.php /app/

# Stage 3: ECR Encrypt (default)
FROM php:8.2-cli AS ecr-encrypt
WORKDIR /app
COPY PHP/ecr_encrypt/Main.php /app/
COPY PHP/ecr_encrypt/Security.php /app/
CMD ["php", "Main.php"]
