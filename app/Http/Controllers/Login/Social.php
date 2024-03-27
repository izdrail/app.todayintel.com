<?php
declare(strict_types=1);
namespace App\Http\Controllers\Login;


use App\Data\DTO\UserInformationDTO;
use App\Data\Repositories\NetworksRepository;
use App\Managers\SocialSessionManager;
use App\Networks\Facebook;
use App\Networks\Github;
use App\Networks\Linked;
use App\Networks\LinkedInProvider;
use App\Networks\Twitter;
use App\Repositories\SocialAppRepository;
use Filament\Notifications\Notification;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Random\RandomException;
use RuntimeException;


class Social extends Controller
{

    private NetworksRepository $socialConfigurationRepository;

    private SocialSessionManager $socialSessionManager;

    protected array $providers = [
        'twitter' => Twitter::class,
        'linkedin' => Linked::class,
        'github' => Github::class,
        'google' => Github::class,
        'facebook' => Facebook::class,
    ];

    public function __construct(
        NetworksRepository $socialConfigurationRepository,
        SocialSessionManager $socialSessionManager
    )
    {
        $this->socialConfigurationRepository = $socialConfigurationRepository;
        $this->socialSessionManager =  $socialSessionManager;

    }

    /**
     * @throws \Exception
     */
    public final function login(string $account, string $provider): \Illuminate\Http\RedirectResponse
    {
        $this->socialSessionManager->destroySocialSessions();

        $this->socialSessionManager->setSocialCurrentSessions($account, $provider);

        $configuration = $this->socialConfigurationRepository->getAccountConfiguration($account, $provider);

        $providerClass = $this->providers[$provider] ?? "The selected '$provider' is not yet implemented";

        return Socialite::buildProvider($providerClass, (array) $configuration->configuration)
            ->scopes($providerClass->scopes ?? [])
            ->redirect();

    }


    /**
     *
     * @throws RuntimeException
     * @throws RandomException
     */
    public final function callback(Request $request): \Illuminate\Http\RedirectResponse
    {
        //get the sessions
        $account = $this->socialSessionManager->getCurrentSocialAccountSessions('account');

        $provider = $this->socialSessionManager->getCurrentSocialAccountSessions('provider');

        $providerClass = $this->providers[$provider] ?? "The selected '$provider' is not yet implemented";

        $configuration = $this->socialConfigurationRepository->getAccountConfiguration($account, $provider);

        try{
            $user = Socialite::buildProvider($providerClass, (array) $configuration->configuration)
                ->scopes($providerClass->scopes ?? [])
                ->user();
        }catch (InvalidStateException|ClientException $e ){
            throw new RuntimeException("Given state was invalid." . $e->getMessage());
        }

        // All providers
        $data = UserInformationDTO::from([
            'name' => $user->getName(),
            'username' => $user->getNickname(),
            'avatar' =>$user->getAvatar(),
            'provider' => $provider,
            'provider_id'=> $account,
            'data' => ( (array) $user),
            'access_token' => $user->token,
        ]);


        $this->socialConfigurationRepository->saveAccountInformation($data);

        $this->socialSessionManager->destroySocialSessions();


        Notification::make()
            ->title('Login successful')
            ->success()
            ->send();

        return redirect()
            ->route('filament.users.resources.accounts.index');

    }

}
