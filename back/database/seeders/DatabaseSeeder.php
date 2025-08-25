<?php

namespace Database\Seeders;

use App\Models\Alcalde;
use App\Models\Area;
use App\Models\AsignacionFuncionario;
use App\Models\AsignacionOrganizacional;
use App\Models\Cargo;
use App\Models\Categoria;
use App\Models\Competencia;
use App\Models\Dependencia;
use App\Models\DirectorioDistrital;
use App\Models\Funcion;
use App\Models\Funcionarios;
use App\Models\FuncionMacroProceso;
use App\Models\Gabinete;
use App\Models\Galeria;
use App\Models\MacroProceso;
use App\Models\Perfil;
use App\Models\Permiso;
use App\Models\PlanDeDesarrollo;
use App\Models\PlanDocumentos;
use App\Models\ProcedimientoMacroProceso;
use App\Models\Proceso;
use App\Models\Publicacion;
use App\Models\Publicaciones;
use App\Models\Rol;
use App\Models\Secretaria;
use App\Models\Subdireccion;
use App\Models\Subdirecion;
use App\Models\Tag;
use App\Models\Tipo;
use App\Models\TipoEntidad;
use App\Models\TipoProcedimiento;
use App\Models\Tramite;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class DatabaseSeeder extends Seeder
{
    public function run()
    {

        // ini_set('memory_limit', '5120M');

        // DB::connection()->disableQueryLog();


        Alcalde::create([
            'nombre_completo' => 'Carlos Pinedo Cuello',
            'presentacion' => 'Soy un samario enamorado de mi tierra, en Santa Marta nací,
      y ahí he permanecido y espero seguir viviendo el resto de mi vida.
      Mi vocación de servicio me ha permitido trabajar y avanzar de manera ascendente con más de 18 años de experiencia, inicié mi servicio como inspector de policía, inspector de tránsito, y posterior a ello entendí que podía trabajar aún más por mi ciudad, tomando la decisión de postularme al Concejo Distrital, siendo electo en tres periodos consecutivos y obteniendo la mayor votación en la historia del Distrito.
      Actualmente, soy Alcalde de Santa Marta, unos de mis grandes sueños, desde donde deseo construir de la mano de todos una Santa Marta diferente, una ciudad de progreso y desarrollo, con oportunidades, una Santa Marta para todos. Esa es mi mayor motivación, quiero demostrarle a la ciudad y al país, que Santa Marta Sí Puede, tener agua y saneamiento básico, una educación de calidad, salud, empleo digno y formal, ser una ciudad inteligente en materia de seguridad y movilidad, entre otras muchas líneas para trabajar y potencializar.',
            'sexo' => 'Masculino',
            'fecha_inicio' => now(),
            'fecha_fin' => now(),
            'foto_path' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png',
            'actual' => 1,

        ]);
        Alcalde::create([
            'nombre_completo' => 'Virna Lizi Johnson Salcedo',
            'presentacion' => 'Virna Lizi Johnson Salcedo (Santa Marta, 15 de noviembre de 1970) es la actual alcaldesa del distrito de Santa Marta. Participó con éxito en las elecciones locales de Santa Marta de 2019 y el 27 de octubre de ese año se convirtió en la primera mujer en llegar a la Alcaldía Distrital por voto popular.
      Su deseo de estar preparada y cualificada para los retos que tuviera que afrontar, la motivó a especializarse en Gerencia Pública y también a terminar una Maestría en Administración. Cuenta con más de 20 años de experiencia en el sector público. Desde el año 1999 fue parte del proceso de refundación y transformación de la Universidad del Magdalena, liderado por Carlos Eduardo Caicedo Omar, a quien acompañó en la rectoría de la Universidad empezando como Asistente de Rectoría, hasta ser Vicerrectora Administrativa y Financiera, dignidades a las que llegó gracias a su capacidad gerencial y administrativa. También ocupó el cargo de Jefe de Cartera y Directora de Prácticas Profesionales, desde donde aportó para que miles de estudiantes financiaran su carrera, y los ayudó a perfilar y preparar para el escenario laboral.
      Virna ha sido militante del movimiento Fuerza Ciudadana desde su creación en el año 2007 y se ha mantenido con lealtad, compromiso y disciplina durante los últimos 12 años. A partir de 2012 y hasta 2018 fue parte crucial de la trasformación de Santa Marta al conformar el gabinete distrital de los gobiernos del Cambio, iniciado por el exalcalde Caicedo y continuado por el alcalde Martínez.
      En estos gobiernos ocupó los cargos de Gerente de la Empresa de Servicios Públicos de Aseo del Distrito (ESPA); Secretaria de Hacienda en el gobierno de Carlos Caicedo, desde la cual lideró el saneamiento de las finanzas del Distrito, sacando a Santa Marta de la Ley 550, y la liquidación de 16 entidades que llevaban 20 años desangrando las finanzas distritales.
      También fue Gerente del Sistema Estratégico de Transporte Público (SETP) en los gobiernos de Carlos Caicedo y de Rafael Martínez hasta el 2018, llevándose el reconocimiento del Banco Interamericano de Desarrollo, por ser el sistema de transporte que mejor ejecutó sus recursos y de manera más eficiente. Durante los cuatro años y siete meses que estuvo liderando los procesos del SETP, se realizaron intervenciones en las avenidas de El Libertador, la carrera 19, la avenida de El Río, los puentes de la carrera 19, la carrera quinta, la carrera cuarta, Carrera 5ta entre calle 22 y 29, la avenida Tamacá, vías principales en los barrios Líbano y Curinca, la construcción de dos tramos de la calle 30 (entre carreras 4 y 5 y carreras 12 - 13a), entre otras, consideradas vitales para la ciudad.
      Siendo gerente del SETP, asumió -de forma simultánea- la dirección de los XVIII Juegos Bolivarianos, cuyo reto enfrentó con total capacidad, logrando, de manera exitosa, la construcción de 12 nuevos escenarios deportivos que hoy simbolizan el mayor legado del cambio de la ciudad. Los Juegos Bolivarianos Santa Marta 2017 fueron considerados por la Organización Deportiva Bolivariana -ODEBO- como los mejores juegos de la historia.',
            'sexo' => 'Femenino',
            'fecha_inicio' => now(),
            'fecha_fin' => now(),
            'foto_path' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png',
            'actual' => 0,
            'actual' => 0,

        ]);
        Alcalde::create([
            'nombre_completo' => 'Rafael Alejandro Martínez',
            'presentacion' => 'Nació el 14 de mayo de 1974 en el municipio de Guamal, Magdalena. Ganó las elecciones a la Alcaldía de Santa Marta con 91.294 votos, el 51.81% del total. Su candidatura se hizo por medio de firmas, con el movimiento "Fuerza Ciudadana", que contaba con el apoyo de la Alianza Verde.
      Martínez estudió administración de empresas en la Universidad del Magdalena y administración pública territorial en la Escuela de Administración Pública –Esap-. Es especialista en administración de la Universidad Eafit y cursó una maestría en negocios internacionales y siete diplomados.
      Cuenta con más de 15 años de experiencia profesional, siete de ellos en el sector público. Ha desarrollado actividades de planeación académica, ejecución de proyectos de inversión, elaboración de presupuestos, procesos de contratación régimen público y privado.
      Antes de lograr ser la máxima autoridad de la ciudad de Santa Marta, acompañó los cuatro años del Gobierno de la Equidad tiempo en el que se desempeñó como director de la Unidad de Tránsito desde donde adelantó importantes procesos de transformación para mejorar la  calidad  de  vida  de  los  samarios, entre  ellos presentación  del proyecto  de reestructuración de las rutas de transportes existentes en la ciudad, la unificación de las empresas transportadoras que operan en Santa Marta, concertado con empresarios y propietarios.
      Fue secretario de Gobierno desde donde gestionó y promovió nueve (9) políticas públicas para beneficiar poblaciones específicas y en condición de vulnerabilidad. Acompañó la recuperación del espacio público.  Organizó los temas que contribuyeron a mejorar la percepción ciudadana frente a la seguridad y la convivencia. Siendo secretario de Gobierno Santa Marta se constituyó en 2014 como una de las ciudades más seguras del país.
      Además, se desempeñó como secretario de Educación y director del Departamento Administrativo Distrital del Medio Ambiente (Dadma), también laboró en la Universidad del Magdalena donde inició como dirigente estudiantil, coordinador académico y decano de la facultad de Ciencias Empresariales y Económicas. Después de trabajar en Unimagdalena se desempeñó durante tres años como jefe del Departamento de Servicios Generales de la Universidad del Atlántico, cargo al que llegó por concurso de méritos.
      Padre de Alejandro, Esteban e Isabella. Youtuber en su tiempo libre y deportista consumado.',
            'sexo' => 'Femenino',
            'fecha_inicio' => now(),
            'fecha_fin' => now(),
            'foto_path' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png',
            'actual' => 0,

        ]);

        Alcalde::create([
            'nombre_completo' => 'Carlos Eduardo Caicedo Omar',
            'presentacion' => 'Nacido en el Municipio de Aracataca, Magdalena el 03 de octubre de 1965, samario por adopción. Es abogado egresado de la Universidad Nacional de Colombia y magister en Dirección Universitaria de la Universidad de Los Andes. Formado en el sistema educativo público, desde el preescolar hasta su carrera profesional. Se graduó en el Liceo Celedón de Santa Marta, donde inició el liderazgo estudiantil que potenció en la Universidad Nacional desde donde participó como promotor del Movimiento Estudiantil por la Séptima Papeleta que impulsó la Asamblea Nacional Constituyente, a la que fue candidato en 1990. Entre 1993 y 1994 fue vocero Nacional de Paz entre el sector del ELN y el gobierno nacional.
      Se ha desempeñado como consejero para el desarrollo social, coordinador de la Oficina de Prevención y Atención de Desastres del Departamento del Magdalena; rector de la Universidad del Magdalena entre 1997 a 2006 y presidente de la Asociación Colombiana de Universidades (Ascun), 2002. Su gestión fue reconocida luego de que superara la crisis que amenazaba con cerrar definitivamente el único centro público de educación superior del Magdalena, al transformar la Universidad, que estaba entre las más ineficientes de la época en una de las mejores del país, como se lo reconoció el Ministerio de Educación en el año 2000. Logró superar un déficit de más de 30 mil millones y aumentó el presupuesto de seis mil a 40 mil millones; implementó becas, aumentó el número de estudiantes de dos mil a nueve mil y abrió 20 programas de pregrado.
      El éxito como rector de la Universidad del Magdalena, fue la carta de presentación para ser alcalde de la ciudad de Santa Marta (2012-2015), después de haber librado una dura batalla judicial que lo privó de la libertad durante cinco años injustamente, por blindar el presupuesto de esa casa der estudios de la injerencia de los políticos tradicionales del Magdalena.',
            'sexo' => 'Femenino',
            'fecha_inicio' => now(),
            'fecha_fin' => now(),
            'foto_path' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png',
            'actual' => 0,

        ]);


        PlanDeDesarrollo::create([
            'titulo' => 'PLAN DE DESARROLLO DISTRITAL',
            'descripcion' => 'Santa Marta será la primera ciudad del país y de Suramérica en cumplir 500 años de fundación. Será en el año 2025, durante la vigencia del presente Plan Distrital de Desarrollo y en la administración del alcalde Carlos Pinedo. La celebración del V centenario de su fundación es y será una gran oportunidad, como ya lo ha sido, para pensar y repensar el potencial, los desafíos y las oportunidades de la ciudad en el mundo de hoy; es la oportunidad de movilizar recursos, de concretar apuestas, de implementar planes y proyectos, pero, ante todo, de acordar colectivamente el devenir de la ciudad.
      El Plan de Desarrollo “Santa Marta 500+” le apuesta a avanzar en la solución de los principales habilitantes del desarrollo, como por ejemplo el acceso al agua y la seguridad, sin los cuales no habrá las condiciones para aprovechar todo el potencial que tiene la ciudad. Dicho potencial radica, ante todo, en su riqueza natural, base de sus activos y capital ecosistémico, así como fundamento, junto con su diversidad étnica y cultural,  de sus vocaciones productivas y su identidad. La identidad y sostenibilidad ambiental no son solo elementos transversales del actual Plan de Desarrollo; son la base sobre la que se fundamenta y construye el contenido programático y estratégico.',

            'alcalde_id' => 1,
        ]);

        PlanDeDesarrollo::create([
            'titulo' => 'PLAN DE DESARROLLO DISTRITAL',
            'descripcion' => 'El Plan de Desarrollo  "Santa Marta Corazón del Cambio"  está soportado en cuatro ejes estratégicos cuya base fundamental  es la continuidad  en las trasformaciones   que vienen  dándose  en la ciudad desde hace dos periodos  de gobierno.  En estos ocho  años  los logros  alcanzados  han  impactado positivamente  la calidad  de vida de los samarios, reforzando  sus derechos, generando  capacidades humanas para los más desfavorecidos,  pero también propiciando  mejores niveles de competitividad y desarrollo económico  al tiempo que cuidamos  nuestro  medio ambiente  y modernizamos  nuestra forma de gobernar;  un gobierno  donde todos participan  porque desde  luego se hace cercano  a la gente y sus necesidades.
      Nuestro propósito  en este periodo de gobierno es justamente  ese,  seguir impulsando  el desarrollo social, económico  y ambiental  de nuestro amado Distrito.  Esta vez retomamos  el tesón y el empuje imprimido en el Gobierno  de Carlos Eduardo Caicedo  Ornar (2012-2015)  quien inicio los procesos de transformación  y cambio que hoy se reconocen  en muchas áreas como la salud,  la educación,  la validación  de los derechos  de la población,  la infraestructura  entre otros  muchos  para continuar con ese legado,  que se valoriza  mucho  más ahora cuando  desde la gobernación  podemos  contar con su ayuda. Por primera vez en la Historia los gobiernos  departamental  y distrital están alineados con el propósito de cada uno desde sus competencias  llevar mejores y mayores niveles de bienestar a la población,  impulsar  el desarrollo  económico  y gobernar  bien para cuidar el medio ambiente  y optimizar  cada peso  público.  Por eso  la gobernación  del Magdalena  será nuestro  aliado  en esta etapa de cuatro años para seguir cultivando  esos logros que la ciudad reclama y se merece.',

            'alcalde_id' => 2,
        ]);

        PlanDeDesarrollo::create([
            'titulo' => 'PLAN DE DESARROLLO DISTRITAL',
            'descripcion' => 'El Plan de Desarrollo 2016-2019 “Unidos por el cambio, Santa Marta Ciudad del Buen Vivir”, soportado en cinco ejes estratégicos que permitirán mejorar las condiciones de la ciudad y la calidad de vida de sus habitantes.
      En los cinco pilares que alimentaron el Plan de Desarrollo Distrital se encuentra el Plan de Desarrollo Nacional; el PDD del gobierno del exalcalde Carlos Eduardo Caicedo; el programa de gobierno que presentóel en ese entonces candidato y hoy alcalde Rafael Martínez; los objetivos de desarrollo sostenible y la participación con la comunidad donde se concertó con 43.335 personas que participaron en las jornadas de construcción del PDD.
      El alcalde Rafael Alejandro Martínez, con este Plan pretende, en cuatro años, entregarles a los samarios una ciudad de buen vivir, encaminada a convertirse en un territorio modelo en lo social, cultural, ambiental y económico.',

            'alcalde_id' => 3,
        ]);

        PlanDeDesarrollo::create([
            'titulo' => 'PLAN DE DESARROLLO DISTRITAL',
            'descripcion' => 'El Plan de Desarrollo 2012 – 2015 del exalcalde Carlos Caicedo, Equidad para Todos, Primero los Niños y las Niñas, parte de la identificación de unos rasgos problemáticos que caracterizan al territorio del Distrito.
      El Plan de Desarrollo avanzó en el mejoramiento de los niveles de equidad y desarrollo humano integral, reduciendo la pobreza, la exclusión social y la vulnerabilidad; elementos básicos que hicieron de Santa Marta una ciudad más sostenible, segura, competitiva y atractiva para el acceso con igualdad de oportunidades a los beneficios del desarrollo, con especial protección de niños, niñas y adolescentes.
      El Plan Distrital de Desarrollo fue estructurado alrededor de un eje transversal y cinco ejes estratégicos direccionados hacia el logro del objetivo central:
      Eje transversal Red Equidad
      Estrategia de intervención y gestión social, que articula esfuerzos del nivel nacional, regional y local, para restablecer los derechos de la ciudadanía samaria, con énfasis en la población en estado de pobreza y vulnerabilidad. Redequidad se desarrolla a través de diferentes líneas de acción de los cinco ejes del Plan y por lo tanto constituye una estrategia para orientar dichos acciones hacia el logro de los objetivos de este eje transversal.
      Eje 1: Santa Marta, Distrito Equitativo y Solidario
      Sus líneas y programas buscan disminuir las brechas que obstaculizan el acceso al bienestar social de los sectores de mayor pobreza. Sus acciones se encaminan hacia la equidad, la justicia social, el acceso a los derechos básicos a la vivienda, la educación y la salud; la erradicación del hambre y el analfabetismo, con enfoque diferencial y especial atención para niños y niñas.
      Eje 2: Santa Marta, Distrito con Calidad de Vida para Todos
      Busca lograr el acceso a infraestructuras, equipamientos y servicios ciudadanos de calidad, incluidas las Tecnologías de la Información y las Comunicaciones, el deporte, la cultura y la recreación, que potencien las capacidades, oportunidades y libertades.
      Eje 3: Santa Marta, Distrito Competitivo con Más Oportunidades
      Se orienta a aprovechar las ventajas y potencialidades naturales, históricas y culturales y remover los obstáculos a la competitividad, fomentar el espíritu emprendedor, redistribuir equitativamente la riqueza e impulsar el acceso al trabajo.
      Eje 4: Santa Marta, Distrito Sostenible
      El propósito de este eje es formular y adoptar instrumentos de planificación y la ejecución de proyectos urbanos que garanticen la sostenibilidad del territorio, el aumento de la capacidad de respuesta ante los riesgos y la recuperación de la dimensión ambiental del desarrollo.
      Eje 5: Santa Marta, Distrito Gobernable, Participativo y Seguro
      El compromiso del Gobierno Distrital es ejercer un liderazgo que garantice la seguridad y convivencia y promueva la participación y cultura ciudadana, la defensa del interés colectivo, el respeto de los dineros públicos y la descentralización, y que incentiva una adecuada cooperación público-privada.',




            'alcalde_id' => 4,
        ]);

        $planDesarrollo = PlanDeDesarrollo::find(1);
        $planDesarrollo->documentos()->createMany([



            [
                'nombre' => 'Plan Estratégico 2020-2024.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],
            [
                'nombre' => 'Anexo Técnico.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],
            [
                'nombre' => 'Presupuesto Ejecutivo.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],
            [
                'nombre' => 'Resumen Ejecutivo.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],

        ]);

        $planDesarrollo = PlanDeDesarrollo::find(2);
        $planDesarrollo->documentos()->createMany([



            [
                'nombre' => 'Plan Estratégico 2020-2024.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],
            [
                'nombre' => 'Anexo Técnico.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],
            [
                'nombre' => 'Presupuesto Ejecutivo.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],
            [
                'nombre' => 'Resumen Ejecutivo.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],

        ]);

        $planDesarrollo = PlanDeDesarrollo::find(3);
        $planDesarrollo->documentos()->createMany([



            [
                'nombre' => 'Plan Estratégico 2020-2024.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],
            [
                'nombre' => 'Anexo Técnico.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],
            [
                'nombre' => 'Presupuesto Ejecutivo.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],
            [
                'nombre' => 'Resumen Ejecutivo.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],

        ]);

        $planDesarrollo = PlanDeDesarrollo::find(4);
        $planDesarrollo->documentos()->createMany([



            [
                'nombre' => 'Plan Estratégico 2020-2024.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],
            [
                'nombre' => 'Anexo Técnico.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],
            [
                'nombre' => 'Presupuesto Ejecutivo.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],
            [
                'nombre' => 'Resumen Ejecutivo.pdf',
                'path'   =>     "planes/documentos/aAQzcxqUdwzjdb7XEVdvyREdur2Rjklj66cUfm3x.pdf",
            ],

        ]);




        // 1. Perfiles (3)
        $perfil1 = Perfil::create([
            'titulo_profesional' => 'Ingeniero de Sistemas',
            'especializacion' => 'Desarrollo Web',
            'doctorado' => 'PhD en Ciencias Computacionales',
            'experiencia' => '10 años en desarrollo empresarial'
        ]);

        $perfil2 = Perfil::create([
            'titulo_profesional' => 'Economista',
            'especializacion' => 'Finanzas Públicas',
            'doctorado' => null,
            'experiencia' => '8 años en gestión presupuestaria'
        ]);

        $perfil3 = Perfil::create([
            'titulo_profesional' => 'Abogado',
            'especializacion' => 'Derecho Administrativo',
            'doctorado' => 'PhD en Derecho Público',
            'experiencia' => '12 años en asesoría gubernamental'
        ]);

        // 2. Dependencias (3)
        $secretariaTic = Dependencia::create([
            'nombre' => 'Secretaría TIC',
            'codigo' => 'STIC',
            'descripcion' => 'Gestión de tecnologías de información',
            'tipo' => 'SECRETARIA',
            'mision' => 'Impulsar la transformación digital',
            'vision' => 'Ser referente nacional en gobierno digital',
            'dependencia_padre_id' => null,
            'organigrama' => null
        ]);

        $fotomultas = Dependencia::create([
            'nombre' => 'División Fotomultas',
            'codigo' => 'DFM',
            'descripcion' => 'Gestión de sistema de fotodetección',
            'tipo' => 'SUB_DEPENDENCIA',
            'mision' => 'Controlar infracciones de tránsito',
            'vision' => 'Reducir accidentes viales en 40%',
            'dependencia_padre_id' => $secretariaTic->id,
            'organigrama' => null
        ]);

        $desarrolloApp = Dependencia::create([
            'nombre' => 'Desarrollo de Aplicaciones',
            'codigo' => 'DAPP',
            'descripcion' => 'Creación de software institucional',
            'tipo' => 'SUB_DEPENDENCIA',
            'mision' => 'Desarrollar soluciones tecnológicas',
            'vision' => 'Ser el área líder en innovación',
            'dependencia_padre_id' => $secretariaTic->id,
            'organigrama' => null
        ]);

        // 3. Cargos (3)
        $secretario = Cargo::create([
            'cargo' => 'Secretario',
            'descripcion' => 'Máximo responsable de la entidad',
            'nivel' => 'DIRECTIVO',
            'grado' => '1'
        ]);

        $coordinador = Cargo::create([
            'cargo' => 'Coordinador Técnico',
            'descripcion' => 'Responsable de área operativa',
            'nivel' => 'JEFATURA',
            'grado' => '2'
        ]);

        $analista = Cargo::create([
            'cargo' => 'Analista Senior',
            'descripcion' => 'Especialista en desarrollo',
            'nivel' => 'OPERATIVO',
            'grado' => '3',
        ]);

        // 4. Funcionarios (3)
        $funcionario1 = Funcionarios::create([
            'nombres' => 'María',
            'apellidos' => 'Gómez Pérez',
            'genero' => 'F',
            'foto' => 'funcionarios/maria-perez.jpg',
            'correo' => 'maria.gomez@stic.gov.co',
            'linkedin' => 'linkedin.com/in/mariagomez',
            'departamento' => 'Antioquia',
            'municipio' => 'Medellín',
            'fecha_nacimiento' => '1985-05-15',
            'dependencia_id' => $secretariaTic->id,
            'cargo_id' => $secretario->id,
            'perfil_id' => $perfil1->id,
            'estado' => 'Activo'
        ]);

        $funcionario2 = Funcionarios::create([
            'nombres' => 'Carlos',
            'apellidos' => 'Ruiz López',
            'genero' => 'M',
            'foto' => 'funcionarios/carlos-ruiz.jpg',
            'correo' => 'carlos.ruiz@stic.gov.co',
            'linkedin' => 'linkedin.com/in/carlosruiz',
            'departamento' => 'Cundinamarca',
            'municipio' => 'Bogotá',
            'fecha_nacimiento' => '1990-11-22',
            'dependencia_id' => $fotomultas->id,
            'cargo_id' => $coordinador->id,
            'perfil_id' => $perfil1->id,
            'estado' => 'Activo'
        ]);

        $funcionario3 = Funcionarios::create([
            'nombres' => 'Ana',
            'apellidos' => 'Rodríguez Vargas',
            'genero' => 'F',
            'foto' => 'funcionarios/ana-rodriguez.jpg',
            'correo' => 'ana.rodriguez@stic.gov.co',
            'linkedin' => 'linkedin.com/in/ana-rodriguez',
            'departamento' => 'Valle del Cauca',
            'municipio' => 'Cali',
            'fecha_nacimiento' => '1988-07-30',
            'dependencia_id' => $desarrolloApp->id,
            'cargo_id' => $analista->id,
            'perfil_id' => $perfil1->id,
            'estado' => 'Activo'
        ]);

        // 5. Competencias (3)
        Competencia::create([
            'competencia' => 'Desarrollo de aplicaciones móviles',
            'orden' => 1,
            'dependencia_id' => $secretariaTic->id
        ]);

        Competencia::create([
            'competencia' => 'Gestión de infracciones digitales',
            'orden' => 2,
            'dependencia_id' => $fotomultas->id
        ]);

        Competencia::create([
            'competencia' => 'Desarrollo de APIs REST',
            'orden' => 3,
            'dependencia_id' => $desarrolloApp->id
        ]);

        // 6. Trámites (3)
        Tramite::create([
            'tramite' => 'Apelación de fotomulta',
            'codigo' => 'TRAM-FM01',
            'descripcion' => 'Proceso para apelar multas por fotodetección',
            'dependencia_id' => $fotomultas->id
        ]);

        Tramite::create([
            'tramite' => 'Solicitud de certificado digital',
            'codigo' => 'TRAM-CD01',
            'descripcion' => 'Obtención de certificado de firma digital',
            'dependencia_id' => $secretariaTic->id
        ]);

        Tramite::create([
            'tramite' => 'Reporte de fallas técnicas',
            'codigo' => 'TRAM-FT01',
            'descripcion' => 'Reporte de problemas en sistemas institucionales',
            'dependencia_id' => $desarrolloApp->id
        ]);

        // 7. Macroprocesos (3)
        $macroprocesoTic = Macroproceso::create([
            'macrop' => 'Gestión Tecnológica',
            'codigo' => 'MP-TIC01',
            'descripcion' => 'Procesos relacionados con TI',
            'dependencia_id' => $secretariaTic->id
        ]);

        $macroprocesoFotomultas = Macroproceso::create([
            'macrop' => 'Control de Infracciones',
            'codigo' => 'MP-FM01',
            'descripcion' => 'Procesamiento de fotomultas',
            'dependencia_id' => $fotomultas->id
        ]);

        $macroprocesoDesarrollo = Macroproceso::create([
            'macrop' => 'Desarrollo de Software',
            'codigo' => 'MP-DS01',
            'descripcion' => 'Ciclo de vida de desarrollo',
            'dependencia_id' => $desarrolloApp->id
        ]);

        // 8. Procesos (3)
        Proceso::create([
            'proceso' => 'Procesamiento de Infracciones',
            'codigo' => 'PROC-FM01',
            'descripcion' => 'Validación y procesamiento de fotomultas',
            'macroproceso_id' => $macroprocesoFotomultas->id
        ]);

        Proceso::create([
            'proceso' => 'Desarrollo Frontend',
            'codigo' => 'PROC-FE01',
            'descripcion' => 'Creación de interfaces de usuario',
            'macroproceso_id' => $macroprocesoDesarrollo->id
        ]);

        Proceso::create([
            'proceso' => 'Soporte Técnico',
            'codigo' => 'PROC-ST01',
            'descripcion' => 'Atención a usuarios finales',
            'macroproceso_id' => $macroprocesoTic->id
        ]);

        // 9. Asignaciones (3)
        AsignacionFuncionario::create([
            'funcionario_id' => $funcionario1->id,
            'dependencia_id' => $secretariaTic->id,
            'cargo_id' => $secretario->id,
            'fecha_inicio' => now()->subYear(),
            'observacion' => 'Titular de la secretaría'
        ]);

        AsignacionFuncionario::create([
            'funcionario_id' => $funcionario2->id,
            'dependencia_id' => $fotomultas->id,
            'cargo_id' => $coordinador->id,
            'fecha_inicio' => now()->subMonths(6),
            'observacion' => 'Responsable técnico del sistema'
        ]);

        AsignacionFuncionario::create([
            'funcionario_id' => $funcionario3->id,
            'dependencia_id' => $desarrolloApp->id,
            'cargo_id' => $analista->id,
            'fecha_inicio' => now()->subMonths(3),
            'observacion' => 'Desarrolladora principal'
        ]);
    }
}

Tag::create([
    'nombre' => 'Educacion',
]);
Tag::create([
    'nombre' => 'Salud',
]);
Tag::create([
    'nombre' => 'Tecnologia',
]);
Tag::create([
    'nombre' => 'Hacienda',
]);
Tag::create([
    'nombre' => 'Catastro',
]);
Tag::create([
    'nombre' => 'Rentas',
]);

Tipo::create([
    'nombre' => 'Infografía',
]);

Tipo::create([
    'nombre' => 'Reseña',
]);

Tipo::create([
    'nombre' => 'Boletín',
]);

Tipo::create([
    'nombre' => 'Noticia',
]);

Tipo::create([
    'nombre' => 'Blog',
]);

Tipo::create([
    'nombre' => 'Artículo',
]);



$pub = Publicacion::create([
    'titulo'      => 'Lanzamiento de la nueva app',
    'descripcion' => 'Resumen breve de la noticia',
    'cuerpo'      => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',
    'tag_id' => 1,
    'tipo_id' => 1
]);
$pub2 = Publicacion::create([
    'titulo'      => 'Tecnologia',
    'descripcion' => 'Resumen breve de la noticia',
    'cuerpo'      => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',
    'tag_id' => 2,
    'tipo_id' => 2
]);
$pub3 = Publicacion::create([
    'titulo'      => 'Alcalde Pinedo',
    'descripcion' => 'Resumen breve de la noticia',
    'cuerpo'      => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',
    'tag_id' => 3,
    'tipo_id' => 3
]);
$pub4 = Publicacion::create([
    'titulo'      => 'Mas obras en la ciudad',
    'descripcion' => 'Resumen breve de la noticia',
    'cuerpo'      => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',
    'tag_id' => 4,
    'tipo_id' => 4
]);
$pub5 = Publicacion::create([
    'titulo'      => 'Santa marta y sus barrios',
    'descripcion' => 'Resumen breve de la noticia',
    'cuerpo'      => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',
    'tag_id' => 5,
    'tipo_id' => 5
]);
$pub6 = Publicacion::create([
    'titulo'      => 'El rodadero en santa marta',
    'descripcion' => 'Resumen breve de la noticia',
    'cuerpo'      => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',
    'tag_id' => 6,
    'tipo_id' => 6
]);

// Fotos
$pub->fotos()->createMany([
    ['ruta' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png', 'alt' => $pub->titulo, 'orden' => 1],
    ['ruta' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png', 'alt' => $pub->titulo, 'orden' => 2],
]);

// Documentos
$pub->documentos()->createMany([
    [

        'ruta' => 'planes/documentos/l1iq0kOKnoqESEGkGf6OBID3l36H9HouzjILrSeR.pdf',
        'titulo' => $pub->titulo,
        'descripcion' => $pub->titulo
    ],
    [

        'ruta' => 'planes/documentos/l1iq0kOKnoqESEGkGf6OBID3l36H9HouzjILrSeR.pdf',
        'titulo' => $pub->titulo,
        'descripcion' => $pub->titulo
    ],
]);
// Fotos
$pub2->fotos()->createMany([

    ['publicacion_id' => 2, 'ruta' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png', 'alt' => $pub2->titulo, 'orden' => 1],
    ['publicacion_id' => 2, 'ruta' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png', 'alt' => $pub2->titulo, 'orden' => 2],
]);

// Documentos
$pub2->documentos()->createMany([
    [

        'ruta' => 'planes/documentos/l1iq0kOKnoqESEGkGf6OBID3l36H9HouzjILrSeR.pdf',
        'titulo' => $pub2->titulo,
        'descripcion' => $pub2->titulo
    ],
    [

        'ruta' => 'planes/documentos/l1iq0kOKnoqESEGkGf6OBID3l36H9HouzjILrSeR.pdf',
        'titulo' => $pub2->titulo,
        'descripcion' => $pub2->titulo
    ],
]);


// Fotos
$pub3->fotos()->createMany([
    ['ruta' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png', 'alt' => $pub3->titulo, 'orden' => 1],
    ['ruta' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png', 'alt' => $pub3->titulo, 'orden' => 2],
]);

// Documentos
$pub3->documentos()->createMany([
    [

        'ruta' => 'planes/documentos/l1iq0kOKnoqESEGkGf6OBID3l36H9HouzjILrSeR.pdf',
        'titulo' => $pub3->titulo,
        'descripcion' => $pub3->titulo
    ],
    [

        'ruta' => 'planes/documentos/l1iq0kOKnoqESEGkGf6OBID3l36H9HouzjILrSeR.pdf',
        'titulo' => $pub3->titulo,
        'descripcion' => $pub3->titulo
    ],
]);
// Fotos
$pub4->fotos()->createMany([
    ['ruta' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png', 'alt' => $pub4->titulo, 'orden' => 1],
    ['ruta' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png', 'alt' => $pub4->titulo, 'orden' => 2],
]);

// Documentos
$pub4->documentos()->createMany([
    [

        'ruta' => 'planes/documentos/l1iq0kOKnoqESEGkGf6OBID3l36H9HouzjILrSeR.pdf',
        'titulo' => $pub4->titulo,
        'descripcion' => $pub4->titulo
    ],
    [

        'ruta' => 'planes/documentos/l1iq0kOKnoqESEGkGf6OBID3l36H9HouzjILrSeR.pdf',
        'titulo' => $pub4->titulo,
        'descripcion' => $pub4->titulo
    ],
]);


// Fotos
$pub5->fotos()->createMany([
    ['ruta' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png', 'alt' => $pub5->titulo, 'orden' => 1],
    ['ruta' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png', 'alt' => $pub5->titulo, 'orden' => 2],
]);

// Documentos
$pub5->documentos()->createMany([
    [
        'ruta' => 'planes/documentos/l1iq0kOKnoqESEGkGf6OBID3l36H9HouzjILrSeR.pdf',
        'titulo' => $pub5->titulo,
        'descripcion' => $pub5->titulo
    ],
    [
        'ruta' => 'planes/documentos/l1iq0kOKnoqESEGkGf6OBID3l36H9HouzjILrSeR.pdf',
        'titulo' => $pub5->titulo,
        'descripcion' => $pub5->titulo
    ],
]);

// Fotos
$pub6->fotos()->createMany([
    ['ruta' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png', 'alt' => $pub6->titulo, 'orden' => 1],
    ['ruta' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png', 'alt' => $pub6->titulo, 'orden' => 2],
]);

// Documentos
$pub6->documentos()->createMany([
    [
        'ruta' => 'planes/documentos/l1iq0kOKnoqESEGkGf6OBID3l36H9HouzjILrSeR.pdf',
        'titulo' => $pub6->titulo,
        'descripcion' => $pub6->titulo
    ],
    [
        'ruta' => 'planes/documentos/l1iq0kOKnoqESEGkGf6OBID3l36H9HouzjILrSeR.pdf',
        'titulo' => $pub6->titulo,
        'descripcion' => $pub6->titulo
    ],
]);


$user = User::create([
    'name' => 'Jose Acuña Polo',
    'email' => 'santanderjose19@gmail.com',
    'password' => '85154239',
]);

$user = User::create([
    'name' => 'usuario',
    'email' => 'usuario@gmail.com',
    'password' => '123456789',
]);

$user = User::create([
    'name' => 'admin',
    'email' => 'admin@gmail.com',
    'password' => '123456789',
]);






        // Artisan::call('auditoria:triggers');
