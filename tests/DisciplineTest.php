<?php
/**
 * DisciplineTest.php  –  CRUD-тесты для модели дисциплин.
 *
 * Запуск: vendor/bin/phpunit tests/DisciplineTest.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Model\User;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Model\Discipline;
use Src\Auth\Auth;
use Src\Validation\DisciplineValidator;

class DisciplineTest extends TestCase
{
    private static Capsule $db;
    private static int $createdId;   // id, созданный в testCreateSuccess

    /*--------------------------------------------------------------
      setUpBeforeClass / tearDownAfterClass
      — одна транзакция на ВСЁ время выполнения тест-класса
    --------------------------------------------------------------*/
    public static function setUpBeforeClass(): void
    {
        $cfg = include __DIR__ . '/../config/db.php';

        self::$db = new Capsule;
        self::$db->addConnection($cfg);
        self::$db->setAsGlobal();
        self::$db->bootEloquent();
        self::$db->getConnection()->beginTransaction();
    }

    public static function tearDownAfterClass(): void
    {
        self::$db->getConnection()->rollBack();   // БД вернулась в исходное состояние
    }

    /*--------------------------------------------------------------
      Обычный setUp: сессия + Auth (без транзакций)
    --------------------------------------------------------------*/
    protected function setUp(): void
    {
        parent::setUp();

        if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
            @session_start();
        }
        Auth::init(new User);
    }

    /*==============================================================
      TC_DISC_01 : required-поля
    ==============================================================*/
    public function testCreateRequired(): void
    {
        $v = new DisciplineValidator();
        $this->assertFalse($v->validate(['name'=>'', 'hours'=>'']));

        $err = $v->errors();
        $this->assertArrayHasKey('name',  $err);
        $this->assertArrayHasKey('hours', $err);
    }

    /*==============================================================
      TC_DISC_02 : уникальное название
    ==============================================================*/
    public function testCreateUniqueName(): void
    {
        $busy = Discipline::first()->name ?? 'Алгебра';

        $v = new DisciplineValidator();
        $this->assertFalse($v->validate(['name'=>$busy, 'hours'=>48]));
        $this->assertArrayHasKey('name', $v->errors());
    }

    /*==============================================================
      TC_DISC_03 : успешное создание
    ==============================================================*/
    public function testCreateSuccess(): void
    {
        $name  = 'Теория вероятностей';
        $hours = 36;

        $v = new DisciplineValidator();
        $this->assertTrue($v->validate(['name'=>$name, 'hours'=>$hours]));

        $d = Discipline::create(['name'=>$name, 'hours'=>$hours]);
        $this->assertNotNull($d->id);

        self::$createdId = $d->id;
        $this->assertSame($name,  $d->name);
        $this->assertSame($hours, (int)$d->hours);
    }

    /*==============================================================
      TC_DISC_04 : успешное редактирование
    ==============================================================*/
    /**
     * @depends testCreateSuccess
     */
    public function testUpdateSuccess(): void
    {
        $d = Discipline::find(self::$createdId);
        $this->assertNotNull($d, 'Запись не найдена (создание могло провалиться)');

        $d->update([
            'name'  => 'Теория вероятностей – продвинутый курс',
            'hours' => 72,
        ]);

        $fresh = Discipline::find(self::$createdId);
        $this->assertSame('Теория вероятностей – продвинутый курс', $fresh->name);
        $this->assertSame(72, (int)$fresh->hours);
    }

    /*==============================================================
      TC_DISC_05 : успешное удаление
    ==============================================================*/
    /**
     * @depends testCreateSuccess
     */
    public function testDeleteSuccess(): void
    {
        $this->assertTrue((bool)Discipline::destroy(self::$createdId));
        $this->assertNull(Discipline::find(self::$createdId));
    }
}
