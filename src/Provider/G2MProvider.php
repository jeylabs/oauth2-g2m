<?php


namespace Jeylabs\OAuth2\Client\Provider;


use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use League\OAuth2\Client\Grant\AbstractGrant;
use Psr\Http\Message\ResponseInterface;

class G2MProvider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * @var string
     */
    private $urlAuthorize;

    /**
     * @var string
     */
    private $urlAccessToken;

    /**
     * @var string
     */
    private $urlResourceOwnerDetails;

    /**
     * @var string
     */
    private $accessTokenMethod;

    /**
     * @var string
     */
    private $accessTokenResourceOwnerId;

    /**
     * @var array|null
     */
    private $scopes = null;

    /**
     * @var string
     */
    private $scopeSeparator;

    /**
     * @var string
     */
    private $responseError = 'error';

    /**
     * @var string
     */
    private $responseCode;

    /**
     * @var string
     */
    private $responseResourceOwnerId = 'account_key';

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (!empty($data[$this->responseError])) {
            $error = $data[$this->responseError];
            $code = $this->responseCode ? $data[$this->responseCode] : 0;
            throw new IdentityProviderException($error, $code, $data);
        }
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->urlResourceOwnerDetails;
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->urlAccessToken;
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new G2MResourceOwner($response);
    }

    public function getBaseAuthorizationUrl()
    {
        return $this->urlAuthorize;
    }

    public function getDefaultScopes()
    {
        return $this->scopes;
    }
}