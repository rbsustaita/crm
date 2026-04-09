<?php

namespace Database\Seeders;

use App\Models\standard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StandardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $standard = new standard();
        $standard->id = 1; // Asignar el ID de la norma
        $standard->NOM = 'NOM-003-SSA1-2006';
        $standard->title = 'NORMA OFICIAL MEXICANA NOM-003-SSA1-2006, SALUD AMBIENTAL. REQUISITOS SANITARIOS QUE DEBE SATISFACER EL ETIQUETADO DE PINTURAS, TINTAS, BARNICES, LACAS Y ESMALTES';
        $standard->description = 'Pinturas, tintas, barnices, lacas y esmaltes';
        $standard->status = false;
        // Save the standard to the database
        $standard->save();
        // You can create more standards as needed

        $standard = new standard();
        $standard->id = 2; // Asignar el ID de la norma
        $standard->NOM = 'NOM-004-SE-2021';
        $standard->title = 'NORMA Oficial Mexicana NOM-004-SE-2021, Información comercial-Etiquetado de productos textiles, prendas de vestir, sus accesorios y ropa de casa (cancela a la NOM-004-SCFI-2006).';
        $standard->description = 'Textiles, prendas de vestir, sus accesorios y ropa de casa';
        $standard->status = true;
        // Save the standard to the database
        $standard->save();

        $standard = new standard();
        $standard->id = 3; // Asignar el ID de la norma
        $standard->NOM = 'NOM-015-SCFI-2007';
        $standard->title = 'NORMA Oficial Mexicana NOM-015-SCFI-2007, Información comercial-Etiquetado para juguetes.';
        $standard->description = 'Juguetes';
        $standard->status = false;
        // Save the standard to the database
        $standard->save();

        $standard = new standard();
        $standard->id = 4; // Asignar el ID de la norma
        $standard->NOM = 'NOM-020-SCFI-1997';
        $standard->title = 'NORMA Oficial Mexicana NOM-020-SCFI-1997, Información comercial-Etiquetado de cueros y pieles curtidas naturales y materiales sintéticos o artificiales con esa apariencia, calzado, marroquinerí­a, así­ como los productos elaborados con dichos materiales.';
        $standard->description = 'Cueros y pieles curtidas naturales y materiales sintéticos, cazado';
        $standard->status = true;
        $standard->save();


        $standard = new standard();
        $standard->id = 5; // Asignar el ID de la norma
        $standard->NOM = 'NOM-024-SCFI-2013';
        $standard->title = 'NORMA Oficial Mexicana NOM-024-SCFI-2013, Información comercial para empaques, instructivos y garantías de los productos electrónicos, eléctricos y electrodomésticos.';
        $standard->description = 'Electrónicos, eléctricos y electrodomésticos';
        $standard->status = true;
        // Save the standard to the database
        $standard->save();

        $standard = new standard();
        $standard->id = 6; // Asignar el ID de la norma
        $standard->NOM = 'NOM-050-SCFI-2004';
        $standard->title = 'NORMA Oficial Mexicana NOM-050-SCFI-2004, Información comercial-Etiquetado general de productos.';
        $standard->description = 'Productos en general';
        $standard->status = true;
        // Save the standard to the database
        $standard->save();


        $standard = new standard();
        $standard->id = 7; // Asignar el ID de la norma
        $standard->NOM = 'NOM-051-SCFI/SSA1-2010';
        $standard->title = 'Norma Oficial Mexicana NOM-051-SCFI/SSA1-2010, Especificaciones generales de etiquetado para alimentos y bebidas no alcohólicas preenvasados-Información comercial y sanitaria,  publicada el 5 de abril de 2010. ';
        $standard->description = 'Alimentos y bebidas no alcohólicas preenvasadas';
        $standard->status = false;
        // Save the standard to the database
        $standard->save();

        $standard = new standard();
        $standard->id = 8; // Asignar el ID de la norma
        $standard->NOM = 'NOM-055-SCFI-1994';
        $standard->title = 'NORMA Oficial Mexicana NOM-055-SCFI-1994, Información comercial - Materiales retardantes y/o inhibidores de flama y/o ignífugos - Etiquetado.';
        $standard->description = 'Materiales retardantes, inhibidores de fuego';
        $standard->status = false;
        // Save the standard to the database
        $standard->save();


        $standard = new standard();
        $standard->id = 9; // Asignar el ID de la norma
        $standard->NOM = 'NOM-139-SCFI-2012';
        $standard->title = 'NORMA Oficial Mexicana NOM-139-SCFI-2012, Información comercial-Etiquetado de extracto natural de vainilla (Vanilla spp), derivados y sustitutos.';
        $standard->description = 'Extracto natural de vainilla, derivados y surtidos';
        $standard->status = false;
        // Save the standard to the database
        $standard->save();

        $standard = new standard();
        $standard->id = 10; // Asignar el ID de la norma
        $standard->NOM = 'NOM-141-SSA1/SCFI-2012';
        $standard->title = 'NORMA Oficial Mexicana NOM-141-SSA1/SCFI-2012, Etiquetado para productos cosméticos preenvasados. Etiquetado sanitario y comercial.';
        $standard->description = 'Cosméticos';
        $standard->status = false;
        // Save the standard to the database
        $standard->save();


        $standard = new standard();
        $standard->id = 11; // Asignar el ID de la norma
        $standard->NOM = 'NOM-142-SSA1/SCFI-2014';
        $standard->title = 'NORMA Oficial Mexicana NOM-142-SSA1/SCFI-2014, Bebidas alcohólicas. Especificaciones sanitarias. Etiquetado sanitario y comercial.';
        $standard->description = 'Bebidas alcohólicas';
        $standard->status = false;
        // Save the standard to the database
        $standard->save();

        $standard = new standard();
        $standard->id = 12; // Asignar el ID de la norma
        $standard->NOM = 'NOM-187-SSA1/SCFI-2002';
        $standard->title = 'NORMA Oficial Mexicana NOM-187-SSA1/SCFI-2002, Productos y servicios. Masa, tortillas, tostadas y harinas preparadas para su elaboración y establecimientos donde se procesan. Especificaciones sanitarias. Información comercial. Métodos de prueba.';
        $standard->description = 'Masa, tortillas, tostadas preparadas para su elaboración';
        $standard->status = false;
        // Save the standard to the database
        $standard->save();

        $standard = new standard();
        $standard->id = 13; // Asignar el ID de la norma
        $standard->NOM = 'NOM-189-SSA1/SCFI-2018';
        $standard->title = 'NORMA Oficial Mexicana NOM-189-SSA1/SCFI-2018, Productos y servicios. Etiquetado y envasado para productos de aseo de uso doméstico.';
        $standard->description = 'Aseo doméstico';
        $standard->status = false;
        // Save the standard to the database
        $standard->save();

        $standard = new standard();
        $standard->id = 14; // Asignar el ID de la norma
        $standard->NOM = 'NOM-235-SE-2020';
        $standard->title = 'NORMA Oficial Mexicana NOM-235-SE-2020, Atún y bonita preenvasados-Denominación-Especificaciones-Información comercial y métodos de prueba.';
        $standard->description = 'Atún y bonita preenvasados';
        $standard->status = false;
        // Save the standard to the database
        $standard->save();
    }
}
