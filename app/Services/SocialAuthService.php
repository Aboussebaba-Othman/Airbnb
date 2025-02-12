<?php
namespace App\Services;

use Google_Client;

class SocialAuthService {
    private $googleClient;
    private $fbAppId;
    private $fbAppSecret;
    private $fbRedirectUri;

    public function __construct() {
        $this->googleClient = new Google_Client();
        $this->googleClient->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $this->googleClient->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $this->googleClient->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');

        $this->fbAppId = $_ENV['FACEBOOK_APP_ID'];
        $this->fbAppSecret = $_ENV['FACEBOOK_APP_SECRET'];
        $this->fbRedirectUri = $_ENV['FACEBOOK_REDIRECT_URI'];
    }

    public function getGoogleAuthUrl() {
        $this->googleClient->revokeToken(); 
        $this->googleClient->setPrompt('select_account consent'); 
        $this->googleClient->setAccessType('offline');
        return $this->googleClient->createAuthUrl();
    }

    public function handleGoogleCallback($code) {
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($code);
        $this->googleClient->setAccessToken($token);

        $google_oauth = new \Google_Service_Oauth2($this->googleClient);
        $google_account_info = $google_oauth->userinfo->get();

        return [
            'email' => $google_account_info->email,
            'name' => $google_account_info->name,
            'picture' => $google_account_info->picture
        ];
    }

    public function getFacebookAuthUrl() {
        $state = bin2hex(random_bytes(16));
        $_SESSION['fb_state'] = $state;

        return 'https://www.facebook.com/v12.0/dialog/oauth?' . http_build_query([
            'client_id' => $this->fbAppId,
            'redirect_uri' => $this->fbRedirectUri,
            'state' => $state,
            'scope' => 'email'
        ]);
    }

    public function handleFacebookCallback($code) {
        if (!isset($_SESSION['fb_state']) || $_GET['state'] !== $_SESSION['fb_state']) {
            throw new \Exception('État invalide');
        }

        $tokenUrl = "https://graph.facebook.com/v12.0/oauth/access_token";
        $response = file_get_contents($tokenUrl . '?' . http_build_query([
            'client_id' => $this->fbAppId,
            'client_secret' => $this->fbAppSecret,
            'redirect_uri' => $this->fbRedirectUri,
            'code' => $code
        ]));

        $accessToken = json_decode($response, true)['access_token'];

        $graphUrl = "https://graph.facebook.com/v12.0/me";
        $response = file_get_contents($graphUrl . '?' . http_build_query([
            'fields' => 'id,name,email,picture',
            'access_token' => $accessToken
        ]));

        $userData = json_decode($response, true);

        return [
            'email' => $userData['email'] ?? null,
            'name' => $userData['name'] ?? null,
            'picture' => $userData['picture']['data']['url'] ?? null
        ];
    }
}