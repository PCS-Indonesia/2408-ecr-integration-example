Imports System.Security.Cryptography
Imports System.Text
Imports System.IO

Public Class AESHelper
    Private aes As Aes

    Public Sub New()
        aes = Aes.Create()
        aes.Mode = CipherMode.ECB
        aes.Padding = PaddingMode.PKCS7
    End Sub

    ' Derives a 128-bit AES key from a password using SHA-1
    Public Sub SetKey()
        Try
            Dim password = "ECR2022secretKey"
            Dim keyBytes As Byte() = Encoding.UTF8.GetBytes(password)

            ' Hash the password with SHA-1
            Using sha1 As SHA1 = SHA1.Create()
                keyBytes = sha1.ComputeHash(keyBytes)
            End Using

            ' Resize to 16 bytes (AES-128)
            Array.Resize(keyBytes, 16)

            aes.Key = keyBytes

            ' Set a fixed IV for simplicity, or generate a random one per message
            aes.IV = New Byte(15) {} ' 16 zero bytes (not secure for real-world use!)
        Catch ex As Exception
            Console.WriteLine("Error setting key: " & ex.Message)
        End Try
    End Sub

    ' Encrypts a plain text string and returns base64-encoded ciphertext
    Public Function Encrypt(plainText As String) As String
        Try
            SetKey()
            Dim plainBytes As Byte() = Encoding.UTF8.GetBytes(plainText)
            Using encryptor = aes.CreateEncryptor()
                Dim cipherBytes As Byte() = encryptor.TransformFinalBlock(plainBytes, 0, plainBytes.Length)
                Return Convert.ToBase64String(cipherBytes)
            End Using
        Catch ex As Exception
            Console.WriteLine("Encryption error: " & ex.Message)
            Return Nothing
        End Try
    End Function

    ' Decrypts a base64-encoded string back to plain text
    Public Function Decrypt(cipherText As String) As String
        Try
            SetKey()
            Dim cipherBytes As Byte() = Convert.FromBase64String(cipherText)
            Using decryptor = aes.CreateDecryptor()
                Dim plainBytes As Byte() = decryptor.TransformFinalBlock(cipherBytes, 0, cipherBytes.Length)
                Return Encoding.UTF8.GetString(plainBytes)
            End Using
        Catch ex As Exception
            Console.WriteLine("Decryption error: " & ex.Message)
            Return Nothing
        End Try
    End Function
End Class
