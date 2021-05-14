<?php
define("SECRET", $_SERVER["HTTP_SALT"] ?? "secret");

function base64url_encode($data): string
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data): string
{
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '='));
}

class Token
{
    private string $token;
    private string $signature_encoded;
    private string $signature;
    private string $payload_encoded;
    private string $headers_encoded;
    private array $payload;
    private array $headers;

    /**
     * Create a new token from given data
     * @param array $headers
     * @param array $payload
     * @return string Token
     * @throws Exception
     */
    function create(array $headers, array $payload): string
    {
        assert($payload["expiry"], "An expiry date must be provided in the token's payload.");

        $this->headers = $headers;
        $this->payload = $payload;

        // Build and return the token
        $this->build();
        return $this->token;
    }

    /**
     * Import token
     * @param string $token
     */
    function import(string $token)
    {
        $this->token = $token;

        $tokenParts = explode('.', $token);

        $this->headers_encoded = $tokenParts[0];
        $this->payload_encoded = $tokenParts[1];
        $this->signature_encoded = $tokenParts[2];

        $this->headers = json_decode(base64url_decode($this->headers_encoded), true);
        $this->payload = json_decode(base64url_decode($this->payload_encoded), true);
        $this->signature = base64url_decode($this->payload_encoded);
    }

    /**
     * Verify if token is valid
     * @return bool Token is valid
     * @throws Exception
     */
    function validate(): bool
    {
        assert($this->payload["expiry"], "Token does not have an expiry date.");

        if ($this->payload['expiry'] < time()) {
            return false;
        }

        $signature = hash_hmac('sha256', $this->headers_encoded . "." . $this->payload_encoded, SECRET, true);
        $signature_encoded = rtrim(base64url_encode($signature), "=");

        return $signature_encoded == $this->signature_encoded;
    }

    /**
     * @return string The token
     */
    function get(): string
    {
        return $this->token;
    }

    /**
     * @return array The payload as an array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    public function renew(int $interval): void
    {
        $this->payload["expiry"] = time() + $interval;
        $this->build();
    }

    private function build(): void
    {
        $this->headers_encoded = rtrim(base64url_encode(json_encode($this->headers)), "=");
        $this->payload_encoded = rtrim(base64url_encode(json_encode($this->payload)), "=");
        $this->signature = hash_hmac('sha256', "$this->headers_encoded.$this->payload_encoded", SECRET, true);

        $this->signature_encoded = rtrim(base64url_encode($this->signature), "=");

        $this->token = "$this->headers_encoded.$this->payload_encoded.$this->signature_encoded";
    }
}