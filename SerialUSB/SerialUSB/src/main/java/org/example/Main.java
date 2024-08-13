package org.example;

import com.fazecast.jSerialComm.SerialPort;

import java.util.Scanner;

public class Main {
    private static SerialPort spUSB = null;
    private static String messageSend = "";
    private static boolean isListening = true;
    private static String messageGet = "";
    public static void main(String[] args) {
        System.out.println("Hello world!");
        SerialPort[] arrSp = SerialPort.getCommPorts();
        boolean foundUSB = false;
        for(int i = 0; i < arrSp.length; i++){
            SerialPort sp = arrSp[i];
            if(sp.getDescriptivePortName().contains("USB-to-Serial")){
                foundUSB = true;
                spUSB = sp;
            }
        }
        if(foundUSB){
            System.out.println("USB Found");
            System.out.println(spUSB.getSystemPortName());
            System.out.println(spUSB.getDescriptivePortName());
            setSettingUSB();
            writeToCom();
            communicateUSB();
        }

    }

    private static void writeToCom() {
        Scanner obj = new Scanner(System.in);
        System.out.println("Input");
        messageSend = obj.nextLine();
    }

    private static void communicateUSB() {
        System.out.println("Opening Com");
        spUSB.openPort();
        try {
            System.out.println("Opening Com Success");
            System.out.println("Try Sending Data");
            spUSB.writeBytes(messageSend.getBytes(), messageSend.getBytes().length);

            while (isListening)
            {
                while (spUSB.bytesAvailable() == 0)
                    Thread.sleep(20);
                byte[] readBuffer = new byte[spUSB.bytesAvailable()];
                int numRead = spUSB.readBytes(readBuffer, readBuffer.length);
                System.out.println("Read " + numRead + " bytes.");
                messageGet = messageGet + new String(readBuffer, 0, numRead);
                if (messageGet.endsWith("\n")){
                    isListening = false;
                    System.out.println("Read "+ messageGet);
                    System.out.println("Closing com");
                    spUSB.closePort();
                }
            }
        }
        catch (Exception e) { e.printStackTrace(); }
    }

    private static void setSettingUSB() {
        spUSB.setBaudRate(115200);
        spUSB.setNumDataBits(8);
        spUSB.setNumStopBits(1);
        spUSB.setParity(0);
        System.out.println("Set Setting USB Done");

    }
}