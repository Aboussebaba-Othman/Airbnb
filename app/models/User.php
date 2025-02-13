<?php
namespace App\Models;
use Core\Model;

class User extends Model {
    protected $table = 'users';
   
    public function findByEmail($email) {
        $query = "SELECT users.*, roles.title as role_title 
                 FROM users 
                 JOIN roles ON roles.id = users.role_id 
                 WHERE users.email = :email";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
   
    public function create($data) {
        $query = "INSERT INTO users (username, email, password, role_id, photo, description) 
                 VALUES (:username, :email, :password, :role_id, :photo, :description)";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'], 
            'role_id' => $data['role_id'],
            'photo' => $data['photo'] ?? null,
            'description' => $data['description'] ?? null
        ]);
    }
}