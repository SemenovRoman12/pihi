<?php

namespace Src\Validation;

/**
 * Базовый класс для всех валидаторов.
 * Хранит ошибки и предоставляет общий интерфейс validate()/fails()/errors().
 */
abstract class BaseValidator
{
    protected array $errors = [];

    /** Записать сообщение об ошибке по конкретному полю */
    protected function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    /** Возвращает true, если произошли ошибки */
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    /** Список ошибок */
    public function errors(): array
    {
        return $this->errors;
    }

    abstract public function validate(array $data): bool;
}
