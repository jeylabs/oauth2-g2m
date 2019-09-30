<?php


namespace Jeylabs\OAuth2\Client\Provider;


use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class G2MResourceOwner implements ResourceOwnerInterface
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function getId()
    {
        return $this->claim('account_key');
    }

    public function toArray()
    {
        return $this->data;
    }

    public function getFirstName()
    {
        return $this->claim('firstName');
    }

    public function getLastName()
    {
        return $this->claim('lastName');
    }

    public function getEmail()
    {
        return $this->claim('email');
    }

    public function claim($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }
}