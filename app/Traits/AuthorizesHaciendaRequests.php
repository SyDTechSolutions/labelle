<?php

namespace App\Traits;

use App\Services\HaciendaAuthenticationService;

trait AuthorizesHaciendaRequests
{
    /**
     * Resolves the elements to send when authorazing the request
     * @param  array &$queryParams
     * @param  array &$formParams
     * @param  array &$headers
     * @return void
     */
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $accessToken = $this->resolveAccessToken();

        $headers['Authorization'] = $accessToken;
        //$headers['Content-Type'] = 'application/json';
      
    }

    public function resolveAccessToken()
    {
        $authenticationService = resolve(HaciendaAuthenticationService::class);
        $settings = \App\Setting::first();

        if ($settings) {
            return $authenticationService->getAuthenticatedUserToken();
        }

        return '';
    }
}
