import { createRouter, createWebHistory } from 'vue-router'

import Home from '@/views/HomeView.vue'



// Nuestra Alcaldía
import Gabinete from '@/modules/gabinete/GabineteList.vue'
//import Dependencias from '@/modules/dependencias/DependenciasList.vue'
//import CarlosPinedo from '@/modules/carlos-pinedo/CarlosPinedo.vue'
//import VirnaJohnson from '@/modules/virna-johnson/VirnaJohnson.vue'
//import RafaelMartinez from '@/modules/rafael-martinez/RafaelMartinez.vue'
//import CarlosCaicedo from '@/modules/carlos-caicedo/CarlosCaicedo.vue'
//import DirectorioDistrital from '@/modules/directorio-distrital/Directorio.vue'
//import AlcaldesAnteriores from '@/modules/alcaldes-anteriores/Alcaldes.vue'

// Nuestra Gestión
//import Cronograma from '@/modules/cronograma/Cronograma.vue'
//import Circular011 from '@/modules/circular-011/Circular011.vue'
//import ObrasCambio from '@/modules/obras-cambio/Obras.vue'
//import CentrosReferenciacion from '@/modules/centros-referenciacion/Centros.vue'
//import PlanSantaMarta500 from '@/modules/plan-500/Plan500.vue'
//import Gestion2020 from '@/modules/gestion-2020/Gestion.vue'
//import JuegosBolivarianos from '@/modules/juegos-bolivarianos/Juegos.vue'

// Programas y Proyectos
//import FeriasEquidad from '@/modules/ferias-equidad/Ferias.vue'
//import AdultoMayor from '@/modules/adulto-mayor/Adulto.vue'
//import MiCalle from '@/modules/mi-calle/MiCalle.vue'
//import PAE from '@/modules/pae/PAE.vue'
//import LegalizacionBarrios from '@/modules/legalizacion-barrios/Legalizacion.vue'
//import BancarizacionVivienda from '@/modules/bancarizacion/Bancarizacion.vue'
//import POT from '@/modules/pot/POT.vue'
//import RedEquidad from '@/modules/red-equidad/Red.vue'
//import BienestarAnimal from '@/modules/bienestar-animal/Bienestar.vue'
//import MovilizacionEducacion from '@/modules/movilizacion-educacion/Movilizacion.vue'

// Planes de Desarrollo
//import PDD2012 from '@/modules/pdd-2012/PDD2012.vue'
//import PDD2016 from '@/modules/pdd-2016/PDD2016.vue'
//import PDD2020 from '@/modules/pdd-2020/PDD2020.vue'
//import PDD2024 from '@/modules/pdd-2024/PDD2024.vue'

// Santa Marta
//import ComoLlegar from '@/modules/santa-marta/ComoLlegar.vue'
//import ParaVisitar from '@/modules/santa-marta/ParaVisitar.vue'
//import PlayasReservas from '@/modules/santa-marta/PlayasReservas.vue'
//import ParquesPlazas from '@/modules/santa-marta/ParquesPlazas.vue'
//import Bibliotecas from '@/modules/santa-marta/Bibliotecas.vue'
//import Museos from '@/modules/santa-marta/Museos.vue'
//import Monumentos from '@/modules/santa-marta/Monumentos.vue'
//import DatosUtiles from '@/modules/santa-marta/DatosUtiles.vue'
//import Geografia from '@/modules/santa-marta/Geografia.vue'
//import Historia from '@/modules/santa-marta/Historia.vue'
//import Simbolos from '@/modules/santa-marta/Simbolos.vue'
//import MapaTuristico from '@/modules/santa-marta/MapaTuristico.vue'
//import Playas from '@/modules/santa-marta/Playas.vue'
//import Ecoturismo from '@/modules/santa-marta/Ecoturismo.vue'
//import Transporte from '@/modules/santa-marta/Transporte.vue'
//import Educacion from '@/modules/santa-marta/Educacion.vue'
//import Salud from '@/modules/santa-marta/Salud.vue'

// Transparencia
//import RendicionCuentas from '@/modules/transparencia/RendicionCuentas.vue'
//import ControlInterno from '@/modules/transparencia/ControlInterno.vue'
//import AccesoInformacion from '@/modules/transparencia/AccesoInformacion.vue'
//import ConcursoCuradores2016 from '@/modules/transparencia/Curadores2016.vue'
//import SistemaGestion from '@/modules/transparencia/SistemaGestion.vue'
//import Contratacion from '@/modules/transparencia/Contratacion.vue'
//import ConcursoCuradores2018 from '@/modules/transparencia/Curadores2018.vue'
//import FODCA2022 from '@/modules/transparencia/FODCA2022.vue'
//import FODCA2023 from '@/modules/transparencia/FODCA2023.vue'
//import ObrasMenores from '@/modules/transparencia/ObrasMenores.vue'
//import TurismoEmprende from '@/modules/transparencia/TurismoEmprende.vue'
//import EncuestaPresupuesto from '@/modules/transparencia/Encuesta.vue'
//import Convocatorias2022 from '@/modules/transparencia/Convocatorias2022.vue'
//import Convocatorias2025 from '@/modules/transparencia/Convocatorias2025.vue'

// Sala de Prensa
//import Noticias from '@/modules/prensa/Noticias.vue'
//import Audiovisuales from '@/modules/prensa/Audiovisuales.vue'
//import Informacion from '@/modules/prensa/Informacion.vue'
//import Gacetas from '@/modules/prensa/Gacetas.vue'

// Atención al Ciudadano
//import PQRSD from '@/modules/atencion/PQRSD.vue'
//import Eventos from '@/modules/atencion/Eventos.vue'
//import Glosario from '@/modules/atencion/Glosario.vue'
//import Accesibilidad from '@/modules/atencion/Accesibilidad.vue'
//import Manuales from '@/modules/atencion/Manuales.vue'
//import DirectorioAtencion from '@/modules/atencion/Directorio.vue'
//import PreguntasFrecuentes from '@/modules/atencion/Preguntas.vue'
//import InfoCiudadano from '@/modules/atencion/Informacion.vue'
//import TramitesServicios from '@/modules/atencion/TramitesServicios.vue'

// Organismos
//import SecHacienda from '@/modules/organismos/SecHacienda.vue'
//import SecEducacion from '@/modules/organismos/SecEducacion.vue'
//import SecMujer from '@/modules/organismos/SecMujer.vue'

export default createRouter({
  history: createWebHistory(),
  routes: [
    // Rutas anteriores...
    { path: '/', component: Home },
    // Nuestra Alcaldía
    { path: '/gabinete', component: GabineteList },

    // Santa Marta
    { path: '/como-llegar', component: ComoLlegar },
    { path: '/para-visitar', component: ParaVisitar },
    { path: '/playas-reservas', component: PlayasReservas },
    { path: '/parques-plazas', component: ParquesPlazas },
    { path: '/bibliotecas', component: Bibliotecas },
    { path: '/museos', component: Museos },
    { path: '/monumentos', component: Monumentos },
    { path: '/datos-utiles', component: DatosUtiles },
    { path: '/geografia', component: Geografia },
    { path: '/historia', component: Historia },
    { path: '/simbolos', component: Simbolos },
    { path: '/mapa-turistico', component: MapaTuristico },
    { path: '/playas', component: Playas },
    { path: '/ecoturismo', component: Ecoturismo },
    { path: '/transporte', component: Transporte },
    { path: '/educacion', component: Educacion },
    { path: '/salud', component: Salud },

    // Transparencia
    { path: '/rendicion-cuentas', component: RendicionCuentas },
    { path: '/control-interno', component: ControlInterno },
    { path: '/acceso-informacion', component: AccesoInformacion },
    { path: '/concurso-curadores-2016', component: ConcursoCuradores2016 },
    { path: '/sistema-gestion', component: SistemaGestion },
    { path: '/contratacion', component: Contratacion },
    { path: '/concurso-curadores-2018', component: ConcursoCuradores2018 },
    { path: '/fodca-2022', component: FODCA2022 },
    { path: '/fodca-2023', component: FODCA2023 },
    { path: '/obras-menores', component: ObrasMenores },
    { path: '/turismo-emprende', component: TurismoEmprende },
    { path: '/encuesta-presupuesto', component: EncuestaPresupuesto },
    { path: '/convocatorias-2022', component: Convocatorias2022 },
    { path: '/convocatorias-2025', component: Convocatorias2025 },

    // Sala de Prensa
    { path: '/noticias', component: Noticias },
    { path: '/audiovisuales', component: Audiovisuales },
    { path: '/informacion', component: Informacion },
    { path: '/gacetas', component: Gacetas },

    // Atención al Ciudadano
    { path: '/pqrsd', component: PQRSD },
    { path: '/eventos', component: Eventos },
    { path: '/glosario', component: Glosario },
    { path: '/accesibilidad', component: Accesibilidad },
    { path: '/manuales', component: Manuales },
    { path: '/directorio-atencion', component: DirectorioAtencion },
    { path: '/preguntas-frecuentes', component: PreguntasFrecuentes },
    { path: '/info-ciudadano', component: InfoCiudadano },
    { path: '/tramites-servicios', component: TramitesServicios },

    // Organismos
    { path: '/secretaria-hacienda', component: SecHacienda },
    { path: '/secretaria-educacion', component: SecEducacion },
    { path: '/secretaria-mujer', component: SecMujer },
  ]
})
