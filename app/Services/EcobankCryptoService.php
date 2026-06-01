<?php

namespace App\Services;

class EcobankCryptoService
{
    protected string $key;

    public function __construct()
    {

        $this->key1 = config('services.ecobank.pin');
    }

    public function encrypt(array $payload): string
    {
        $plaintext = json_encode($payload);

        $salt = random_bytes(16);

        $iv = random_bytes(12);

        $key = hash_pbkdf2(
            'sha256',
            config('services.ecobank.pin'),
            // "123456",
            $salt,
            53389,
            32,
            true
        );

        $tag = '';

        $ciphertext = openssl_encrypt(
            $plaintext,
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        if ($ciphertext === false) {
            throw new \Exception('Encryption failed');
        }

        return base64_encode(
            $iv .
            $salt .
            $ciphertext .
            $tag
        );
    }

    public function decrypt(string $encrypted)
    {
        // $decoded = base64_decode($encrypted);
        $decoded = base64_decode(
            $encrypted,
            true
        );

        if ($decoded === false) {
            throw new \Exception('Invalid base64');
        }

        if (strlen($decoded) < 44) {
            throw new \Exception(
                'Encrypted payload too short'
            );
        }

        $iv = substr($decoded, 0, 12);

        $salt = substr($decoded, 12, 16);

        $ciphertextWithTag = substr($decoded, 28);

        $tag = substr(
            $ciphertextWithTag,
            -16
        );

        $ciphertext = substr(
            $ciphertextWithTag,
            0,
            -16
        );

        $key = hash_pbkdf2(
            'sha256',
            config('services.ecobank.pin'),
            // "123456",
            $salt,
            53389,
            32,
            true
        );

        $plaintext = openssl_decrypt(
            $ciphertext,
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        return json_decode(
            $plaintext,
            true
        );
    }
}