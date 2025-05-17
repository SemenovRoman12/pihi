<?php

namespace Src\Validation;

use Model\Department;

/**
 * Проверяет название кафедры при создании/редактировании.
 */
class DepartmentValidator extends BaseValidator
{
    public function validate(array $data): bool
    {
        $this->errors = [];
        $name = $data['name'] ?? '';
        $id   = $data['id']   ?? null;

        /*
         * Требования:
         * 1) название начинается с кириллической буквы;
         * 2) далее допускаются кириллица, пробелы, дефисы «-» и «–».
         */
        if (!preg_match('/^[А-ЯЁа-яё][А-ЯЁа-яё\s\-–]*$/u', $name)) {
            $this->addError(
                'name',
                'Название должно начинаться с буквы и быть на кириллице; разрешены пробелы и дефисы'
            );
        } else {
            $exists = Department::where('name', $name)
                ->when($id, fn($q) => $q->where('id', '!=', $id))
                ->exists();
            if ($exists) {
                $this->addError('name', 'Кафедра с таким названием уже существует');
            }
        }

        return !$this->fails();
    }
}
