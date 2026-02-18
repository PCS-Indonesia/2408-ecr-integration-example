# ECR Integration Example - PHP

This repository contains PHP implementations for ECR (Electronic Cash Register) integration examples.

## Components

### 1. SerialUSB
Serial USB communication implementation for ECR devices.

**Features:**
- Auto-detect USB-to-Serial devices
- Configure serial port settings (115200 baud, 8 data bits, 1 stop bit, no parity)
- Send and receive data via serial communication

**Usage:**
```bash
cd PHP/SerialUSB
php SerialUSB.php
```

**Docker:**
```bash
cd PHP/SerialUSB
docker build -t ecr-serialusb .
docker run --device=/dev/ttyUSB0 -it ecr-serialusb
```

### 2. Bluetooth
Bluetooth RFCOMM server for wireless ECR communication.

**Features:**
- Create Bluetooth RFCOMM server
- Accept client connections
- Bidirectional data exchange

**Usage:**
```bash
cd PHP/bluetooth
php BluetoothServer.php
```

**Docker:**
```bash
cd PHP/bluetooth
docker build -t ecr-bluetooth .
docker run --privileged --network host -it ecr-bluetooth
```

### 3. ECR Encrypt
Encryption utilities for secure ECR transaction data.

**Features:**
- AES-128-ECB encryption
- SHA-1 key derivation
- Base64 encoding
- Transaction JSON formatting

**Supported Transactions:**
- Sale (Standard, QRIS, Purchase, Brizzi)
- Void (QRIS, Purchase, Brizzi)
- Reprint (Last, Any)
- Settlement
- Check Status

**Usage:**
```bash
cd PHP/ecr_encrypt
php Main.php
```

**Docker:**
```bash
cd PHP/ecr_encrypt
docker build -t ecr-encrypt .
docker run ecr-encrypt
```

## Requirements

- PHP 8.2 or higher
- For SerialUSB: Access to serial devices
- For Bluetooth: Bluetooth adapter and bluez library
- Docker (optional)

## Security Note

The encryption key "ECR2022secretKey" is hardcoded for demonstration purposes. In production, use secure key management practices.
