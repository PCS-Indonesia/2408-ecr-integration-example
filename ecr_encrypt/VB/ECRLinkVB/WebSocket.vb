Imports System.Net
Imports System.Net.Security
Imports System.Net.WebSockets
Imports System.Security.Cryptography.X509Certificates
Imports System.Text
Imports System.Text.Json.Nodes
Imports System.Threading

Module WebSocketClient

    Public Function Main()

        Dim certPath As String = "C:\Users\Aldi Megantara\Downloads\pcsindonesia.pfx"
        Dim certPassword As String = "tanyaale"
        Dim clientCertificate As New X509Certificate2(certPath, certPassword, X509KeyStorageFlags.MachineKeySet)



        Dim ws As New ClientWebSocket()
        ws.Options.ClientCertificates = New X509Certificate2Collection()
        ws.Options.ClientCertificates.Add(clientCertificate)
        ws.Options.RemoteCertificateValidationCallback = Function(sender, cert, chain, sslPolicyErrors) True
        Dim encryptSale = New JsonEncrypt().encryptSale
        Dim uri As New Uri("wss://192.168.1.23:6746") ' <-- Port 6746

        ws.ConnectAsync(uri, CancellationToken.None).Wait()

        If ws.State = WebSocketState.Open Then
            Console.WriteLine("Connected to port 6746!")


            ' Send a message once
            Dim message = Encoding.UTF8.GetBytes(encryptSale)
            ws.SendAsync(New ArraySegment(Of Byte)(message), WebSocketMessageType.Text, True, CancellationToken.None).Wait()

            Dim buffer(1024) As Byte

            ' Keep receiving messages in a loop
            While ws.State = WebSocketState.Open
                Try
                    Dim result = ws.ReceiveAsync(New ArraySegment(Of Byte)(buffer), CancellationToken.None).Result

                    If result.MessageType = WebSocketMessageType.Close Then
                        Console.WriteLine("Server requested close. Closing...")
                        ws.CloseAsync(WebSocketCloseStatus.NormalClosure, "Closing", CancellationToken.None).Wait()
                        Exit While
                    End If

                    Dim receivedMessage = Encoding.UTF8.GetString(buffer, 0, result.Count)
                    Console.WriteLine("Received: " & receivedMessage)
                Catch ex As Exception
                    Console.WriteLine("Error receiving data: " & ex.Message)
                    Exit While
                End Try
            End While
        Else
            Console.WriteLine("Failed to connect.")
        End If

        Console.WriteLine("Press Enter to exit.")
        Console.ReadLine()
    End Function

    Private Function AcceptAllCertifications(sender As Object, certificate As X509Certificate, chain As X509Chain, sslPolicyErrors As SslPolicyErrors) As Boolean
        Return True
    End Function



End Module
