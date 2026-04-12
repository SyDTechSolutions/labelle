<?php

namespace App\Services;


use App\Traits\ConsumesExternalServices;
use App\Traits\InteractsWithHaciendaResponses;
use Illuminate\Support\Facades\Http;
use function GuzzleHttp\json_encode;

class HaciendaAuthenticationService
{
    /**
     * The url from which send the requests
     * @var string
     */
    protected $baseUri;

    /**
     * The client_id to identify the client in the API
     * @var string
     */
    protected $clientId;

    /**
     * The client_secret to identify the client in the API
     * @var string
     */
    protected $clientSecret;

 

    use ConsumesExternalServices, InteractsWithHaciendaResponses;

    public function __construct()
    {
        $this->baseUri = env('HACIENDA_OAUTH_URI');
        $this->logoutUri = env('HACIENDA_LOGOUT_URI');
        $this->clientId = env('HACIENDA_CLIENT_ID');
        $this->clientSecret = env('HACIENDA_CLIENT_SECRET');
        
    }


     /**
     * Obtains an access token from user credentials
     * @param  string $username
     * @param  string $password
     * @return stdClass
     */
    public function logout($credential)
    {
        $formParams = [
            'client_id' => $this->clientId,
            'refresh_token' => $credential->refresh_token,
        ];

        $tokenData = $this->makeRequest('POST', $this->logoutUri, [], $formParams);

       // \Log::info('cerramos sesion');

        return $tokenData;
    }

    /**
     * Obtains an access token from user credentials
     * @param  string $username
     * @param  string $password
     * @return stdClass
     */
    public function getPasswordToken($username, $password)
    {

        // $tokenData = $this->makeRequest('POST', $this->baseUri, [], $formParams);
        $data = array(
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'password',
            'username' => $username,
            'password' => $password,
        );
        $response = Http::asForm()->post($this->baseUri, $data);
        $tokenData = $response->object();
  
        \Log::info(isset($tokenData->access_token) ? 'Token OK' : 'No Token generado');


        $this->storeValidToken($tokenData, 'password');

        return $tokenData;
    }

    /**
     * Obtains an access token from the authenticated user
     * @return string
     */
    public function getAuthenticatedUserToken()
    {
        $setting = \App\Setting::first();//auth()->user();

        $credential = $setting->getObligadoTributario();
        
        if (now()->lt($credential->token_expires_at)) { // si no ha expirado el token retornarlo
           // \Log::info('no ha expirado el token actual');
            return $credential->access_token;
        }

        if (now()->lt($credential->refresh_expires_at)) { // si ya expiro el refresh obtener un nuevo token y refresh
           // \Log::info('Solicitando Refrescar Token con refresh token');
           
            return $this->refreshAuthenticatedUserToken($credential);
            
        }
        
        return $this->getNewPasswordToken($credential);
    }

    public function refreshAuthenticatedUserToken($credential)
    {
        $clientId = $this->clientId;
        $clientSecret = $this->clientSecret;

        
        $formParams = [
            'grant_type' => 'refresh_token',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $credential->refresh_token,
        ];

        $response = Http::asForm()->post($this->baseUri, $formParams);
        $tokenData = $response->object();
  
        \Log::info(isset($tokenData->access_token) ? 'Token OK en refresh' : 'No Token generado refresh');
        
        if(!$tokenData){
           // \Log::info('Refresh token expired - volver a iniciar sesion');
            return $this->getNewPasswordToken($credential);
        }

        $this->storeValidToken($tokenData, $credential->grant_type);

        $credential->fill([
            'access_token' => $tokenData->access_token,
            'refresh_token' => $tokenData->refresh_token,
            'token_expires_at' => $tokenData->token_expires_at,
            'refresh_expires_at' => $tokenData->refresh_expires_at,
        ]);

        $credential->save();

        return $credential->access_token;
    }

    public function getNewPasswordToken($credential)
    {
        $this->logout($credential);

        //\Log::info('Solicitamos nuevo token iniciando sesion ya que el refresh token expiró');

        $tokenData = $this->getPasswordToken($credential->atv_user, $credential->atv_password);

        $credential->fill([
            'access_token' => $tokenData->access_token,
            'refresh_token' => $tokenData->refresh_token,
            'token_expires_at' => $tokenData->token_expires_at,
            'refresh_expires_at' => $tokenData->refresh_expires_at,
        ]);
        
        $credential->save();

        return $credential->access_token;
    }

    /**
     * Stores a valid token
     * @param  stdClass $tokenData
     * @param  string $grantType
     * @return void
     */
    public function storeValidToken($tokenData, $grantType)
    {
        $tokenData->token_expires_at = now()->addSeconds($tokenData->expires_in - 30); //30 seg antes
        $tokenData->refresh_expires_at = now()->addSeconds($tokenData->refresh_expires_in - 300); //5 min antes
        $tokenData->access_token = "{$tokenData->token_type} {$tokenData->access_token}";
        $tokenData->grant_type = $grantType;

        session()->put(['current_token' => $tokenData]);

        
    }

    
}
