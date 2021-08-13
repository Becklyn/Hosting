<?php declare(strict_types=1);

namespace Becklyn\Hosting\Sentry\Integration;

use function Sentry\configureScope;
use Sentry\Event;
use Sentry\Integration\IntegrationInterface;
use Sentry\State\Scope;
use Symfony\Component\Security\Core\Security;

class UserRoleSentryIntegration implements IntegrationInterface
{
    private Security $security;


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
            function (Scope $scope) : void
            {
                $scope->addEventProcessor(
                    function (Event $event) : Event
                    {
                        $user = $this->security->getUser();

                        if (null !== $user)
                        {
                            $extra = $event->getExtra();
                            $extra["user_roles"] = $user->getRoles();

                            $event->setExtra($extra);
                        }

                        return $event;
                    }
                );
            }
        );
    }
}
