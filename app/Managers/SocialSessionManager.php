<?php
declare(strict_types=1);
namespace App\Managers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SocialSessionManager
{
    public final function setSocialCurrentSessions(string $account, string $provider): self
    {
        session()->put('account', $account);
        session()->put('provider', $provider);
        return $this;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public final function getCurrentSocialAccountSessions(string $sessionName): string|int|null
    {
        // Retrieve session data for account and provider
        $account = session()->get('account');
        $provider = session()->get('provider');

        // Return the value of the specified session variable, or null if not found
        return match ($sessionName) {
            'account' => $account ?? null,
            'provider' => $provider ?? null,
        };
    }

    public final function destroySocialSessions(): self
    {
        session()->remove('account');
        session()->remove('provider');
        session()->remove('oauth2state');
        session()->remove('oauth2verifier');
        return $this;
    }



}
