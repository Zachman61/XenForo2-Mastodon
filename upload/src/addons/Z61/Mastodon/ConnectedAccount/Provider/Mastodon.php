<?php

namespace Z61\Mastodon\ConnectedAccount\Provider;

use XF\ConnectedAccount\Provider\AbstractProvider;
use XF\Entity\ConnectedAccountProvider;

class Mastodon extends AbstractProvider
{
    public function getOAuthServiceName()
    {
        return 'Z61\Mastodon:Service\Mastodon';
    }

    public function getProviderDataClass()
    {
        return 'Z61\Mastodon:ProviderData\Mastodon';
    }

    public function getDefaultOptions()
    {
        return [
            'client_id' => '',
            'client_secret' => ''
        ];
    }

    public function getOAuthConfig(ConnectedAccountProvider $provider, $redirectUri = null)
    {
        return [
            'key' => $provider->options['client_id'],
            'secret' => $provider->options['client_secret'],
            'grant_type' => 'authorization_code',
            'scopes' => [
                \Z61\Mastodon\ConnectedAccount\Service\Mastodon::SCOPE_READ,
            ],
            'redirect' => $redirectUri ?: $this->getRedirectUri($provider)
        ];
    }
}