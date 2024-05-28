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
            ['id' => 1, 'name' => 'Zona 1'],
            ['id' => 2, 'name' => 'Zona 2'],
            ['id' => 3, 'name' => 'Zona 3'],
            ['id' => 4, 'name' => 'Zona 4'],
            ['id' => 5, 'name' => 'Zona 5'],
            ['id' => 6, 'name' => 'Zona 6'],
            ['id' => 7, 'name' => 'Zona 7'],
            ['id' => 8, 'name' => 'Zona 8'],
            ['id' => 9, 'name' => 'Zona 9'],
            ['id' => 10, 'name' => 'Zona 10'],
        ]);
        $this->db->table('schools')->insert([
            ['id' => 1, 'name' => 'Esc. de Ens. Media Nº 439 Dr. Melitón Francisco Hierro'],
            ['id' => 2, 'name' => 'Esc. de Edu. Téc. Nº 477 Combate de San Lorenzo'],
            ['id' => 3, 'name' => 'Esc. de Edu. Téc. Nº 672 Remedios Escalada de San Martín'],
            ['id' => 4, 'name' => 'Esc. de Ens. Media Nº 549 Ma. Catalina Echavarría de Vidal'],
            ['id' => 5, 'name' => 'Esc. de Ens. Media Particular Incorp. Nº 8083 San Carlos'],
            ['id' => 6, 'name' => 'E.E.S.O.P.I. Nº 3180 Sta. Rosa de Viterbo'],
            ['id' => 7, 'name' => 'Colegio Nº 8111 Nuestra Sra. de la Misericordia'],
            ['id' => 8, 'name' => 'Esc. de Ens. Media Nº 548 Mariano Moreno'],
            ['id' => 9, 'name' => 'Esc. de Educación Secundaria Orientada Nº 438'],
            ['id' => 10, 'name' => 'Esc. de Educación Secundaria Irientada Part. Nº 3179 Cristiano Redentor'],
            // ['id' => 1, 'name' => 'Esc. de Ens. Media Nº 439 Dr. Melitón Francisco Hierro'],
            // ['id' => 2, 'name' => 'Esc. de Edu. Téc. Nº 477 Combate de San Lorenzo'],
            // ['id' => 3, 'name' => 'Colegio Nº 8111 Nuestra Sra. de la Misericordia'],
            // ['id' => 4, 'name' => 'Esc. de Ens. Media Nº 549 Ma. Catalina Echavarría de Vidal'],
            // ['id' => 5, 'name' => 'E.E.S.O.P.I. Nº 3180 Sta. Rosa de Viterbo'],
            // ['id' => 6, 'name' => 'Esc. de Ens. Media Particular Incorp. Nº 8083 San Carlos'],
            // ['id' => 7, 'name' => 'Esc. de Educación Secundaria Orientada Nº 438'],
            // ['id' => 8, 'name' => 'Esc. de Ens. Media Nº 548'],
            // ['id' => 9, 'name' => 'Esc. de Educación Secundaria Irientada Part. Nº 3179 Cristiano Redentor'],
            // ['id' => 10, 'name' => 'Esc. de Edu. Téc. Nº 672 Remedios Escalada de San Martín'],
        ]);
        $this->db->table('neighbourhoods')->insert([
            ['id' => 1, 'district_id' => 1, 'school_id' => 1, 'name' => 'Norte'],
            ['id' => 2, 'district_id' => 1, 'school_id' => 1, 'name' => 'Diaz Velez'],
            ['id' => 3, 'district_id' => 2, 'school_id' => 2, 'name' => 'Islas Malvinas'],
            ['id' => 4, 'district_id' => 2, 'school_id' => 2, 'name' => 'Oroño'],
            ['id' => 5, 'district_id' => 2, 'school_id' => 2, 'name' => 'El Pino'],
            ['id' => 6, 'district_id' => 3, 'school_id' => 3, 'name' => 'Capitán Bermudez'],
            ['id' => 7, 'district_id' => 3, 'school_id' => 3, 'name' => '3 de Febrero'],
            ['id' => 8, 'district_id' => 3, 'school_id' => 3, 'name' => 'Las Quintas'],
            ['id' => 9, 'district_id' => 4, 'school_id' => 4, 'name' => 'Fonavi Oeste'],
            ['id' => 10, 'district_id' => 4, 'school_id' => 4, 'name' => 'Alem'],
            ['id' => 11, 'district_id' => 4, 'school_id' => 4, 'name' => 'S.U.P.E.'],
            ['id' => 12, 'district_id' => 5, 'school_id' => 5, 'name' => 'Mitre'],
            ['id' => 13, 'district_id' => 6, 'school_id' => 6, 'name' => 'Remedios de Escalada'],
            ['id' => 14, 'district_id' => 6, 'school_id' => 6, 'name' => 'Del combate'],
            ['id' => 15, 'district_id' => 7, 'school_id' => 7, 'name' => 'Sargento Cabral'],
            ['id' => 16, 'district_id' => 7, 'school_id' => 7, 'name' => '17 de Agosto'],
            ['id' => 17, 'district_id' => 7, 'school_id' => 7, 'name' => '1° de Julio'],
            ['id' => 18, 'district_id' => 7, 'school_id' => 7, 'name' => 'San Martin'],
            ['id' => 19, 'district_id' => 8, 'school_id' => 8, 'name' => 'M. Moreno'],
            ['id' => 20, 'district_id' => 8, 'school_id' => 8, 'name' => 'José Hernandez'],
            ['id' => 21, 'district_id' => 9, 'school_id' => 9, 'name' => 'Villa Felisa'],
            ['id' => 22, 'district_id' => 9, 'school_id' => 9, 'name' => 'Rivadavia'],
            ['id' => 23, 'district_id' => 9, 'school_id' => 9, 'name' => 'Morando'],
            ['id' => 24, 'district_id' => 9, 'school_id' => 9, 'name' => 'San Eduardo'],
            ['id' => 25, 'district_id' => 10, 'school_id' => 10, 'name' => 'Bouchard'],
            ['id' => 26, 'district_id' => 10, 'school_id' => 10, 'name' => '2 de Abríl'],
        ]);
    }
}