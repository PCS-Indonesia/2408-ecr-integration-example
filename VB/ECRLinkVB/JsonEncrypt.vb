Imports System.Text.Json.Nodes

Public Class JsonEncrypt

    Public Function encryptSale() As String
        Dim aes = New AESHelper().Encrypt(jsonSale(""))
        Return aes
    End Function

    Public Function jsonSale(method As String) As String
        Dim json = New JsonObject()
        json.Add("amount", "1")
        json.Add("action", "Sale")
        json.Add("trx_id", "trx_id")
        json.Add("pos_address", "172.0.0.1")
        json.Add("time_stamp", DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss"))
        If String.IsNullOrEmpty(method) Then
            json.Add("method", method)
        End If
        Return json.ToString
    End Function
End Class
