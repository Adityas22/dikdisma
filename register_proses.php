<?php
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Caesar Cipher Encryption
function caesar_encrypt($text, $shift) {
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

// AES Encryption
function aes_encrypt($data, $key) {
    $method = 'AES-256-CBC';
    $key = substr(hash('sha256', $key, true), 0, 32);
    $iv = openssl_random_pseudo_bytes(16); // Generate a random IV

    $encrypted = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encrypted); // Combine IV and encrypted data, then encode with base64
}

// Use a predetermined AES key
$aes_key = 'dikporasmaabcdefghijklnopqrs'; // 32 character key for AES-256

$caesar_shift = 3; // Shift for Caesar Cipher
$caesar_encrypted_password = caesar_encrypt($password, $caesar_shift);

$aes_encrypted_password = aes_encrypt($caesar_encrypted_password, $aes_key);

$cek = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM admin WHERE username='$username'"));

if ($cek > 0) {
    header("location: register.php?message=register_gagal");
} else {
    $sql = "INSERT INTO admin (username, password) VALUES ('$username', '$aes_encrypted_password')";
    $query = mysqli_query($connect, $sql) or die(mysqli_error($connect));
    if ($query) {
        header("location: login.php?message=register_berhasil");
    } else {
        echo "Registration failed: " . mysqli_error($connect);
    }
}
?>