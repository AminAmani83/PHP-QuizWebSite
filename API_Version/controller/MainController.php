<?php

use Auth0\SDK\Exception\InvalidTokenException;
use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;
use Auth0\SDK\Helpers\Tokens\TokenVerifier;
use Kodus\Cache\FileCache;

// Built using instructions from Auth0:
// https://auth0.com/docs/quickstart/backend/php/01-authorization#

class MainController
{
    // Vars
    protected $f3;
    protected $db;
    // Authentication Vars
    protected $issuer;
    protected $audience;
    protected $token;
    protected $tokenInfo;

    function __construct()
    {
        $this->f3 = BASE::instance();
        $this->db = new DB\SQL(
            $this->f3->get('dbName'),
            $this->f3->get('dbUsername'),
            $this->f3->get('dbPassword'),
            array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
        );
        // Authentication
        $this->issuer = $this->f3->get("issuer");
        $this->audience = $this->f3->get("identifier");
    }

    /**
     * Authentication 1 - Auth0
     * @param $token
     * @throws InvalidTokenException
     */
    public function setCurrentToken($token)
    {
        $cacheHandler = new FileCache('./cache', 600);
        $jwksUri = $this->issuer . '.well-known/jwks.json';

        $jwksFetcher = new JWKFetcher($cacheHandler, ['base_uri' => $jwksUri]);
        $sigVerifier = new AsymmetricVerifier($jwksFetcher);
        $tokenVerifier = new TokenVerifier($this->issuer, $this->audience, $sigVerifier);

        try {
            $this->tokenInfo = $tokenVerifier->verify($token);
            $this->token = $token;
        } catch (InvalidTokenException $e) {
            throw new InvalidTokenException($e->getMessage());
        }
    }

    /**
     * Authentication 2 - Auth0
     */
    public function authenticate()
    {
        $requestHeaders = getallheaders();

        if (!isset($requestHeaders['authorization']) && !isset($requestHeaders['Authorization'])) {
            header('HTTP/1.0 401 Unauthorized');
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array("message" => "No token provided."));
            exit();
        }

        $authorizationHeader = isset($requestHeaders['authorization']) ? $requestHeaders['authorization'] : $requestHeaders['Authorization'];

        if ($authorizationHeader == null) {
            header('HTTP/1.0 401 Unauthorized');
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array("message" => "No authorization header sent."));
            exit();
        }

        $authorizationHeader = str_replace('bearer ', '', $authorizationHeader);
        $token = str_replace('Bearer ', '', $authorizationHeader);

        try {
            $this->setCurrentToken($token);
        } catch (\Auth0\SDK\Exception\CoreException $e) {
            header('HTTP/1.0 401 Unauthorized');
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array("message" => $e->getMessage()));
            exit();
        }
    }

    public function checkRole($role)
    {
        $this->authenticate();
        if (!$this->tokenInfo || !$this->tokenInfo['http://localhost:3000/roles'] ||
            !in_array($role, $this->tokenInfo['http://localhost:3000/roles'])) {
                header('HTTP/1.0 401 Unauthorized');
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array("message" => "The required role was not provided."));
                exit();
            }
    }

    public function checkScope($scope)
    {
        $this->authenticate();
        if ($this->tokenInfo && $this->tokenInfo->scope) {
            $scopes = explode(" ", $this->tokenInfo->scope);
            foreach ($scopes as $s) {
                if ($s === $scope)
                    return;
            }
        }
        // Scope does not match
        header('HTTP/1.0 401 Unauthorized');
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array("message" => "The required scope was not provided."));
        exit();
    }

}