<?php
namespace Core;
class Validation {
    private array $errors = [];
    public function validate(array $data, array $rules): bool {
        $this->errors = [];
        foreach ($rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule) {
                $value = $data[$field] ?? null;
               
                switch ($rule) {
                    case 'required':
                        if (empty($value)) {
                            $this->addError($field, 'Ce champ est requis');
                        }
                        break;
                    case 'email':
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $this->addError($field, 'Email invalide');
                        }
                        break;
                    case 'min:6':
                        if (strlen($value) < 6) {
                            $this->addError($field, 'Minimum 6 caractères requis');
                        }
                        break;
                }
            }
        }
        return empty($this->errors);
    }
    public function addError(string $field, string $message): void {
        $this->errors[$field] = $message;
    }
    public function getErrors(): array {
        return $this->errors;
    }
    public function getError(string $field): ?string {
        return $this->errors[$field] ?? null;
    }
    public function hasErrors(): bool {
        return !empty($this->errors);
    }
}