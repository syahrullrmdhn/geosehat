<?php
use PHPUnit\Framework\TestCase;

class MCaseTest extends TestCase
{
    /** @var M_case */
    private $model;

    protected function setUp(): void
    {
        $this->model = new M_case();
        $db = get_instance()->db;
        $db->query('CREATE TABLE cases (id INTEGER PRIMARY KEY AUTOINCREMENT, confirmed INTEGER, recovered INTEGER, deaths INTEGER, suspected INTEGER);');
    }

    public function testSumColumnReturnsCorrectValue()
    {
        $db = get_instance()->db;
        $db->insert('cases', ['confirmed' => 1, 'recovered' => 0, 'deaths' => 0, 'suspected' => 0]);
        $db->insert('cases', ['confirmed' => 2, 'recovered' => 0, 'deaths' => 0, 'suspected' => 0]);

        $sum = $this->model->sumColumn('confirmed');
        $this->assertSame(3, $sum);
    }
}
