<?php


namespace Z61\Mastodon\ConnectedAccount\Service;

use OAuth\Common\Consumer\CredentialsInterface;
use OAuth\Common\Http\Client\ClientInterface;
use OAuth\Common\Http\Exception\TokenResponseException;
use OAuth\Common\Http\Uri\Uri;
use OAuth\Common\Http\Uri\UriInterface;
use OAuth\Common\Storage\TokenStorageInterface;
use OAuth\OAuth2\Service\AbstractService;
use OAuth\OAuth2\Token\StdOAuth2Token;

class Mastodon extends AbstractService
{
    const SCOPE_READ = 'read';
    const SCOPE_WRITE = 'write';
    const SCOPE_FOLLOW = 'follow';

    public function __construct(CredentialsInterface $credentials, ClientInterface $httpClient, TokenStorageInterface $storage, $scopes = array(), UriInterface $baseApiUri = null)
    {
        parent::__construct($credentials, $httpClient, $storage, $scopes, $baseApiUri);

        if (null === $baseApiUri) {
            $this->baseApiUri = new Uri(\XF::options()->z61MastodonInstance);
        }
    }

    protected function getAuthorizationMethod()
    {
        return static::AUTHORIZATION_METHOD_HEADER_BEARER;
    }

    protected function parseAccessTokenResponse($responseBody)
    {
        $data = json_decode($responseBody, true);

        if ($data === null || !is_array($data) || array_key_exists('error', $data))
        {
            throw new TokenResponseException('Unable to parse access token response.');
        }


        $token = new StdOAuth2Token();
        $token->setAccessToken($data['access_token']);
        unset($data['access_token']);

        if (array_key_exists('refresh_token', $data))
        {
            $token->setRefreshToken($data['refresh_token']);
            unset($data['refresh_token']);
        }

        if (array_key_exists('expires_in', $data))
        {
            $token->setEndOfLife(time() + $data['expires_in']);
            unset($data['expires_in']);
        }

        $token->setExtraParams($data);

        return $token;
    }

    public function getAuthorizationEndpoint()
    {
        return new Uri($this->baseApiUri . '/oauth/authorize');
    }

    public function getAccessTokenEndpoint()
    {
        return new Uri($this->baseApiUri. '/oauth/token');
    }

    public function getAuthorizationUri(array $additionalParameters = array())
    {
        $parameters = array_merge(
            $additionalParameters,
            array(
                'client_id'     => $this->credentials->getConsumerId(),
                'redirect_uri'  => $this->credentials->getCallbackUrl(),
                'response_type' => 'code',
            )
        );

        if ($this->needsStateParameterInAuthUrl()) {
            if (!isset($parameters['state'])) {
                $parameters['state'] = $this->generateAuthorizationState();
            }
            $this->storeAuthorizationState($parameters['state']);
        }

        $parameters['scope'] = implode(' ', $this->scopes);
        // Build the url
        $url = clone $this->getAuthorizationEndpoint();
        foreach ($parameters as $key => $val) {
            $url->addToQuery($key, $val);
        }
        return $url;
    }
}