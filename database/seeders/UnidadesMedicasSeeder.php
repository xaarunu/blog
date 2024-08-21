<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadesMedicasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unidades = [
            ['id' => 1, 'nombre' => 'UMF49 CUITLAHUAC', 'estado' => 'Jalisco', 'municipio' => 'Guadalajara', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'UMF40 CHAPALA', 'estado' => 'Jalisco', 'municipio' => 'Chapala', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'UMF20 AUTLAN', 'estado' => 'Jalisco', 'municipio' => 'Autlán de Navarro', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nombre' => 'UMF10 SANTIAGO', 'estado' => 'Nayarit', 'municipio' => 'Santiago Ixcuintla', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nombre' => 'UMF20 TEPIC', 'estado' => 'Nayarit', 'municipio' => 'Tepic', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'nombre' => 'UMF24 AMECA', 'estado' => 'Jalisco', 'municipio' => 'Ameca', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'nombre' => 'UMF168 TEPATITLAN', 'estado' => 'Jalisco', 'municipio' => 'Tepatitlán', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'nombre' => 'UMF85 JALOSTOTITLAN', 'estado' => 'Jalisco', 'municipio' => 'Jalostotitlán', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'nombre' => 'UMF41 SAN JUAN DE LOS LAGOS', 'estado' => 'Jalisco', 'municipio' => 'San Juan de los Lagos', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'nombre' => 'UMF86 SAN MIGUEL EL ALTO', 'estado' => 'Jalisco', 'municipio' => 'San Miguel el Alto', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'nombre' => 'UMF07 LAGOS DE MORENO', 'estado' => 'Jalisco', 'municipio' => 'Lagos de Moreno', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'nombre' => 'UMF95 PONCITLAN', 'estado' => 'Jalisco', 'municipio' => 'Poncitlán', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'nombre' => 'UMF06 OCOTLAN', 'estado' => 'Jalisco', 'municipio' => 'Ocotlán', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'nombre' => 'UMF169 OCOTLAN', 'estado' => 'Jalisco', 'municipio' => 'Ocotlán', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'nombre' => 'UMF23 LA BARCA', 'estado' => 'Jalisco', 'municipio' => 'La Barca', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'nombre' => 'UMF09 CIUDAD GUZMAN', 'estado' => 'Jalisco', 'municipio' => 'Zapotlán El Grande', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'nombre' => 'UMF62 SAYULA', 'estado' => 'Jalisco', 'municipio' => 'Sayula', 'created_at' => now(), 'updated_at' => now()],
['id' => 18, 'nombre' => 'UMF111 ZAPOTLAN DEL REY', 'estado' => 'Jalisco', 'municipio' => '', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'nombre' => 'UMF179 PUERTO VALLARTA', 'estado' => 'Jalisco', 'municipio' => 'Puerto Vallarta', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'nombre' => 'UMF10 TEQUILA', 'estado' => 'Jalisco', 'municipio' => 'Tequila', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'nombre' => 'UMF75 TECOLOTLAN', 'estado' => 'Jalisco', 'municipio' => 'Tecolotlan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'nombre' => 'UMF81 EL GRULLO', 'estado' => 'Jalisco', 'municipio' => 'El Grullo', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'nombre' => 'UMF96 MASCOTA', 'estado' => 'Jalisco', 'municipio' => 'Mascota', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'nombre' => 'UMF82 UNION DE TULA', 'estado' => 'Jalisco', 'municipio' => 'Unión de Tula', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'nombre' => 'UMF71 AYUTLA', 'estado' => 'Jalisco', 'municipio' => 'Ayutla', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'nombre' => 'UMF132 SAN JULIAN', 'estado' => 'Jalisco', 'municipio' => 'San Julián', 'created_at' => now(), 'updated_at' => now()],    
            ['id' => 27, 'nombre' => 'UMF42 PUERTO VALLARTA', 'estado' => 'Jalisco', 'municipio' => 'Puerto Vallarta', 'created_at' => now(), 'updated_at' => now()],   
            ['id' => 28, 'nombre' => 'UMF50 ATOTONILQUILLO', 'estado' => 'Jalisco', 'municipio' => 'Atotonilquillo', 'created_at' => now(), 'updated_at' => now()],    
            ['id' => 29, 'nombre' => 'UMF31 AHUALULCO DEL MERCADO', 'estado' => 'Jalisco', 'municipio' => 'Ahualulco de Mercado', 'created_at' => now(), 'updated_at' => now()],    
            ['id' => 30, 'nombre' => 'UMF73 SAN MARTIN HIDALGO', 'estado' => 'Jalisco', 'municipio' => 'San Martín Hidalgo', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 31, 'nombre' => 'UMF26 TALA', 'estado' => 'Jalisco', 'municipio' => 'Tala', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'nombre' => 'UMF97 MAGDALENA', 'estado' => 'Jalisco', 'municipio' => 'Magdalena', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'nombre' => 'UMF48 OBLATOS', 'estado' => 'Jalisco', 'municipio' => 'Guadalajara', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'nombre' => 'UMF56 ACATLAN DE JUAREZ', 'estado' => 'Jalisco', 'municipio' => 'Acatlán de Juárez', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 35, 'nombre' => 'UMF27 VILLA CORONA', 'estado' => 'Jalisco', 'municipio' => 'Villa Corona', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 36, 'nombre' => 'UMF58 JOCOTEPEC', 'estado' => 'Jalisco', 'municipio' => 'Jocotepec', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 37, 'nombre' => 'UMF059 TLAJOMULCO', 'estado' => 'Jalisco', 'municipio' => 'Tlajomulco de Zúñiga', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 38, 'nombre' => 'UMF05 EL SALTO', 'estado' => 'Jalisco', 'municipio' => 'El Salto', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 39, 'nombre' => 'UMF08 TUXPAN', 'estado' => 'Nayarit', 'municipio' => 'Tuxpan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 40, 'nombre' => 'UMF06 ACAPONETA', 'estado' => 'Nayarit', 'municipio' => 'Acaponeta', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 41, 'nombre' => 'UMF13 SAN BLAS', 'estado' => 'Nayarit', 'municipio' => 'San Blas', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 42, 'nombre' => 'UMF07 TECUALA', 'estado' => 'Nayarit', 'municipio' => 'Tecuala', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 43, 'nombre' => 'UMF09 RUIZ', 'estado' => 'Nayarit', 'municipio' => 'Ruiz', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 44, 'nombre' => 'UMF15 LAS VARAS', 'estado' => 'Nayarit', 'municipio' => 'Las Varas', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 45, 'nombre' => 'UMF18 IXTLAN DEL RIO', 'estado' => 'Nayarit', 'municipio' => 'Ixtlán del Río', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 46, 'nombre' => 'UMF17 AHUACATLAN', 'estado' => 'Nayarit', 'municipio' => 'Ahuacatlán', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 47, 'nombre' => 'UMF14 COMPOSTELA', 'estado' => 'Nayarit', 'municipio' => 'Compostela', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 48, 'nombre' => 'UMF142 MIXTLAN', 'estado' => 'Jalisco', 'municipio' => 'Mixtlán', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 49, 'nombre' => 'UMF43 TOMATLAN', 'estado' => 'Jalisco', 'municipio' => 'Tomatlán', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 50, 'nombre' => 'UMF22 SAN JUAN DE ABAJO', 'estado' => 'Nayarit', 'municipio' => 'San Juan de Abajo', 'created_at' => now(), 'updated_at' => now()], 
            ['id' => 51, 'nombre' => 'UMF170 ARAMARA', 'estado' => 'Jalisco', 'municipio' => 'Puerto Vallarta', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 52, 'nombre' => 'UMF171 LAS AGUILAS', 'estado' => 'Jalisco', 'municipio' => 'Zapopan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 53, 'nombre' => 'UMF01 CALZADA DEL CAMPESINO', 'estado' => 'Jalisco', 'municipio' => 'Guadalajara', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 54, 'nombre' => 'UMF39 TLAQUEPAQUE', 'estado' => 'Jalisco', 'municipio' => 'Tlaquepaque', 'created_at' => now(), 'updated_at' => now()]
        ];
        DB::table('unidades_medicas')->insert($unidades);
    }
}
