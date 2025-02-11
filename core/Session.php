<?php
namespace Core;

class Session {
    public function __construct() {

    }

    public function set(string $key, $value): void {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public function remove(string $key): void {
        unset($_SESSION[$key]);
    }

    public function destroy(): void {
        session_destroy();
    }

    public function setUserData(array $user): void {
        $this->set('user_id', $user['id']);
        $this->set('user_role', $user['role_title']);
        $this->set('user_role_id', $user['role_id']);
        $this->set('username', $user['username']);
    }

    public function getUserRole() {
        return $this->get('user_role');
    }

    public function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }

    public function setFlash(string $key, string $message): void {
        $_SESSION['flash'][$key] = $message;
    }

    public function getFlash(string $key) {
        if (isset($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        return null;
    }
}