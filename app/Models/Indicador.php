<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    use HasFactory;

    protected $table = 'Indicadores';

    protected $fillable =  [
        'indicador',
        'meta',
        'tolerancia',
        'meta_con_margen',
        'mes',
        'año',
        'zona'
    ];

    static $PERSPECTIVES = [//100%
        'Financiero' => [//30%
            'ebitda',//5%
            'ive',//5%
            'cusb',//5%
            'ctp',//5%
            'cv',//5%
            'per',//5%
        ],
        'Clientes' => [//32%
            'pgc',//6%
            'imu',//5% -> 6% provisional
            'comser',//5%
            'eat',//5%
            'illa',//5%
            'pf',//6%
        ],
        'Procesos Internos' => [//25%
            'rez',//2.27%
            'recc',//2.27%
            'ioc',//2.27%
            'icc',//2.27%
            'cf',//2.27%
            'pca',//2.27%
            'dis',//2.27%
            'cca',//2.27%
            'usu',//2.27%
            'ven',//2.27%
            'pro',//2.27%
        ],
        'Aprendizaje y Conocimiento' => [//13%
            'da',//4.3%
            'dss',//4.3%
            'ico',//4.3%
        ],
    ];

    static $PERSPECIVAS_TIPO =
    [
        'ebitda' => 'Financiero',
        'ive' => 'Financiero',
        'cusb' => 'Financiero',
        'ctp' => 'Financiero',
        'cv' => 'Financiero',
        'per' => 'Financiero',

        'pgc' => 'Clientes',
        'imu' => 'Clientes',
        'comser' => 'Clientes',
        'eat' => 'Clientes',
        'illa' => 'Clientes',
        'pf' => 'Clientes',

        'rez' => 'Procesos Internos',
        'recc' => 'Procesos Internos',
        'ioc' => 'Procesos Internos',
        'icc' => 'Procesos Internos',
        'cf' => 'Procesos Internos',
        'pca' => 'Procesos Internos',
        'dis' => 'Procesos Internos',
        'cca' => 'Procesos Internos',
        'usu' => 'Procesos Internos',
        'ven' => 'Procesos Internos',
        'pro' => 'Procesos Internos',

        'da' => 'Aprendizaje y Conocimiento',
        'dss'=> 'Aprendizaje y Conocimiento',
        'ico'=> 'Aprendizaje y Conocimiento',
    ];

    static $INDICATORS_PERCENTAGES = [//100%
        'Financiero' => [//30%
            'ebitda' => 5,//5%
            'ive'=> 5,//5%
            'cusb'=> 5,//5%
            'ctp'=> 5,//5%
            'cv'=> 5,//5%
            'per'=> 5,//5%
        ],
        'Clientes' => [//32%
            'pgc'=> 6,//6%
            'imu'=> 5,//5%
            'comser'=> 5,//5%
            'eat'=> 5,//5%
            'illa'=> 5,//5%
            'pf'=> 6,//6%
        ],
        'Procesos Internos' => [//25%
            'rez'=> 2.27,//2.27%
            'recc'=> 2.27,//2.27%
            'ioc'=> 2.27,//2.27%
            'icc'=> 2.27,//2.27%
            'cf'=> 2.27,//2.27%
            'pca'=> 2.27,//2.27%
            'dis'=> 2.27,//2.27%
            'cca'=> 2.27,//2.27%
            'usu'=> 2.27,//2.27%
            'ven'=> 2.27,//2.27%
            'pro'=> 2.27,//2.27%
        ],
        'Aprendizaje y Conocimiento' => [//13%
            'da'=> 4.3,//4.3%
            'dss'=> 4.3,//4.3%
            'ico'=> 4.3,//4.3%
        ],
    ];/*[
        /////////////Financiero
        'ebitda'=>5,
        'ive'=>5,
        'cusb'=>5,
        'ctp'=>5,
        'cv'=>5,
        'per'=>5,
        /////////////Clientes
        'pgc'=>6,
        'imu'=>5,
        'comser'=>5,
        'eat'=>5,
        'illa'=>5,
        'pf'=>6,
        ////////////Procesos Internos
        'rez'=>2.27,
        'recc'=>2.27,
        'ioc'=>2.27,
        'icc'=>2.27,
        'cf'=>2.27,
        'pca'=>2.27,
        'dis'=>2.27,
        'cca' => 2.27,
        'usu' => 2.27,
        'ven' => 2.27,
        'pro' => 2.27,
        /////////////Aprendizaje y Conocimiento
        'da'=>4.3,
        'dss'=>4.3,
        'ico'=>4.3,
    ];*/

    static $PERSPECTIVES_PERCENTAGES = [
      'Financiero' => 30,
      'Clientes' => 32,
      'Procesos Internos' => 25,
      'Aprendizaje y Conocimiento' => 13,
    ];

    static $INDICATORS_ACTIVES = [
        //'Financiero'
            'ebitda',
            'ive',
            'cusb',
            'ctp',
            'cv',
            'per',

        //'Clientes'
            'pgc',
            'imu',
            'comser',
            'eat',
            'illa',
            'pf',

        //'Procesos Internos'
            'rez',
            'recc',
            'ioc',
            'icc',
            'cf',
            'pca',
            'dis',
            'cca',
            'usu',
            'ven',
            'pro',

        //'Aprendizaje y Conocimiento'
            'da',
            'dss',
            'ico',
    ];

    static $INDICATORS_DESCRIPTIONS = [
        /////////////Financiero
        'ebitda'=>'Ganancia antes de interés,Impuestos, depreciación y Amortización de CFE SSB',
        'ive'=> 'Ingresos por Venta de Energía Eléctrica',
        'cusb'=> 'Costo Unitario de Suministro Básico',
        'ctp'=> 'Cumplimiento al Techo Presupuestal',
        'cv'=> 'Cartera Vencida',
        'per'=> 'Pérdidas de Energía Eléctrica con AT',
        /////////////Clientes
        'pgc'=> 'Percepción Global del Cliente',
        'imu'=> 'Inconformidades por cada Mil Usuarios Total',
        'comser'=> 'Compromisos de Servicio',
        'eat'=> 'Efectividad en la Atención en Telefónica',
        'illa'=> 'Índice de Llamadas Atendidas Total',
        'pf'=> 'Percepción de la Facturación',
        ////////////Procesos Internos
        'rez'=>'Rezago',
        'recc'=> 'Recuperación Efectiva de las Cuentas por Cobrar',
        'ioc'=>'Índice de Oportunidad en la Cobranza',
        'icc'=>'Índice de Cobrabilidad',
        'cf'=>'Calidad en la Facturación',
        'pca'=> 'Pasivo Contingente Anualizado',
        'dis'=>'Disponibilidad de Sistemas Informáticos',
        'cca' => 'Cuentas por Cobrar Anualizado',
        'usu' => 'Usuarios',
        'ven' => 'Ventas',
        'pro' => 'Productos',
        /////////////Aprendizaje y Conocimiento
        'da'=>'Desempeño de Aprendizaje',
        'dss'=> 'Desempeño de Seguridad y Salud',
        'ico'=> 'Índice de Clima Organizacional',
    ];
}
