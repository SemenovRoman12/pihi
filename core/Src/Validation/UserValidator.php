<?php

namespace Src\Validation;

use AbstractValidator\BaseValidator;
use Model\User;
use Pynhaxd\Validation\Interfaces\BaseInterface;
use Pynhaxd\Validation\Validators\Date;
use Pynhaxd\Validation\Validators\Login;
use Pynhaxd\Validation\Validators\Name;
use Pynhaxd\Validation\Validators\Password;

class UserValidator extends BaseValidator
{
    protected function check(string $field, $value, BaseInterface $rule): void
    {
        if ($rule->fails($value)) {                 // пакетная логика
            $this->addError($field, $rule->message());
        }
    }

    public function validate(array $data): bool
    {
        $this->errors = [];                       // сбрасываем прошлые ошибки
        $fio        = $data['fio']        ?? '';
        $birth      = $data['birth_date'] ?? '';
        $login      = $data['login']      ?? '';
        $password   = $data['password']   ?? '';

        /* ---- ФИО ---- */
        $this->check('fio',        $data['fio']        ?? '', new Name);
        $this->check('birth_date', $data['birth_date'] ?? '', new Date);
        $this->check('login',      $data['login']      ?? '', new Login);
        $this->check('password',   $data['password']   ?? '', new Password);

        if (!empty($data['login']) && User::where('login', $data['login'])->exists()) {
            $this->addError('login', 'Пользователь с таким логином уже существует');
        }

        return !$this->fails();
    }
}
