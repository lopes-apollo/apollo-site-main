<?php
// Quick script to generate password hash
$password = 'apollo2026!';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "<h1>Password Hash Generator</h1>";
echo "<p>Password: <strong>$password</strong></p>";
echo "<p>Hash: <strong>$hash</strong></p>";
echo "<p>Copy this hash to admin/config.php</p>";
echo "<hr>";
echo "<p>To verify: " . (password_verify($password, $hash) ? "✅ Hash is correct!" : "❌ Hash is incorrect");
?>
