<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página oficial de la Alcaldía de Santa Marta. Tramites, servicios y atención al ciudadano.">

    <title>@yield('title', 'Alcaldia de Santa Marta')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header>
        @yield('header')
        <!-- Logo de gov.co -->
        <ul class="nav justify-content-center" style="background-color: #3366CC">
            <li class="nav-item">
                <a href="https://www.gov.co"><img src="https://www.gov.co/uploads/53cb9900-1f6d-4d95-81a1-02e02efbe3be.svg"
                        style="width: auto; height: 30px; object-fit: cover; display: block; margin: 0 auto;"
                        alt="Imagen optimizada"></a>

            </li>

        </ul>
        <!-- fin de gov.co -->

        <!-- Section de logos -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100">
                    <div class="row w-100">
                        <div class="col-md-8 col-lg-8 d-flex justify-content-start">
                            <li class="list-group-item">
                                <img src="{{ asset('storage/images/logo500Or.png') }}" style="width: 200px;" class="d-block mx-auto img-fluid" alt="Logo 500 Años">
                            </li>
                            <li class="list-group-item">
                                <img src="https://www.santamarta.gov.co/sites/default/files/styles/medium/public/earth.gif" style="width: 137px; background-color: #3366CC;" class="d-block mx-auto img-fluid" alt="Catastros">
                            </li>
                        </div>
                        <div class="col-md-8 col-lg-4 d-flex justify-content-between">
                            <li class="list-group-item">
                                <div class="d-flex justify-content-center text-danger">
                                    <div class="p-2">
                                        <a href="https://www.youtube.com/@SantaMartaDTCH">
                                            <span class="govco-link-modal">
                                                <img src="{{ asset('storage/images/icon/youtube.png') }}" style="width: 30px;" class="d-block mx-auto img-fluid" alt="Redes sociales Youtube">
                                            </span>
                                        </a>
                                    </div>
                                    <div class="p-2">
                                        <a href="https://x.com/SantaMartaDTCH">
                                            <span class="govco-link-modal">
                                                <img src="{{ asset('storage/images/icon/x.png') }}" style="width: 30px;" class="d-block mx-auto img-fluid" alt="Redes sociales X">
                                            </span>
                                        </a>
                                    </div>
                                    <div class="p-2">
                                        <a href="https://www.facebook.com/SantaMartaDTCH">
                                            <span class="govco-link-modal">
                                                <img src="{{ asset('storage/images/icon/facebook.png') }}" style="width: 30px;" class="d-block mx-auto img-fluid" alt="Redes sociales Facebook">
                                            </span>
                                        </a>
                                    </div>
                                    <div class="p-2">
                                        <a href="https://www.facebook.com/SantaMartaDTCH">
                                            <span class="govco-link-modal">
                                                <img src="{{ asset('storage/images/icon/instagram.png') }}" style="width: 30px;" class="d-block mx-auto img-fluid" alt="Redes sociales Instagram">
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </div>
                    </div>
                </ul>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Aquí puedes agregar más elementos del navbar si es necesario -->
                </div>
            </div>
        </nav>
        <!-- fin de logos -->

        <nav class="navbar navbar-expand-lg navbar-primary " style="color:white; ">
            <div class="container-fluid">
                <a class="navbar-brand text-light" href="#"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Santa Marta
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item text-light" href="#">Action</a></li>
                                <li><a class="dropdown-item text-light" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-light" href="#">Something else here</a></li>
                            </ul>
                        </li>
                        <li class="listing-dropdown">
                            <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Publicaciones
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item text-light" href="#">Action</a></li>
                                <li><a class="dropdown-item text-light" href="#">Another action</a></li>
                                <li><a class="dropdown-item text-light" href="#">Something else here</a></li>
                            </ul>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-light" aria-current="page" href="#">Tramites y
                                servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="#">Atencion al ciudadano</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="#">Alcaldia</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">Buscar</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>



    <main>
        @yield('content')
    </main>
    <footer>
        @yield('footer')
        <div class="govco-footer">
            <div class="govco-data-front">

                <div class="govco-footer-text">
                    <div class="row govco-nombre-entidad">
                        <div class="col-xs-12 col-lg-6">
                            <p class="govco-text-header-1">Alcaldia Distrital de Santa Marta</p>
                        </div>
                        <div class="col-xs-12 col-lg-5 govco-logo-div-a">
                            <span class="govco-logo-entidad">
                                <img src="{{ asset('storage/images/logo500Or.png') }}" style="width: 250px;"
                                    class="d-block mx-auto img-fluid" alt="Logo 500 Años">
                            </span>
                        </div>


                    </div>

                    <div class="row col-xs-12 col-lg-7 govco-texto-sedes">
                        <p class="govco-text-header-2">Sede principal</p>
                        Dirección: Calle 14 # 2-29
                        Palacio Municipal <br class="govco-mostrar">
                        Magdalena Santa Marta. <br>
                        Código Postal: 470004 <br>
                        Horario de atención: Lunes a Viernes 08:00 a.m. a 12:00 p.m. - 02:00 pm a 06:00 pm <br>
                        Teléfono conmutador: 605 4209600 ext 1212 <br>

                        Línea anticorrupción: 605 4209600 ext 1212 <br>
                        Correo institucional: <br class="govco-mostrar">
                        atencionalciudadano@santamarta.gov.co <br>
                        Correo de notificaciones judiciales: <br class="govco-mostrar">
                        notificacionesalcaldiadistrital@santamarta.gov.co
                    </div>

                    <div class="row col-xs-12 col-lg-7 govco-network">
                        <div class="govco-iconContainer">
                            <a href="https://x.com/SantaMartaDTCH">
                                <span class="govco-link-modal"><img src="{{ asset('storage/images/icon/x.png') }}" style="width: 30px;"
                                        class="d-block mx-auto img-fluid" alt="Redes sociales X"></span></a>
                        </div>
                        <div class="govco-iconContainer">
                            <a href="https://www.instagram.com/SantaMartaDTCH/">
                                <span class="govco-link-modal">
                                    <img src="{{ asset('storage/images/icon/instagram.png') }}" style="width: 30px;"
                                        class="d-block mx-auto img-fluid" alt="Redes sociales Instagram">
                                </span>
                            </a>
                        </div>
                        <div class="govco-iconContainer">
                            <a href="https://www.facebook.com/SantaMartaDTCH">
                                <span class="govco-link-modal"><img src="{{ asset('storage/images/icon/facebook.png') }}" style="width: 30px;"
                                        class="d-block mx-auto img-fluid" alt="Redes sociales Instagram"></span>
                            </a>
                        </div>

                        <div class="govco-iconContainer">
                            <a href="https://www.youtube.com/@SantaMartaDTCH">
                                <span class="govco-link-modal"><img src="{{ asset('storage/images/icon/youtube.png') }}" style="width: 30px;"
                                        class="d-block mx-auto img-fluid" alt="Redes sociales Youtube"></span>
                            </a>
                        </div>
                    </div>

                    <div class="govco-listado-sedes">
                        <div class="row govco-sedes">

                        </div>

                        <div class="row govco-sedes">

                        </div>

                        <div class="row govco-sedes">

                        </div>
                    </div>

                    <div class="row govco-links-container">
                        <div class="govco-link-container mt-2">
                            <a class="govco-link-modal govco-link-modal-bold" href="#">Políticas</a>
                            <a class="govco-link-modal govco-link-modal-bold" href="#">Mapa del sitio</a>
                        </div>
                        <div class="govco-link-container mt-2">
                            <a class="govco-link-modal govco-link-modal-bold" href="#">Términos y condiciones</a> <br>
                        </div>
                        <div class="govco-link-container mt-2">
                            <a class="govco-link-modal govco-link-modal-bold" href="#">Accesibilidad</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="govco-footer-logo">
                <div class="govco-logo-container">
                    <span class="govco-co"></span>
                    <span class="govco-separator"></span>
                    <span class="govco-logo"></span>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
