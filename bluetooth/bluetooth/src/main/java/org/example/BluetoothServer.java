package org.example;

import javax.bluetooth.BluetoothStateException;
import javax.bluetooth.LocalDevice;
import javax.bluetooth.UUID;
import javax.microedition.io.Connector;
import javax.microedition.io.StreamConnection;
import javax.microedition.io.StreamConnectionNotifier;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.Scanner;

public class BluetoothServer {

    public static void main(String[] args) {
        try {
            LocalDevice localDevice = LocalDevice.getLocalDevice();
            System.out.println("Local Bluetooth Address: " + localDevice.getBluetoothAddress());
            System.out.println("Local Device Name: " + localDevice.getFriendlyName());

            // Create a UUID for the service (you can use a different one)
            UUID uuid = new UUID("8ce255c0200a11e0ac640800200c9a66", false);

            // Create a server and start listening for connections
            String url = "btspp://localhost:" + uuid + ";name=BluetoothServer";
            StreamConnectionNotifier server = (StreamConnectionNotifier) Connector.open(url);
            System.out.println("Waiting for connection...");

            StreamConnection connection = server.acceptAndOpen();
            System.out.println("Connected to client.");

            // Get input and output streams for data transfer
            InputStream inputStream = connection.openInputStream();
            OutputStream outputStream = connection.openOutputStream();

            // Receive and send data
            byte[] buffer = new byte[1024];
            int bytesRead;

            Boolean isReading = false;
            while (true) {
                if(isReading) {
                    bytesRead = inputStream.read(buffer);
                    if (bytesRead > 0) {
                        String receivedData = new String(buffer, 0, bytesRead);
                        System.out.println("Received: " + receivedData);
                        // Echo back the received data
                        outputStream.write(buffer, 0, bytesRead);
                        outputStream.flush();
                        isReading = false;
                    }
                }
                else{
                    isReading = true;
                    Scanner obj = new Scanner(System.in);
                    System.out.println("Input");
                    String text = obj.nextLine();
                    outputStream.write(text.getBytes(), 0, text.getBytes().length);
                }
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}