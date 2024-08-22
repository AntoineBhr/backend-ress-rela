<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;


Class APIAuthenticator extends AbstractAuthenticator
{


    public function supports(Request $request): bool
    {
        // dd($request->headers->has('Authorization') && str_contains($request->headers->get('Authorization'), 'Bearer '));

        return $request->headers->has('Authorization') && str_contains($request->headers->get('Authorization'), 'Bearer ');
    }
    
    public function authenticate(Request $request): Passport
    {
        $identifier = str_replace('Bearer ', '',$request->headers->get('Authorization'));
        return new SelfValidatingPassport(
            new UserBadge($identifier)
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null; 
    }


    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        // Retourner une réponse JSON d'erreur
        return new JsonResponse(['error' => $exception->getMessageKey()], Response::HTTP_UNAUTHORIZED);
    }

}

?>