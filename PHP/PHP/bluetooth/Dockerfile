FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    bluez \
    libbluetooth-dev \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY BluetoothServer.php /app/

CMD ["php", "BluetoothServer.php"]
