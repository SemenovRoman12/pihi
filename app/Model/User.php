<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    public    $timestamps = false;
    protected $table      = 'users';
    protected $fillable   = ['login', 'password', 'role'];

    /*--------------------------------------------------------------
     | IdentityInterface
     *-------------------------------------------------------------*/
    public function getId(): int
    {
        return $this->id;
    }

    public function attemptIdentity(array $credentials): ?self
    {
        $login    = $credentials['login']    ?? '';
        $password = $credentials['password'] ?? '';

        /* md5 хешируем «как в БД» */
        $hash = md5($password);

        return self::where('login', $login)
            ->where('password', $hash)
            ->first();
    }

    public function findIdentity(int $id): ?self
    {
        return self::find($id);
    }
}
