<?php

namespace Alexsample\Shopper\Service;

use Magento\Integration\Model\IntegrationFactory;
use Magento\Integration\Model\OauthService;
use Magento\Integration\Model\AuthorizationService;
use Magento\Integration\Model\Oauth\Token;
use Alexsample\Shopper\Api\Service\TokenServiceInterface;


class TokenService implements TokenServiceInterface
{
    public function __construct(
        IntegrationFactory $integrationFactory,
        OauthService $oauthService,
        AuthorizationService $authorizationService,
        Token $token
    ) {
        $this->integrationFactory = $integrationFactory;
        $this->oauthService = $oauthService;
        $this->authorizationService = $authorizationService;
        $this->token = $token;
    }

    /**
     * {@inheritdoc}
     */
    public function createToken()
    {
        if ($token = $this->getToken()) {
            return $token;
        }

        $integrationData = array(
            'name' => self::NAME,
            'email' => self::EMAIL,
            'status' => '1',
            'endpoint' => self::ENDPOINT,
            'setup_type' => '0'
        );

        $integrationFactory = $this->integrationFactory->create();
        $integration = $integrationFactory->setData($integrationData);
        $integration->save();
        $integrationId = $integration->getId();
        $consumerName = 'Integration' . $integrationId;
        $consumer = $this->oauthService->createConsumer(['name' => $consumerName]);
        $consumerId = $consumer->getId();
        $integration->setConsumerId($consumer->getId());
        $integration->save();
        $this->authorizationService->grantAllPermissions($integrationId);
        $this->token->createVerifierToken($consumerId);
        $this->token->setType('access');
        $this->token->save();
    }

    /**
     * {@inheritdoc}
     */
    public function getToken()
    {
        if ($consumerId = $this->getConsumerId()) {
            $token = $this->oauthService->getAccessToken($consumerId);
            return $token->getToken();
        }

        return false;
    }

    /**
     * @return bool|int
     */
    protected function getConsumerId()
    {
        $integration = $this->integrationFactory->create()
            ->load(self::NAME,'name')->getData();
        if(empty($integration)){
           return false;
        }

        return $integration['consumer_id'];
    }
}