<?php

class SerialUSB {
    private $port = null;
    private $messageSend = "";
    private $isListening = true;
    private $messageGet = "";
    
    public function run() {
        echo "Hello world!\n";
        
        // Find USB-to-Serial port
        $foundUSB = $this->findUSBPort();
        
        if ($foundUSB) {
            echo "USB Found\n";
            echo $this->port . "\n";
            $this->setSettingUSB();
            $this->writeToCom();
            $this->communicateUSB();
        }
    }
    
    private function findUSBPort() {
        // On Linux, serial ports are typically /dev/ttyUSB* or /dev/ttyACM*
        $ports = glob('/dev/ttyUSB*');
        if (empty($ports)) {
            $ports = glob('/dev/ttyACM*');
        }
        
        if (!empty($ports)) {
            $this->port = $ports[0];
            return true;
        }
        return false;
    }
    
    private function writeToCom() {
        echo "Input: ";
        $this->messageSend = trim(fgets(STDIN));
    }
    
    private function communicateUSB() {
        echo "Opening Com\n";
        
        // Configure serial port using stty
        exec("stty -F {$this->port} 115200 cs8 -cstopb -parenb");
        
        $handle = fopen($this->port, "r+");
        
        if ($handle) {
            echo "Opening Com Success\n";
            echo "Try Sending Data\n";
            
            fwrite($handle, $this->messageSend);
            fflush($handle);
            
            while ($this->isListening) {
                $data = fread($handle, 1024);
                if ($data !== false && strlen($data) > 0) {
                    echo "Read " . strlen($data) . " bytes.\n";
                    $this->messageGet .= $data;
                    
                    if (substr($this->messageGet, -1) === "\n") {
                        $this->isListening = false;
                        echo "Read " . $this->messageGet;
                        echo "Closing com\n";
                        fclose($handle);
                    }
                } else {
                    usleep(20000); // Sleep 20ms
                }
            }
        }
    }
    
    private function setSettingUSB() {
        // Settings applied via stty in communicateUSB
        echo "Set Setting USB Done\n";
    }
}

$serial = new SerialUSB();
$serial->run();
