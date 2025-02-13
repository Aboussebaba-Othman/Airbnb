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
    public function count() {
        return $this->queryScalar("SELECT COUNT(*) FROM {$this->table}");
    }
}