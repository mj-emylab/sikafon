<?php

namespace App\Services;

class EcobankCryptoService
{
    protected string $key;

    public function __construct()
    {
        $this->key = hash(
            'sha256',
            env('ECOBANK_PIN'),
            true
        );
    }

    public function encrypt(array $payload): string
    {
        $plaintext = json_encode($payload);

        $iv = random_bytes(12);

        $tag = '';

        $ciphertext = openssl_encrypt(
            $plaintext,
            'aes-256-gcm',
            $this->key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        if ($ciphertext === false) {
            throw new \Exception(
                'Encryption failed'
            );
        }

        return base64_encode(
            $iv .
            $tag .
            $ciphertext
        );
    }

    public function decrypt(
        string $encryptedText
    ): array {

        $decoded = base64_decode(
            $encryptedText,
            true
        );

        if ($decoded === false) {
            throw new \Exception(
                'Invalid base64 response'
            );
        }

        $iv = substr($decoded, 0, 12);

        $tag = substr($decoded, 12, 16);

        $ciphertext = substr($decoded, 28);

        $plaintext = openssl_decrypt(
            $ciphertext,
            'aes-256-gcm',
            $this->key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        if ($plaintext === false) {
            throw new \Exception(
                'Decryption failed'
            );
        }

        $json = json_decode(
            $plaintext,
            true
        );

        if (!is_array($json)) {
            throw new \Exception(
                'Invalid decrypted JSON'
            );
        }

        return $json;
    }
}