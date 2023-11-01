<?php

namespace App\Support;

use DateTimeImmutable;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Validator;
use Ramsey\Uuid\Uuid;

/**
 * JWT Auth
 */
final class JwtAuth
{
    /**
     * @var string The issuer name
     */
    private string $issuer;

    /**
     * @var int Max lifetime in seconds
     */
    private int $lifetime;

    /**
     * @var string The private key
     */
    private string $privateKey;

    /**
     * @var string The public key
     */
    private string $publicKey;

    private Sha256 $algorithm;

    const UID = "uid";

    /**
     * The constructor.
     *
     * @param string $issuer The issuer name
     * @param int $lifetime The max lifetime
     * @param string $privateKey The private key as string
     * @param string $publicKey The public key as string
     */
    public function __construct(
        string $issuer,
        int    $lifetime,
        string $privateKey,
        string $publicKey
    )
    {
        $this->issuer = $issuer;
        $this->lifetime = $lifetime;
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
        $this->algorithm = new Sha256();
    }

    /**
     * Get JWT max lifetime.
     *
     * @return int The lifetime in seconds
     */
    public function getLifetime(): int
    {
        return $this->lifetime;
    }

    /**
     * Create JSON web token.
     *
     * @param string $uid The user id
     *
     * @return string The JWT
     */
    public function createJwt(string $uid): string
    {
        $tokenBuilder = (new Builder(new JoseEncoder(), ChainedFormatter::default()));

        $issuedAt = new DateTimeImmutable();
        $token = $tokenBuilder
            // Configures the issuer (iss claim)
            ->issuedBy($this->issuer)
            // Configures the audience (aud claim)
            // todo ->permittedFor('http://example.org')
            // Configures the id (jti claim)
            ->identifiedBy(Uuid::uuid4()->toString(), true)
            // Configures the time that the token was issue (iat claim)
            ->issuedAt($issuedAt)
            // Configures the time that the token can be used (nbf claim)
            ->canOnlyBeUsedAfter($issuedAt->modify('+1 minute'))
            // Configures the expiration time of the token (exp claim)
            ->expiresAt($issuedAt->modify('+' . $this->lifetime . ' seconds'))
            // Configures a new claim, called "uid"
            ->withClaim(self::UID, $uid)
            // Builds a new token
            ->getToken($this->algorithm, InMemory::plainText($this->privateKey));

        return $token->toString();
    }

    /**
     * Parse token.
     *
     * @param string $token The JWT
     *
     * @return Token The parsed token
     *
     */
    public function createParsedToken(string $token): Token
    {
        return (new Parser(new JoseEncoder()))->parse($token);
    }

    /**
     * Validate the access token.
     *
     * @param string $accessToken The JWT
     *
     * @return bool The status
     */
    public function validateToken(string $accessToken): bool
    {
        $token = $this->createParsedToken($accessToken);
        $validator = new Validator();

        if ($token->isExpired(new \DateTime())) {
            return false;
        }

        return $validator->validate(
            $token,
            new IssuedBy($this->issuer),
            new SignedWith($this->algorithm, InMemory::plainText($this->publicKey))
        );
    }
}