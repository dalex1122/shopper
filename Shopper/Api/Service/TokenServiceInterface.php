<?php

namespace Alexsample\Shopper\Api\Service;

interface TokenServiceInterface
{
    CONST NAME = 'Integration-Name14';
    CONST EMAIL = 'email@email.com';
    CONST ENDPOINT = 'any_url';

    /**
     * @return void
     */
    public function createToken();

    /**
     * @return string|bool
     */
    public function getToken();
}