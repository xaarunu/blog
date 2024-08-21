<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return voarea_clave
     */
    public function run()
    {
        //$areas = [
            Area::insert(['area_clave' => 'D200', 'area_nombre' => 'Dirección General', 'division_id' => 'D2', 'tipo' => 'Direccion']);


            //  datos  oficinas  divisionales
            Area::insert(['area_clave' => 'DA00', 'area_nombre' => 'Oficinas Divisional Baja California', 'division_id' => 'DA', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DB00', 'area_nombre' => 'Oficinas Divisional Noroeste', 'division_id' => 'DB', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DD00', 'area_nombre' => 'Oficinas Divisional Golfo Norte', 'division_id' => 'DD', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DF00', 'area_nombre' => 'Oficinas Divisional Centro Occidente', 'division_id' => 'DF', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DC00', 'area_nombre' => 'Oficinas Divisional Norte', 'division_id' => 'DC', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DJ00', 'area_nombre' => 'Oficinas Divisional Oriente', 'division_id' => 'DJ', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DG00', 'area_nombre' => 'Oficinas Divisional Centro Sur', 'division_id' => 'DG', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DK00', 'area_nombre' => 'Oficinas Divisional Sureste', 'division_id' => 'DK', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DL00', 'area_nombre' => 'Oficinas Divisional Valle de México Norte', 'division_id' => 'DL', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DM00', 'area_nombre' => 'Oficinas Divisional Valle de México Cto', 'division_id' => 'DM', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DN00', 'area_nombre' => 'Oficinas Divisional Valle de México Sur', 'division_id' => 'DN', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DP00', 'area_nombre' => 'Oficinas Divisional Bajío', 'division_id' => 'DP', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DU00', 'area_nombre' => 'Oficinas Divisional Golfo Centro', 'division_id' => 'DU', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DV00', 'area_nombre' => 'Oficinas Divisional Centro Oriente', 'division_id' => 'DV', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DW00', 'area_nombre' => 'Oficinas Divisional Peninsular', 'division_id' => 'DW', 'tipo' => 'Oficina Divisional']);
            Area::insert(['area_clave' => 'DX00', 'area_nombre' => 'Oficinas Divisional Jalisco', 'division_id' => 'DX', 'tipo' => 'Oficina Divisional']);


            Area::insert(['area_clave' => 'DAC0', 'area_nombre' => 'CAR Baja California', 'division_id' => 'DA', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DBC0', 'area_nombre' => 'CAR Noroeste', 'division_id' => 'DB', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DDC0', 'area_nombre' => 'CAR Golfo Norte', 'division_id' => 'DD', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DFC0', 'area_nombre' => 'CAR Centro Occidente', 'division_id' => 'DF', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DCC0', 'area_nombre' => 'CAR Norte', 'division_id' => 'DC', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DJC0', 'area_nombre' => 'CAR Oriente', 'division_id' => 'DJ', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DGC0', 'area_nombre' => 'CAR Centro Sur', 'division_id' => 'DG', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DKC0', 'area_nombre' => 'CAR Sureste', 'division_id' => 'DK', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DLC0', 'area_nombre' => 'CAR Valle de México Norte', 'division_id' => 'DL', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DMC0', 'area_nombre' => 'CAR Valle de México Cto', 'division_id' => 'DM', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DNC0', 'area_nombre' => 'CAR Valle de México Sur', 'division_id' => 'DN', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DPC0', 'area_nombre' => 'CAR Bajío', 'division_id' => 'DP', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DUC0', 'area_nombre' => 'CAR Golfo Centro', 'division_id' => 'DU', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DVC0', 'area_nombre' => 'CAR Centro Oriente', 'division_id' => 'DV', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DWC0', 'area_nombre' => 'CAR Peninsular', 'division_id' => 'DW', 'tipo' => 'CAR']);
            Area::insert(['area_clave' => 'DXC0', 'area_nombre' => 'CAR Jalisco', 'division_id' => 'DX', 'tipo' => 'CAR']);







            Area::insert(['area_clave' => 'DA01', 'area_nombre' => 'Zona Tijuana', 'division_id' => 'DA']);
            Area::insert(['area_clave' => 'DA02', 'area_nombre' => 'Zona La Paz', 'division_id' => 'DA']);
            Area::insert(['area_clave' => 'DA08', 'area_nombre' => 'Zona Ensenada', 'division_id' => 'DA']);
            Area::insert(['area_clave' => 'DA10', 'area_nombre' => 'Zona Cd Constitución', 'division_id' => 'DA']);
            Area::insert(['area_clave' => 'DA15', 'area_nombre' => 'Zona Mexicali', 'division_id' => 'DA']);
            Area::insert(['area_clave' => 'DA16', 'area_nombre' => 'Zona San Luis', 'division_id' => 'DA']);
            Area::insert(['area_clave' => 'DA17', 'area_nombre' => 'Zona Los Cabos', 'division_id' => 'DA']);

            Area::insert(['area_clave' => 'DB01', 'area_nombre' => 'Zona Hermosillo', 'division_id' => 'DB']);
            Area::insert(['area_clave' => 'DB02', 'area_nombre' => 'Zona Guaymas', 'division_id' => 'DB']);
            Area::insert(['area_clave' => 'DB03', 'area_nombre' => 'Zona Obregón', 'division_id' => 'DB']);
            Area::insert(['area_clave' => 'DB04', 'area_nombre' => 'Zona Navojoa', 'division_id' => 'DB']);
            Area::insert(['area_clave' => 'DB05', 'area_nombre' => 'Zona Mazatlán', 'division_id' => 'DB']);
            Area::insert(['area_clave' => 'DB07', 'area_nombre' => 'Zona Mochis', 'division_id' => 'DB']);
            Area::insert(['area_clave' => 'DB08', 'area_nombre' => 'Zona Guasave', 'division_id' => 'DB']);
            Area::insert(['area_clave' => 'DB10', 'area_nombre' => 'Zona Culiacán', 'division_id' => 'DB']);
            Area::insert(['area_clave' => 'DB15', 'area_nombre' => 'Zona Caborca', 'division_id' => 'DB']);
            Area::insert(['area_clave' => 'DB33', 'area_nombre' => 'Zona Nogales', 'division_id' => 'DB']);

            Area::insert(['area_clave' => 'DC01', 'area_nombre' => 'Zona Chihuahua', 'division_id' => 'DC']);
            Area::insert(['area_clave' => 'DC02', 'area_nombre' => 'Zona Cuauhtémoc', 'division_id' => 'DC']);
            Area::insert(['area_clave' => 'DC04', 'area_nombre' => 'Zona Juárez', 'division_id' => 'DC']);
            Area::insert(['area_clave' => 'DC06', 'area_nombre' => 'Zona Delicias', 'division_id' => 'DC']);
            Area::insert(['area_clave' => 'DC14', 'area_nombre' => 'Zona Casas Grandes', 'division_id' => 'DC']);
            Area::insert(['area_clave' => 'DC22', 'area_nombre' => 'Zona Torreón', 'division_id' => 'DC']);
            Area::insert(['area_clave' => 'DC24', 'area_nombre' => 'Zona Parral', 'division_id' => 'DC']);
            Area::insert(['area_clave' => 'DC26', 'area_nombre' => 'Zona Durango', 'division_id' => 'DC']);
            Area::insert(['area_clave' => 'DC27', 'area_nombre' => 'Zona Gómez Palacio', 'division_id' => 'DC']);

            Area::insert(['area_clave' => 'DD03', 'area_nombre' => 'Zona Nuevo Laredo', 'division_id' => 'DD']);
            Area::insert(['area_clave' => 'DD04', 'area_nombre' => 'Zona Reynosa', 'division_id' => 'DD']);
            Area::insert(['area_clave' => 'DD05', 'area_nombre' => 'Zona Cerralvo Sabina', 'division_id' => 'DD']);
            Area::insert(['area_clave' => 'DD06', 'area_nombre' => 'Zona Montemorelos', 'division_id' => 'DD']);
            Area::insert(['area_clave' => 'DD09', 'area_nombre' => 'Zona Matamoros', 'division_id' => 'DD']);
            Area::insert(['area_clave' => 'DD10', 'area_nombre' => 'Zona Metro Norte', 'division_id' => 'DD']);
            Area::insert(['area_clave' => 'DD11', 'area_nombre' => 'Zona Metro Oriente', 'division_id' => 'DD']);
            Area::insert(['area_clave' => 'DD12', 'area_nombre' => 'Zona Metro Poniente', 'division_id' => 'DD']);
            Area::insert(['area_clave' => 'DD16', 'area_nombre' => 'Zona Piedras Negras', 'division_id' => 'DD']);
            Area::insert(['area_clave' => 'DD17', 'area_nombre' => 'Zona Sabinas', 'division_id' => 'DD']);
            Area::insert(['area_clave' => 'DD18', 'area_nombre' => 'Zona Monclova', 'division_id' => 'DD']);
            Area::insert(['area_clave' => 'DD19', 'area_nombre' => 'Zona Saltillo', 'division_id' => 'DD']);

            Area::insert(['area_clave' => 'DF07', 'area_nombre' => 'Zona Morelia', 'division_id' => 'DF']);
            Area::insert(['area_clave' => 'DF12', 'area_nombre' => 'Zona Uruapan', 'division_id' => 'DF']);
            Area::insert(['area_clave' => 'DF15', 'area_nombre' => 'Zona Zamora', 'division_id' => 'DF']);
            Area::insert(['area_clave' => 'DF25', 'area_nombre' => 'Zona Colima', 'division_id' => 'DF']);
            Area::insert(['area_clave' => 'DF30', 'area_nombre' => 'Zona Zitácuaro', 'division_id' => 'DF']);
            Area::insert(['area_clave' => 'DF35', 'area_nombre' => 'Zona Lázaro Cárdenas', 'division_id' => 'DF']);
            Area::insert(['area_clave' => 'DF40', 'area_nombre' => 'Zona La Piedad', 'division_id' => 'DF']);
            Area::insert(['area_clave' => 'DF45', 'area_nombre' => 'Zona Pátzcuaro', 'division_id' => 'DF']);
            Area::insert(['area_clave' => 'DF50', 'area_nombre' => 'Zona Apatzingán', 'division_id' => 'DF']);
            Area::insert(['area_clave' => 'DF55', 'area_nombre' => 'Zona Manzanillo', 'division_id' => 'DF']);
            Area::insert(['area_clave' => 'DF60', 'area_nombre' => 'Zona Jiquilpan', 'division_id' => 'DF']);
            Area::insert(['area_clave' => 'DF65', 'area_nombre' => 'Zona Zacapu', 'division_id' => 'DF']);

            Area::insert(['area_clave' => 'DG11', 'area_nombre' => 'Zona Chilpancingo', 'division_id' => 'DG']);
            Area::insert(['area_clave' => 'DG21', 'area_nombre' => 'Zona Iguala', 'division_id' => 'DG']);
            Area::insert(['area_clave' => 'DG31', 'area_nombre' => 'Zona Morelos', 'division_id' => 'DG']);
            Area::insert(['area_clave' => 'DG35', 'area_nombre' => 'Zona Cuautla', 'division_id' => 'DG']);
            Area::insert(['area_clave' => 'DG41', 'area_nombre' => 'Zona Atlacomulco', 'division_id' => 'DG']);
            Area::insert(['area_clave' => 'DG51', 'area_nombre' => 'Zona Altamirano', 'division_id' => 'DG']);
            Area::insert(['area_clave' => 'DG61', 'area_nombre' => 'Zona Cuernavaca', 'division_id' => 'DG']);
            Area::insert(['area_clave' => 'DG71', 'area_nombre' => 'Zona Valle de Bravo', 'division_id' => 'DG']);
            Area::insert(['area_clave' => 'DG81', 'area_nombre' => 'Zona Acapulco', 'division_id' => 'DG']);
            Area::insert(['area_clave' => 'DG91', 'area_nombre' => 'Zona Zihuatanejo', 'division_id' => 'DG']);

            Area::insert(['area_clave' => 'DJ01', 'area_nombre' => 'Zona Poza Rica', 'division_id' => 'DJ']);
            Area::insert(['area_clave' => 'DJ02', 'area_nombre' => 'Zona Xalapa', 'division_id' => 'DJ']);
            Area::insert(['area_clave' => 'DJ03', 'area_nombre' => 'Zona Teziutlán', 'division_id' => 'DJ']);
            Area::insert(['area_clave' => 'DJ06', 'area_nombre' => 'Zona Veracruz', 'division_id' => 'DJ']);
            Area::insert(['area_clave' => 'DJ07', 'area_nombre' => 'Zona Papaloapán', 'division_id' => 'DJ']);
            Area::insert(['area_clave' => 'DJ10', 'area_nombre' => 'Zona Los Tuxtlas', 'division_id' => 'DJ']);
            Area::insert(['area_clave' => 'DJ11', 'area_nombre' => 'Zona Coatzacoalcos', 'division_id' => 'DJ']);
            Area::insert(['area_clave' => 'DJ13', 'area_nombre' => 'Zona Orizaba', 'division_id' => 'DJ']);
            Area::insert(['area_clave' => 'DJ14', 'area_nombre' => 'Zona Córdoba', 'division_id' => 'DJ']);

            Area::insert(['area_clave' => 'DK03', 'area_nombre' => 'Zona San Cristóbal', 'division_id' => 'DK']);
            Area::insert(['area_clave' => 'DK04', 'area_nombre' => 'Zona Tuxtla', 'division_id' => 'DK']);
            Area::insert(['area_clave' => 'DK09', 'area_nombre' => 'Zona Oaxaca', 'division_id' => 'DK']);
            Area::insert(['area_clave' => 'DK11', 'area_nombre' => 'Zona Huatulco', 'division_id' => 'DK']);
            Area::insert(['area_clave' => 'DK12', 'area_nombre' => 'Zona Huajuapan', 'division_id' => 'DK']);
            Area::insert(['area_clave' => 'DK13', 'area_nombre' => 'Zona Tapachula', 'division_id' => 'DK']);
            Area::insert(['area_clave' => 'DK14', 'area_nombre' => 'Zona Tehuantepec', 'division_id' => 'DK']);
            Area::insert(['area_clave' => 'DK17', 'area_nombre' => 'Zona Villahermosa', 'division_id' => 'DK']);
            Area::insert(['area_clave' => 'DK18', 'area_nombre' => 'Zona Chontalpa', 'division_id' => 'DK']);
            Area::insert(['area_clave' => 'DK19', 'area_nombre' => 'Zona Los Ríos', 'division_id' => 'DK']);

            Area::insert(['area_clave' => 'DL10', 'area_nombre' => 'Zona Basílica', 'division_id' => 'DL']);
            Area::insert(['area_clave' => 'DL20', 'area_nombre' => 'Zona Cuautitlán', 'division_id' => 'DL']);
            Area::insert(['area_clave' => 'DL30', 'area_nombre' => 'Zona Atizapan', 'division_id' => 'DL']);
            Area::insert(['area_clave' => 'DL40', 'area_nombre' => 'Zona Azteca', 'division_id' => 'DL']);
            Area::insert(['area_clave' => 'DL50', 'area_nombre' => 'Zona Tlalnepantla', 'division_id' => 'DL']);
            Area::insert(['area_clave' => 'DL60', 'area_nombre' => 'Zona Ecatepec', 'division_id' => 'DL']);
            Area::insert(['area_clave' => 'DL70', 'area_nombre' => 'Zona Naucalpan', 'division_id' => 'DL']);

            Area::insert(['area_clave' => 'DM25', 'area_nombre' => 'Zona Aeropuerto', 'division_id' => 'DM']);
            Area::insert(['area_clave' => 'DM22', 'area_nombre' => 'Zona Benito Juárez', 'division_id' => 'DM']);
            Area::insert(['area_clave' => 'DM27', 'area_nombre' => 'Zona Chapingo', 'division_id' => 'DM']);
            Area::insert(['area_clave' => 'DM26', 'area_nombre' => 'Zona Neza', 'division_id' => 'DM']);
            Area::insert(['area_clave' => 'DM23', 'area_nombre' => 'Zona Polanco', 'division_id' => 'DM']);
            Area::insert(['area_clave' => 'DM24', 'area_nombre' => 'Zona Tacuba', 'division_id' => 'DM']);
            Area::insert(['area_clave' => 'DM21', 'area_nombre' => 'Zona Zócalo', 'division_id' => 'DM']);

            Area::insert(['area_clave' => 'DN10', 'area_nombre' => 'Zona Universidad', 'division_id' => 'DN']);
            Area::insert(['area_clave' => 'DN20', 'area_nombre' => 'Zona Lomas', 'division_id' => 'DN']);
            Area::insert(['area_clave' => 'DN30', 'area_nombre' => 'Zona Ermita', 'division_id' => 'DN']);
            Area::insert(['area_clave' => 'DN40', 'area_nombre' => 'Zona Tenango', 'division_id' => 'DN']);
            Area::insert(['area_clave' => 'DN50', 'area_nombre' => 'Zona Toluca', 'division_id' => 'DN']);
            Area::insert(['area_clave' => 'DN60', 'area_nombre' => 'Zona Volcanes', 'division_id' => 'DN']);
            Area::insert(['area_clave' => 'DN70', 'area_nombre' => 'Zona Coapa', 'division_id' => 'DN']);

            Area::insert(['area_clave' => 'DP03', 'area_nombre' => 'Zona San Juan del Río', 'division_id' => 'DP']);
            Area::insert(['area_clave' => 'DP06', 'area_nombre' => 'Zona Irapuato', 'division_id' => 'DP']);
            Area::insert(['area_clave' => 'DP07', 'area_nombre' => 'Zona Léon', 'division_id' => 'DP']);
            Area::insert(['area_clave' => 'DP08', 'area_nombre' => 'Zona Celaya', 'division_id' => 'DP']);
            Area::insert(['area_clave' => 'DP09', 'area_nombre' => 'Zona Querétaro', 'division_id' => 'DP']);
            Area::insert(['area_clave' => 'DP10', 'area_nombre' => 'Zona Salvatierra', 'division_id' => 'DP']);
            Area::insert(['area_clave' => 'DP13', 'area_nombre' => 'Zona Ixmiquilpan', 'division_id' => 'DP']);
            Area::insert(['area_clave' => 'DP52', 'area_nombre' => 'Zona Aguascalientes', 'division_id' => 'DP']);
            Area::insert(['area_clave' => 'DP53', 'area_nombre' => 'Zona Fresnillo', 'division_id' => 'DP']);
            Area::insert(['area_clave' => 'DP58', 'area_nombre' => 'Zona Zacatecas', 'division_id' => 'DP']);

            Area::insert(['area_clave' => 'DU01', 'area_nombre' => 'Zona Tampico', 'division_id' => 'DU']);
            Area::insert(['area_clave' => 'DU02', 'area_nombre' => 'Zona Mante', 'division_id' => 'DU']);
            Area::insert(['area_clave' => 'DU03', 'area_nombre' => 'Zona Victoria', 'division_id' => 'DU']);
            Area::insert(['area_clave' => 'DU04', 'area_nombre' => 'Zona Matehuala', 'division_id' => 'DU']);
            Area::insert(['area_clave' => 'DU05', 'area_nombre' => 'Zona San Luis Potosí', 'division_id' => 'DU']);
            Area::insert(['area_clave' => 'DU06', 'area_nombre' => 'Zona Río Verde', 'division_id' => 'DU']);
            Area::insert(['area_clave' => 'DU07', 'area_nombre' => 'Zona Valles', 'division_id' => 'DU']);
            Area::insert(['area_clave' => 'DU08', 'area_nombre' => 'Zona Huejutla', 'division_id' => 'DU']);

            Area::insert(['area_clave' => 'DV02', 'area_nombre' => 'Zona Tlaxcala', 'division_id' => 'DV']);
            Area::insert(['area_clave' => 'DV03', 'area_nombre' => 'Zona Tehuacán', 'division_id' => 'DV']);
            Area::insert(['area_clave' => 'DV04', 'area_nombre' => 'Zona I de Matamoros', 'division_id' => 'DV']);
            Area::insert(['area_clave' => 'DV05', 'area_nombre' => 'Zona San Martín', 'division_id' => 'DV']);
            Area::insert(['area_clave' => 'DV06', 'area_nombre' => 'Zona Tecamachalco', 'division_id' => 'DV']);
            Area::insert(['area_clave' => 'DV07', 'area_nombre' => 'Zona Puebla Poniente', 'division_id' => 'DV']);
            Area::insert(['area_clave' => 'DV08', 'area_nombre' => 'Zona Puebla Oriente', 'division_id' => 'DV']);
            Area::insert(['area_clave' => 'DV11', 'area_nombre' => 'Zona Pachuca', 'division_id' => 'DV']);
            Area::insert(['area_clave' => 'DV12', 'area_nombre' => 'Zona Tulancingo', 'division_id' => 'DV']);
            Area::insert(['area_clave' => 'DV13', 'area_nombre' => 'Zona Tula', 'division_id' => 'DV']);

            Area::insert(['area_clave' => 'DW01', 'area_nombre' => 'Zona Mérida', 'division_id' => 'DW']);
            Area::insert(['area_clave' => 'DW03', 'area_nombre' => 'Zona Ticul', 'division_id' => 'DW']);
            Area::insert(['area_clave' => 'DW04', 'area_nombre' => 'Zona Campeche', 'division_id' => 'DW']);
            Area::insert(['area_clave' => 'DW05', 'area_nombre' => 'Zona Cd Carmen', 'division_id' => 'DW']);
            Area::insert(['area_clave' => 'DW06', 'area_nombre' => 'Zona Chetumal', 'division_id' => 'DW']);
            Area::insert(['area_clave' => 'DW07', 'area_nombre' => 'Zona Tizimín', 'division_id' => 'DW']);
            Area::insert(['area_clave' => 'DW08', 'area_nombre' => 'Zona Motul', 'division_id' => 'DW']);
            Area::insert(['area_clave' => 'DW12', 'area_nombre' => 'Zona Cancún', 'division_id' => 'DW']);
            Area::insert(['area_clave' => 'DW22', 'area_nombre' => 'Zona Riviera Maya', 'division_id' => 'DW']);

            Area::insert(['area_clave' => 'DX02', 'area_nombre' => 'Zona Altos', 'division_id' => 'DX']);
            Area::insert(['area_clave' => 'DX03', 'area_nombre' => 'Zona Cienega', 'division_id' => 'DX']);
            Area::insert(['area_clave' => 'DX04', 'area_nombre' => 'Zona Zapotlán', 'division_id' => 'DX']);
            Area::insert(['area_clave' => 'DX05', 'area_nombre' => 'Zona Costa', 'division_id' => 'DX']);
            Area::insert(['area_clave' => 'DX06', 'area_nombre' => 'Zona Minas', 'division_id' => 'DX']);
            Area::insert(['area_clave' => 'DX07', 'area_nombre' => 'Zona Chapala', 'division_id' => 'DX']);
            Area::insert(['area_clave' => 'DX11', 'area_nombre' => 'Zona Santiago', 'division_id' => 'DX']);
            Area::insert(['area_clave' => 'DX12', 'area_nombre' => 'Zona Tepic', 'division_id' => 'DX']);
            Area::insert(['area_clave' => 'DX13', 'area_nombre' => 'Zona Vallarta', 'division_id' => 'DX']);
            Area::insert(['area_clave' => 'DX14', 'area_nombre' => 'Zona Hidalgo', 'division_id' => 'DX']);
            Area::insert(['area_clave' => 'DX15', 'area_nombre' => 'Zona Juárez', 'division_id' => 'DX']);
            Area::insert(['area_clave' => 'DX16', 'area_nombre' => 'Zona Libertad', 'division_id' => 'DX']);
            Area::insert(['area_clave' => 'DX17', 'area_nombre' => 'Zona Reforma', 'division_id' => 'DX']);

            Area::insert(['area_clave' => 'DXSU', 'area_nombre' => 'SUTERM', 'division_id' => 'DX']);
        //];

        //Area::insert($areas);
    //}
}
}
