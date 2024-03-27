<?php

namespace Tests\Unit;



use App\Managers\SocialSessionManager;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tests\TestCase;

class SocialManagerTest extends TestCase
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testSetAndGetSocialSessions():void
    {
        // Create an instance of the SocialSessionManager
        $socialSessionManager = new SocialSessionManager();

        // Set social sessions
        $socialSessionManager->setSocialCurrentSessions("account", 'facebook');

        // Check if the social sessions were set correctly

        $this->assertEquals('account', $socialSessionManager->getCurrentSocialAccountSessions('account'));
        $this->assertEquals('facebook', $socialSessionManager->getCurrentSocialAccountSessions('provider'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testDestroySocialSessions():void
    {
        // Create an instance of the SocialSessionManager
        $socialSessionManager = new SocialSessionManager();

        // Set social sessions
        $socialSessionManager->setSocialCurrentSessions("123", 'facebook');

        // Destroy social sessions
        $socialSessionManager->destroySocialSessions();

        // Check if the social sessions were destroyed
        $this->assertNull($socialSessionManager->getCurrentSocialAccountSessions('account'));
        $this->assertNull($socialSessionManager->getCurrentSocialAccountSessions('provider'));
    }
}
