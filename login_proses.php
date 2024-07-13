<?php
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Caesar Cipher Encryption
function caesar_encrypt($text, $shift)
{
    $result = '';
    $shift = $shift % 26; // Shift should be within the range of 0-25

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (ctype_upper($char)) {
            $result .= chr((ord($char) + $shift - 65) % 26 + 65);
        } else {
            $result .= chr((ord($char) + $shift - 97) % 26 + 97);
        }
    }

    return $result;
}

// AES Decryption
function aes_decrypt($data, $key)
{
    $method = 'AES-256-CBC';
    $key = substr(hash('sha256', $key, true), 0, 32);
    $data = base64_decode($data);
    $iv = substr($data, 0, 16);
    $encrypted = substr($data, 16);

    return openssl_decrypt($encrypted, $method, $key, OPENSSL_RAW_DATA, $iv);
}

// Use a predetermined AES key
$aes_key = 'dikporasma'; // 32 character key for AES-256

$cek = mysqli_query($connect, "SELECT * FROM admin WHERE username='$username'");

if (mysqli_num_rows($cek) > 0) {
    $row = mysqli_fetch_assoc($cek);
    $stored_encrypted_password = $row['password'];

    // Decrypt stored password
    $decrypted_stored_password = aes_decrypt($stored_encrypted_password, $aes_key);

    // Encrypt input password using the same method
    $caesar_encrypted_password = caesar_encrypt($password, 3); // Use the same shift used during encryption

    if ($decrypted_stored_password === $caesar_encrypted_password) {
        // Password match
        header("location: data.php?message=login_berhasil");
        // print($username);
        // print("\n");
        // print($decrypted_stored_password);
        // print("\n");
        // print($caesar_encrypted_password);
    } else {
        // Password does not match
        header("location: login.php?message=login_gagal");
        // print($username);
        // print("\n");
        // print($decrypted_stored_password);
        // print("\n");
        // print($caesar_encrypted_password);
    }
} else {
    // Username not found
    header("location: login.php?message=login_gagal");
    // print($username);
    // print("\n");
    // print($decrypted_stored_password);
    // print("\n");
    // print($caesar_encrypted_password);
}