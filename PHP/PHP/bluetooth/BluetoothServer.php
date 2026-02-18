<?php

class BluetoothServer {
    private $socket = null;
    private $clientSocket = null;
    
    public function run() {
        try {
            // Get local Bluetooth device info
            $address = $this->getLocalBluetoothAddress();
            $name = $this->getLocalDeviceName();
            
            echo "Local Bluetooth Address: " . $address . "\n";
            echo "Local Device Name: " . $name . "\n";
            
            // Create RFCOMM socket
            $this->socket = socket_create(AF_BLUETOOTH, SOCK_STREAM, BTPROTO_RFCOMM);
            
            if (!$this->socket) {
                throw new Exception("Failed to create socket");
            }
            
            // Bind to any local adapter
            socket_bind($this->socket, BDADDR_ANY, 1);
            socket_listen($this->socket);
            
            echo "Waiting for connection...\n";
            
            $this->clientSocket = socket_accept($this->socket);
            
            if (!$this->clientSocket) {
                throw new Exception("Failed to accept connection");
            }
            
            echo "Connected to client.\n";
            
            $isReading = false;
            
            while (true) {
                if ($isReading) {
                    $buffer = socket_read($this->clientSocket, 1024);
                    if ($buffer !== false && strlen($buffer) > 0) {
                        echo "Received: " . $buffer . "\n";
                        // Echo back the received data
                        socket_write($this->clientSocket, $buffer);
                        $isReading = false;
                    }
                } else {
                    $isReading = true;
                    echo "Input: ";
                    $text = trim(fgets(STDIN));
                    socket_write($this->clientSocket, $text);
                }
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        } finally {
            if ($this->clientSocket) {
                socket_close($this->clientSocket);
            }
            if ($this->socket) {
                socket_close($this->socket);
            }
        }
    }
    
    private function getLocalBluetoothAddress() {
        $output = shell_exec("hciconfig hci0 2>/dev/null | grep 'BD Address' | awk '{print $3}'");
        return trim($output ?: "00:00:00:00:00:00");
    }
    
    private function getLocalDeviceName() {
        $output = shell_exec("hostname 2>/dev/null");
        return trim($output ?: "Unknown");
    }
}

$server = new BluetoothServer();
$server->run();
