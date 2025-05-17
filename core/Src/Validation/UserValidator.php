<?php

namespace Src\Validation;

use Model\User;

class UserValidator extends BaseValidator
{
    public function validate(array $data): bool
    {
        $this->errors = [];                       // сбрасываем прошлые ошибки
        $fio        = $data['fio']        ?? '';
        $birth      = $data['birth_date'] ?? '';
        $login      = $data['login']      ?? '';
        $password   = $data['password']   ?? '';

        /* ---- ФИО ---- */
        if (!preg_match('/^[А-ЯЁа-яё\\s]+$/u', $fio)) {
            $this->addError('fio', 'ФИО должно содержать только русские буквы');
        }

        /* ---- Дата рождения ---- */
        $dt = \DateTime::createFromFormat('Y-m-d', $birth);
        if (!$dt || $dt > new \DateTime()) {
            $this->addError('birth_date', 'Некорректная дата рождения');
        }

        /* ---- Логин ---- */
        if (!preg_match('/^[A-Za-z]+$/', $login)) {
            $this->addError('login', 'Логин должен состоять только из английских букв');
        } elseif (User::where('login', $login)->exists()) {
            $this->addError('login', 'Пользователь с таким логином уже существует');
        }

        /* ---- Пароль ---- */
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\\d)[A-Za-z\\d]{8,}$/', $password)) {
            $this->addError(
                'password',
                'Пароль ≥ 8 символов, только латиница и цифры, минимум одна буква и одна цифра'
            );
        }

        return !$this->fails();
    }
}
