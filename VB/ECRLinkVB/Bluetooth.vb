Imports InTheHand.Net.Sockets
Imports InTheHand.Net.Bluetooth
Imports System.Text
Imports System.Threading

Class BluetoothHost

    Public Function Main()
        ' Define a unique UUID for the service
        Dim serviceUuid As New Guid("8ce255c0200a11e0ac640800200c9a66") ' SPP (Serial Port Profile)
        Dim listener As New BluetoothListener(serviceUuid)

        listener.Start()
        Console.WriteLine("Bluetooth host started. Waiting for connection...")

        ' Accept incoming connection (blocking)
        Dim client As BluetoothClient = listener.AcceptBluetoothClient()
        Console.WriteLine("Client connected!")
        Dim stream = client.GetStream()



        ' send a Message
        Dim sendData As String = New JsonEncrypt().encryptSale
        Dim sendBytes As Byte() = Encoding.UTF8.GetBytes(sendData)
        stream.Write(sendBytes, 0, sendBytes.Length)

        ' Read from client

        Dim buffer(1024) As Byte
        Dim bytesRead As Integer = stream.Read(buffer, 0, buffer.Length)
        Dim receivedMessage As String = Encoding.UTF8.GetString(buffer, 0, bytesRead)

        Console.WriteLine("Received: " & receivedMessage)

        ' Close connection
        stream.Close()
        client.Close()
        listener.Stop()
        Console.WriteLine("Connection closed.")
    End Function

End Class
