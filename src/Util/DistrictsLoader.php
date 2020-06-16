<?php namespace App\Util;

class DistrictsLoader
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up()
    {
        $this->db->table('districts')->insert([
            ['id' => 1, 'name' => 'Escuela'],
        ]);
        $this->db->table('neighbourhoods')->insert([
            ['id' => 1, 'district_id' => 1, 'name' => 'N°439 Dr. Melitón Francisco Hierro'],
            ['id' => 2, 'district_id' => 1, 'name' => 'Nuestra Señora de la Misericordia'],
            ['id' => 3, 'district_id' => 1, 'name' => 'Islas Malvinas'],
            ['id' => 4, 'district_id' => 1, 'name' => 'San Carlos'],
            ['id' => 5, 'district_id' => 1, 'name' => 'EESO N°548'],
            ['id' => 6, 'district_id' => 1, 'name' => 'EESO N°549'],
            ['id' => 7, 'district_id' => 1, 'name' => 'Colegio Cristiano Redentor'],
            ['id' => 8, 'district_id' => 1, 'name' => 'Santa Rosa de Viterbo'],
            ['id' => 9, 'district_id' => 1, 'name' => 'EETP N°672 Remedios Escalada de San Martín'],
            ['id' => 10, 'district_id' => 1, 'name' => 'EETP N°477 Combate de San Lorenzo'],
            ['id' => 11, 'district_id' => 1, 'name' => 'EEMPA N°1128 Juana Azurduy'],
            ['id' => 12, 'district_id' => 1, 'name' => 'Vivo en SL y voy a una escuela de otra localidad'],
        ]);
    }
}
