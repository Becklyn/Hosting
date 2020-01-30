<?php declare(strict_types=1);

namespace Becklyn\Hosting\Sentry\Integration;

use Sentry\Event;
use Sentry\Integration\IntegrationInterface;
use Sentry\State\Scope;
use Symfony\Component\Security\Core\Security;
use function Sentry\configureScope;

class UserRoleSentryIntegration implements IntegrationInterface
{
    /** @var Security */
    private $security;

    /**
     */
    public function __construct (Security $security)
    {
        $this->security = $security;
    }

    /**
     * @inheritDoc
     */
    public function setupOnce () : void
    {
        configureScope(
            function (Scope $scope): void
            {
                $scope->addEventProcessor(
                    function (Event $event) : Event
                    {
                        $user = $this->security->getUser();

                        if (null !== $user)
                        {
                            $event->getExtraContext()->merge(['user_roles' => $user->getRoles()]);
                        }

                        return $event;
                    }
                );
            }
        );
    }
}
