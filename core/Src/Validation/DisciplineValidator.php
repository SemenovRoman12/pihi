<?php

namespace Src\Validation;

use Model\Discipline;

/**
 * Проверяет название и часы дисциплины при создании/редактировании.
 */
class DisciplineValidator extends BaseValidator
{
    public function validate(array $data): bool
    {
        $this->errors = [];
        $name  = $data['name']  ?? '';
        $hours = $data['hours'] ?? null;
        $id    = $data['id']    ?? null; // полезно при редактировании

        /* ---- Название ---- */
        if (!preg_match('/^[А-ЯЁа-яё][А-ЯЁа-яё\s\-–]*$/u', $name)) {
            $this->addError('name', 'Название должно начинаться с буквы и быть на кириллице; разрешены пробелы и дефисы');
        } else {
            $exists = Discipline::where('name', $name)
                ->when($id, fn($q) => $q->where('id', '!=', $id))
                ->exists();
            if ($exists) {
                $this->addError('name', 'Дисциплина с таким названием уже есть');
            }
        }

        /* ---- Часы ---- */
        if (!is_numeric($hours) || $hours < 0 || $hours > 999) {
            $this->addError('hours', 'Часы должны быть числом от 0 до 999');
        }

        return !$this->fails();
    }
}
