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

    public function getAllUsers() {
        $query = "SELECT u.*, r.title as role_title, 
                  COALESCE(u.status, 'active') as status
                  FROM users u 
                  LEFT JOIN roles r ON u.role_id = r.id 
                  WHERE u.role_id != 1  
                  ORDER BY u.id ASC";
        
        return $this->query($query);
    }

    public function toggleStatus($userId, $status) {
        $query = "UPDATE users SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'status' => $status,
            'id' => $userId
        ]);
    }
    public function update($id, $data) {
        $fields = array_map(function($field) {
            return "$field = :$field";
        }, array_keys($data));
    
        $query = "UPDATE {$this->table} SET " . implode(", ", $fields) . " WHERE id = :id";
        
        $data['id'] = $id;
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }
}
