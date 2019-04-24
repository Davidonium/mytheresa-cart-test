<?php


namespace App\MyTheresaCart\Application\EventSubscriber;


use App\MyTheresaCart\Domain\Model\MyTheresaCartDomainException;
use App\MyTheresaCart\Domain\Model\Shop\ProductNotFoundException;
use App\MyTheresaCart\Domain\Model\User\UserNotSignedInException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionMappingEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onException'
        ];
    }

    public function onException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if (!$exception instanceof MyTheresaCartDomainException) {
            return;
        }

        if ($exception instanceof ProductNotFoundException) {
            $event->setResponse(JsonResponse::create(['message' => $exception->getMessage()], Response::HTTP_NOT_FOUND));
        }

        if ($exception instanceof UserNotSignedInException) {
            $event->setResponse(JsonResponse::create(['message' => 'Not Allowed'], Response::HTTP_UNAUTHORIZED));
        }
    }

}