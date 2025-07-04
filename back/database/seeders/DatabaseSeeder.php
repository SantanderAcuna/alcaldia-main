<?php

namespace Database\Seeders;

use App\Models\Alcalde;
use App\Models\Area;
use App\Models\AsignacionFuncionario;
use App\Models\AsignacionOrganizacional;
use App\Models\Categoria;
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
use App\Models\ProcedimientoMacroProceso;
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

        ini_set('memory_limit', '5120M');

        DB::connection()->disableQueryLog();


        Alcalde::create([
            'nombre_completo' => 'Carlos Pinedo Cuello',
            'presentacion' => 'Carlos Pinedo Cuello',
            'sexo' => 'Masculino',
            'fecha_inicio' => now(),
            'fecha_fin' => now(),
            'foto_path' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png',
            'actual' => 1,

        ]);
        Alcalde::create([
            'nombre_completo' => 'Prueba',
            'presentacion' => 'Prueba',
            'sexo' => 'Femenino',
            'fecha_inicio' => now(),
            'fecha_fin' => now(),
            'foto_path' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png',
            'actual' => 0,

        ]);


        PlanDeDesarrollo::create([
            'titulo' => 'Carlos Pinedo Cuello',
            'descripcion' => 'Carlos Pinedo Cuello',
            'document_path' => 'planes/documentos/l1iq0kOKnoqESEGkGf6OBID3l36H9HouzjILrSeR.pdf',
            'alcalde_id' => 1,
        ]);

        PlanDeDesarrollo::create([
            'titulo' => 'Prueba 2',
            'descripcion' => 'Prueba 2',
            'document_path' => 'planes/documentos/l1iq0kOKnoqESEGkGf6OBID3l36H9HouzjILrSeR.pdf',
            'alcalde_id' => 2,
        ]);


        $secretaria1 =  Secretaria::create([
            'nombre' => 'Secretaria Tic',
            'mision' => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',
            'vision' => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',
            'organigrama' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png',
        ]);

        $secretaria2 =   Secretaria::create([
            'nombre' => 'Secretaria Hacienda',
            'mision' => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',
            'vision' => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',
            'organigrama' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png',
        ]);

        Funcion::create([
            'nombre' => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',
            'orden' => 1,
            'secretaria_id' => 1
        ]);

        Funcion::create([
            'nombre' => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',
            'orden' => 2,
            'secretaria_id' => 1
        ]);
        Funcion::create([
            'nombre' => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',
            'orden' => 1,
            'secretaria_id' => 2
        ]);
        Funcion::create([
            'nombre' => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',
            'orden' => 2,
            'secretaria_id' => 2
        ]);

        $perfil1 =  Perfil::create([
            'titulo_profesional' => 'Prueba 1',
            'especializacion' => 'Prueba 1',
            'experiencia' => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',

        ]);
        $perfil2 =  Perfil::create([
            'titulo_profesional' => 'Prueba 2',
            'especializacion' => 'Prueba 2',
            'experiencia' => 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.',

        ]);


        $funcionario1 =  Funcionarios::create([
            'nombres' => 'Pepita',
            'apellidos' => 'Peralta',
            'cargo' => 'Secretario',
            'genero' => 'F',
            'foto' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png',
            'correo' => 'correo1@gmail.com',
            'linkendin' => '@linkendin1',
            'fecha_ingreso' => now(),
            'secretaria_id' => 1,
            'perfil_id' => 1,
            'estado' => 'activo',
        ]);

        $funcionario2 =   Funcionarios::create([
            'nombres' => 'Pepe',
            'apellidos' => 'Perez',
            'cargo' => 'Secretario',
            'genero' => 'M',
            'foto' => 'alcaldes/fotos/R3P7H4Wf3dz2NSIwDdNCahJ6Ra2FNgZ7At0KAvkY.png',
            'correo' => 'correo2@gmail.com',
            'linkendin' => '@linkendin2',
            'fecha_ingreso' => now(),
            'secretaria_id' => 2,
            'perfil_id' => 2,
            'estado' => 'activo',
        ]);


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

        $dep1 = Dependencia::create([
            'nombre' => 'Planeacion',
            'descripcion' => 'pertenece a secretaria ',
            'secretaria_id' => 1
        ]);
        $dep2 =   Dependencia::create([
            'nombre' => 'Catastro',
            'descripcion' => 'pertenece a secretaria ',
            'secretaria_id' => 2
        ]);
        $dep3 =    Dependencia::create([
            'nombre' => 'Rentas',
            'descripcion' => 'pertenece a secretaria ',
            'secretaria_id' => 1
        ]);
        $dep4 =  Dependencia::create([
            'nombre' => 'Movilidad',
            'descripcion' => 'pertenece a secretaria ',
            'secretaria_id' => 2
        ]);


        Tramite::create([
            'nombre' => 'Pagar Ipu',
            'descripcion' => 'Se puede realizar pago del impuesto o servicio que se requiere ',
            'secretaria_id' => 1,
            'dependencia_id' => 1
        ]);
        Tramite::create([
            'nombre' => 'Pagar Estanpilla',
            'descripcion' => 'Se puede realizar pago del impuesto o servicio que se requiere ',
            'secretaria_id' => 1,
            'dependencia_id' => 2
        ]);
        Tramite::create([
            'nombre' => 'Pagar transito',
            'descripcion' => 'Se puede realizar pago del impuesto o servicio que se requiere ',
            'secretaria_id' => 2,
            'dependencia_id' => 1
        ]);
        Tramite::create([
            'nombre' => 'Pagar Planeacionn',
            'descripcion' => 'Se puede realizar pago del impuesto o servicio que se requiere ',
            'secretaria_id' => 2,
            'dependencia_id' => 2
        ]);
        Tramite::create([
            'nombre' => 'Pagar Rentas',
            'descripcion' => 'Se puede realizar pago del impuesto o servicio que se requiere ',
            'secretaria_id' => 1,
            'dependencia_id' => 3
        ]);
        Tramite::create([
            'nombre' => 'Pagar Catastro',
            'descripcion' => 'Se puede realizar pago del impuesto o servicio que se requiere ',
            'secretaria_id' => 2,
            'dependencia_id' => 3
        ]);

        // Crear Asignaciones Organizacionales (polimórficas)
        AsignacionOrganizacional::create([
            'funcionario_id' => $funcionario1->id,
            'organizacion_id' => $secretaria1->id,
            'organizacion_type' => Secretaria::class,
        ]);

        AsignacionOrganizacional::create([
            'funcionario_id' => $funcionario2->id,
            'organizacion_id' => $dep2->id,
            'organizacion_type' => Dependencia::class,
        ]);

        AsignacionFuncionario::create([
            'funcionario_id' => $funcionario1->id,
            'secretaria_id' => $secretaria1->id ?? null,
            'dependencia_id' => $dep1->id ?? null,
            'perfil_id' => $perfil1->id,
            'fecha_asignacion' => now(),
            'observacion' => $funcionario1->nombres,
        ]);
        AsignacionFuncionario::create([
            'funcionario_id' => $funcionario2->id,
            'secretaria_id' => $secretaria2->id ?? null,
            'dependencia_id' => $dep2->id ?? null,
            'perfil_id' => $perfil2->id,
            'fecha_asignacion' => now(),
            'observacion' => $funcionario2->nombres,
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






          Artisan::call('auditoria:triggers');
    }
}
