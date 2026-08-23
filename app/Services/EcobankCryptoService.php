<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

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
            // "123out456",
            // "ECOa7d931765caa4601#af997dd0f327f602!",
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
            // "ECOa7d931765caa4601#af997dd0f327f602!",
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



    public function decrypt1(string $encrypted)
    {
        // $decoded = base64_decode($encrypted);

        $encrypted = "C2Q37s/nY2twu1TBa/9bBKlcPkpAed0ZnfN5q2rcVErD/06bljIHk40iuM+udsVHRAkjo1mbgLUd33Hdz9GQwS/CqKQC76TyIB7+MOqaMm9VTStjxxjGpNmwjEIPBP0BSJ1dAD05d/iKWVPvddoELiAbAgIMCxwvBtCPaw7b/6hE+7SXY7mWvAzT2Lcof47IUnRJ/TTbUy/pn7a9idJLA+ed+5xfHabGP/Q1XMD1wE4n824iWjhYJPo+VyTTCWm6PyFpZ4n9jmjV2iIvx4X60u/eBmSCvW4lhGL821ovnXxKbu7da35ebOKwe4iTfd5R41dSBBGrvqCGNidOPzoAZl4HxCRF/o5ZyZ5893SB0piVkLVJHk+NIXHlh+KxQMd9xAad/S07+WU8W8CXXfwwOo1RTU0h/rVkh5v97BkI2d36G1usGyZPRwDVzJhRwGoLTIALf1aRBDcVon2OuEYuA/ZZTCORvaM5d1/eZ6slvh9F+qRTkRU4/gmsXyLTHA3t12MVQDvhkqtqt52ez0g9mSkd7Sx8q4s4zeGfAIvOS1fWd7J0Zf1jtVEuzyTAAbWwH5pXU/JQwkxkQLZqNY0IencTwE7DpIHWtHcP9zy20jOGG61HzXDxEnlMNemXDZkGwmoKrh8JxE74nO+R5hKuxQmchgGUGNBM/wq1lRmRsG9j8NOwQNYiFyX0z166rT1dQoUMcWo=";


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
            // "ECOa7d931765caa4601#af997dd0f327f602!",
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


        Log::info('Decrypt Debug', [
            'decoded_length' => strlen($decoded),
            'iv_length' => strlen($iv),
            'salt_length' => strlen($salt),
            'ciphertext_length' => strlen($ciphertext),
            'tag_length' => strlen($tag),
        ]);

        Log::info('Decrypt Debug Key', [
            'key_base64' => base64_encode($key),
        ]);

        Log::info('Decrypt Debug Plaintext', [
            'plaintext' => $plaintext,
        ]);

        if ($plaintext === false) {
            Log::error('OpenSSL decrypt failed', [
                'openssl_error' => openssl_error_string(),
            ]);

            throw new \Exception('openssl_decrypt failed');
        }

        return json_decode(
            $plaintext,
            true
        );
    }
}
