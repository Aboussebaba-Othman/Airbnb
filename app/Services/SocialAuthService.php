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
        return $this->googleClient->createAuthUrl();
    }

    public function getFacebookAuthUrl() {
        $state = bin2hex(random_bytes(16));
        $_SESSION['fb_state'] = $state;
        
        return "https://www.facebook.com/v12.0/dialog/oauth?" . http_build_query([
            'client_id' => $this->fbAppId,
            'redirect_uri' => $this->fbRedirectUri,
            'state' => $state,
            'scope' => 'email'
        ]);
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

    public function handleFacebookCallback($code) {
        if (!isset($_SESSION['fb_state']) || $_GET['state'] !== $_SESSION['fb_state']) {
            throw new \Exception('Invalid state parameter');
        }

        $token_url = "https://graph.facebook.com/v12.0/oauth/access_token?" . http_build_query([
            'client_id' => $this->fbAppId,
            'client_secret' => $this->fbAppSecret,
            'redirect_uri' => $this->fbRedirectUri,
            'code' => $code
        ]);

        $response = file_get_contents($token_url);
        $data = json_decode($response, true);

        if (!isset($data['access_token'])) {
            throw new \Exception('Failed to get access token');
        }

        $graph_url = "https://graph.facebook.com/v12.0/me?" . http_build_query([
            'fields' => 'id,name,email,picture',
            'access_token' => $data['access_token']
        ]);

        $response = file_get_contents($graph_url);
        $user_data = json_decode($response, true);

        return [
            'email' => $user_data['email'] ?? null,
            'name' => $user_data['name'] ?? null,
            'picture' => $user_data['picture']['data']['url'] ?? null
        ];
    }
}