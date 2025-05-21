<?php
/**
 * Тесты регистрации и авторизации.
 *   vendor/bin/phpunit tests/SiteTest.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Model\User;
use Src\Auth\Auth;

class SiteTest extends TestCase
{
    protected Capsule $db;

    /* ---------- окружение ---------- */
    protected function setUp(): void
    {
        parent::setUp();

        $cfg = include __DIR__ . '/../config/db.php';

        $this->db = new Capsule;
        $this->db->addConnection($cfg);
        $this->db->setAsGlobal();
        $this->db->bootEloquent();
        $this->db->getConnection()->beginTransaction();

        if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
            @session_start();
        }
        Auth::init(new User);
    }

    protected function tearDown(): void
    {
        $this->db->getConnection()->rollBack();
        parent::tearDown();
    }

    /* ---------- помощник ---------- */
    private function assertUserExists(string $login): void
    {
        $this->assertTrue(
            User::where('login', $login)->exists(),
            "В базе нет пользователя «{$login}»."
        );
    }

    /* =============================================================
       1. Обязательные поля (проверяем, что валидатор ловит ошибки)
    ============================================================= */
    public function testSignupRequired(): void
    {
        $validator = new \Src\Validation\UserValidator();
        $ok = $validator->validate([
            'fio'        => '',
            'birth_date' => '',
            'login'      => '',
            'password'   => '',
        ]);

        $this->assertFalse($ok);
        $errors = $validator->errors();
        $this->assertArrayHasKey('fio',        $errors);
        $this->assertArrayHasKey('birth_date', $errors);
        $this->assertArrayHasKey('login',      $errors);
        $this->assertArrayHasKey('password',   $errors);
    }

    /* =============================================================
       2. Занятый login (unique)
    ============================================================= */
    public function testSignupUniqueLogin(): void
    {
        $busyLogin = User::first()->login ?? 'admin';

        $validator = new \Src\Validation\UserValidator();
        $ok = $validator->validate([
            'fio'        => 'Иван Иванов',
            'birth_date' => '1990-01-01',
            'login'      => $busyLogin,          // уже занят
            'password'   => 'Secret123',         // валидный пароль
        ]);

        $this->assertFalse($ok);
        $this->assertArrayHasKey('login', $validator->errors());
    }

    /* =============================================================
       3. Успешная регистрация
    ============================================================= */
    public function testSignupSuccess(): void
    {
        $login = 'unit_' . uniqid();
        $plain = 'Secret123';

        $validator = new \Src\Validation\UserValidator();
        $this->assertTrue($validator->validate([
            'fio'        => 'Иван Иванов',
            'birth_date' => '1990-01-01',
            'login'      => $login,
            'password'   => $plain,
        ]));

        User::create([
            'fio'        => 'Иван Иванов',
            'birth_date' => '1990-01-01',
            'login'      => $login,
            'password'   => md5($plain),
            'role'       => 'user',
        ]);

        $this->assertUserExists($login);
    }

    /* =============================================================
       4. Авторизация
    ============================================================= */
    public function testLogin(): void
    {
        $login = 'login_' . uniqid();
        $plain = 'Secret123';

        $user = User::create([
            'fio'        => 'Пётр Петров',
            'birth_date' => '1985-05-05',
            'login'      => $login,
            'password'   => md5($plain),
            'role'       => 'user',
        ]);

        /* верный пароль */
        $this->assertTrue(Auth::attempt([
            'login'    => $login,
            'password' => $plain,
        ]));
        $this->assertEquals($user->id, $_SESSION['id']);

        /* неверный пароль */
        $this->assertFalse(Auth::attempt([
            'login'    => $login,
            'password' => 'WrongPass1',
        ]));
    }
}
