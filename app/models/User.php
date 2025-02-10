<?php
namespace App\Models;

use Core\Model;

class User extends Model {
    protected $table = 'users';
    
    public function findByEmail($email) {
        $query = "SELECT u.*, r.title as role_title 
                 FROM users u 
                 JOIN roles r ON r.id = u.role_id 
                 WHERE u.email = :email";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}