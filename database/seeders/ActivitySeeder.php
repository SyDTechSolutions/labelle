<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('activities')->insert([
            [
                'actividad' => 'CULTIVO DE CANA DE AZUCAR',
                'codigo' => '114.0',
                'descripcion' => 'Cultivo de caña de azúcar',
            ],
            [
                'actividad' => 'CULTIVO DE TABACO',
                'codigo' => '115.0',
                'descripcion' => 'Cultivo de tabaco',
            ],
            [
                'actividad' => 'CULTIVO DE ALGODON',
                'codigo' => '116.0',
                'descripcion' => 'Cultivo de plantas de fibras',
            ],
            [
                'actividad' => 'CULTIVO DE FLORES DE TODO TIPO',
                'codigo' => '119.1',
                'descripcion' => 'Cultivo de Flores',
            ],
            [
                'actividad' => 'CULTIVO DE BANANO',
                'codigo' => '122.1',
                'descripcion' => 'Cultivo de banano',
            ],
            [
                'actividad' => 'CULTIVO DE PINA',
                'codigo' => '122.3',
                'descripcion' => 'Cultivo de piña',
            ],
            [
                'actividad' => 'CULTIVO DE FRUTAS',
                'codigo' => '122.9',
                'descripcion' => 'Cultivo de otras frutas tropicales y subtropicales',
            ],
            [
                'actividad' => 'CULTIVO DE SEMILLAS COMESTIBLES Y GERMINACION DE SEMILLAS OLEAGINOSAS',
                'codigo' => '125.0',
                'descripcion' => 'Cultivo de otros frutos y nueces de árboles y arbustos',
            ],
            [
                'actividad' => 'CULTIVO DE PALMA AFRICANA Y OTROS FRUTOS OLEAGINOSOS',
                'codigo' => '126.1',
                'descripcion' => 'Cultivo de palma africana (aceitera)',
            ],
            [
                'actividad' => 'CULTIVO DE CAFE',
                'codigo' => '127.1',
                'descripcion' => 'Cultivo de café',
            ],
            [
                'actividad' => 'CULTIVO DE ESPECIAS DE TODO TIPO',
                'codigo' => '128.0',
                'descripcion' => 'Cultivo de especies de plantas aromáticas, medicinales y farmacéuticas',
            ],
            [
                'actividad' => 'CRIA Y VENTA DE GANADO BOVINO (VACUNO) Y BUFALO',
                'codigo' => '141.1',
                'descripcion' => 'Cría de ganado Bovino (vacuno) para carne',
            ],
            [
                'actividad' => 'PRODUCCION DE LECHE CRUDA Y OTROS PRODUCTOS LACTEOS SIN PROCESAMIENTO INCLUIDOS EN CANASTA BASICA',
                'codigo' => '141.2',
                'descripcion' => 'Cría de ganado Bovino (vacuno) para producción de leche cruda',
            ],
            [
                'actividad' => 'PRODUCCION DE SEMEN BOVINO, VENTA DE SEMEN CONGELADO Y DILUYENTE PARA SEMEN',
                'codigo' => '141.9',
                'descripcion' => 'Cría de Búfalos y otra producción de ganado bovino (vacuno)',
            ],
            [
                'actividad' => 'CRIA DE CABALLOS Y OTROS EQUINOS',
                'codigo' => '142.0',
                'descripcion' => 'Cría de caballos y otros equinos',
            ],
            [
                'actividad' => 'CRIA DE ANIMALES DOMESTICOS COMO:OVEJAS Y CABRAS',
                'codigo' => '144.0',
                'descripcion' => 'Cría de ovejas y cabras',
            ],
            [
                'actividad' => 'CRIA DE CERDOS',
                'codigo' => '145.0',
                'descripcion' => 'Cría de cerdos',
            ],
            [
                'actividad' => 'PRODUCCION DE HUEVOS DE GALLINA INCLUIDOS EN LA CANASTA BASICA',
                'codigo' => '146.2',
                'descripcion' => 'Actividades de granja para la producción de huevos de gallina',
            ],
            [
                'actividad' => 'CULTIVO DE PRODUCTOS AGRICOLAS EN COMBINACION CON LA CRIA DE ANIMALES (EXPLOTACI',
                'codigo' => '150.0',
                'descripcion' => 'Cultivo de productos agrícolas en combinación con la cría de animales (explotación mixta)',
            ],
            [
                'actividad' => 'SERVICIO DE HERRADURA',
                'codigo' => '162.9',
                'descripcion' => 'Otras actividades de apoyo a la ganadería',
            ],
            [
                'actividad' => 'BENEFICIO O PROCESAMIENTO DE CAFE',
                'codigo' => '163.1',
                'descripcion' => 'Beneficio de café',
            ],
            [
                'actividad' => 'RECOLECCION DE COSECHAS Y ACTIVIDADES CONEXAS',
                'codigo' => '163.9',
                'descripcion' => 'Otras actividades posteriores a la cosecha',
            ],
            [
                'actividad' => 'CAZA ORDINARIA MEDIANTE TRAMPAS, Y REPOBLACION DE ANIMALES DE CAZA, INCLUSO LAS ACTIVIDADES DE SERVICIOS CONEXAS.',
                'codigo' => '170.0',
                'descripcion' => 'Caza ordinaria, mediante trampas y actividades de servicio conexas',
            ],
            [
                'actividad' => 'EXTRACCION Y/O VENTA DE MADERA',
                'codigo' => '220.0',
                'descripcion' => 'Extracción de madera',
            ],
            [
                'actividad' => 'CRIADERO DE PECES, CRUSTACEOS O MOLUSCOS. COMERCIALIZACION DE LARVAS DE ESPECIES MARINAS',
                'codigo' => '321.0',
                'descripcion' => 'Acuicultura marina',
            ],
            [
                'actividad' => 'EXTRACCION Y AGLOMERACION DE CARBON DE PIEDRA',
                'codigo' => '510.0',
                'descripcion' => 'Extracción de carbón de piedra',
            ],
            [
                'actividad' => 'EXTRACCION DE PETROLEO CRUDO Y GAS NATURAL',
                'codigo' => '620.0',
                'descripcion' => 'Extracción de gas natural',
            ],
            [
                'actividad' => 'EXTRACCION DE MINERALES DE URANIO Y TORIO',
                'codigo' => '721.0',
                'descripcion' => 'Extracción de minerales metalíferos no ferrosos',
            ],
            [
                'actividad' => 'EXTRACCION DE PIEDRA, ARENA Y ARCILLA',
                'codigo' => '810.0',
                'descripcion' => 'Extracción de piedra, arena y arcilla',
            ],
            [
                'actividad' => 'EXTRACCION DE MINERALES Y SUSTANCIAS PARA LA FABRICACION DE ABONOS',
                'codigo' => '891.0',
                'descripcion' => 'Extracción de minerales para la fabricación de abonos y productos químicos',
            ],
            [
                'actividad' => 'EXTRACCION DE SAL',
                'codigo' => '893.0',
                'descripcion' => 'Extracción de sal',
            ],
            [
                'actividad' => 'ELABORACION Y CONSERVACION DE CARNE Y EMBUTIDOS DE GANADO VACUNO, PORCINO Y DE AVES',
                'codigo' => '1010.9',
                'descripcion' => 'Elaboración y conservación de otro tipo de carnes n.c.p',
            ],
            [
                'actividad' => 'ELABORACION Y CONSERVACION DE PESCADO Y SUS DERIVADOS',
                'codigo' => '1020.0',
                'descripcion' => 'Elaboración y conservación de pescados, crustáceos y moluscos',
            ],
            [
                'actividad' => 'ELABORACION DE ACEITES Y GRASAS DE ORIGEN VEGETAL Y ANIMAL',
                'codigo' => '1040.0',
                'descripcion' => 'Elaboración de aceites y grasas de origen vegetal y animal',
            ],
            [
                'actividad' => 'BENEFICIO DE ARROZ',
                'codigo' => '1061.1',
                'descripcion' => 'Beneficio de arroz',
            ],
            [
                'actividad' => 'ELABORACION DE PRODUCTOS DERIVADOS DE ALMIDON',
                'codigo' => '1062.0',
                'descripcion' => 'Elaboración de almidones y productos derivados del almidón',
            ],
            [
                'actividad' => 'ELABORACION DE BEBIDAS NO ALCOHOLICAS / GASEOSAS / AGUA MINERAL Y DE MANANTIAL',
                'codigo' => '1104.0',
                'descripcion' => 'Elaboración de bebidas no alcohólicas; producción de aguas minerales y otras aguas embotelladas',
            ],
            [
                'actividad' => 'ELABORACION DE PRODUCTOS DE TABACO',
                'codigo' => '1200.0',
                'descripcion' => 'Elaboración de productos de tabaco',
            ],
            [
                'actividad' => 'FABRICACION DE TODO TIPO DE TELAS Y/O HILOS',
                'codigo' => '1312.0',
                'descripcion' => 'Tejedura de productos textiles',
            ],
            [
                'actividad' => 'FABRICACION DE TEJDOS Y ARTICULOS DE PUNTO Y GANCHILLO',
                'codigo' => '1391.0',
                'descripcion' => 'Fabricación de tejidos de punto y ganchillo',
            ],
            [
                'actividad' => 'FABRICACION DE ARTICULOS CONFECCIONADOS DE MATERIALES TEXTILES, EXEPTO PRENDAS DE VESTIR',
                'codigo' => '1392.0',
                'descripcion' => 'Fabricación de artículos confeccionados con materiales textiles, excepto prendas de vestir',
            ],
            [
                'actividad' => 'FABRICACION DE TAPICES Y ALFOMBRAS',
                'codigo' => '1393.0',
                'descripcion' => 'Fabricación de tapices y alfombras',
            ],
            [
                'actividad' => 'ADOBO Y TENIDO DE PIELES; FABRICACION DE ARTICULOS DE PIEL NATURAL O ARTIFICIAL',
                'codigo' => '1511.0',
                'descripcion' => 'Curtido y adobo de cueros; adobo y teñido de pieles',
            ],
            [
                'actividad' => 'FABRICACION DE MALETAS, BOLSOS DE MANO Y ARTICULOS SIMILARES',
                'codigo' => '1512.0',
                'descripcion' => 'Fabricación de maletas, bolsos de mano y de artículos similares, y artículos de talabartería o guarnicionería',
            ],
            [
                'actividad' => 'FABRICACION DE TODO TIPO DE ZAPATOS EXEPTO EL ORTOPEDICO',
                'codigo' => '1520.0',
                'descripcion' => 'Fabricación de calzado',
            ],
            [
                'actividad' => 'ASERRADO Y ACEPILLADURA DE MADERA',
                'codigo' => '1610.0',
                'descripcion' => 'Aserrado y acepilladura de madera',
            ],
            [
                'actividad' => 'FABRICACION DE HOJAS DE MADERA PARA ENCHAPADO Y TABLEROS COMO PLYWOOD, DURPANEL Y SIMILARES',
                'codigo' => '1621.0',
                'descripcion' => 'Fabricación de hojas de madera para enchapado y tableros a base de madera',
            ],
            [
                'actividad' => 'FABRICACION DE PAPEL Y CARTON Y ENVASES DE PAPEL Y CARTON',
                'codigo' => '1701.0',
                'descripcion' => 'Fabricación de pasta de madera , papel y cartón',
            ],
            [
                'actividad' => 'FABRICACION DE OTROS ARTICULOS DE PAPEL Y CARTON',
                'codigo' => '1709.0',
                'descripcion' => 'Fabricación de otros artículos del papel y cartón',
            ],
            [
                'actividad' => 'REPRODUCCION DE GRABACIONES',
                'codigo' => '1820.0',
                'descripcion' => 'Reproducción de grabaciones',
            ],
            [
                'actividad' => 'FABRICACION DE ABONOS Y COMPUESTOS DE NITROGENO (ORGANICOS Y QUIMICOS)',
                'codigo' => '2012.0',
                'descripcion' => 'Fabricación abonos y compuestos de nitrógeno',
            ],
            [
                'actividad' => 'FABRICACION DE PLAGUICIDAS Y OTROS PRODUCTOS QUIMICOS DE USO AGROPECUARIO',
                'codigo' => '2021.0',
                'descripcion' => 'Fabricación de plaguicidas y de otros productos químicos de uso agropecuario',
            ],
            [
                'actividad' => 'FABRICACION DE JABONES DE TOCADOR',
                'codigo' => '2023.2',
                'descripcion' => 'Fabricación de perfumes y preparados de tocador',
            ],
            [
                'actividad' => 'FABRICACION DE FIBRAS SINTETICAS',
                'codigo' => '2030.0',
                'descripcion' => 'Fabricación de fibras artificiales',
            ],
            [
                'actividad' => 'FABRICACION PRODUCTOS FARMACEUTICOS, SUSTANCIAS QUIMICAS YPRODUCTOS BOTANICOS',
                'codigo' => '2100.0',
                'descripcion' => 'Fabricación de productos farmacéuticos, sustancias químicas medicinales y de productos botánicos de uso farmacéutico',
            ],
            [
                'actividad' => 'FABRICACION DE OTROS PRODUCTOS DE CAUCHO',
                'codigo' => '2219.0',
                'descripcion' => 'Fabricación de otros productos de caucho',
            ],
            [
                'actividad' => 'FABRICACION DE ARTICULOS DE PLASTICO',
                'codigo' => '2220.9',
                'descripcion' => 'Fabricación de otros productos de plástico',
            ],
            [
                'actividad' => 'FABRICACION DE VIDRIO Y PRODUCTOS DE VIDRIO',
                'codigo' => '2310.0',
                'descripcion' => 'Fabricación de vidrio y de productos de vidrio',
            ],
            [
                'actividad' => 'FABRICACION DE PRODUCTOS DE CERAMICA REFRACTARIA',
                'codigo' => '2391.0',
                'descripcion' => 'Fabricación de productos refractarios',
            ],
            [
                'actividad' => 'FABRICACION DE PRODUCTOS DE ARCILLA Y CERAMICA NO REFRACTARIAS PARA USO ESTRUCTURAL',
                'codigo' => '2392.0',
                'descripcion' => 'Fabricación de material de arcilla para la construcción',
            ],
            [
                'actividad' => 'FABRICACION PRODUCTOS DE CERAMICA BARRO LOZA Y/O PORCELANANO REFRACTARIA USO NO ESTRUCTURAL',
                'codigo' => '2393.0',
                'descripcion' => 'Fabricación de otros productos de cerámica y porcelana',
            ],
            [
                'actividad' => 'FABRICACION DE ARTICULOS DE CEMENTO, YESO Y HORMIGON PARA LA CONSTRUCCION',
                'codigo' => '2395.0',
                'descripcion' => 'Fabricación de artículos de hormigón, de cemento y de yeso',
            ],
            [
                'actividad' => 'CORTE, TALLADO Y ACABADO DE LA PIEDRA',
                'codigo' => '2396.0',
                'descripcion' => 'Corte, tallado y acabado de la piedra',
            ],
            [
                'actividad' => 'FABRICACION DE OTROS PRODUCTOS MINERALES NO METALICOS N.C.P.',
                'codigo' => '2399.0',
                'descripcion' => 'Fabricación de otros productos minerales no metálicos n.c.p',
            ],
            [
                'actividad' => 'INDUSTRIAS BASICAS DE HIERRO Y ACERO',
                'codigo' => '2410.0',
                'descripcion' => 'Industrias básicas de hierro y acero',
            ],
            [
                'actividad' => 'FABRICACION DE PRODUCTOS PRIMARIOS DE METALES PRECIOSOS Y METALES NO FERROSOS',
                'codigo' => '2420.0',
                'descripcion' => 'Fabricación de productos primarios de metales preciosos y metales no ferrosos',
            ],
            [
                'actividad' => 'FUNDICION DE HIERRO Y ACERO',
                'codigo' => '2431.0',
                'descripcion' => 'Fundición de hierro y acero',
            ],
            [
                'actividad' => 'FUNDICION DE METALES NO FERROSOS',
                'codigo' => '2432.0',
                'descripcion' => 'Fundición de metales no ferrosos',
            ],
            [
                'actividad' => 'FABRICACION DE PRODUCTOS METALICOS PARA USO ESTRUCTURAL',
                'codigo' => '2511.0',
                'descripcion' => 'Fabricación de productos metálicos para uso estructural',
            ],
            [
                'actividad' => 'FABRICACION DE TANQUES, DEPOSITOS Y RECIPIENTES DE METAL',
                'codigo' => '2512.0',
                'descripcion' => 'Fabricación de tanques, depósitos y recipientes de metal',
            ],
            [
                'actividad' => 'FABRICACION GENERADORES DE VAPOR, EXCEPTO CALDERAS DE AGUA CALIENTE PARA CALEFACION CENTRAL',
                'codigo' => '2513.0',
                'descripcion' => 'Fabricación de los generadores del vapor, excepto calderas de agua caliente para calefacción central',
            ],
            [
                'actividad' => 'FABRICACION DE ARMAS Y MUNICIONES',
                'codigo' => '2520.0',
                'descripcion' => 'Fabricación de armas y municiones',
            ],
            [
                'actividad' => 'FABRICACION DE TRANSMISORES Y RECEPTORES DE RADIO Y TELEVISION',
                'codigo' => '2630.0',
                'descripcion' => 'Fabricación de equipos de comunicaciones',
            ],
            [
                'actividad' => 'FABRICACION DE EQUIPOS PARA MEDIR, VERIFICAR, Y NAVEGAR Y DE EQUIPOS DE CONTROL',
                'codigo' => '2651.0',
                'descripcion' => 'Fabricación de equipos de medición, prueba, verificación, navegación y de equipo de control',
            ],
            [
                'actividad' => 'FABRICACION DE RELOJES DE TODO TIPO',
                'codigo' => '2652.0',
                'descripcion' => 'Fabricación de relojes',
            ],
            [
                'actividad' => 'FABRICACION DE INSTRUMENTOS OPTICOS Y EQUIPO FOTOGRAFICO',
                'codigo' => '2670.0',
                'descripcion' => 'Fabricación de instrumentos ópticos de equipo fotográfico',
            ],
            [
                'actividad' => 'FABRICACION DE PILAS, BATERIAS Y ACUMULADORES',
                'codigo' => '2720.0',
                'descripcion' => 'Fabricación de baterias y acumuladores',
            ],
            [
                'actividad' => 'FABRICACION DE HILOS Y CABLES AISLADOS',
                'codigo' => '2732.0',
                'descripcion' => 'Fabricación de otros hilos y cables eléctricos',
            ],
            [
                'actividad' => 'FABRICACION DE LAMPARAS ELECTRICAS Y EQUIPO DE ILUMINACION',
                'codigo' => '2740.0',
                'descripcion' => 'Fabricación de equipos de iluminación eléctricos',
            ],
            [
                'actividad' => 'FABRICACION DE APARATOS DE USO DOMESTICO N.C.P.',
                'codigo' => '2750.0',
                'descripcion' => 'Fabricación de aparatos de uso doméstico',
            ],
            [
                'actividad' => 'FABRICACION DE OTROS TIPOS DE EQUIPO ELECTRICO N.C.P.',
                'codigo' => '2790.0',
                'descripcion' => 'Fabricación de otro equipo eléctrico',
            ],
            [
                'actividad' => 'FABRICACION DE MOTORES Y TURBINAS, EXCEPTO MOTORES PARA AERONAVES, VEHICULOS AUTOMOTORES Y MOTOCICLETAS',
                'codigo' => '2811.0',
                'descripcion' => 'Fabricación de motores y turbinas, excepto motores para aeronaves, vehículos automotores y motocicletas',
            ],
            [
                'actividad' => 'FABRICACION DE BOMBAS, COMPRESORES, GRIFOS Y VALVULAS',
                'codigo' => '2813.0',
                'descripcion' => 'Fabricación de otras bombas, compresores, grifos y válvulas',
            ],
            [
                'actividad' => 'FABRICACION DE HORNOS Y QUEMADORES',
                'codigo' => '2815.0',
                'descripcion' => 'Fabricación de hornos, hogueras y quemadores',
            ],
            [
                'actividad' => 'FABRICACION DE MAQUINARIA DE OFICINA, CONTABILIDAD E INFORMATICA',
                'codigo' => '2817.0',
                'descripcion' => 'Fabricación de maquinaria y equipo de oficina (excepto computadoras y equipos periféricos)',
            ],
            [
                'actividad' => 'FABRICACION DE MAQUINARIA AGRICOLA',
                'codigo' => '2821.0',
                'descripcion' => 'Fabricación de maquinaria agropecuaria y forestal',
            ],
            [
                'actividad' => 'FABRICACION DE MAQUINAS HERRAMIENTA',
                'codigo' => '2822.0',
                'descripcion' => 'Fabricación de maquinarias para la conformación de metales y de máquinas herramienstas',
            ],
            [
                'actividad' => 'FABRICACION DE MAQUINARIA METALURGICA',
                'codigo' => '2823.0',
                'descripcion' => 'Fabricación de maquinaria para metalúrgica',
            ],
            [
                'actividad' => 'FABRICACION DE MAQUINARIA PARA LA EXPLOTACION DE MINAS Y CANTERAS Y PARA OBRAS DE CONSTRUCCION',
                'codigo' => '2824.0',
                'descripcion' => 'Fabricación de maquinaria para explotación de minas y canteras y para obras de construcción',
            ],
            [
                'actividad' => 'FABRICACION DE MAQUINARIA PARA LA ELABORACION DE ALIMENTOS,BEBIDAS Y TABACO',
                'codigo' => '2825.0',
                'descripcion' => 'Fabricación de maquinaria para la elaboración de alimentos, bebidas y tabaco',
            ],
            [
                'actividad' => 'FABRICACION MAQUINARIA PARA LA ELABORACION DE PRODUCTOS TEXTILES, PRENDAS DE VESTIR Y CUEROS',
                'codigo' => '2826.0',
                'descripcion' => 'Fabricación de maquinaria para la elaboración de productos textiles, prendas de vestir y cueros',
            ],
            [
                'actividad' => 'FABRICACION DE OTROS TIPOS DE MAQUINARIA DE USO ESPECIAL',
                'codigo' => '2829.0',
                'descripcion' => 'Fabricación de otros tipos de maquinaria de uso especial',
            ],
            [
                'actividad' => 'FABRICACION DE VEHICULOS AUTOMOTORES',
                'codigo' => '2910.0',
                'descripcion' => 'Fabricación de vehículos automotores',
            ],
            [
                'actividad' => 'FABRICACION DE PARTES, PIEZAS Y ACCESORIOS PARA VEHICULOS AUTOMOTORES',
                'codigo' => '2930.0',
                'descripcion' => 'Fabricación de partes y accesorios para motores de vehículos',
            ],
            [
                'actividad' => 'CONSTRUCCION DE EMBARCACIONES Y ESTRUCTURAS FLOTANTES',
                'codigo' => '3012.0',
                'descripcion' => 'Construcción de embarcaciones de recreo y deporte',
            ],
            [
                'actividad' => 'FABRICACION DE LOCOMOTORAS Y MATERIAL RODANTE PARA FERROCARRILES Y TRANVIAS',
                'codigo' => '3020.0',
                'descripcion' => 'Fabricación de locomotoras y de material rodante',
            ],
            [
                'actividad' => 'FABRICACION DE AERONAVES Y NAVES ESPACIALES Y MAQUINARIA CONEXA',
                'codigo' => '3030.0',
                'descripcion' => 'Fabricación de aeronaves y naves espaciales y de maquinaria conexa',
            ],
            [
                'actividad' => 'FABRICACION DE MOTOCICLETAS, PARTES, PIEZAS Y SUS ACCESORIOS',
                'codigo' => '3091.0',
                'descripcion' => 'Fabricación de motocicletas',
            ],
            [
                'actividad' => 'FABRICACION DE BICICLETAS Y SILLAS DE RUEDAS, PARTES, PIEZAS Y SUS ACCESORIOS',
                'codigo' => '3092.0',
                'descripcion' => 'Fabricación de bicicletas y sillas de ruedas para personas con discapacidad',
            ],
            [
                'actividad' => 'FABRICACION DE OTROS TIPOS DE EQUIPO DE TRANSPORTE N.C.P.',
                'codigo' => '3099.0',
                'descripcion' => 'Fabricación de otros tipos de equipo de transporte n.c.p',
            ],
            [
                'actividad' => 'FABRICACION Y/O REPARACION DE MUEBLES Y ACCESORIOS (INCLUYECOLCHONES)',
                'codigo' => '3100.1',
                'descripcion' => 'Fabricación de muebles de madera',
            ],
            [
                'actividad' => 'MAQUILA DE MUEBLES',
                'codigo' => '3100.9',
                'descripcion' => 'Fabricación de muebles de otro tipo de material (excepto de madera, piedra, cemento o cerámica)',
            ],
            [
                'actividad' => 'FABRICACION DE JOYAS, BISUTERIA Y ARTICULOS CONEXOS',
                'codigo' => '3211.0',
                'descripcion' => 'Fabricación de joyas y artículos conexos',
            ],
            [
                'actividad' => '',
                'codigo' => '3212.0',
                'descripcion' => 'Fabricación de bisutería y artículos conexos',
            ],
            [
                'actividad' => 'FABRICACION DE INSTRUMENTOS MUSICALES, PARTES Y PIEZAS Y SUS ACCESORIOS',
                'codigo' => '3220.0',
                'descripcion' => 'Fabricación de Instrumentos musicales',
            ],
            [
                'actividad' => 'FABRICACION DE ARTICULOS DE DEPORTE',
                'codigo' => '3230.0',
                'descripcion' => 'Fabricación de artículos de deporte',
            ],
            [
                'actividad' => 'FABRICACION DE JUEGOS Y JUGUETES',
                'codigo' => '3240.0',
                'descripcion' => 'Fabricación de juegos y juguetes',
            ],
            [
                'actividad' => 'REPARACION DE ARMAS DE FUEGO',
                'codigo' => '3311.0',
                'descripcion' => 'Reparación de productos elaborados de metal',
            ],
            [
                'actividad' => 'REPARACION DE PORTONES ELECTRICOS',
                'codigo' => '3314.0',
                'descripcion' => 'Reparación de equipo eléctrico',
            ],
            [
                'actividad' => 'SERVICIO DE REPARACION DE EMBARCACIONES Y SUS PARTES Y/O ESTRUCTURAS FLOTANTES',
                'codigo' => '3315.0',
                'descripcion' => 'Reparación de equipo de transporte, excepto los vehículos automotores',
            ],
            [
                'actividad' => 'GENERACION Y/O DISTRIBUCION DE ENERGIA ELECTRICA (HIDRAULICA,CONVENCIONAL, TERMICO, ETC)',
                'codigo' => '3510.0',
                'descripcion' => 'Generación , transmisión y distribución de energía eléctrica',
            ],
            [
                'actividad' => 'FABRICACION DE GAS; DISTRIBUCION DE COMBUSTIBLES GASEOSOS POR TUBERIAS',
                'codigo' => '3520.0',
                'descripcion' => 'Fabricación de gas; distribución de combustibles gaseosos por tuberías',
            ],
            [
                'actividad' => 'LIMPIEZA DE TANQUES SEPTICOS Y AGUAS REDISUALES',
                'codigo' => '3700.0',
                'descripcion' => 'Evacuación de aguas residuales',
            ],
            [
                'actividad' => 'ASESORAMIENTO Y ELIMINACION DE DESPERDICIOS, SANEAMIENTO (EXCEPTO LIMPIEZA DE TANQUES SEPTICOS)',
                'codigo' => '3811.0',
                'descripcion' => 'Recolección de desechos no peligrosos',
            ],
            [
                'actividad' => 'CONSTRUCCION DE EDIFICIOS, APARTAMENTOS, CONDOMINIOS Y CASAS DE HABITACION',
                'codigo' => '4100.0',
                'descripcion' => 'Construcción de edificios',
            ],
            [
                'actividad' => 'CONSTRUCCION Y MANTENIMIENTO DE CARRETERAS Y OTRAS VIAS',
                'codigo' => '4210.0',
                'descripcion' => 'Construcción de carreteras y vías férreas',
            ],
            [
                'actividad' => 'DEMOLICION DE EDIFICIOS Y OTRAS ESTRUCTURAS',
                'codigo' => '4311.0',
                'descripcion' => 'Demolición',
            ],
            [
                'actividad' => 'PREPARACION DE TERRENOS',
                'codigo' => '4312.0',
                'descripcion' => 'Preparación del terreno',
            ],
            [
                'actividad' => 'COMISIONISTAS, AGENTES DE VENTAS, ORGANIZADORES DE SUBASTAS,TIQUETERAS, ETC.',
                'codigo' => '4610.0',
                'descripcion' => 'Venta al por mayor a cambio de una retribución o por contrato',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE CALZADO, PRODUCTOS TEXTILES; PRENDASDE VESTIR;',
                'codigo' => '4641.1',
                'descripcion' => 'Venta al por mayor de productos textiles y prendas de vestir',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE ARTICULOS, ARTEFACTOS, DISCOS Y MUEBLES PARA EL HOGAR',
                'codigo' => '4649.1',
                'descripcion' => 'Venta al por mayor de aparatos, artículos y equipo de uso doméstico',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE EQUIPO DE COMPUTO, SUS PARTES Y ACCESORIOS',
                'codigo' => '4651.0',
                'descripcion' => 'Venta al por mayor de computadoras, equipo informático periférico y programas informáticos',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE ARTICULOS Y ACCESORIOS ELECTRONICOS',
                'codigo' => '4652.0',
                'descripcion' => 'Venta al por mayor de equipo, partes y piezas electrónicas y de telecomunicaciones',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE METALES Y MINERALES METALIFEROS',
                'codigo' => '4662.0',
                'descripcion' => 'Venta al por mayor de metales y de minerales metalíferos',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE PRODUCTOS PARA USO AGROPECUARIO Y VENTA DESECHOS ORGANICOS E INORGANICOS',
                'codigo' => '4669.1',
                'descripcion' => 'Venta al por mayor de fertilizantes y productos agroquímicos',
            ],
            [
                'actividad' => 'SUPERMERCADOS Y ALMACENES DE ABARROTES EN CADENA',
                'codigo' => '4711.1',
                'descripcion' => 'Venta al por menor en supermercados, almacenes y similares',
            ],
            [
                'actividad' => 'TIENDAS O ALMACENES POR DEPARTAMENTOS',
                'codigo' => '4719.1',
                'descripcion' => 'Venta al por menor en tiendas por departamentos',
            ],
            [
                'actividad' => 'BAZARES',
                'codigo' => '4719.9',
                'descripcion' => 'Venta al por menor en bazares y otros establecimientos no especializados n.c.p',
            ],
            [
                'actividad' => 'COMERCIO AL POR MENOR DE PRODUCTOS DE TABACO',
                'codigo' => '4723.0',
                'descripcion' => 'Venta al por menor de tabaco en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE EQUIPO DE AUDIO Y VIDEO',
                'codigo' => '4742.0',
                'descripcion' => 'Venta al por menor de equipo de audio y video en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE VIDRIO PARA LA CONSTRUCCION',
                'codigo' => '4752.2',
                'descripcion' => 'Venta al por menor de productos de vidrio en comercios especializados',
            ],
            [
                'actividad' => 'VENTA DE ALFOMBRAS Y TAPICES',
                'codigo' => '4753.0',
                'descripcion' => 'Venta al por menor de tapices, alfombras, cubrimientos para paredes y pisos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE JUGUETES Y/O ARTICULOS DE ESPARCIMIENTO',
                'codigo' => '4764.0',
                'descripcion' => 'Venta al por menor de juegos y de juguetes en almacenes especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE CALZADO (ZAPATAERIAS)',
                'codigo' => '4771.2',
                'descripcion' => 'Venta al por menor de zapatos en comercios especializados',
            ],
            [
                'actividad' => 'SERVICIO DE TRANSPORTE POR VIA FERREA',
                'codigo' => '4911.0',
                'descripcion' => 'Transporte de pasajeros por ferrocarril',
            ],
            [
                'actividad' => 'SERVICIO DE TRANSPORTE REGULAR DE PERSONAS POR VIA TERRESTRE',
                'codigo' => '4921.0',
                'descripcion' => 'Transporte terrestre de pasajeros del área urbana, suburbana por vía terrestre',
            ],
            [
                'actividad' => 'TRANSPORTE REGULAR DE ESTUDIANTES Y EMPLEADOS POR VIA TERRESTRE',
                'codigo' => '4922.1',
                'descripcion' => 'Transporte terrestre de estudiantes y de empleados',
            ],
            [
                'actividad' => 'TRANSPORTE NO REGULAR DE PASAJEROS POR VIA TERRESTRE(EXCURSIONES)',
                'codigo' => '4922.3',
                'descripcion' => 'Transporte terrestre no regular de pasajeros, en buses',
            ],
            [
                'actividad' => 'SERVICIO DE MUDANZA INTERNACIONAL',
                'codigo' => '4923.1',
                'descripcion' => 'Transporte terrestre local e internacional de contenedores',
            ],
            [
                'actividad' => 'SERVICIO DE TRANSPORTE POR TUBERIAS',
                'codigo' => '4930.0',
                'descripcion' => 'Transporte por tuberías',
            ],
            [
                'actividad' => 'TRANSPORTE DE CARGA POR VIA ACUATICA',
                'codigo' => '5012.0',
                'descripcion' => 'Transporte marítimo y de cabotaje de carga',
            ],
            [
                'actividad' => 'SERVICIO DE TRANSPORTE DE CARGA POR VIA AEREA',
                'codigo' => '5120.0',
                'descripcion' => 'Transporte de carga por vía aérea',
            ],
            [
                'actividad' => 'SERVICIOS DE ALMACENAJE',
                'codigo' => '5210.0',
                'descripcion' => 'Almacenamiento y depósito',
            ],
            [
                'actividad' => 'SERVICIOS DE GRUA',
                'codigo' => '5221.1',
                'descripcion' => 'Remolque y asistencia para vehículo destinado al transporte terrestre',
            ],
            [
                'actividad' => 'PERMISO DE PASO POR PROPIEDADES PRIVADAS (PEAJE)',
                'codigo' => '5221.9',
                'descripcion' => 'Servicios de administración de carreteras, puentes y otros servicios auxiliares',
            ],
            [
                'actividad' => 'SERVICIO DE CONSOLIDACION DE CARGA Y DESCARGA',
                'codigo' => '5224.0',
                'descripcion' => 'Manipulación de carga',
            ],
            [
                'actividad' => 'ACTIVIDADES POSTALES Y DE CORREO',
                'codigo' => '5310.0',
                'descripcion' => 'Servicios postales (Correo)',
            ],
            [
                'actividad' => 'ALQUILER DE BIENES INMUEBLES DE USO HABITACIONAL POR PERIODOS INFERIORES A UN MES (CASAS DE ESTANCIA TRANSITORIA,
        CASA DE HUESPEDES, CABINAS, CAMPAMENTOS, ENTRE OTROS)',
                'codigo' => '5510.9',
                'descripcion' => 'Otras actividades de alojamiento para estancias cortas n.c.p',
            ],
            [
                'actividad' => 'RESIDENCIAS UNIVERSITARIAS CON SERVICIOS INTEGRADOS',
                'codigo' => '5590.0',
                'descripcion' => 'Otras actividades de alojamientos',
            ],
            [
                'actividad' => 'SERVICIOS DE CATERING SERVICE',
                'codigo' => '5621.0',
                'descripcion' => 'Suministros de comidas por encargo',
            ],
            [
                'actividad' => 'BARES, CANTINAS O TABERNAS',
                'codigo' => '5630.0',
                'descripcion' => 'Actividades de servicio de bebidas',
            ],
            [
                'actividad' => 'EDICION DE LIBROS DE TEXTOS',
                'codigo' => '5811.0',
                'descripcion' => 'Edición de libros',
            ],
            [
                'actividad' => 'EDICION DE PERIODICOS, REVISTAS Y OTRAS PUBLICACIONES PERIODICAS',
                'codigo' => '5813.0',
                'descripcion' => 'Edición de periódicos, diarios y revistas',
            ],
            [
                'actividad' => 'ACTIVIDADES PRODUCCION POSTPRODUCCION Y DISTRIBUCION DE PELICULAS CINEMATOGRAFICAS (VIDEOS)',
                'codigo' => '5911.0',
                'descripcion' => 'Actividades de producción de películas cinematográficas, videos y programas de televisión',
            ],
            [
                'actividad' => 'EXHIBICION DE FILMES Y VIDEOCINTAS (SALAS DE CINE)',
                'codigo' => '5914.0',
                'descripcion' => 'Actividades de proyección de películas',
            ],
            [
                'actividad' => 'GRABACION DE SONIDO (MUSICA, ETC.) EN DISCOS GRAMOFONICOS YEN CINTA MAGNETOFONICA',
                'codigo' => '5920.0',
                'descripcion' => 'Actividades de grabación y publicación de grabaciones sonoras',
            ],
            [
                'actividad' => 'SERVICIO DE TRANSMISION DE DATOS, TEXTO, SONIDO, VOZ Y VIDEO POR MEDIO DE LA RED DE INTERNET',
                'codigo' => '6120.0',
                'descripcion' => 'Actividades de telecomunicaciones inalámbricas',
            ],
            [
                'actividad' => 'SERVICIOS DE INTERNET EN LOCALES PUBLICOS ( CAFE INTERNET )',
                'codigo' => '6190.1',
                'descripcion' => 'Servicios de café internet',
            ],
            [
                'actividad' => 'DISENADOR GRAFICO, DE SOFTWARE Y PAGINAS WEB',
                'codigo' => '6201.0',
                'descripcion' => 'Actividades de programación informática',
            ],
            [
                'actividad' => 'CONSULTORES INFORMATICOS',
                'codigo' => '6202.0',
                'descripcion' => 'Actividades de consultoría informática y gestión de instalaciones informáticas',
            ],
            [
                'actividad' => 'OTRAS ACTIVIDADES DE INFORMATICA',
                'codigo' => '6209.0',
                'descripcion' => 'Otras actividades de la tecnología de información y servicio informáticos',
            ],
            [
                'actividad' => 'ACTIVIDADES DE AGENCIAS DE NOTICIAS',
                'codigo' => '6391.0',
                'descripcion' => 'Actividades de agencias de noticias',
            ],
            [
                'actividad' => 'BANCA CENTRAL',
                'codigo' => '6411.0',
                'descripcion' => 'Banca Central',
            ],
            [
                'actividad' => 'ACTIVIDADES DE SOCIEDADES DE CARTERA (HOLDING)',
                'codigo' => '6420.0',
                'descripcion' => 'Actividades de sociedades de cartera',
            ],
            [
                'actividad' => 'ARRENDAMIENTO OPERATIVO EN FUNCION FINANCIERA CON OPCION DECOMPRA O RENOVACION (LEASING OPERATIVO)',
                'codigo' => '6491.0',
                'descripcion' => 'Arrendamiento financiero',
            ],
            [
                'actividad' => 'SEGUROS DE VIDA',
                'codigo' => '6511.0',
                'descripcion' => 'Seguros de vida',
            ],
            [
                'actividad' => 'PLANES DE SEGUROS GENERALES',
                'codigo' => '6512.0',
                'descripcion' => 'Seguros generales',
            ],
            [
                'actividad' => 'ADMINISTRACION DE MERCADOS FINANCIEROS',
                'codigo' => '6611.0',
                'descripcion' => 'Administración de mercados financieros',
            ],
            [
                'actividad' => 'ACTIVIDADES AUXILIARES DE LA FINANCIACION DE PLANES DE SEGUROS Y DE PENSIONES',
                'codigo' => '6629.0',
                'descripcion' => 'Otras actividades auxiliares de seguros y fondos de pensiones',
            ],
            [
                'actividad' => 'AGENTES O CORREDORES DE BIENES RAICES',
                'codigo' => '6820.0',
                'descripcion' => 'Actividades inmobiliarias realizadas a cambio de una retribución o por contrata',
            ],
            [
                'actividad' => 'ACTIVIDADES DE SERVICIOS AUXILIARES PARA LA ADMINISTRACION PUBLICA EN GENERAL',
                'codigo' => '7010.0',
                'descripcion' => 'Actividades de oficinas principales',
            ],
            [
                'actividad' => 'ASESORAMIENTO EMPRESARIAL Y EN MATERIA DE GESTION',
                'codigo' => '7020.0',
                'descripcion' => 'Actividades de consultoría en gestión',
            ],
            [
                'actividad' => 'INVESTIGACION Y DESARROLLO EXPERIMENTAL EN EL CAMPO DE LAS CIENCIAS NATURALES Y LA INGENIERIA',
                'codigo' => '7210.0',
                'descripcion' => 'Investigaciones y desarrollo experimental en el campo de las ciencias naturales y la ingeniería',
            ],
            [
                'actividad' => 'INVESTIGACIONES Y DESARROLLO EXPERIMENTAL EN EL CAMPO DE LAS CIENCIAS SOCIALES Y LAS HUMANIDADES',
                'codigo' => '7220.0',
                'descripcion' => 'Investigación y desarrollo experimental en el campo de las ciencias sociales y las humanidades',
            ],
            [
                'actividad' => 'ALQUILER DE AUTOMOVILES DE TODO TIPO',
                'codigo' => '7710.1',
                'descripcion' => 'Alquiler de automóviles sin conductor',
            ],
            [
                'actividad' => 'ALQUILER DE PELICULAS CINEMATOGRAFICAS (VIDEO CLUB) Y/O VIDEO JUEGOS',
                'codigo' => '7722.0',
                'descripcion' => 'Alquiler de cintas de vídeo y discos',
            ],
            [
                'actividad' => 'SERVICIOS DE ADMINISTRACION DE PERSONAL',
                'codigo' => '7830.0',
                'descripcion' => 'Otras actividades de dotación de recursos humanos',
            ],
            [
                'actividad' => 'AGENCIAS DE VIAJES Y EXCURSIONES',
                'codigo' => '7911.0',
                'descripcion' => 'Actividades de agencias de viajes',
            ],
            [
                'actividad' => 'MANTENIMIENTO, REPARACION Y LIMPIEZA DE LOS SERVICIOS Y BIENES COMUNES DE LA PROPIEDAD EN CONDOMINIO',
                'codigo' => '8110.0',
                'descripcion' => 'Actividades combinadas de apoyo a instalaciones',
            ],
            [
                'actividad' => 'SERVICIOS DE LIMPIEZA (INTERIORES Y EXTERIORES)',
                'codigo' => '8121.0',
                'descripcion' => 'Limpieza general de edificios',
            ],
            [
                'actividad' => 'SERVICIOS DE FUMIGACION (NO AGRICOLA)',
                'codigo' => '8129.0',
                'descripcion' => 'Otras actividades de limpieza de edificios e instalaciones industriales',
            ],
            [
                'actividad' => 'SERVICIO DE JARDINERIA Y/O DISENO PAISAJISTA',
                'codigo' => '8130.0',
                'descripcion' => 'Actividades de paisajismo y servicios de mantenimiento conexos',
            ],
            [
                'actividad' => 'SERVICIO DE CONTESTACION DE TELEFONOS (CALL CENTER)',
                'codigo' => '8220.0',
                'descripcion' => 'Actividades de centros de llamadas',
            ],
            [
                'actividad' => 'SERVICIOS DE ENVASE Y EMPAQUE',
                'codigo' => '8292.0',
                'descripcion' => 'Actividades de envasado y empacado',
            ],
            [
                'actividad' => 'SERVICIO DE RECOLECCION DE MONEDAS DE LOS TELEFONOS PUBLICOS',
                'codigo' => '8299.0',
                'descripcion' => 'Otras actividades de servicios de apoyo a las empresas n.c.p',
            ],
            [
                'actividad' => 'RELACIONES EXTERIORES',
                'codigo' => '8421.0',
                'descripcion' => 'Relaciones exteriores',
            ],
            [
                'actividad' => 'ACTIVIDADES DE PLANES DE SEGURIDAD SOCIAL DE AFILIACION OBLIGATORIA',
                'codigo' => '8430.0',
                'descripcion' => 'Actividades de planes de seguridad social de afiliación obligatoria',
            ],
            [
                'actividad' => 'ENSENANZA SECUNDARIA DE FORMACION TECNICA Y PROFESIONAL NO AUTORIZADA POR EL MEP.',
                'codigo' => '8522.0',
                'descripcion' => 'Enseñanza de formación técnica y profesional',
            ],
            [
                'actividad' => 'ENSENANZA DE FORMACION TECNICA Y PARAUNIVERSITARIA',
                'codigo' => '8530.2',
                'descripcion' => 'Enseñanza parauniversitaria',
            ],
            [
                'actividad' => 'SERVICIOS DE ODONTOLOGO Y CONEXOS',
                'codigo' => '8620.2',
                'descripcion' => 'Actividades de odontólogos',
            ],
            [
                'actividad' => 'ASOCIACION PROAYUDA A PERSONAS ADICTAS A DROGAS E INDIGENTES',
                'codigo' => '8720.0',
                'descripcion' => 'Actividades de atención en instituciones para personas con retraso mental, enfermos mentales y toxicómanos',
            ],
            [
                'actividad' => 'FUNDACIONES DE SERVICIO SOCIAL SIN ALOJAMIENTO',
                'codigo' => '8810.0',
                'descripcion' => 'Asistencia social sin alojamiento para el adulto mayor y personas con discapacidad',
            ],
            [
                'actividad' => 'ACTIVIDADES DE BIBLIOTECAS Y ARCHIVOS',
                'codigo' => '9101.0',
                'descripcion' => 'Actividades de Bibliotecas y archivos',
            ],
            [
                'actividad' => 'GALERIAS DE ARTE',
                'codigo' => '9102.0',
                'descripcion' => 'Actividades de museos y preservación de lugares históricos',
            ],
            [
                'actividad' => 'ACTIVIDADES DE JARDINES BOTANICOS, ZOOLOGICOS, PARQUES NACIONALES Y RESERVAS NACIONALES',
                'codigo' => '9103.0',
                'descripcion' => 'Actividades de jardines botánicos, zoológicos y parques naturales',
            ],
            [
                'actividad' => 'ACTIVIDADES DE ORGANIZACIONES PROFESIONALES',
                'codigo' => '9412.0',
                'descripcion' => 'Actividades de asociaciones profesionales',
            ],
            [
                'actividad' => 'ACTIVIDADES DE ORGANIZACIONES RELIGIOSAS',
                'codigo' => '9491.0',
                'descripcion' => 'Actividades de organizaciones religiosas',
            ],
            [
                'actividad' => 'ACTIVIDADES DE ORGANIZACIONES POLITICAS',
                'codigo' => '9492.0',
                'descripcion' => 'Actividades de organizaciones políticas',
            ],
            [
                'actividad' => 'REPARACION Y MANTENIMIENTO DE EQUIPO PARA TELECOMUNICACIONES',
                'codigo' => '9512.0',
                'descripcion' => 'Reparación de equipos de comunicaciones',
            ],
            [
                'actividad' => 'REPARACION EQUIPO DE AUDIO Y VIDEO',
                'codigo' => '9521.0',
                'descripcion' => 'Reparación de aparatos electrónicos de consumo eléctrico',
            ],
            [
                'actividad' => 'REPARACION DE ARTICULOS ELECTRICOS',
                'codigo' => '9522.0',
                'descripcion' => 'Reparación de aparatos de uso doméstico y equipo doméstico y de jardinería',
            ],
            [
                'actividad' => 'SERVICIOS DE REPARACION DE ZAPATOS',
                'codigo' => '9523.0',
                'descripcion' => 'Reparación de calzado y artículos de cuero',
            ],
            [
                'actividad' => 'SALONES DE BELLEZA, PELUQUERIA Y BARBERIA',
                'codigo' => '9602.0',
                'descripcion' => 'Actividades de peluquería y otros tratamientos de belleza',
            ],
            [
                'actividad' => 'HOGARES PRIVADOS CON SERVICIO DOMESTICO',
                'codigo' => '9700.0',
                'descripcion' => 'Actividades de los hogares como empleadores de personal doméstico',
            ],
            [
                'actividad' => 'CULTIVO Y VENTA DE CEREALES, LEGUMBRES Y GRANOS BASICOS NO INCLUIDAS EN CANASTA BASICA',
                'codigo' => '111.9',
                'descripcion' => 'Cultivo de otros cereales, legumbres y semillas oleaginosas n.c.p',
            ],
            [
                'actividad' => 'CULTIVO HORTALIZAS LEGUMBRES ESPECIALIDADES HORTICOLAS PRODUCTOS DE VIVERO EXCENTO DE VENTAS',
                'codigo' => '111.9',
                'descripcion' => 'Cultivo de otros cereales, legumbres y semillas oleaginosas n.c.p',
            ],
            [
                'actividad' => 'CULTIVO HORTALIZAS LEGUMBRES ESPECIALIDADES HORTICOLAS PRODUCTOS VIVERO GRABADOS VENTAS',
                'codigo' => '111.9',
                'descripcion' => 'Cultivo de otros cereales, legumbres y semillas oleaginosas n.c.p',
            ],
            [
                'actividad' => 'CULTIVO Y VENTA DE CEREALES, LEGUMBRES Y GRANOS BASICOS INCLUIDOS EN CANASTA BASICA',
                'codigo' => '111.9',
                'descripcion' => 'Cultivo de otros cereales, legumbres y semillas oleaginosas n.c.p',
            ],
            [
                'actividad' => 'CULTIVO DE TUBERCULOS',
                'codigo' => '113.9',
                'descripcion' => 'Cultivo de otras hortalizas, raíces o tubérculos n.c.p',
            ],
            [
                'actividad' => 'PRODUCCION DE MINIVEGETALES',
                'codigo' => '113.9',
                'descripcion' => 'Cultivo de otras hortalizas, raíces o tubérculos n.c.p',
            ],
            [
                'actividad' => 'CULTIVO DE PLANTAS PARA PREPARAR BEBIDAS Y MEDICINAS',
                'codigo' => '127.9',
                'descripcion' => 'Cultivo de otras plantas con las que se preparan bebidas, excepto el cultivo de café n.c.p',
            ],
            [
                'actividad' => 'CULTIVO DE CACAO',
                'codigo' => '127.9',
                'descripcion' => 'Cultivo de otras plantas con las que se preparan bebidas, excepto el cultivo de café n.c.p',
            ],
            [
                'actividad' => 'CRIA DE ANIMALES DOMESTICADOS (AVES DE CORRAL)',
                'codigo' => '146.9',
                'descripcion' => 'Cría de otras aves de corral, excepto pollos',
            ],
            [
                'actividad' => 'PRODUCCION Y VENTA DE HUEVOS DE CUALQUIER TIPO, EXCEPTO LOS DE GALLINA',
                'codigo' => '146.9',
                'descripcion' => 'Cría de otras aves de corral, excepto pollos',
            ],
            [
                'actividad' => 'FUMIGACION DE CULTIVOS',
                'codigo' => '161.2',
                'descripcion' => 'Servicios de fumigación y riego agrícola',
            ],
            [
                'actividad' => 'MANEJO E INSTALACION DE SISTEMAS DE RIEGO',
                'codigo' => '161.2',
                'descripcion' => 'Servicios de fumigación y riego agrícola',
            ],
            [
                'actividad' => 'SERVICIO DE PLANTACION DE ARBOLES Y SIMILARES',
                'codigo' => '161.9',
                'descripcion' => 'Otros servicios de apoyo a la agricultura',
            ],
            [
                'actividad' => 'PREPARACION DE TERRENOS AGRICOLAS',
                'codigo' => '161.9',
                'descripcion' => 'Otros servicios de apoyo a la agricultura',
            ],
            [
                'actividad' => 'VENTA DE ARBOLES EN PIE (ARBOLES DE REFORESTACION)',
                'codigo' => '210.0',
                'descripcion' => 'Silvicultura y otras actividades forestales',
            ],
            [
                'actividad' => 'ACTIVIDADES DE CONSERVACION DE BOSQUES. (SERVICIOS AMBIENTALES, VENTA DE OXIGENO).',
                'codigo' => '210.0',
                'descripcion' => 'Silvicultura y otras actividades forestales',
            ],
            [
                'actividad' => 'EXPLOTACION DE MINAS Y CANTERAS N.C.P.',
                'codigo' => '899.0',
                'descripcion' => 'Explotación de otras minas y canteras n.c.p',
            ],
            [
                'actividad' => 'EXPLOTACION DE OTRAS MINAS Y CANTERAS N.C.P.',
                'codigo' => '899.0',
                'descripcion' => 'Explotación de otras minas y canteras n.c.p',
            ],
            [
                'actividad' => 'ELABORACION Y CONSERVACION DE FRUTAS, LEGUMBRES Y HORTALIZAS',
                'codigo' => '1030.0',
                'descripcion' => 'Elaboración y conservación de frutas, legumbres y hortalizas (vegetales)',
            ],
            [
                'actividad' => 'PRODUCCION DE CONCENTRADOS PARA JUGOS (CITRICULTURA)',
                'codigo' => '1030.0',
                'descripcion' => 'Elaboración y conservación de frutas, legumbres y hortalizas (vegetales)',
            ],
            [
                'actividad' => 'PRODUCCION DE PRODUCTOS LACTEOS Y SUS DERIVADOS INCLUIDOS EN CANASTA BASICA CON RECONOCIMIENTO DE CREDITOS
        FISCALES',
                'codigo' => '1050.0',
                'descripcion' => 'Elaboración de productos lácteos',
            ],
            [
                'actividad' => 'PRODUCCION DE HELADOS Y OTROS PRODUCTOS SIMILARES',
                'codigo' => '1050.0',
                'descripcion' => 'Elaboración de productos lácteos',
            ],
            [
                'actividad' => 'ELABORACION DE PRODUCTOS LACTEOS',
                'codigo' => '1050.0',
                'descripcion' => 'Elaboración de productos lácteos',
            ],
            [
                'actividad' => 'ELABORACION Y VENTA DE PRODUCTOS LACTEOS INCLUIDOS EN CANASTA BASICA',
                'codigo' => '1050.0',
                'descripcion' => 'Elaboración de productos lácteos',
            ],
            [
                'actividad' => 'SERVICIO DE MOLIENDA',
                'codigo' => '1061.9',
                'descripcion' => 'Elaboración de productos de molinería excepto arroz',
            ],
            [
                'actividad' => 'ELABORACION DE HARINAS PREMEZCLADAS Y PREPARADAS PARA LA FABRICACION DE PRODUCTOS DE PANADERIA Y REPOSTERIA',
                'codigo' => '1061.9',
                'descripcion' => 'Elaboración de productos de molinería excepto arroz',
            ],
            [
                'actividad' => 'ELABORACION DE PRODUCTOS DE MOLINERIA INCLUIDOS EN CANASTA BASICA',
                'codigo' => '1061.9',
                'descripcion' => 'Elaboración de productos de molinería excepto arroz',
            ],
            [
                'actividad' => 'ELABORACION DE PRODUCTOS DE MAIZ EXENTOS DE VENTAS',
                'codigo' => '1061.9',
                'descripcion' => 'Elaboración de productos de molinería excepto arroz',
            ],
            [
                'actividad' => 'ELABORACION DE PRODUCTOS DE MAIZ GRAVADOS CON VENTAS',
                'codigo' => '1061.9',
                'descripcion' => 'Elaboración de productos de molinería excepto arroz',
            ],
            [
                'actividad' => 'ELABORACION Y VENTA DE AZUCAR Y PRODUCTOS DERIVADOS DE LA CANA DE AZUCAR',
                'codigo' => '1072.0',
                'descripcion' => 'Elaboración de azúcar y otros productos derivados de la caña de azúcar',
            ],
            [
                'actividad' => 'ELABORACION DE PRODUCTOS DERIVADOS DE LA CANA DE AZUCAR',
                'codigo' => '1072.0',
                'descripcion' => 'Elaboración de azúcar y otros productos derivados de la caña de azúcar',
            ],
            [
                'actividad' => 'ELABORACION DE CACAO',
                'codigo' => '1073.0',
                'descripcion' => 'Elaboración de cacao, chocolate y productos de confitería',
            ],
            [
                'actividad' => 'ELABORACION DE CHOCOLATE',
                'codigo' => '1073.0',
                'descripcion' => 'Elaboración de cacao, chocolate y productos de confitería',
            ],
            [
                'actividad' => 'ELABORACION DE DULCES, GOLOSINAS Y CONSERVAS EN AZUCAR',
                'codigo' => '1073.0',
                'descripcion' => 'Elaboración de cacao, chocolate y productos de confitería',
            ],
            [
                'actividad' => 'ELABORACION DE MACARRONES, FIDEOS, ALCUZCUZ Y PRODUCTOS FARINACEOS SIMILARES',
                'codigo' => '1074.0',
                'descripcion' => 'Elaboración de macarrones, fideos, alcuzcuz y productos farináceos similares',
            ],
            [
                'actividad' => 'ELABORACION DE MACARRONES, FIDEOS, ALCUZCUZ Y PRODUCTOS FARINACEOS SIMILARES INCLUIDOS EN CANASTA BASICA',
                'codigo' => '1074.0',
                'descripcion' => 'Elaboración de macarrones, fideos, alcuzcuz y productos farináceos similares',
            ],
            [
                'actividad' => 'FABRICACION DE PRODUCTOS ALIMENTICIOS PREPARADOS N.C.P. (NOCONTEMPLADOS EN OTRA PARTE)',
                'codigo' => '1079.9',
                'descripcion' => 'Elaboración de otros productos alimenticios n.c.p',
            ],
            [
                'actividad' => 'ELABORACION DE CONCENTRADO PARA BEBIDAS NATURALES Y GASEOSAS',
                'codigo' => '1079.9',
                'descripcion' => 'Elaboración de otros productos alimenticios n.c.p',
            ],
            [
                'actividad' => 'ELABORACION DE ALIMENTOS PARA ANIMALES DOMESTICOS',
                'codigo' => '1080.0',
                'descripcion' => 'Elaboración de alimentos preparados para animales',
            ],
            [
                'actividad' => 'ELABORACION DE PACAS DE HENO',
                'codigo' => '1080.0',
                'descripcion' => 'Elaboración de alimentos preparados para animales',
            ],
            [
                'actividad' => 'ELABORACION DE ALIMENTOS PARA ANIMALES PARA EXPLOTACION AGROPECUARIA',
                'codigo' => '1080.0',
                'descripcion' => 'Elaboración de alimentos preparados para animales',
            ],
            [
                'actividad' => 'MAQUILA DE PRODUCTOS TEXTILES',
                'codigo' => '1313.0',
                'descripcion' => 'Acabado de productos textiles',
            ],
            [
                'actividad' => 'HIDROFUGADO/IMPERMEABILIZADO',
                'codigo' => '1313.0',
                'descripcion' => 'Acabado de productos textiles',
            ],
            [
                'actividad' => 'SERVICIO DE BORDADO A MANO O A MAQUINA',
                'codigo' => '1313.0',
                'descripcion' => 'Acabado de productos textiles',
            ],
            [
                'actividad' => 'SERVICIO DE TENIDO DE PRENDAS DE VESTIR',
                'codigo' => '1313.0',
                'descripcion' => 'Acabado de productos textiles',
            ],
            [
                'actividad' => 'FABRICACION DE CUERDAS, CORDELES,BRAMANTES Y REDES',
                'codigo' => '1394.0',
                'descripcion' => 'Fabricación de cuerdas, cordeles, bramantes y redes',
            ],
            [
                'actividad' => 'FABRICACION DE HILOS Y CUERDAS PARA USO AGRICOLA Y PESCA',
                'codigo' => '1394.0',
                'descripcion' => 'Fabricación de cuerdas, cordeles, bramantes y redes',
            ],
            [
                'actividad' => 'SERVICIOS DE COSTURA Y SASTRERIA (COSTURERAS Y SASTRES)',
                'codigo' => '1410.9',
                'descripcion' => 'Fabricación de otras prendas de vestir, excepto ropa interior y prendas de piel',
            ],
            [
                'actividad' => 'FABRICACION DE PRENDAS DE VESTIR (ROPA DE TODO TIPO)',
                'codigo' => '1410.9',
                'descripcion' => 'Fabricación de otras prendas de vestir, excepto ropa interior y prendas de piel',
            ],
            [
                'actividad' => 'FABRICACION DE PARTES Y PIEZAS DE CARPINTERIA PARA EDIFICIOS Y CONSTRUCCIONES',
                'codigo' => '1622.0',
                'descripcion' => 'Fabricación de partes y piezas de carpimtería para edificios y construcciones',
            ],
            [
                'actividad' => 'FABRICACION DE TARIMAS',
                'codigo' => '1622.0',
                'descripcion' => 'Fabricación de partes y piezas de carpimtería para edificios y construcciones',
            ],
            [
                'actividad' => 'ELABORACION DE BIOCOMBUSTIBLES',
                'codigo' => '2011.0',
                'descripcion' => 'Fabricación de sustancias químicas básicas',
            ],
            [
                'actividad' => 'FABRICACION DE SUSTANCIAS QUIMICAS Y GASES INDUSTRIALES EXCEPTO ABONOS',
                'codigo' => '2011.0',
                'descripcion' => 'Fabricación de sustancias químicas básicas',
            ],
            [
                'actividad' => 'FABRICACION DE PLASTICOS Y CAUCHO SINTETICO EN FORMAS PRIMARIAS',
                'codigo' => '2013.0',
                'descripcion' => 'Fabricación de plásticos y de caucho sintético en formas primarias',
            ],
            [
                'actividad' => 'FABRICACION DE RESINAS',
                'codigo' => '2013.0',
                'descripcion' => 'Fabricación de plásticos y de caucho sintético en formas primarias',
            ],
            [
                'actividad' => 'FABRICACION DE OTROS PRODUCTOS QUIMICOS.',
                'codigo' => '2029.0',
                'descripcion' => 'Fabricación de otros productos químicos n.c.p',
            ],
            [
                'actividad' => 'FABRICACION DE PEGAMENTOS Y ADHESIVOS',
                'codigo' => '2029.0',
                'descripcion' => 'Fabricación de otros productos químicos n.c.p',
            ],
            [
                'actividad' => 'SERVICIOS DE SOLDADURA',
                'codigo' => '2592.0',
                'descripcion' => 'Tratamiento y revestimiento de metales',
            ],
            [
                'actividad' => 'SERVICIO DE TRATAMIENTO Y REVESTIMIENTO DE TODO TIPO DE MATERIALES',
                'codigo' => '2592.0',
                'descripcion' => 'Tratamiento y revestimiento de metales',
            ],
            [
                'actividad' => 'HOJALATERIA',
                'codigo' => '2592.0',
                'descripcion' => 'Tratamiento y revestimiento de metales',
            ],
            [
                'actividad' => 'TALLER DE MECANICA DE PRECISION',
                'codigo' => '2592.0',
                'descripcion' => 'Tratamiento y revestimiento de metales',
            ],
            [
                'actividad' => 'SERVICIOS DE TORNO (MECANICA DE PRECISION)',
                'codigo' => '2592.0',
                'descripcion' => 'Tratamiento y revestimiento de metales',
            ],
            [
                'actividad' => 'FABRICACION DE PIEZAS, ARTICULOS Y ACCESORIOS DE METAL INCLUYE LAS CERRAJERIAS.',
                'codigo' => '2599.0',
                'descripcion' => 'Fabricación de otros productos de metal n.c.p',
            ],
            [
                'actividad' => 'FABRICACION DE OTROS PRODUCTOS ELABORADOS DE METAL N.C.P.',
                'codigo' => '2599.0',
                'descripcion' => 'Fabricación de otros productos de metal n.c.p',
            ],
            [
                'actividad' => 'MANUFACTURA O FABRICACION DE OTROS COMPONENTES ELECTRONICOS',
                'codigo' => '2610.0',
                'descripcion' => 'Fabricación de componentes y tableros electrónicos',
            ],
            [
                'actividad' => 'DISENO DE COMPONENTES ELECTRONICOS',
                'codigo' => '2610.0',
                'descripcion' => 'Fabricación de componentes y tableros electrónicos',
            ],
            [
                'actividad' => 'FABRICACION DE MOTORES, GENERADORES Y TRANSFORMADORES ELECTRICOS, PARTES Y ACCES',
                'codigo' => '2710.0',
                'descripcion' => 'Fabricación de motores eléctricos, generadores, transformadores eléctricos y aparatos de distribución y control de la energía eléctrica',
            ],
            [
                'actividad' => 'FABRICACION, ENSAMBLE Y VENTA DE SISTEMAS PARA EL APROVECHAMIENTO DE ENERGIAS RENOBABLES',
                'codigo' => '2710.0',
                'descripcion' => 'Fabricación de motores eléctricos, generadores, transformadores eléctricos y aparatos de distribución y control de la energía eléctrica',
            ],
            [
                'actividad' => 'FABRICACION Y/O VENTA DE ATAUDES (CAJAS MORTUORIAS, FERETROS).',
                'codigo' => '3290.0',
                'descripcion' => 'Otras industrias manufactureras n.c.p',
            ],
            [
                'actividad' => 'FABRICACION DE ESCOBAS',
                'codigo' => '3290.0',
                'descripcion' => 'Otras industrias manufactureras n.c.p',
            ],
            [
                'actividad' => 'FABRICACION DE VELAS (CANDELAS) EXCEPTO LAS PERFUMADAS, COLOREADAS Y DECORADAS.',
                'codigo' => '3290.0',
                'descripcion' => 'Otras industrias manufactureras n.c.p',
            ],
            [
                'actividad' => 'FABRICACION DE VELAS COLOREADAS, PERFUMADAS Y DECORADAS',
                'codigo' => '3290.0',
                'descripcion' => 'Otras industrias manufactureras n.c.p',
            ],
            [
                'actividad' => 'FABRICACION DE SELLOS DE MANO, METAL O HULE (CAUCHO)',
                'codigo' => '3290.0',
                'descripcion' => 'Otras industrias manufactureras n.c.p',
            ],
            [
                'actividad' => 'TRABAJOS DE MANUALIDADES',
                'codigo' => '3290.0',
                'descripcion' => 'Otras industrias manufactureras n.c.p',
            ],
            [
                'actividad' => 'SERVICIO DE REPARACION DE MAQUINARIA Y EQUIPO.',
                'codigo' => '3312.0',
                'descripcion' => 'Reparación de maquinaria',
            ],
            [
                'actividad' => 'SERVICIO DE MANTENIMIENTO DE MAQUINARIA Y EQUIPO.',
                'codigo' => '3312.0',
                'descripcion' => 'Reparación de maquinaria',
            ],
            [
                'actividad' => 'REPARACION DE EQUIPO DE REFRIGERACION Y CONGELACION',
                'codigo' => '3312.0',
                'descripcion' => 'Reparación de maquinaria',
            ],
            [
                'actividad' => 'INSTALACION Y/O MANTENIMIENTO DE EQUIPO DE REFRIGERACION Y CONGELACION',
                'codigo' => '3312.0',
                'descripcion' => 'Reparación de maquinaria',
            ],
            [
                'actividad' => 'MANTENIMIENTO DE EXTINTORES',
                'codigo' => '3312.0',
                'descripcion' => 'Reparación de maquinaria',
            ],
            [
                'actividad' => 'REPARACION CAJAS REGISTRADORAS, CALCULADORAS, MAQUINAS DE CONTABILIDAD Y EQUIPO DE OFICINA',
                'codigo' => '3312.0',
                'descripcion' => 'Reparación de maquinaria',
            ],
            [
                'actividad' => 'MANTENIMIENTO DE CAJAS REGISTRADORAS, CALCULADORAS, MAQUINAS DE CONTABILIDAD',
                'codigo' => '3312.0',
                'descripcion' => 'Reparación de maquinaria',
            ],
            [
                'actividad' => 'FABRICACION DE HIELO',
                'codigo' => '3530.0',
                'descripcion' => 'Suministro de vapor y aire acondicionado',
            ],
            [
                'actividad' => 'SUMINISTRO DE VAPOR Y AIRE ACONDICIONADO',
                'codigo' => '3530.0',
                'descripcion' => 'Suministro de vapor y aire acondicionado',
            ],
            [
                'actividad' => 'CAPTACION, TRATAMIENTO Y DISTRIBUCION DE AGUA',
                'codigo' => '3600.0',
                'descripcion' => 'Captación, tratamiento y distribución de agua',
            ],
            [
                'actividad' => 'ASOCIACIONES ADMINISTRADORAS DE LOS SISTEMAS DE ACUEDUCTOS Y ALCANTARILLADOS (ASADAS).',
                'codigo' => '3600.0',
                'descripcion' => 'Captación, tratamiento y distribución de agua',
            ],
            [
                'actividad' => 'RECICLAJE DE OTRO TIPO DE MATERIALES N.C.P.',
                'codigo' => '3830.0',
                'descripcion' => 'Recuperación de materiales',
            ],
            [
                'actividad' => 'RECICLAJE DE PAPEL Y PLASTICO Y MATERIALES RELACIONADOS',
                'codigo' => '3830.0',
                'descripcion' => 'Recuperación de materiales',
            ],
            [
                'actividad' => 'VENTA E INSTALACION DE ALARMAS Y OTROS SISTEMAS ELECTRICOS',
                'codigo' => '4321.0',
                'descripcion' => 'Instalación eléctrica y de telecomunicaciones',
            ],
            [
                'actividad' => 'REPARACION DE CABLEADO DE COMUNICACIONES',
                'codigo' => '4321.0',
                'descripcion' => 'Instalación eléctrica y de telecomunicaciones',
            ],
            [
                'actividad' => 'INSTALACION DE ALARMAS Y OTROS SISTEMAS DE SEGURIDAD',
                'codigo' => '4321.0',
                'descripcion' => 'Instalación eléctrica y de telecomunicaciones',
            ],
            [
                'actividad' => 'INSTALACION Y MANTENIMIENTO DE CABLEADO DE COMUNICACIONES Y/O ENERGIA ELECTRICA',
                'codigo' => '4321.0',
                'descripcion' => 'Instalación eléctrica y de telecomunicaciones',
            ],
            [
                'actividad' => 'INSTALACION Y MANTENIMIENTO DE CONMUTADORES Y OTROS SISTEMAS PARA TELECOMUNICACIONES',
                'codigo' => '4321.0',
                'descripcion' => 'Instalación eléctrica y de telecomunicaciones',
            ],
            [
                'actividad' => 'ELECTRICISTA, SERVICIOS',
                'codigo' => '4321.0',
                'descripcion' => 'Instalación eléctrica y de telecomunicaciones',
            ],
            [
                'actividad' => 'REPARACION DE AIRE ACONDICIONADO',
                'codigo' => '4322.0',
                'descripcion' => 'Instalación de fontanería e instalación de calefacción y aire acondicionado',
            ],
            [
                'actividad' => 'INSTALACION Y MANTENIMIENTO DE AIRE ACONDICIONADO',
                'codigo' => '4322.0',
                'descripcion' => 'Instalación de fontanería e instalación de calefacción y aire acondicionado',
            ],
            [
                'actividad' => 'REPARACION DE ASCENSORES(ELEVADORES)',
                'codigo' => '4329.0',
                'descripcion' => 'Otro tipo de instalaciones de construcción',
            ],
            [
                'actividad' => 'INSTALACION Y MANTENIMIENTO DE ASCENSORES (ELEVADORES)',
                'codigo' => '4329.0',
                'descripcion' => 'Otro tipo de instalaciones de construcción',
            ],
            [
                'actividad' => 'INSTALACION Y MANTENIMIENTO DE PORTONES ELECTRICOS',
                'codigo' => '4329.0',
                'descripcion' => 'Otro tipo de instalaciones de construcción',
            ],
            [
                'actividad' => 'MANTENIMIENTO, REPARACION Y AMPLIACIONES DE EDIFICIOS, APARTAMENTOS, CONDOMINIOS Y CASAS',
                'codigo' => '4330.0',
                'descripcion' => 'Terminación y acabados de edificios',
            ],
            [
                'actividad' => 'SERVICIOS DE TERMINACION Y ACABADO DE EDIFICIOS',
                'codigo' => '4330.0',
                'descripcion' => 'Terminación y acabados de edificios',
            ],
            [
                'actividad' => 'INSTALACION Y MANTENIMIENTO DE PERSIANAS Y CORTINAS',
                'codigo' => '4330.0',
                'descripcion' => 'Terminación y acabados de edificios',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR Y MENOR DE VEHICULOS NUEVOS Y/O USADOS (PARTIDAS ARANCELARIAS 8703 Y 8711)',
                'codigo' => '4510.0',
                'descripcion' => 'Venta de vehículos automotores',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR Y MENOR DE VEHICULOS NUEVOS Y/O USADOS, EXCEPTO PARTIDAS ARANCELARIAS 8702 Y 8704',
                'codigo' => '4510.0',
                'descripcion' => 'Venta de vehículos automotores',
            ],
            [
                'actividad' => 'LAVADO, ENCERADO Y PULIDO DE AUTOMOVILES (LAVA CAR)',
                'codigo' => '4520.0',
                'descripcion' => 'Mantenimiento y reparación de vehículos automotores',
            ],
            [
                'actividad' => 'SERVICIOS DE ALINEAMIENTO Y REPARACION DE LLANTAS',
                'codigo' => '4520.0',
                'descripcion' => 'Mantenimiento y reparación de vehículos automotores',
            ],
            [
                'actividad' => 'SERVICIO DE REPARACION DE TODA CLASE DE VEHICULOS Y SUS PARTES',
                'codigo' => '4520.0',
                'descripcion' => 'Mantenimiento y reparación de vehículos automotores',
            ],
            [
                'actividad' => 'SERVICIO DE ENDEREZADO Y PINTURA PARA TODA CLASE DE VEHICULO',
                'codigo' => '4520.0',
                'descripcion' => 'Mantenimiento y reparación de vehículos automotores',
            ],
            [
                'actividad' => 'AUTODECORACION',
                'codigo' => '4520.0',
                'descripcion' => 'Mantenimiento y reparación de vehículos automotores',
            ],
            [
                'actividad' => 'VENTA DE REPUESTOS NUEVOS PARA AUTOMOVILES',
                'codigo' => '4530.0',
                'descripcion' => 'Venta de partes, piezas y accesorios de vehículos automotores',
            ],
            [
                'actividad' => 'COMERCIALIZACION DE LLANTAS (NEUMATICAS) PARA VEHICULOS AUTOMOTORES',
                'codigo' => '4530.0',
                'descripcion' => 'Venta de partes, piezas y accesorios de vehículos automotores',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE FLORES Y PLANTAS DE TODO TIPO',
                'codigo' => '4620.0',
                'descripcion' => 'Venta al por mayor de materias primas agropecuarias y animales vivos',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE POLEN Y/O SEMILLAS PARA USO AGRICOLA',
                'codigo' => '4620.0',
                'descripcion' => 'Venta al por mayor de materias primas agropecuarias y animales vivos',
            ],
            [
                'actividad' => 'COMERCIO AL POR MENOR DE ANIMALES DOMESTICOS PARA CONSUMO HUMANO',
                'codigo' => '4620.0',
                'descripcion' => 'Venta al por mayor de materias primas agropecuarias y animales vivos',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR Y MAYOR DE PRODUCTOS E INSUMOS AGROPECUARIOS',
                'codigo' => '4620.0',
                'descripcion' => 'Venta al por mayor de materias primas agropecuarias y animales vivos',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE FLORES Y PLANTAS',
                'codigo' => '4620.0',
                'descripcion' => 'Venta al por mayor de materias primas agropecuarias y animales vivos',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE FRUTAS Y VERDURAS FRESCAS INCLUIDAS O NO EN CANASTA BASICA',
                'codigo' => '4630.3',
                'descripcion' => 'Venta al por mayor de frutas y verduras frescas',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE FRUTAS Y VERDURAS FRESCAS',
                'codigo' => '4630.3',
                'descripcion' => 'Venta al por mayor de frutas y verduras frescas',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE PRODUCTOS DE TABACO',
                'codigo' => '4630.4',
                'descripcion' => 'Venta al por mayor de licores, bebidas y tabaco',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE BEBIDAS CON CONTENIDO ALCOHOLICO (IMPORTADORES)',
                'codigo' => '4630.4',
                'descripcion' => 'Venta al por mayor de licores, bebidas y tabaco',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE BEBIDAS GASEOSAS Y CARBONATADAS',
                'codigo' => '4630.4',
                'descripcion' => 'Venta al por mayor de licores, bebidas y tabaco',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE VINOS. BEBIDAS FERMENTADAS Y NO FERMENTADAS',
                'codigo' => '4630.4',
                'descripcion' => 'Venta al por mayor de licores, bebidas y tabaco',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE BEBIDAS NO ALCOHOLICAS (JUGOS DEFRUTAS, VEGETALES) Y AGUA EMBOTELLADA',
                'codigo' => '4630.4',
                'descripcion' => 'Venta al por mayor de licores, bebidas y tabaco',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE CERVEZA IMPORTADA',
                'codigo' => '4630.4',
                'descripcion' => 'Venta al por mayor de licores, bebidas y tabaco',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE ALIMENTOS, GRANOS BASICOS, CARNES Y DEMAS COMESTIBLES Y ARTICULOS DE LA CANASTA BASICA',
                'codigo' => '4630.9',
                'descripcion' => 'Venta al por mayor de otros alimentos',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE PRODUCTOS LACTEOS',
                'codigo' => '4630.9',
                'descripcion' => 'Venta al por mayor de otros alimentos',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE PRODUCTOS DE CONFITERIA',
                'codigo' => '4630.9',
                'descripcion' => 'Venta al por mayor de otros alimentos',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE OTROS ALIMENTOS N.C.P. GRABADOS CON VENTAS',
                'codigo' => '4630.9',
                'descripcion' => 'Venta al por mayor de otros alimentos',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE CAFE (EXCEPTO EL ENVASADO, ENLATADO, SOLUBLE, DESCAFEINADO)',
                'codigo' => '4630.9',
                'descripcion' => 'Venta al por mayor de otros alimentos',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE CAFE EMPACADO, ENVASADO, ENLATADO, SOLUBLE Y DESCAFEINADO',
                'codigo' => '4630.9',
                'descripcion' => 'Venta al por mayor de otros alimentos',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE PRODUCTOS SUSTITUTOS DEL AZUCAR',
                'codigo' => '4630.9',
                'descripcion' => 'Venta al por mayor de otros alimentos',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE CARNES DE TODO TIPO (PREPARADAS SAZONADAS CONDIMENTADAS EMPANIZADAS)',
                'codigo' => '4630.9',
                'descripcion' => 'Venta al por mayor de otros alimentos',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE ALIMENTOS Y PRODUCTOS N.C.P. EXCENTOS DE VENTAS',
                'codigo' => '4630.9',
                'descripcion' => 'Venta al por mayor de otros alimentos',
            ],
            [
                'actividad' => 'COMERCIALIZACION Y DISTRIBUCION AL POR MAYOR DE ALIMENTOS PREPARADOS PARA ANIMALES DOMESTICOS',
                'codigo' => '4630.9',
                'descripcion' => 'Venta al por mayor de otros alimentos',
            ],
            [
                'actividad' => 'COMERCIALIZACION AL POR MAYOR DE SUPLEMENTOS ALIMENTICIOS',
                'codigo' => '4630.9',
                'descripcion' => 'Venta al por mayor de otros alimentos',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE PRODUCTOS VETERINARIOS GRAVADOS CON IVA',
                'codigo' => '4649.2',
                'descripcion' => 'Venta al por mayor de productos farmacéuticos, veterinarios y artículos de tocador',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE EQUIPO, ARTICULOS Y ACCESORIOS DE BELLEZA, COSMETICOS E HIGIENE PERSONAL',
                'codigo' => '4649.2',
                'descripcion' => 'Venta al por mayor de productos farmacéuticos, veterinarios y artículos de tocador',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE EQUIPO PARA CAMPO DE JUEGOS (PLAY)',
                'codigo' => '4649.3',
                'descripcion' => 'Venta al por mayor de juegos, juguetes, artículos deportivos y de esparcimiento',
            ],
            [
                'actividad' => 'COMERCIO AL POR MAYOR DE EQUIPO Y ACCESORIOS PARA PESCA DEPORTIVA O ARTESANAL',
                'codigo' => '4649.3',
                'descripcion' => 'Venta al por mayor de juegos, juguetes, artículos deportivos y de esparcimiento',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE PREPARADOS Y/O ARTICULOS PARA LA LIMPIEZA DE USO GENERAL',
                'codigo' => '4649.9',
                'descripcion' => 'Venta al por mayor de otros enseres domésticos n.c.p',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE LIBROS Y TEXTOS EDUCATIVOS',
                'codigo' => '4649.9',
                'descripcion' => 'Venta al por mayor de otros enseres domésticos n.c.p',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE SUMINISTROS Y ARTICULOS DE LIBRERIA',
                'codigo' => '4649.9',
                'descripcion' => 'Venta al por mayor de otros enseres domésticos n.c.p',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE DISCOS COMPACTOS Y OTROS DISPOSITIVOSDE GRABACION',
                'codigo' => '4649.9',
                'descripcion' => 'Venta al por mayor de otros enseres domésticos n.c.p',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE REPUESTOS Y/O ACCESORIOS PARA MAQUINARIA Y EQUIPO AGROPECUARIO',
                'codigo' => '4653.0',
                'descripcion' => 'Venta al por mayor de maquinaria, equipo y materiales agropecuarios',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE MAQUINARIA Y EQUIPO AGROPECUARIO',
                'codigo' => '4653.0',
                'descripcion' => 'Venta al por mayor de maquinaria, equipo y materiales agropecuarios',
            ],
            [
                'actividad' => 'VENTA DE BOMBAS DE AGUA',
                'codigo' => '4659.0',
                'descripcion' => 'Venta al por mayor de otro tipo de maquinaria y equipo',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR EQUIPO MEDICO ACCESORIOS MEDICAMENTOS PRODUC FARMACEUTICO EXENTOS DE VENTAS',
                'codigo' => '4659.0',
                'descripcion' => 'Venta al por mayor de otro tipo de maquinaria y equipo',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR EQUIPO MEDICO ACCESORIO MEDICAMENTO PRODUC FARMACEUTICO GRABADOS CON VENTAS',
                'codigo' => '4659.0',
                'descripcion' => 'Venta al por mayor de otro tipo de maquinaria y equipo',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE MAQUINARIA Y EQUIPO INDUSTRIAL, DE CONSTRUCCION, INGENIERIA CIVIL Y OTROS, ASI COMO SUS
        ACCESORIOS',
                'codigo' => '4659.0',
                'descripcion' => 'Venta al por mayor de otro tipo de maquinaria y equipo',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE EQUIPO Y SUMINISTROS DE OFICINA',
                'codigo' => '4659.0',
                'descripcion' => 'Venta al por mayor de otro tipo de maquinaria y equipo',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE COMBUSTIBLES SOLIDOS (LENA Y SIMILARES)',
                'codigo' => '4661.0',
                'descripcion' => 'Venta al por mayor de combustibles sólidos, líquidos y gaseosos y de productos conexos',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE COMBUSTIBLES SOLIDOS (CARBON)',
                'codigo' => '4661.0',
                'descripcion' => 'Venta al por mayor de combustibles sólidos, líquidos y gaseosos y de productos conexos',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE EQUIPO DE AIRE ACONDICIONADO Y CALENTADORES (ELECTRICOS, SOLARES, ETC.)',
                'codigo' => '4663.0',
                'descripcion' => 'Venta al por mayor de materiales de construcción, articulos de ferretería y equipo y materiales de fontanería y calefacción',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE MATERIALES PARA LA CONTRUCCION, ARTICULOS DE FERRETERIA, EQUIPO Y MATERIALES DE FONTANERIA Y
        CALEFACCION',
                'codigo' => '4663.0',
                'descripcion' => 'Venta al por mayor de materiales de construcción, articulos de ferretería y equipo y materiales de fontanería y calefacción',
            ],
            [
                'actividad' => 'RECICLAJE DE DESPERDICIOS Y DESECHOS METALICOS',
                'codigo' => '4669.9',
                'descripcion' => 'Venta al por mayor de basura, desechos y otros productos n.c.p',
            ],
            [
                'actividad' => 'ACTIVIDADES DE DESARME DE VEHICULOS Y VENTA DE REPUESTOS',
                'codigo' => '4669.9',
                'descripcion' => 'Venta al por mayor de basura, desechos y otros productos n.c.p',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE PRODUCTOS,SUSTANCIAS O REACTIVOS QUIMICOS Y SOLVENTES EN GENERAL',
                'codigo' => '4669.9',
                'descripcion' => 'Venta al por mayor de basura, desechos y otros productos n.c.p',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR Y AL POR MENOR DE CHATARRA',
                'codigo' => '4669.9',
                'descripcion' => 'Venta al por mayor de basura, desechos y otros productos n.c.p',
            ],
            [
                'actividad' => 'DISTRIBUCION Y COMERCIALIZACION AL POR MAYOR DE MATERIAL DEEMPAQUE',
                'codigo' => '4669.9',
                'descripcion' => 'Venta al por mayor de basura, desechos y otros productos n.c.p',
            ],
            [
                'actividad' => 'VENTA DE ASFALTO/MEZCLA ASFALTICA',
                'codigo' => '4690.0',
                'descripcion' => 'Venta al por mayor de otros productos no especializada',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE TODO TIPO DE ARTICULOS POR CATALOGO',
                'codigo' => '4690.0',
                'descripcion' => 'Venta al por mayor de otros productos no especializada',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE EXTINTORES Y EQUIPO SIMILAR',
                'codigo' => '4690.0',
                'descripcion' => 'Venta al por mayor de otros productos no especializada',
            ],
            [
                'actividad' => 'VENTA AL POR MAYOR DE OTROS PRODUCTOS NO ESPECIALIZADOS',
                'codigo' => '4690.0',
                'descripcion' => 'Venta al por mayor de otros productos no especializada',
            ],
            [
                'actividad' => 'ABASTECEDORES, PULPERIAS O MINI-SUPER',
                'codigo' => '4711.2',
                'descripcion' => 'Venta al por menor en minisuper, pulperias y similares',
            ],
            [
                'actividad' => 'PULPERIAS ( MINI-SUPER)(SIN CANTINA)',
                'codigo' => '4711.2',
                'descripcion' => 'Venta al por menor en minisuper, pulperias y similares',
            ],
            [
                'actividad' => 'VENTA DE CARNES (RES, POLLO,CERDO) INCLUIDAS EN LA CANASTA BASICA',
                'codigo' => '4721.1',
                'descripcion' => 'Venta al por menor de carne de bovino, porcino y sus derivados',
            ],
            [
                'actividad' => 'VENTA DE EMBUTIDOS Y CARNES (RES, POLLO, CERDO)INCLUIDAS ENLA CANASTA BASICA',
                'codigo' => '4721.1',
                'descripcion' => 'Venta al por menor de carne de bovino, porcino y sus derivados',
            ],
            [
                'actividad' => 'VENTA DE EMBUTIDOS Y CARNES (RES, POLLO, CERDO, CABALLO,ETC) GRAVADAS CON IVA',
                'codigo' => '4721.1',
                'descripcion' => 'Venta al por menor de carne de bovino, porcino y sus derivados',
            ],
            [
                'actividad' => 'VENTA DE MARISCOS Y/O PESCADO (PESCADERIAS O MARISQUERIAS)INCLUIDOS EN LA CANASTA BASICA',
                'codigo' => '4721.3',
                'descripcion' => 'Venta al por menor de pescados y mariscos',
            ],
            [
                'actividad' => 'VENTA DE PESCADOS Y/O MARISCOS (PESCADERIAS O MARISQUERIAS) GRAVADOS EN VENTAS',
                'codigo' => '4721.3',
                'descripcion' => 'Venta al por menor de pescados y mariscos',
            ],
            [
                'actividad' => 'VENTA DE VERDURAS Y FRUTAS',
                'codigo' => '4721.4',
                'descripcion' => 'Venta al por menor de frutas y verduras frescas',
            ],
            [
                'actividad' => 'VENTA DE FRUTAS GRAVADAS CON IVA',
                'codigo' => '4721.4',
                'descripcion' => 'Venta al por menor de frutas y verduras frescas',
            ],
            [
                'actividad' => 'VENTA DE FRUTAS INCLUIDAS EN LA NUEVA CANASTA BASICA',
                'codigo' => '4721.4',
                'descripcion' => 'Venta al por menor de frutas y verduras frescas',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE ESPECIAS, SALSAS Y CONDIMENTOS',
                'codigo' => '4721.9',
                'descripcion' => 'Venta al por menor de otros alimentos',
            ],
            [
                'actividad' => 'COMERCIO AL POR MENOR DE CONFITES Y OTROS PRODUCTOS RELACIONADOS (CONFITERIA)',
                'codigo' => '4721.9',
                'descripcion' => 'Venta al por menor de otros alimentos',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE HUEVOS DE GALLINA INCLUIDOS EN LA CANASTA BASICA',
                'codigo' => '4721.9',
                'descripcion' => 'Venta al por menor de otros alimentos',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE OTROS ALIMENTOS NO INCLUIDOS EN CANASTA BASICA',
                'codigo' => '4721.9',
                'descripcion' => 'Venta al por menor de otros alimentos',
            ],
            [
                'actividad' => 'COMERCIO AL POR MENOR DE ALIMENTOS Y PRODUCTOS N.C.P. INCLUIDOS EN CANASTA BASICA',
                'codigo' => '4721.9',
                'descripcion' => 'Venta al por menor de otros alimentos',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE CAFE (EXCEPTO EL ENVASADO, ENLATADO, SOLUBLE, DESCAFEINADO)',
                'codigo' => '4721.9',
                'descripcion' => 'Venta al por menor de otros alimentos',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE POLEN Y SEMILLAS',
                'codigo' => '4721.9',
                'descripcion' => 'Venta al por menor de otros alimentos',
            ],
            [
                'actividad' => 'LICORERIAS Y/O DEPOSITO DE LICORES (VENTA AL POR MENOR)',
                'codigo' => '4722.0',
                'descripcion' => 'Venta al por menor de bebidas en comercios especializados',
            ],
            [
                'actividad' => 'COMERCIO AL POR MENOR DE BEBIDAS GASEOSAS Y CARBONATADAS',
                'codigo' => '4722.0',
                'descripcion' => 'Venta al por menor de bebidas en comercios especializados',
            ],
            [
                'actividad' => 'COMERCIO AL POR MENOR DE AGUA EMBOTELLADA',
                'codigo' => '4722.0',
                'descripcion' => 'Venta al por menor de bebidas en comercios especializados',
            ],
            [
                'actividad' => 'PASAMANERIAS',
                'codigo' => '4751.0',
                'descripcion' => 'Venta al por menor de productos textiles en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE PRODUCTOS TEXTILES (TELAS)',
                'codigo' => '4751.0',
                'descripcion' => 'Venta al por menor de productos textiles en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE DEPOSITO DE MADERA',
                'codigo' => '4752.1',
                'descripcion' => 'Venta al por menor de artículos de ferretería y pinturas en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR ARTICULOS DE FERRETERIA PINTURAS MADERA Y MATERIALES PARA LA CONSTRUCCION',
                'codigo' => '4752.1',
                'descripcion' => 'Venta al por menor de artículos de ferretería y pinturas en comercios especializados',
            ],
            [
                'actividad' => 'VENTA DE PINTURAS',
                'codigo' => '4752.1',
                'descripcion' => 'Venta al por menor de artículos de ferretería y pinturas en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE MATERIALES PARA LA CONSTRUCCION',
                'codigo' => '4752.1',
                'descripcion' => 'Venta al por menor de artículos de ferretería y pinturas en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE PLYWOOD',
                'codigo' => '4752.1',
                'descripcion' => 'Venta al por menor de artículos de ferretería y pinturas en comercios especializados',
            ],
            [
                'actividad' => 'COMERCIO AL POR MENOR DE OBJETOS DE CERAMICA Y PORCELANA',
                'codigo' => '4759.0',
                'descripcion' => 'Venta al por menor de aparatos eléctricos de uso doméstico, muebles, equipos de iluminación y otros enseres domésticos en comercios
        especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE CRISTALERIA',
                'codigo' => '4759.0',
                'descripcion' => 'Venta al por menor de aparatos eléctricos de uso doméstico, muebles, equipos de iluminación y otros enseres domésticos en comercios
        especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE ELECTRODOMESTICOS, MUEBLES Y ARTICULOS PARA EL HOGAR',
                'codigo' => '4759.0',
                'descripcion' => 'Venta al por menor de aparatos eléctricos de uso doméstico, muebles, equipos de iluminación y otros enseres domésticos en comercios
        especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE INSTRUMENTOS MUSICALES, PARTES Y ACCESORIOS',
                'codigo' => '4759.0',
                'descripcion' => 'Venta al por menor de aparatos eléctricos de uso doméstico, muebles, equipos de iluminación y otros enseres domésticos en comercios
        especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR REALIZADA DENTRO DEL DEPOSITO LIBRE COMERCIAL DE GOLFITO.',
                'codigo' => '4759.0',
                'descripcion' => 'Venta al por menor de aparatos eléctricos de uso doméstico, muebles, equipos de iluminación y otros enseres domésticos en comercios
        especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE PURIFICADORES DE AGUA, SUS PARTES Y REPUESTOS',
                'codigo' => '4759.0',
                'descripcion' => 'Venta al por menor de aparatos eléctricos de uso doméstico, muebles, equipos de iluminación y otros enseres domésticos en comercios
        especializados',
            ],
            [
                'actividad' => 'LIBRERIAS',
                'codigo' => '4761.0',
                'descripcion' => 'Venta al por menor de libros, periódicos y artículos de papelería en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE REVISTAS/PERIODICOS EN PUESTOS DE VENTAS O MERCADOS',
                'codigo' => '4761.0',
                'descripcion' => 'Venta al por menor de libros, periódicos y artículos de papelería en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE LIBROS Y TEXTOS EDUCATIVOS',
                'codigo' => '4761.0',
                'descripcion' => 'Venta al por menor de libros, periódicos y artículos de papelería en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE SUMINISTROS Y/0 EQUIPO DE OFICINA',
                'codigo' => '4761.0',
                'descripcion' => 'Venta al por menor de libros, periódicos y artículos de papelería en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE DISCOS, CDS Y OTROS SIMILARES',
                'codigo' => '4762.0',
                'descripcion' => 'Venta al por menor de grabaciones musicales y videográficas en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE DISCOS, GRABACIONES DE MUSICA Y DE VIDEO',
                'codigo' => '4762.0',
                'descripcion' => 'Venta al por menor de grabaciones musicales y videográficas en comercios especializados',
            ],
            [
                'actividad' => 'VENTA DE EMBARCACIONES DE MOTOR Y VELA',
                'codigo' => '4763.0',
                'descripcion' => 'Venta al por menor de artículos de deporte en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE ARTICULOS DEPORTIVOS',
                'codigo' => '4763.0',
                'descripcion' => 'Venta al por menor de artículos de deporte en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE BICICLETAS Y SUS ACCESORIOS',
                'codigo' => '4763.0',
                'descripcion' => 'Venta al por menor de artículos de deporte en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE ROPA (BOUTIQUE)',
                'codigo' => '4771.1',
                'descripcion' => 'Venta al por menor de prendas de vestir y artículos de cuero en almacenes especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE PRENDAS DE VESTIR, ROPA Y ZAPATOS (TIENDAS)',
                'codigo' => '4771.1',
                'descripcion' => 'Venta al por menor de prendas de vestir y artículos de cuero en almacenes especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE ARTICULOS DE CUERO (EXCEPTO CALZADO)',
                'codigo' => '4771.1',
                'descripcion' => 'Venta al por menor de prendas de vestir y artículos de cuero en almacenes especializados',
            ],
            [
                'actividad' => 'MACROBIOTICAS',
                'codigo' => '4772.0',
                'descripcion' => 'Venta al por menor de productos farmacéuticos y medicinales, cosméticos y artículos de tocador en comercios especializados',
            ],
            [
                'actividad' => 'FARMACIAS',
                'codigo' => '4772.0',
                'descripcion' => 'Venta al por menor de productos farmacéuticos y medicinales, cosméticos y artículos de tocador en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE COSMETICOS Y PERFUMERIA',
                'codigo' => '4772.0',
                'descripcion' => 'Venta al por menor de productos farmacéuticos y medicinales, cosméticos y artículos de tocador en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE ARTICULOS Y ACCESORIOS ORTOPEDICOS',
                'codigo' => '4772.0',
                'descripcion' => 'Venta al por menor de productos farmacéuticos y medicinales, cosméticos y artículos de tocador en comercios especializados',
            ],
            [
                'actividad' => 'SERVICIO DE TRANSPORTE DE CARGA POR VIA TERRESTRE',
                'codigo' => '4923.9',
                'descripcion' => 'Otro transporte de carga n.c.p',
            ],
            [
                'actividad' => 'TRANSPORTE DE PRODUCTOS DERIVADOS DEL PETROLEO',
                'codigo' => '4923.9',
                'descripcion' => 'Otro transporte de carga n.c.p',
            ],
            [
                'actividad' => 'SERVICIO DE ACARREO Y DISTRIBUCION DE TODO TIPO DE MERCANCIA (INCLUYE LA MUDANZA NACIONAL)',
                'codigo' => '4923.9',
                'descripcion' => 'Otro transporte de carga n.c.p',
            ],
            [
                'actividad' => 'SERVICIO DE TRANSPORTE AEREO REGULADO DE PASAJEROS (LINEAS AEREAS)',
                'codigo' => '5110.0',
                'descripcion' => 'Transporte de pasajeros por vía aérea',
            ],
            [
                'actividad' => 'SERVICIO DE TRANSPORTE AEREO NO REGULAR DE PASAJEROS',
                'codigo' => '5110.0',
                'descripcion' => 'Transporte de pasajeros por vía aérea',
            ],
            [
                'actividad' => 'PARQUEOS/ESTACIONAMIENTO DE VEHICULOS',
                'codigo' => '5221.2',
                'descripcion' => 'Servicios de estacionamientos y garajes',
            ],
            [
                'actividad' => 'FUNCIONAMIENTO DE INSTALACIONES TERMINALES COMO PUERTOS, MUELLES Y AEROPUERTOS',
                'codigo' => '5221.2',
                'descripcion' => 'Servicios de estacionamientos y garajes',
            ],
            [
                'actividad' => 'SERVICIO DE SALAS VIP Y PREMIUN EN AEROPUERTOS',
                'codigo' => '5223.0',
                'descripcion' => 'Actividades de servicio secundario de transporte por vía aérea',
            ],
            [
                'actividad' => 'PRESTACION DE SERVICIOS DE TRANSITO AEREO',
                'codigo' => '5223.0',
                'descripcion' => 'Actividades de servicio secundario de transporte por vía aérea',
            ],
            [
                'actividad' => 'AGENCIAS ADUANALES, ALMACENES FISCALES Y ESTACIONAMIENTOS TRANSITORIOS',
                'codigo' => '5229.0',
                'descripcion' => 'Otras actividades de apoyo al transporte',
            ],
            [
                'actividad' => 'AGENCIA DE TRANSPORTE (NAVIERA)',
                'codigo' => '5229.0',
                'descripcion' => 'Otras actividades de apoyo al transporte',
            ],
            [
                'actividad' => 'AGENTE ADUANERO FISICO O JURIDICO',
                'codigo' => '5229.0',
                'descripcion' => 'Otras actividades de apoyo al transporte',
            ],
            [
                'actividad' => 'ASESOR ADUANERO',
                'codigo' => '5229.0',
                'descripcion' => 'Otras actividades de apoyo al transporte',
            ],
            [
                'actividad' => 'SERVICIO DE INSPECCION DE TODO TIPO DE MERCADERIAS Y ACTIVOS(INCLUYE DROGAS)',
                'codigo' => '5229.0',
                'descripcion' => 'Otras actividades de apoyo al transporte',
            ],
            [
                'actividad' => 'HOTEL',
                'codigo' => '5510.1',
                'descripcion' => 'Actividades de alojamiento para estancias cortas en hoteles y moteles',
            ],
            [
                'actividad' => 'MOTEL Y/O SERVICIO DE HABITACION OCASIONAL, ALBERGUES, POSADAS Y SIMILARES',
                'codigo' => '5510.1',
                'descripcion' => 'Actividades de alojamiento para estancias cortas en hoteles y moteles',
            ],
            [
                'actividad' => 'PREPARACION, SERVICIO Y VENTA DE FRUTAS PICADAS Y BEBIDAS DE FRUTAS Y/O LEGUMBRES.',
                'codigo' => '5610.0',
                'descripcion' => 'Actividades de restaurantes y de servicios móviles de comidas',
            ],
            [
                'actividad' => 'CAFETERIAS',
                'codigo' => '5610.0',
                'descripcion' => 'Actividades de restaurantes y de servicios móviles de comidas',
            ],
            [
                'actividad' => 'SERVICIO DE RESTAURANTE, CAFETERIAS, SODAS Y OTROS EXPENDIOS DE COMIDA',
                'codigo' => '5610.0',
                'descripcion' => 'Actividades de restaurantes y de servicios móviles de comidas',
            ],
            [
                'actividad' => 'SODAS',
                'codigo' => '5610.0',
                'descripcion' => 'Actividades de restaurantes y de servicios móviles de comidas',
            ],
            [
                'actividad' => 'OTROS EXPENDIOS DE COMIDAS',
                'codigo' => '5610.0',
                'descripcion' => 'Actividades de restaurantes y de servicios móviles de comidas',
            ],
            [
                'actividad' => 'SERVICIO DE RADIO FRECUENCIA',
                'codigo' => '6010.0',
                'descripcion' => 'Transmisiones de radio',
            ],
            [
                'actividad' => 'TRANSMISIONES DE RADIO',
                'codigo' => '6010.0',
                'descripcion' => 'Transmisiones de radio',
            ],
            [
                'actividad' => 'TRANSMISIONES DE RADIO CULTURALES SEGUN LEY GENERAL DE TELECOMUNICACIONES.',
                'codigo' => '6010.0',
                'descripcion' => 'Transmisiones de radio',
            ],
            [
                'actividad' => 'PROGRAMACION Y TRANSMISIONES DE TELEVISION',
                'codigo' => '6020.0',
                'descripcion' => 'Programación y transmisión de televisión',
            ],
            [
                'actividad' => 'CANALES DE TELEVISION',
                'codigo' => '6020.0',
                'descripcion' => 'Programación y transmisión de televisión',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE TARJETAS TELEFONICAS, PINES, TIEMPO AIRE Y SIMILARES',
                'codigo' => '6190.9',
                'descripcion' => 'Otras actividades de telecomunicación',
            ],
            [
                'actividad' => 'SERVICIOS DE RADIO-MENSAJES, RADIOLOCALIZADORES Y SIMILARES',
                'codigo' => '6190.9',
                'descripcion' => 'Otras actividades de telecomunicación',
            ],
            [
                'actividad' => 'MANTENIMIENTO DE REDES DE TELECOMUNICACION',
                'codigo' => '6190.9',
                'descripcion' => 'Otras actividades de telecomunicación',
            ],
            [
                'actividad' => 'PROCESAMIENTO DE DATOS',
                'codigo' => '6311.0',
                'descripcion' => 'Procesamiento de datos, hospedaje y actividades conexas',
            ],
            [
                'actividad' => 'ACTIVIDADES RELACIONADAS CON BASES DE DATOS',
                'codigo' => '6311.0',
                'descripcion' => 'Procesamiento de datos, hospedaje y actividades conexas',
            ],
            [
                'actividad' => 'FIDEICOMISOS Y/O ADMINISTRADORES DE FONDOS DE INVERSION',
                'codigo' => '6430.0',
                'descripcion' => 'Fondo y sociedades de Inversión y entidades financieras similares',
            ],
            [
                'actividad' => 'SOCIEDADES DE INVERSION MOBILIARIA',
                'codigo' => '6430.0',
                'descripcion' => 'Fondo y sociedades de Inversión y entidades financieras similares',
            ],
            [
                'actividad' => 'FONDOS DE INVERSION',
                'codigo' => '6430.0',
                'descripcion' => 'Fondo y sociedades de Inversión y entidades financieras similares',
            ],
            [
                'actividad' => 'CORREDORES DE BOLSA',
                'codigo' => '6612.0',
                'descripcion' => 'Corretaje de valores y de contratos de productos básicos',
            ],
            [
                'actividad' => 'PUESTOS DE BOLSA',
                'codigo' => '6612.0',
                'descripcion' => 'Corretaje de valores y de contratos de productos básicos',
            ],
            [
                'actividad' => 'PUESTOS Y/O CASAS DE CAMBIO DE MONEDA EXTRANJERA',
                'codigo' => '6612.0',
                'descripcion' => 'Corretaje de valores y de contratos de productos básicos',
            ],
            [
                'actividad' => 'AGENTES DE SEGUROS',
                'codigo' => '6622.0',
                'descripcion' => 'Actividades de agentes y corredores de seguro',
            ],
            [
                'actividad' => 'COMERCIALIZADORES DE SEGUROS',
                'codigo' => '6622.0',
                'descripcion' => 'Actividades de agentes y corredores de seguro',
            ],
            [
                'actividad' => 'SERVICIO DE REVISION TECNICA VEHICULAR (DIAGNOSTICOS POR ESCANNER)',
                'codigo' => '7120.0',
                'descripcion' => 'Ensayos y análisis técnicos',
            ],
            [
                'actividad' => 'QUIMICOS',
                'codigo' => '7120.0',
                'descripcion' => 'Ensayos y análisis técnicos',
            ],
            [
                'actividad' => 'ENSAYOS Y ANALISIS TECNICOS',
                'codigo' => '7120.0',
                'descripcion' => 'Ensayos y análisis técnicos',
            ],
            [
                'actividad' => 'PROFESIONALES EN TECNOLOGIA DE ALIMENTOS',
                'codigo' => '7120.0',
                'descripcion' => 'Ensayos y análisis técnicos',
            ],
            [
                'actividad' => 'ASESORES EN MERCADEO Y VENTAS',
                'codigo' => '7320.0',
                'descripcion' => 'Estudios de mercados y encuestas de opinión pública',
            ],
            [
                'actividad' => 'ENCUESTAS DE OPINION PUBLICA',
                'codigo' => '7320.0',
                'descripcion' => 'Estudios de mercados y encuestas de opinión pública',
            ],
            [
                'actividad' => 'DISENO ARTISTICO PARA COSTURA (MOLDES)',
                'codigo' => '7410.0',
                'descripcion' => 'Actividades especializadas de diseño',
            ],
            [
                'actividad' => 'ARTES GRAFICAS',
                'codigo' => '7410.0',
                'descripcion' => 'Actividades especializadas de diseño',
            ],
            [
                'actividad' => 'SERVICIO DE DISENO O DECORACION DE INTERIORES (POR CUENTA PROPIA).',
                'codigo' => '7410.0',
                'descripcion' => 'Actividades especializadas de diseño',
            ],
            [
                'actividad' => 'SERVICIO DE PILOTAJE',
                'codigo' => '7490.0',
                'descripcion' => 'Otras actividades profesionales, científicas y técnicas n.c.p.',
            ],
            [
                'actividad' => 'METEOROLOGO POR CUENTA PROPIA',
                'codigo' => '7490.0',
                'descripcion' => 'Otras actividades profesionales, científicas y técnicas n.c.p.',
            ],
            [
                'actividad' => 'ECONOMISTAS',
                'codigo' => '7490.0',
                'descripcion' => 'Otras actividades profesionales, científicas y técnicas n.c.p.',
            ],
            [
                'actividad' => 'BIOLOGO POR CUENTA PROPIA',
                'codigo' => '7490.0',
                'descripcion' => 'Otras actividades profesionales, científicas y técnicas n.c.p.',
            ],
            [
                'actividad' => 'SERVICIOS DE BIBLIOTECOLOGIA',
                'codigo' => '7490.0',
                'descripcion' => 'Otras actividades profesionales, científicas y técnicas n.c.p.',
            ],
            [
                'actividad' => 'SERVICIOS DE TRADUCTOR',
                'codigo' => '7490.0',
                'descripcion' => 'Otras actividades profesionales, científicas y técnicas n.c.p.',
            ],
            [
                'actividad' => 'MODELAJE PROFESIONAL (MODELO)',
                'codigo' => '7490.0',
                'descripcion' => 'Otras actividades profesionales, científicas y técnicas n.c.p.',
            ],
            [
                'actividad' => 'SERVICIOS PROFESIONALES NO CONTEMPLADOS EN OTRA PARTE',
                'codigo' => '7490.0',
                'descripcion' => 'Otras actividades profesionales, científicas y técnicas n.c.p.',
            ],
            [
                'actividad' => 'SERVICIOS VETERINARIOS CON VENTA DE PRODUCTOS GRAVADOS CON VENTAS',
                'codigo' => '7500.0',
                'descripcion' => 'Actividades veterinarias',
            ],
            [
                'actividad' => 'SERVICIOS MEDICOS VETERINARIOS',
                'codigo' => '7500.0',
                'descripcion' => 'Actividades veterinarias',
            ],
            [
                'actividad' => 'ALQUILER DE CARRITOS DE GOLF Y OTROS',
                'codigo' => '7721.0',
                'descripcion' => 'Alquiler y arrendamiento de equipo recreativo y deportivo',
            ],
            [
                'actividad' => 'ALQUILER DE EQUIPO RECREATIVO Y DEPORTIVO',
                'codigo' => '7721.0',
                'descripcion' => 'Alquiler y arrendamiento de equipo recreativo y deportivo',
            ],
            [
                'actividad' => 'ALQUILER DE ANIMALES (CABALLOS, SERPIENTES, ETC)',
                'codigo' => '7721.0',
                'descripcion' => 'Alquiler y arrendamiento de equipo recreativo y deportivo',
            ],
            [
                'actividad' => 'ALQUILER DE MENAJE',
                'codigo' => '7729.0',
                'descripcion' => 'Alquiler y arrendamiento de otros efectos personales y enseres domésticos',
            ],
            [
                'actividad' => 'ALQUILER DE TRAJES DE TODO TIPO',
                'codigo' => '7729.0',
                'descripcion' => 'Alquiler y arrendamiento de otros efectos personales y enseres domésticos',
            ],
            [
                'actividad' => 'ALQUILER DE EQUIPO Y UTENSILIOS PARA EVENTOS ESPECIALES',
                'codigo' => '7729.0',
                'descripcion' => 'Alquiler y arrendamiento de otros efectos personales y enseres domésticos',
            ],
            [
                'actividad' => 'ALQUILER DE MOTOCICLETA/SERVICIO',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER DE EQUIPO DE TRANSPORTE POR VIA TERRESTRE, ACUATICA O AEREA',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER DE MAQUINARIA Y EQUIPO PARA USO AGRICOLA',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER DE MAQUINARIA Y EQUIPO DE CONSTRUCCION E INGENIERIA CIVIL',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER DE MAQUINARIA Y EQUIPO DE OFICINA',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER DE MAQUINAS EXPENDEDORAS DE ALIMENTOS Y OTROS',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER DE MAQUINAS DE ENTRETENIMIENTO (CON MONEDAS)',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER DE EQUIPO PARA RADIO, TELEVISION Y COMUNICACIONES',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER DE EQUIPO PARA DISPENSAR BILLETES (CAJERO AUTOMA-TICO)',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER MAQUINARIA Y EQUIPO PARA LA ELABORACION Y/O MANTENIMIENTO DE PRODUCTOS',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER DE OTROS TIPOS DE MAQUINARIA Y EQUIPO PARA USO COMERCIAL',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER DE MAQUINARIA Y/O EQUIPO PARA USO INDUSTRIAL',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER DE RAMPAS Y SIMILARES',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER DE EQUIPO MEDICO Y ARTICULOS CONEXOS',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER DE ARTICULOS EN GENERAL PARA LA INDUSTRIA',
                'codigo' => '7730.0',
                'descripcion' => 'Alquiler y arrendamiento de otros tipo de maquinaria, equipo y bienes tangibles',
            ],
            [
                'actividad' => 'ALQUILER DE MARCAS REGISTRADAS',
                'codigo' => '7740.0',
                'descripcion' => 'Arrendamiento de propiedad intelectual y productos similares excepto obras protegidas por derechos de autor',
            ],
            [
                'actividad' => 'ALQUILER DE PATENTES (DE LICORES, UNICAMENTE)',
                'codigo' => '7740.0',
                'descripcion' => 'Arrendamiento de propiedad intelectual y productos similares excepto obras protegidas por derechos de autor',
            ],
            [
                'actividad' => 'EXPLOTACION DE FRANQUICIAS',
                'codigo' => '7740.0',
                'descripcion' => 'Arrendamiento de propiedad intelectual y productos similares excepto obras protegidas por derechos de autor',
            ],
            [
                'actividad' => 'ACTIVIDADES DE OPERADORES TURISTICOS(GUIA DE TURISMO)',
                'codigo' => '7912.0',
                'descripcion' => 'Actividades de operadores turísticos',
            ],
            [
                'actividad' => 'EXPLOTACION DE ACTIVIDADES TURISTICAS(CUYA PRES TACION NO SEA REALIZADA POR UN CENTRO DE RECREO)',
                'codigo' => '7912.0',
                'descripcion' => 'Actividades de operadores turísticos',
            ],
            [
                'actividad' => 'SERVICIOS DE INVESTIGACION, SEGURIDAD PRIVADA, AGENCIAS Y CONSULTORES',
                'codigo' => '8010.0',
                'descripcion' => 'Actividades de seguridad privada',
            ],
            [
                'actividad' => 'ACTIVIDADES DE DEFENSA',
                'codigo' => '8010.0',
                'descripcion' => 'Actividades de seguridad privada',
            ],
            [
                'actividad' => 'SERVICIO DE FOTOCOPIADORA',
                'codigo' => '8219.0',
                'descripcion' => 'Fotocopiado, preparación de documentos y otras actividades especializadas de apoyo de oficina',
            ],
            [
                'actividad' => 'SERVICIO DE FOTOCOPIADO Y OTROS',
                'codigo' => '8219.0',
                'descripcion' => 'Fotocopiado, preparación de documentos y otras actividades especializadas de apoyo de oficina',
            ],
            [
                'actividad' => 'SERVICIOS DE LEVANTADO DE TEXTO Y/O CORRECCION DE TEXTOS Y OTROS',
                'codigo' => '8219.0',
                'descripcion' => 'Fotocopiado, preparación de documentos y otras actividades especializadas de apoyo de oficina',
            ],
            [
                'actividad' => 'SERVICIOS SECRETARIALES Y/O OFICINISTA',
                'codigo' => '8219.0',
                'descripcion' => 'Fotocopiado, preparación de documentos y otras actividades especializadas de apoyo de oficina',
            ],
            [
                'actividad' => 'SERVCICIO DE COBRANZA DE RECIBOS PUBLICOS Y OTROS',
                'codigo' => '8291.0',
                'descripcion' => 'Actividades de agencias de cobro y agencias de calificación crediticia',
            ],
            [
                'actividad' => 'AGENCIAS DE COBRO Y CALIFICACION CREDITICIA',
                'codigo' => '8291.0',
                'descripcion' => 'Actividades de agencias de cobro y agencias de calificación crediticia',
            ],
            [
                'actividad' => 'ACTIVIDADES DEL SECTOR PUBLICO RELACIONADAS CON LA INFRAESTRUCTURA',
                'codigo' => '8413.0',
                'descripcion' => 'Regulación y facilitación de la actividad económica',
            ],
            [
                'actividad' => 'FONDOS PUBLICOS (ACTIVIDADES DEL SECTOR PUBLICO)',
                'codigo' => '8413.0',
                'descripcion' => 'Regulación y facilitación de la actividad económica',
            ],
            [
                'actividad' => 'ACTIVIDADES DE MANTENIMIENTO DEL ORDEN PUBLICO Y DE SEGURIDAD',
                'codigo' => '8423.0',
                'descripcion' => 'Actividades de mantenimiento del orden público y de seguridad',
            ],
            [
                'actividad' => 'SERVICIOS DE VIGILANCIA O CONTROL PORTUARIA, COSTERA, AEREA,Y FRONTERIZA',
                'codigo' => '8423.0',
                'descripcion' => 'Actividades de mantenimiento del orden público y de seguridad',
            ],
            [
                'actividad' => 'ENSENANZA PREESCOLAR Y PRIMARIA PRIVADA',
                'codigo' => '8510.0',
                'descripcion' => 'Enseñanza preescolar y primaria',
            ],
            [
                'actividad' => 'ENSENANZA PREESCOLAR Y PRIMARIA PRIVADA NO AUTORIZADOS POR EL MEP.',
                'codigo' => '8510.0',
                'descripcion' => 'Enseñanza preescolar y primaria',
            ],
            [
                'actividad' => 'PROFESIONALES EN EDUCACION ESPECIAL',
                'codigo' => '8510.0',
                'descripcion' => 'Enseñanza preescolar y primaria',
            ],
            [
                'actividad' => 'ENSENANZA SECUNDARIA PRIVADA',
                'codigo' => '8521.0',
                'descripcion' => 'Enseñanza secundaria de formación general',
            ],
            [
                'actividad' => 'ENSENANZA SECUNDARIA PRIVADA NO AUTORIZADA POR EL MEP.',
                'codigo' => '8521.0',
                'descripcion' => 'Enseñanza secundaria de formación general',
            ],
            [
                'actividad' => 'ENTRENADOR, INSTRUCTORES Y/O PREPARADORES FISICOS POR CUENTA PROPIA',
                'codigo' => '8541.0',
                'descripcion' => 'Educación deportiva y recreativa',
            ],
            [
                'actividad' => 'ACTIVIDADES DE ESCUELAS Y CLUBES DEPORTIVOS',
                'codigo' => '8541.0',
                'descripcion' => 'Educación deportiva y recreativa',
            ],
            [
                'actividad' => 'ENSENANZA CULTURAL',
                'codigo' => '8542.0',
                'descripcion' => 'Educación cultural',
            ],
            [
                'actividad' => 'ESCUELA Y AGENCIA DE MODELOS',
                'codigo' => '8542.0',
                'descripcion' => 'Educación cultural',
            ],
            [
                'actividad' => 'INSTRUCTOR DE TIRO (MANEJO DE ARMAS).',
                'codigo' => '8549.0',
                'descripcion' => 'Otros tipos de enseñanza n.c.p',
            ],
            [
                'actividad' => 'ESCUELAS COMERCIALES (NO ESTATALES)',
                'codigo' => '8549.0',
                'descripcion' => 'Otros tipos de enseñanza n.c.p',
            ],
            [
                'actividad' => 'PROFESOR POR CUENTA PROPIA',
                'codigo' => '8549.0',
                'descripcion' => 'Otros tipos de enseñanza n.c.p',
            ],
            [
                'actividad' => 'ENSENANZA DE LA DE SEGURIDAD PRIVADA',
                'codigo' => '8549.0',
                'descripcion' => 'Otros tipos de enseñanza n.c.p',
            ],
            [
                'actividad' => 'TERAPIA DEL LENGUAJE',
                'codigo' => '8550.0',
                'descripcion' => 'Actividades de apoyo a la enseñanza',
            ],
            [
                'actividad' => 'TERAPIA DEL LENGUAJE',
                'codigo' => '8550.0',
                'descripcion' => 'Actividades de apoyo a la enseñanza',
            ],
            [
                'actividad' => 'ACTIVIDADES DE HOSPITALES',
                'codigo' => '8610.0',
                'descripcion' => 'Actividades de hospitales',
            ],
            [
                'actividad' => 'SERVICIOS DE RADIOLOGIA, ANESTESIOLOGIA Y OTROS',
                'codigo' => '8610.0',
                'descripcion' => 'Actividades de hospitales',
            ],
            [
                'actividad' => 'LABORATORIOS MEDICOS - CLINICOS',
                'codigo' => '8690.1',
                'descripcion' => 'Laboratorios médicos y de diagnóstico',
            ],
            [
                'actividad' => 'SERVICIOS DE ESTERILIZACION DE PRODUCTOS MEDICOS Y FARMACEUTICOS',
                'codigo' => '8690.1',
                'descripcion' => 'Laboratorios médicos y de diagnóstico',
            ],
            [
                'actividad' => 'IMAGENELOGIA DIAGNOSTICA Y TERAPEUTICA',
                'codigo' => '8690.1',
                'descripcion' => 'Laboratorios médicos y de diagnóstico',
            ],
            [
                'actividad' => 'MEDICINA ALTERNATIVA',
                'codigo' => '8690.9',
                'descripcion' => 'Otras actividades relacionadas con la salud humana',
            ],
            [
                'actividad' => 'FISIOTERAPEUTA O TERAPEUTA FISICO',
                'codigo' => '8690.9',
                'descripcion' => 'Otras actividades relacionadas con la salud humana',
            ],
            [
                'actividad' => 'PSICOLOGO',
                'codigo' => '8690.9',
                'descripcion' => 'Otras actividades relacionadas con la salud humana',
            ],
            [
                'actividad' => 'SERVICIOS DE ENFERMERIA',
                'codigo' => '8690.9',
                'descripcion' => 'Otras actividades relacionadas con la salud humana',
            ],
            [
                'actividad' => 'TRANSPORTE EN AMBULANCIA TERRESTRE Y AEREO (SERVICIO PRIVADO)',
                'codigo' => '8690.9',
                'descripcion' => 'Otras actividades relacionadas con la salud humana',
            ],
            [
                'actividad' => 'NUTRICIONISTA',
                'codigo' => '8690.9',
                'descripcion' => 'Otras actividades relacionadas con la salud humana',
            ],
            [
                'actividad' => 'SERVICIOS DE PARAMEDICOS',
                'codigo' => '8690.9',
                'descripcion' => 'Otras actividades relacionadas con la salud humana',
            ],
            [
                'actividad' => 'OTRAS ACTIVIDADES RELACIONADAS CON LA SALUD HUMANA(BANCO DE SANGRE, BANCO DE PIEL, ETC)',
                'codigo' => '8690.9',
                'descripcion' => 'Otras actividades relacionadas con la salud humana',
            ],
            [
                'actividad' => 'AUDIOLOGIA',
                'codigo' => '8690.9',
                'descripcion' => 'Otras actividades relacionadas con la salud humana',
            ],
            [
                'actividad' => 'TERAPIA OCUPACIONAL',
                'codigo' => '8690.9',
                'descripcion' => 'Otras actividades relacionadas con la salud humana',
            ],
            [
                'actividad' => 'TERAPIA RESPIRATORIA',
                'codigo' => '8690.9',
                'descripcion' => 'Otras actividades relacionadas con la salud humana',
            ],
            [
                'actividad' => 'GUARDERIAS/CENTROS INFANTILES Y SERVICIOS SOCIALES',
                'codigo' => '8890.0',
                'descripcion' => 'Otras actividades de asistencia social sin alojamiento n.c.p',
            ],
            [
                'actividad' => 'SERVICIOS SOCIALES SIN ALOJAMIENTO',
                'codigo' => '8890.0',
                'descripcion' => 'Otras actividades de asistencia social sin alojamiento n.c.p',
            ],
            [
                'actividad' => 'GIMNASIOS',
                'codigo' => '9311.0',
                'descripcion' => 'Gestión de instalaciones deportivas',
            ],
            [
                'actividad' => 'EXPLOTACION DE PISCINAS O ALBERCAS DE BANO',
                'codigo' => '9311.0',
                'descripcion' => 'Gestión de instalaciones deportivas',
            ],
            [
                'actividad' => 'EXPLOTACION DE INSTALACIONES Y CAMPOS DEPORTIVOS',
                'codigo' => '9311.0',
                'descripcion' => 'Gestión de instalaciones deportivas',
            ],
            [
                'actividad' => 'ESPECTACULOS DEPORTIVOS',
                'codigo' => '9311.0',
                'descripcion' => 'Gestión de instalaciones deportivas',
            ],
            [
                'actividad' => 'ACTIVIDADES DEPORTIVAS Y OTRAS POR CUENTA PROPIA',
                'codigo' => '9319.0',
                'descripcion' => 'Otras actividades deportivas',
            ],
            [
                'actividad' => 'PESCA DEPORTIVA',
                'codigo' => '9319.0',
                'descripcion' => 'Otras actividades deportivas',
            ],
            [
                'actividad' => 'SALON DE BAILE Y DISCOTECA',
                'codigo' => '9329.0',
                'descripcion' => 'Otras actividades de esparcimiento y recreativas n.c.p',
            ],
            [
                'actividad' => 'SALON DE PATINES',
                'codigo' => '9329.0',
                'descripcion' => 'Otras actividades de esparcimiento y recreativas n.c.p',
            ],
            [
                'actividad' => 'NIGHT CLUB/CABARETTE',
                'codigo' => '9329.0',
                'descripcion' => 'Otras actividades de esparcimiento y recreativas n.c.p',
            ],
            [
                'actividad' => 'ACTIVIDADES DE JUEGOS DE BILLAR, POOL Y OTROS SIMILARES',
                'codigo' => '9329.0',
                'descripcion' => 'Otras actividades de esparcimiento y recreativas n.c.p',
            ],
            [
                'actividad' => 'SALA DE VIDEO JUEGOS',
                'codigo' => '9329.0',
                'descripcion' => 'Otras actividades de esparcimiento y recreativas n.c.p',
            ],
            [
                'actividad' => 'OTRAS ACTIVIDADES DE ESPARCIMIENTO',
                'codigo' => '9329.0',
                'descripcion' => 'Otras actividades de esparcimiento y recreativas n.c.p',
            ],
            [
                'actividad' => 'SERVICIO DE DISCO MOVIL',
                'codigo' => '9329.0',
                'descripcion' => 'Otras actividades de esparcimiento y recreativas n.c.p',
            ],
            [
                'actividad' => 'ACTIVIDADES DE ORGANIZACIONES EMPRESARIALES Y DE EMPLEADORES',
                'codigo' => '9411.0',
                'descripcion' => 'Actividades de Asociaciones empresariales y de empleadores',
            ],
            [
                'actividad' => 'CAMARAS DE COMERCIO',
                'codigo' => '9411.0',
                'descripcion' => 'Actividades de Asociaciones empresariales y de empleadores',
            ],
            [
                'actividad' => 'ASOCIACIONES SOLIDARISTAS',
                'codigo' => '9420.0',
                'descripcion' => 'Actividades de sindicatos',
            ],
            [
                'actividad' => 'ACTIVIDADES DE SINDICATOS',
                'codigo' => '9420.0',
                'descripcion' => 'Actividades de sindicatos',
            ],
            [
                'actividad' => 'REPARACION DE EQUIPO DE COMPUTO',
                'codigo' => '9511.0',
                'descripcion' => 'Reparación de computadoras y equipo periférico',
            ],
            [
                'actividad' => 'MANTENIMIENTO DE EQUIPO DE COMPUTO',
                'codigo' => '9511.0',
                'descripcion' => 'Reparación de computadoras y equipo periférico',
            ],
            [
                'actividad' => 'REPARACION DE TAPICERIA',
                'codigo' => '9524.0',
                'descripcion' => 'Reparación de muebles y accesorios domésticos',
            ],
            [
                'actividad' => 'REPARACION DE MUEBLES Y ACCESORIOS DOMESTICOS',
                'codigo' => '9524.0',
                'descripcion' => 'Reparación de muebles y accesorios domésticos',
            ],
            [
                'actividad' => 'SERVICIOS DE REPARACION DE JOYERIA Y RELOJERIA EN GENERAL',
                'codigo' => '9529.0',
                'descripcion' => 'Reparación de otros bienes personales y enseres domésticos n.c.p',
            ],
            [
                'actividad' => 'REPARACION DE BICICLETAS',
                'codigo' => '9529.0',
                'descripcion' => 'Reparación de otros bienes personales y enseres domésticos n.c.p',
            ],
            [
                'actividad' => 'REPARACION Y MANTENIMIENTO DE PERSIANAS Y CORTINAS',
                'codigo' => '9601.0',
                'descripcion' => 'Lavado y limpieza, incluida la limpieza en seco, de productos textiles y piel',
            ],
            [
                'actividad' => 'SERVICIOS DE LAVANDERIA DE TODO TIPO',
                'codigo' => '9601.0',
                'descripcion' => 'Lavado y limpieza, incluida la limpieza en seco, de productos textiles y piel',
            ],
            [
                'actividad' => 'SERVICIO DE LIMPIEZA Y LAVADO DE MUEBLES',
                'codigo' => '9601.0',
                'descripcion' => 'Lavado y limpieza, incluida la limpieza en seco, de productos textiles y piel',
            ],
            [
                'actividad' => 'SALAS DE MASAJES',
                'codigo' => '9609.0',
                'descripcion' => 'Otras actividades de servicios personales n.c.p',
            ],
            [
                'actividad' => 'OTRAS ACTIVIDADES DE SERVICIOS PERSONALES N.C.P.',
                'codigo' => '9609.0',
                'descripcion' => 'Otras actividades de servicios personales n.c.p',
            ],
            [
                'actividad' => 'CENTRO O SALA DE BRONCEADO',
                'codigo' => '9609.0',
                'descripcion' => 'Otras actividades de servicios personales n.c.p',
            ],
            [
                'actividad' => 'PELUQUERIA Y SALA DE ESTETICA PARA ANIMALES',
                'codigo' => '9609.0',
                'descripcion' => 'Otras actividades de servicios personales n.c.p',
            ],
            [
                'actividad' => 'SERVICIO DE TATUAJE Y PIERCING',
                'codigo' => '9609.0',
                'descripcion' => 'Otras actividades de servicios personales n.c.p',
            ],
            [
                'actividad' => 'ALBERGUE Y CUIDO DE ANIMALES A DOMICILIO',
                'codigo' => '9609.0',
                'descripcion' => 'Otras actividades de servicios personales n.c.p',
            ],
            [
                'actividad' => 'ACTIVIDADES DE ORGANIZACIONES Y ORGANOS EXTRATERRITORIALES QUE BRINDAN SERVICIOS EN EL PAIS',
                'codigo' => '9900.0',
                'descripcion' => 'Actividades de organizaciones y órganos extraterritoriales',
            ],
            [
                'actividad' => 'ACTIVIDADES DE ORGANIZACIONES Y ORGANOS EXTRATERRITORIALES, INCLUYE LAS EMBAJADAS DE OTROS PAISES',
                'codigo' => '9900.0',
                'descripcion' => 'Actividades de organizaciones y órganos extraterritoriales',
            ],
            [
                'actividad' => 'CULTIVO Y COMERCIALIZACION DE CESPED',
                'codigo' => '130.0',
                'descripcion' => 'Propagación de plantas',
            ],
            [
                'actividad' => 'VIVEROS',
                'codigo' => '130.0',
                'descripcion' => 'Propagación de plantas',
            ],
            [
                'actividad' => 'CRIA DE MARIPOSAS',
                'codigo' => '149.0',
                'descripcion' => 'Cría de otros animales',
            ],
            [
                'actividad' => 'CRIA Y VENTA DE OTROS ANIMALES SEMIDOMESTICADOS O SALVAJES',
                'codigo' => '149.0',
                'descripcion' => 'Cría de otros animales',
            ],
            [
                'actividad' => 'APICULTURA Y PRODUCCION DE MIEL Y CERA DE ABEJA',
                'codigo' => '149.0',
                'descripcion' => 'Cría de otros animales',
            ],
            [
                'actividad' => 'PESCADORES ARTESANALES EN PEQ. ESCALA',
                'codigo' => '311.0',
                'descripcion' => 'Pesca marítima',
            ],
            [
                'actividad' => 'PESCADORES ARTESANALES MEDIOS',
                'codigo' => '311.0',
                'descripcion' => 'Pesca marítima',
            ],
            [
                'actividad' => 'PESCADORES EN GRAN ESCALA',
                'codigo' => '311.0',
                'descripcion' => 'Pesca marítima',
            ],
            [
                'actividad' => 'PRODUCCION DE CUEROS Y PIELES SIN CURTIR',
                'codigo' => '1010.1',
                'descripcion' => 'Elaboración y conservación de carne y embutidos de ganado vacuno y porcino',
            ],
            [
                'actividad' => 'PRODUCCION DE EMBUTIDOS EMPACADOS, ENVASADO Y ENLATADO',
                'codigo' => '1010.1',
                'descripcion' => 'Elaboración y conservación de carne y embutidos de ganado vacuno y porcino',
            ],
            [
                'actividad' => 'PASTELERIA, REPOSTERIA O AMBAS',
                'codigo' => '1071.9',
                'descripcion' => 'Elaboración de otros productos de panadería, excepto elaboración de galletas',
            ],
            [
                'actividad' => 'VENTA DE PAN Y OTROS PRODUCTOS SIMILARES GRAVADOS CON IVA',
                'codigo' => '1071.9',
                'descripcion' => 'Elaboración de otros productos de panadería, excepto elaboración de galletas',
            ],
            [
                'actividad' => 'ELABORACION Y VENTA DE PRODUCTOS DE PANADERIA INCLUIDOS EN CANASTA BASICA',
                'codigo' => '1071.9',
                'descripcion' => 'Elaboración de otros productos de panadería, excepto elaboración de galletas',
            ],
            [
                'actividad' => 'ELABORAC. RECTIFICAC MEZCLA BEBIDAS ALCOHOLICAS/PROD. DE ALCOHOL ETILICO (SUSTAN FERMENTADAS)',
                'codigo' => '1101.0',
                'descripcion' => 'Destilación, rectificación y mezcla de bebidas alcohólicas',
            ],
            [
                'actividad' => 'ELABORACION DE BEBIDAS CON PORCENTAJE DE ALCOHOL POR VOLUMEN MENOR AL 15%.',
                'codigo' => '1101.0',
                'descripcion' => 'Destilación, rectificación y mezcla de bebidas alcohólicas',
            ],
            [
                'actividad' => 'ELABORACION DE BEBIDAS CON PORCENTAJE DE ALCOHOL POR VOLUMEN MENOR AL 15%.',
                'codigo' => '1101.0',
                'descripcion' => 'Destilación, rectificación y mezcla de bebidas alcohólicas',
            ],
            [
                'actividad' => 'FABRICA NACIONAL DE LICORES',
                'codigo' => '1101.0',
                'descripcion' => 'Destilación, rectificación y mezcla de bebidas alcohólicas',
            ],
            [
                'actividad' => 'ELABORACION DE BEBIDAS MALTEADAS Y DE MALTA NO ARTESANALES',
                'codigo' => '1103.0',
                'descripcion' => 'Elaboración de bebidas malteadas y de malta',
            ],
            [
                'actividad' => 'ELABORACION ARTESANAL DE BEBIDAS MALTEADAS Y DE MALTA',
                'codigo' => '1103.0',
                'descripcion' => 'Elaboración de bebidas malteadas y de malta',
            ],
            [
                'actividad' => 'TIPOGRAFIA Y/O LITOGRAFIA (IMPRENTA)',
                'codigo' => '1811.0',
                'descripcion' => 'Impresión',
            ],
            [
                'actividad' => 'IMPRESION DIGITAL',
                'codigo' => '1811.0',
                'descripcion' => 'Impresión',
            ],
            [
                'actividad' => 'SERIGRAFIA',
                'codigo' => '1811.0',
                'descripcion' => 'Impresión',
            ],
            [
                'actividad' => 'REFINERIAS DE PETROLEO',
                'codigo' => '1920.0',
                'descripcion' => 'Fabricación de los productos de la refinación del petróleo',
            ],
            [
                'actividad' => 'FABRICACION DE PRODUCTOS DIVERSOS DERIVADOS DEL PETROLEO',
                'codigo' => '1920.0',
                'descripcion' => 'Fabricación de los productos de la refinación del petróleo',
            ],
            [
                'actividad' => 'FABRICACION DE PINTURAS, BARNICES Y PRODUCTOS DE REVESTIMIENTO SIMILARES',
                'codigo' => '2022.0',
                'descripcion' => 'Fabricación de pinturas, barnices y productos de revestimiento similares, tintas de imprenta y masillas',
            ],
            [
                'actividad' => 'FABRICACION DE TINTAS DE IMPRENTAS',
                'codigo' => '2022.0',
                'descripcion' => 'Fabricación de pinturas, barnices y productos de revestimiento similares, tintas de imprenta y masillas',
            ],
            [
                'actividad' => 'FABRICACION JABONES, DETERGENTES, PREPARADOS DE TOCADOR, PARA LIMPIAR PULIR Y PERFUMES',
                'codigo' => '2023.1',
                'descripcion' => 'Fabricación de jabones y detergentes, preparados para limpiar y pulir',
            ],
            [
                'actividad' => 'FABRICACION DE JABONES PARA LAVAR (EXCEPTO PREPARACIONES TENSO ACTIVAS USADAS COMO JABON)',
                'codigo' => '2023.1',
                'descripcion' => 'Fabricación de jabones y detergentes, preparados para limpiar y pulir',
            ],
            [
                'actividad' => 'FABRICACION DE CERAS, ABRILLANTADORES, LUSTRADORES Y PREPARACIONES SIMILARES',
                'codigo' => '2023.1',
                'descripcion' => 'Fabricación de jabones y detergentes, preparados para limpiar y pulir',
            ],
            [
                'actividad' => 'FABRICACION DE LLANTAS Y CUBIERTAS PARA EQUIPO Y MAQUINARIAMOVIL',
                'codigo' => '2211.0',
                'descripcion' => 'Fabricación de cubiertas y cámaras de caucho; recauchutado y renovación de cubiertas de caucho',
            ],
            [
                'actividad' => 'REENCAUCHADORA DE LLANTAS',
                'codigo' => '2211.0',
                'descripcion' => 'Fabricación de cubiertas y cámaras de caucho; recauchutado y renovación de cubiertas de caucho',
            ],
            [
                'actividad' => 'FABRICACION DE CAL O YESO',
                'codigo' => '2394.0',
                'descripcion' => 'Fabricación de cemento, de la cal y del yeso',
            ],
            [
                'actividad' => 'FABRICACION DE CEMENTO',
                'codigo' => '2394.0',
                'descripcion' => 'Fabricación de cemento, de la cal y del yeso',
            ],
            [
                'actividad' => 'FABRICACION DE CARROCERIAS PARA VEHICULOS AUTOMOTORES, REMOLQUES Y SEMIREMOLQUES',
                'codigo' => '2920.0',
                'descripcion' => 'Fabricación de carrocerias para vehículos automotores; fabricación de remolques y semiremolques',
            ],
            [
                'actividad' => 'FABRICACION DE CARROCERIAS PARA CAMIONES DE LAS PARTIDAS ARANCELARIAS 870790002 Y 870790500029',
                'codigo' => '2920.0',
                'descripcion' => 'Fabricación de carrocerias para vehículos automotores; fabricación de remolques y semiremolques',
            ],
            [
                'actividad' => 'FABRICACION DE PROTESIS EN GENERAL',
                'codigo' => '3250.0',
                'descripcion' => 'Fabricación de instrumentos y suministros médicos y odontológicos',
            ],
            [
                'actividad' => 'FABRICACION Y COMERCIALIZACION DE EQUIPO MEDICO',
                'codigo' => '3250.0',
                'descripcion' => 'Fabricación de instrumentos y suministros médicos y odontológicos',
            ],
            [
                'actividad' => 'FABRICACION Y COMERCIALIZACION DE ZAPATOS ORTOPEDICOS',
                'codigo' => '3250.0',
                'descripcion' => 'Fabricación de instrumentos y suministros médicos y odontológicos',
            ],
            [
                'actividad' => 'PERFORACION DE POZOS',
                'codigo' => '4390.0',
                'descripcion' => 'Otras actividades especializadas de la construcción',
            ],
            [
                'actividad' => 'ACTIVIDADES DE CONSTRUCCION ESPECIALES',
                'codigo' => '4390.0',
                'descripcion' => 'Otras actividades especializadas de la construcción',
            ],
            [
                'actividad' => 'INSTALACION Y MANTENIMIENTO DE PISCINAS,JACUZZIS Y SIMILARES',
                'codigo' => '4390.0',
                'descripcion' => 'Otras actividades especializadas de la construcción',
            ],
            [
                'actividad' => 'ALQUILER DE EQUIPO DE CONSTRUCCION O DEMOLICION CON OPERADORES',
                'codigo' => '4390.0',
                'descripcion' => 'Otras actividades especializadas de la construcción',
            ],
            [
                'actividad' => 'SERVICIO DE REPARACION DE TODA CLASE DE MOTOCICLETAS Y SUS PARTES',
                'codigo' => '4540.0',
                'descripcion' => 'Venta, mantenimiento y reparación de motocicletas y de sus partes, piezas y accesorios',
            ],
            [
                'actividad' => 'VENTA DE MOTOCICLETAS',
                'codigo' => '4540.0',
                'descripcion' => 'Venta, mantenimiento y reparación de motocicletas y de sus partes, piezas y accesorios',
            ],
            [
                'actividad' => 'VENTA DE PARTES O ACCESORIOS DE MOTOCICLETAS',
                'codigo' => '4540.0',
                'descripcion' => 'Venta, mantenimiento y reparación de motocicletas y de sus partes, piezas y accesorios',
            ],
            [
                'actividad' => 'VENTA DE COMBUSTIBLES (CONOCIDAS COMO GASOLINERAS O BOMBAS)',
                'codigo' => '4730.0',
                'descripcion' => 'Venta al por menor de combustibles para vehículos automotores en comercios especializados',
            ],
            [
                'actividad' => 'VENTA DE LUBRICANTES, ACEITES, GRASAS Y PRODUCTOS DE LIMPIEZA PARA AUTOMOTORES',
                'codigo' => '4730.0',
                'descripcion' => 'Venta al por menor de combustibles para vehículos automotores en comercios especializados',
            ],
            [
                'actividad' => 'COMERCIO DE COMBUSTIBLE SIN PUNTO FIJO (PEDDLER)',
                'codigo' => '4730.0',
                'descripcion' => 'Venta al por menor de combustibles para vehículos automotores en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE ARTICULOS ELECTRONICOS, ELECTRICOS Y SIMILARES',
                'codigo' => '4741.0',
                'descripcion' => 'Venta al por menor de computadoras, equipo periféricos, programas de información y telecomunicaciones en comercios especializados',
            ],
            [
                'actividad' => 'COMERCIO AL POR MENOR DE COMPUTADORAS, ACCESORIOS, MICROCOMPONENTES Y PAQUETES DE COMPUTO',
                'codigo' => '4741.0',
                'descripcion' => 'Venta al por menor de computadoras, equipo periféricos, programas de información y telecomunicaciones en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR CELULARES ACCESORIOS EQUIPO Y ART PARA COMUNICACIONES INCLUYE LA REPARACION',
                'codigo' => '4741.0',
                'descripcion' => 'Venta al por menor de computadoras, equipo periféricos, programas de información y telecomunicaciones en comercios especializados',
            ],
            [
                'actividad' => 'VENTA DE CUADROS PINTURAS HECHAS POR PINTORES NACIONALES Y EXTRANJEROS PRODUCIDOS EN EL PAIS',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados.',
            ],
            [
                'actividad' => 'VENTA DE PERROS ENTRENADOS PARA SEGURIDAD',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'INSTALACION Y VENTA DE TANQUES PARA GAS',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE ARMAS (ARMERIAS)',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE CAJAS REGISTRADORAS, CALCULADORAS O MAQUINAS DE CONTABILIDAD',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE EXTINTORES',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE MATERIALES PARA CALZADO',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE MAQUINARIA Y EQUIPO DE TODO TIPO Y ARTICULOS CONEXOS',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE REPUESTOS NUEVOS PARA MAQUINARIA, EQUIPO Y OTROS',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE OTROS PRODUCTOS EN ALMACENES ESPECIALIZADOS',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE FLORES',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE JOYERIA, RELOJERIA Y BISUTERIA',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE PANALES DESECHABLES, ARTICULOS DE LIMPIEZA Y OTROS (PANALERA)',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE ANIMALES DOMESTICOS/MASCOTAS, ALIMENTOS Y ACCESORIOS',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE PRODUCTOS PARA USO AGROPECUARIO',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE ANTEOJOS Y ARTICULOS OPTICOS (OPTICA)',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE REPUESTOS PARA ELECTRODOMESTICOS',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE OTROS PRODUCTOS NUEVOS EN COMERCIOS ESPECIALIZADOS NO INCLUIDOS EN CANASTA BASICA.',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA DE PRODUCTOS DE ARTESANIA Y SOUVENIR',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'DISTRIBUCION Y VENTA DE GAS EN CILINDRO',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA DE MONEDAS, BILLETES,ESTAMPILLAS (NUEVAS Y USADAS) PARA COLECCION Y ESPECIES FISCALES',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'FLORISTERIA',
                'codigo' => '4773.0',
                'descripcion' => 'Otra venta al por menor de otros productos nuevos en comercios especializados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE ANTIGUEDADES',
                'codigo' => '4774.0',
                'descripcion' => 'Venta al por menor de artículos de segunda mano',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE REPUESTOS USADOS PARA MAQUINARIA, EQUIPO Y OTROS',
                'codigo' => '4774.0',
                'descripcion' => 'Venta al por menor de artículos de segunda mano',
            ],
            [
                'actividad' => 'VENTA DE TODO TIPO DE ARTICULOS USADOS',
                'codigo' => '4774.0',
                'descripcion' => 'Venta al por menor de artículos de segunda mano',
            ],
            [
                'actividad' => 'VENTA DE REPUESTOS USADOS PARA AUTOMOVILES',
                'codigo' => '4774.0',
                'descripcion' => 'Venta al por menor de artículos de segunda mano',
            ],
            [
                'actividad' => 'VENTA DE LIBROS USADOS',
                'codigo' => '4774.0',
                'descripcion' => 'Venta al por menor de artículos de segunda mano',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE ROPA USADA',
                'codigo' => '4774.0',
                'descripcion' => 'Venta al por menor de artículos de segunda mano',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE MAQUINARIA INDUSTRIAL USADA',
                'codigo' => '4774.0',
                'descripcion' => 'Venta al por menor de artículos de segunda mano',
            ],
            [
                'actividad' => 'PEQUENOS PRODUCTORES AGRICOLAS (FERIAS DEL AGRICULTOR)',
                'codigo' => '4781.0',
                'descripcion' => 'Venta al por menor en puestos de venta y mercados de: alimentos, bebidas y de productos del tabaco',
            ],
            [
                'actividad' => 'PEQUENOS PRODUCTORES AGRICOLAS',
                'codigo' => '4781.0',
                'descripcion' => 'Venta al por menor en puestos de venta y mercados de: alimentos, bebidas y de productos del tabaco',
            ],
            [
                'actividad' => '',
                'codigo' => '4781.0',
                'descripcion' => 'Venta al por menor en puestos de venta y mercados de: alimentos, bebidas y de productos del tabaco',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE TODO TIPO DE ARTICULOS POR CATALOGO',
                'codigo' => '4799.0',
                'descripcion' => 'Otros tipos de venta al por menor no realizada en comercios, puestos de venta o mercados',
            ],
            [
                'actividad' => 'VENTA AL POR MENOR DE PIEZAS DE BAMBU',
                'codigo' => '4799.0',
                'descripcion' => 'Otros tipos de venta al por menor no realizada en comercios, puestos de venta o mercados',
            ],
            [
                'actividad' => 'VENTA DE REVISTAS/PERIODICOS (PUESTOS CALLEJEROS)',
                'codigo' => '4799.0',
                'descripcion' => 'Otros tipos de venta al por menor no realizada en comercios, puestos de venta o mercados',
            ],
            [
                'actividad' => 'VENTA AMBULANTE DE ARTICULOS PARA EL HOGAR',
                'codigo' => '4799.0',
                'descripcion' => 'Otros tipos de venta al por menor no realizada en comercios, puestos de venta o mercados',
            ],
            [
                'actividad' => 'VENTA DE LIBROS A DOMICILIO',
                'codigo' => '4799.0',
                'descripcion' => 'Otros tipos de venta al por menor no realizada en comercios, puestos de venta o mercados',
            ],
            [
                'actividad' => 'SERVICIO DE TAXI',
                'codigo' => '4922.2',
                'descripcion' => 'Servicios de taxi',
            ],
            [
                'actividad' => 'SERVICIO ESPECIAL ESTABLE DE TAXI',
                'codigo' => '4922.2',
                'descripcion' => 'Servicios de taxi',
            ],
            [
                'actividad' => 'SERVICIO DE TELEVISION POR CABLE, SATELITE U OTROS SISTEMA S SIMILARES',
                'codigo' => '6110.0',
                'descripcion' => 'Actividades de telecomunicaciones alámbricas',
            ],
            [
                'actividad' => 'VENTA DE ESPACIO EN EL CABLE SUBMARINO',
                'codigo' => '6110.0',
                'descripcion' => 'Actividades de telecomunicaciones alámbricas',
            ],
            [
                'actividad' => 'SERVICIOS TELEFONICOS, TELEGRAFICOS Y POR TELEX',
                'codigo' => '6110.0',
                'descripcion' => 'Actividades de telecomunicaciones alámbricas',
            ],
            [
                'actividad' => 'COOPERATIVAS DE AHORRO Y CREDITO',
                'codigo' => '6419.0',
                'descripcion' => 'Otros tipos de intermediación monetaria',
            ],
            [
                'actividad' => 'BANCOS ESTATALES (EXCEPTO EL BANCO CENTRAL)',
                'codigo' => '6419.0',
                'descripcion' => 'Otros tipos de intermediación monetaria',
            ],
            [
                'actividad' => 'ENTIDADES FINANCIERAS PRIVADAS (BANCOS)',
                'codigo' => '6419.0',
                'descripcion' => 'Otros tipos de intermediación monetaria',
            ],
            [
                'actividad' => 'INSTITUCIONES DE AHORRO Y CREDITO PARA VIVIENDA',
                'codigo' => '6419.0',
                'descripcion' => 'Otros tipos de intermediación monetaria',
            ],
            [
                'actividad' => 'SERVICIO DE ENVIO Y RECIBO DE DINERO',
                'codigo' => '6419.0',
                'descripcion' => 'Otros tipos de intermediación monetaria',
            ],
            [
                'actividad' => 'EMISORES DE TARJETAS DE CREDITO/DEBITO',
                'codigo' => '6492.0',
                'descripcion' => 'Otros tipos de crédito',
            ],
            [
                'actividad' => 'CASA DE EMPENO Y AFIN',
                'codigo' => '6492.0',
                'descripcion' => 'Otros tipos de crédito',
            ],
            [
                'actividad' => 'ENTIDADES FINANCIERAS DISTINTAS AL SISTEMA BANCARIO NACIONAL',
                'codigo' => '6492.0',
                'descripcion' => 'Otros tipos de crédito',
            ],
            [
                'actividad' => 'SERVICIO DE PRESTAMO (PRESTAMISTAS)',
                'codigo' => '6492.0',
                'descripcion' => 'Otros tipos de crédito',
            ],
            [
                'actividad' => 'SERVICIO RECUPERACION DE DEUDAS (FACTORE0)',
                'codigo' => '6499.0',
                'descripcion' => 'Otras actividades de servicios financiero, excepto las de seguros y fondos de pensiones n.c.p',
            ],
            [
                'actividad' => 'INGRESOS POR INTERESES DIFERENTES AL COMERCIO DEL PRESTAMO',
                'codigo' => '6499.0',
                'descripcion' => 'Otras actividades de servicios financiero, excepto las de seguros y fondos de pensiones n.c.p',
            ],
            [
                'actividad' => '',
                'codigo' => '6499.0',
                'descripcion' => 'Otras actividades de servicios financiero, excepto las de seguros y fondos de pensiones n.c.p',
            ],
            [
                'actividad' => 'OPERADORAS DE PENSIONES',
                'codigo' => '6530.0',
                'descripcion' => 'Fondos de pensión',
            ],
            [
                'actividad' => 'FONDOS DE OPERADORAS DE PENSIONES EXENTOS DEL 8%',
                'codigo' => '6530.0',
                'descripcion' => 'Fondos de pensión',
            ],
            [
                'actividad' => 'TRAMITACION Y LIQUIDACION DE LAS TRANSACCIONES CON TARJETAS DE CREDITO/DEBITO (ADQUIRENTE)',
                'codigo' => '6619.0',
                'descripcion' => 'Otras actividades auxiliares a las actividades de servicios financieros',
            ],
            [
                'actividad' => 'ASESORES FINANCIEROS Y ACTIVIDADES AUXILIARES DE LA INTERMEDICIACION FINANCIERA',
                'codigo' => '6619.0',
                'descripcion' => 'Otras actividades auxiliares a las actividades de servicios financieros',
            ],
            [
                'actividad' => 'COMPRA Y VENTA DE PROPIEDADES (INVERSIONISTAS)',
                'codigo' => '6810.0',
                'descripcion' => 'Actividades inmobiliarias con bienes propios o arrendados',
            ],
            [
                'actividad' => 'ALQUILER DE CASAS Y OTROS',
                'codigo' => '6810.0',
                'descripcion' => 'Actividades inmobiliarias con bienes propios o arrendados',
            ],
            [
                'actividad' => 'ALQUILER DE LOCALES COMERCIALES Y CENTROS COMERCIALES',
                'codigo' => '6810.0',
                'descripcion' => 'Actividades inmobiliarias con bienes propios o arrendados',
            ],
            [
                'actividad' => 'ALQUILER DE EDIFICIOS Y PROPIEDADES DIFERENTES A CASAS DE HABITACION',
                'codigo' => '6810.0',
                'descripcion' => 'Actividades inmobiliarias con bienes propios o arrendados',
            ],
            [
                'actividad' => 'ARRENDAMIENTO O ALQUILER DE BIENES INMUEBLES MEDIANTE CONTRATO VERBAL O ESCRITO.',
                'codigo' => '6810.0',
                'descripcion' => 'Actividades inmobiliarias con bienes propios o arrendados',
            ],
            [
                'actividad' => 'BUFFETE DE ABOGADO, NOTARIO, ASESOR LEGAL',
                'codigo' => '6910.0',
                'descripcion' => 'Actividades jurídicas',
            ],
            [
                'actividad' => 'ACTVIDAD DE CONTABILIDAD (CONTADORES), TENEDURIA DE LIBROS, TODO TIPO DE AUDITORIA,INCLUYENDO LA FISCAL Y ASESORIA
        FISCAL.',
                'codigo' => '6920.0',
                'descripcion' => 'Actividades de contabilidad, teneduría de libros y auditorías; consultoría fiscal',
            ],
            [
                'actividad' => 'ACTIVIDADES DE ARQUITECTURA E INGENIERIA',
                'codigo' => '7110.0',
                'descripcion' => 'Actividades de arquitectura e ingeniería y actividades conexas de consultoría técnica',
            ],
            [
                'actividad' => 'SERVICIOS DE CONSULTORIA EN MANTENIMIENTO INDUSTRIAL Y MECANICO',
                'codigo' => '7110.0',
                'descripcion' => 'Actividades de arquitectura e ingeniería y actividades conexas de consultoría técnica',
            ],
            [
                'actividad' => 'ACTIVIDADES DE GEOGRAFIA Y/O GEOLOGIA',
                'codigo' => '7110.0',
                'descripcion' => 'Actividades de arquitectura e ingeniería y actividades conexas de consultoría técnica',
            ],
            [
                'actividad' => 'DIBUJANTE ARQUITECTONICO Y/O PLANOS DE CONSTRUCCION',
                'codigo' => '7110.0',
                'descripcion' => 'Actividades de arquitectura e ingeniería y actividades conexas de consultoría técnica',
            ],
            [
                'actividad' => 'PROFESIONALES EN SALUD OCUPACIONAL',
                'codigo' => '7110.0',
                'descripcion' => 'Actividades de arquitectura e ingeniería y actividades conexas de consultoría técnica',
            ],
            [
                'actividad' => 'ALQUILER DE ESPACIOS PUBLICITARIOS',
                'codigo' => '7310.0',
                'descripcion' => 'Publicidad',
            ],
            [
                'actividad' => 'PUBLICIDAD',
                'codigo' => '7310.0',
                'descripcion' => 'Publicidad',
            ],
            [
                'actividad' => 'SERVICIOS DE PUBLICIDAD',
                'codigo' => '7310.0',
                'descripcion' => 'Publicidad',
            ],
            [
                'actividad' => 'PUBLICIDAD A TRAVES DE MEDIOS ELECTRONICOS',
                'codigo' => '7310.0',
                'descripcion' => 'Publicidad',
            ],
            [
                'actividad' => 'ESTUDIOS FOTOGRAFICOS',
                'codigo' => '7420.0',
                'descripcion' => 'Actividades de fotografía',
            ],
            [
                'actividad' => 'SERVICIO DE FOTOGRAFIA (FOTOGRAFO)',
                'codigo' => '7420.0',
                'descripcion' => 'Actividades de fotografía',
            ],
            [
                'actividad' => 'AGENCIAS FOTOGRAFICAS POR CATALOGO',
                'codigo' => '7420.0',
                'descripcion' => 'Actividades de fotografía',
            ],
            [
                'actividad' => 'EMISION DE LA LOTERIA NACIONAL Y SIMILARES',
                'codigo' => '8411.0',
                'descripcion' => 'Actividades de la administración pública en general',
            ],
            [
                'actividad' => 'FIDEICOMISOS DE LA LEY DEL SISTEMA DE BANCA PARA EL DESARROLLO',
                'codigo' => '8411.0',
                'descripcion' => 'Actividades de la administración pública en general',
            ],
            [
                'actividad' => 'FONDOS DE LA LEY DEL SISTEMA DE BANCA PARA EL DESARROLLO',
                'codigo' => '8411.0',
                'descripcion' => 'Actividades de la administración pública en general',
            ],
            [
                'actividad' => 'ACTIVIDADES DE LA ADMINISTRACION PUBLICA EN GENERAL',
                'codigo' => '8411.0',
                'descripcion' => 'Actividades de la administración pública en general',
            ],
            [
                'actividad' => 'ENTES PUBLICOS DE NATURALEZA TRIBUTARIA E INSCRIPCION DE BIENES.',
                'codigo' => '8411.0',
                'descripcion' => 'Actividades de la administración pública en general',
            ],
            [
                'actividad' => 'MUNICIPALIDADES Y CONCEJOS DE DISTRITO',
                'codigo' => '8411.0',
                'descripcion' => 'Actividades de la administración pública en general',
            ],
            [
                'actividad' => 'COMITES CANTONALES DE DEPORTES Y RECREACION',
                'codigo' => '8411.0',
                'descripcion' => 'Actividades de la administración pública en general',
            ],
            [
                'actividad' => 'ACTIVIDADES DE LA ADMINISTRACION PUBLICA EN GENERAL, NO SUJETAS A IMPUESTO SOBRE LAS UTILIDADES Y SOBRE EL VALOR
        AGREGADO',
                'codigo' => '8411.0',
                'descripcion' => 'Actividades de la administración pública en general',
            ],
            [
                'actividad' => 'ENSENANZA SUPERIOR PRIVADA (UNIVERSIDADES)',
                'codigo' => '8530.1',
                'descripcion' => 'Enseñanza universitaria',
            ],
            [
                'actividad' => 'ENSENANZA SUPERIOR PUBLICA (UNIVERSIDADES)',
                'codigo' => '8530.1',
                'descripcion' => 'Enseñanza universitaria',
            ],
            [
                'actividad' => 'GINECOLOGO',
                'codigo' => '8620.1',
                'descripcion' => 'Actividades de médicos',
            ],
            [
                'actividad' => 'SERVICIOS DE MEDICO GENERAL',
                'codigo' => '8620.1',
                'descripcion' => 'Actividades de médicos',
            ],
            [
                'actividad' => 'NEUROLOGOS',
                'codigo' => '8620.1',
                'descripcion' => 'Actividades de médicos',
            ],
            [
                'actividad' => 'SERVICIOS DE OFTALMOLOGO U OCULISTA, OPTOMETRISTA Y/O OPTICO',
                'codigo' => '8620.1',
                'descripcion' => 'Actividades de médicos',
            ],
            [
                'actividad' => 'ORTOPEDISTA (CONSULTA PRIVADA)',
                'codigo' => '8620.1',
                'descripcion' => 'Actividades de médicos',
            ],
            [
                'actividad' => 'OTORRINOLARINGOLOGIA Y SERVICIOS CONEXOS.',
                'codigo' => '8620.1',
                'descripcion' => 'Actividades de médicos',
            ],
            [
                'actividad' => 'FARMACEUTICO O BOTICARIO',
                'codigo' => '8620.1',
                'descripcion' => 'Actividades de médicos',
            ],
            [
                'actividad' => 'CARDIOLOGOS',
                'codigo' => '8620.1',
                'descripcion' => 'Actividades de médicos',
            ],
            [
                'actividad' => 'ONCOLOGOS',
                'codigo' => '8620.1',
                'descripcion' => 'Actividades de médicos',
            ],
            [
                'actividad' => 'REUMATOLOGO',
                'codigo' => '8620.1',
                'descripcion' => 'Actividades de médicos',
            ],
            [
                'actividad' => 'PSIQUIATRIA',
                'codigo' => '8620.1',
                'descripcion' => 'Actividades de médicos',
            ],
            [
                'actividad' => 'CIRUJANO PLASTICO.',
                'codigo' => '8620.1',
                'descripcion' => 'Actividades de médicos',
            ],
            [
                'actividad' => 'FUNDACIONES DE SERVICIO SOCIAL CON ALOJAMIENTO',
                'codigo' => '8790.0',
                'descripcion' => 'Otras actividades de atención en instituciones n.c.p',
            ],
            [
                'actividad' => 'SERVICIOS SOCIALES CON ALOJAMIENTO PARA ADULTOS',
                'codigo' => '8790.0',
                'descripcion' => 'Otras actividades de atención en instituciones n.c.p',
            ],
            [
                'actividad' => 'SERVICIOS DE RESTAURACION DE OBRAS DE ARTE',
                'codigo' => '9000.0',
                'descripcion' => 'Actividades creativas, artísticas y de entretenimiento',
            ],
            [
                'actividad' => 'CORRESPONSAL DE RADIO, TELEVISION Y PRENSA ESCRITA',
                'codigo' => '9000.0',
                'descripcion' => 'Actividades creativas, artísticas y de entretenimiento',
            ],
            [
                'actividad' => 'TEATROS (EXPLOTACION)',
                'codigo' => '9000.0',
                'descripcion' => 'Actividades creativas, artísticas y de entretenimiento',
            ],
            [
                'actividad' => 'ACTIVIDADES MUSICALES Y ARTISTICAS (SERVICIOS)',
                'codigo' => '9000.0',
                'descripcion' => 'Actividades creativas, artísticas y de entretenimiento',
            ],
            [
                'actividad' => 'PERIODISTA POR CUENTA PROPIA',
                'codigo' => '9000.0',
                'descripcion' => 'Actividades creativas, artísticas y de entretenimiento',
            ],
            [
                'actividad' => 'ESPECTACULOS PUBLICOS EN GENERAL EXCEPTO LOS DEPORTIVOS Y EL TEATRO',
                'codigo' => '9000.0',
                'descripcion' => 'Actividades creativas, artísticas y de entretenimiento',
            ],
            [
                'actividad' => 'EXPLOTACION DE CASINOS (INCLUYE MESAS DE JUEGOS Y MAQUINAS TRAGAMONEDAS)',
                'codigo' => '9200.0',
                'descripcion' => 'Actividades de juego de azar y apuestas',
            ],
            [
                'actividad' => 'VENTA DE LOTERIA EN AGENCIAS O AL DETALLE',
                'codigo' => '9200.0',
                'descripcion' => 'Actividades de juego de azar y apuestas',
            ],
            [
                'actividad' => 'SERVICIO DE ENLACE DE LLAMADAS Y CASAS DE APUESTAS ELECTRONICAS (SPORTBOOKS)',
                'codigo' => '9200.0',
                'descripcion' => 'Actividades de juego de azar y apuestas',
            ],
            [
                'actividad' => 'EXPLOTACION DE JUEGOS DE AZAR NO ELECTRONICOS (INCLUYE MAQUINAS TRAGAMONEDAS REALIZADAS EN LUGARES DIFERENTES A
        CASINOS.)',
                'codigo' => '9200.0',
                'descripcion' => 'Actividades de juego de azar y apuestas',
            ],
            [
                'actividad' => 'JUNTAS DE EDUCACION, COMEDORES ESCOLARES, PATRONATOS, COOPERATIVAS ESCOLARES, COLEGIALES, VOCACIONALES',
                'codigo' => '9499.0',
                'descripcion' => 'Actividades de otras asociaciones n.c.p',
            ],
            [
                'actividad' => 'ASOCIACION DE DESARROLLO COMUNAL Y/O SERVICIOS COMUNITARIOS',
                'codigo' => '9499.0',
                'descripcion' => 'Actividades de otras asociaciones n.c.p',
            ],
            [
                'actividad' => 'ASOCIACIONES DE CLUBES SOCIALES',
                'codigo' => '9499.0',
                'descripcion' => 'Actividades de otras asociaciones n.c.p',
            ],
            [
                'actividad' => 'ASOCIACIONES O ENTIDADES CON FINES CULTURALES, SOCIALES, RECREATIVOS, ARTESANALES',
                'codigo' => '9499.0',
                'descripcion' => 'Actividades de otras asociaciones n.c.p',
            ],
            [
                'actividad' => 'ASOCIACIONES DECLARADAS DE UTILIDAD PUBLICA POR EL PODER EJECUTIVO',
                'codigo' => '9499.0',
                'descripcion' => 'Actividades de otras asociaciones n.c.p',
            ],
            [
                'actividad' => 'SERVICIOS FUNEBRES Y ACTIVIDADES CONEXAS',
                'codigo' => '9603.0',
                'descripcion' => 'Funerales y actividades conexas',
            ],
            [
                'actividad' => 'CEMENTERIO O CAMPOSANTO PRIVADO',
                'codigo' => '9603.0',
                'descripcion' => 'Funerales y actividades conexas',
            ],
            [
                'actividad' => 'CEMENTERIO PUBLICO (JUNTA ADMINISTRADORA)',
                'codigo' => '9603.0',
                'descripcion' => 'Funerales y actividades conexas',
            ],
            [
                'actividad' => 'ACTIVIDADES PREOPERATIVAS O DE ORGANIZACIÓN',
                'codigo' => '0.1',
                'descripcion' => 'Preoperativa',
            ],
            [
                'actividad' => 'SERVICIOS DIGITALES O DE TELECOMUNICACIONES E INTANGIBLES PRESTADOS DESDE EL EXTERIOR PRESTADOS POR PROVEEDORES',
                'codigo' => '0.2',
                'descripcion' => 'Servicios digitales o de telecomunicaciones e intangibles prestados desde el exterior por proveedores',
            ],
            [
                'actividad' => '',
                'codigo' => '0.3',
                'descripcion' => 'Servicios digitales o de telecomunicaciones e intangibles prestados desde el exterior por intermediarios',
            ]
        ]);
    }
}
