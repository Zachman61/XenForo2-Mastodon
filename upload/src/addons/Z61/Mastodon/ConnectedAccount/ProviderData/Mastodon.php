<?php

namespace Z61\Mastodon\ConnectedAccount\ProviderData;

use XF\ConnectedAccount\ProviderData\AbstractProviderData;

class Mastodon extends AbstractProviderData
{
    public function getDefaultEndpoint()
    {
        return '/api/v1/accounts/verify_credentials';
    }

    public function getProviderKey()
    {
        return $this->requestFromEndpoint('id');
    }

    public function getUsername()
    {
        return $this->requestFromEndpoint('username');
    }

    public function getAcct()
    {
        return $this->requestFromEndpoint('acct');
    }

    /**
     * Get the user's display name, may be empty.
     * @return string|null
     */
    public function getDisplayName()
    {
        return $this->requestFromEndpoint('display_name');
    }

    public function getLocked()
    {
        return $this->requestFromEndpoint('locked');
    }

    public function getCreatedAt()
    {
        return $this->requestFromEndpoint('created_at');
    }

    public function getNote()
    {
        $note = $this->requestFromEndpoint('note');
        if ($note)
        {
            return htmlentities($note);
        }

        return '';
    }

    public function getUrl()
    {
        return $this->requestFromEndpoint('url');
    }

    public function getAvatar()
    {
     return $this->requestFromEndpoint('avatar');
    }

    public function getAvatarStatic()
    {
        return $this->requestFromEndpoint('avatar_static');
    }

    public function getheader()
    {
        return $this->requestFromEndpoint('header');
    }

    public function getHeaderStatic()
    {
        return $this->requestFromEndpoint('header_static');
    }

    public function getFollowers()
    {
        return $this->requestFromEndpoint('followers_count');
    }

    public function getFollowing()
    {
        return $this->requestFromEndpoint('following_count');
    }

    public function getStatusCount()
    {
        return $this->requestFromEndpoint('statuses_count');
    }
}