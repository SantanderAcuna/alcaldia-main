function cambiarContexto(event) {
    event.preventDefault(); // Prevenir comportamiento predeterminado
    const body = document.body;
    body.classList.toggle('modo-oscuro');

    document.querySelectorAll('.navbar, .dropdown-menu, .card, .footer, #contacto').forEach(element => {
        element.classList.toggle('modo-oscuro');
    });

    localStorage.setItem('modoOscuro', body.classList.contains('modo-oscuro'));
}

// Sistema de Tamaño de Fuente
let fontSize = 16;

function aumentarTamanio(event) {
    event.preventDefault(); // Prevenir comportamiento predeterminado
    fontSize = Math.min(18, fontSize + 1);
    document.documentElement.style.fontSize = fontSize + 'px';
    localStorage.setItem('fontSize', fontSize);
}

function disminuirTamanio(event) {
    event.preventDefault(); // Prevenir comportamiento predeterminado
    fontSize = Math.max(12, fontSize - 1);
    document.documentElement.style.fontSize = fontSize + 'px';
    localStorage.setItem('fontSize', fontSize);
}


// Configuración inicial y eventos
window.addEventListener('DOMContentLoaded', () => {
    // Cargar preferencias
    const savedFontSize = localStorage.getItem('fontSize');
    const modoOscuro = localStorage.getItem('modoOscuro') === 'true';

    if (savedFontSize) {
        fontSize = parseInt(savedFontSize);
        document.documentElement.style.fontSize = fontSize + 'px';
    }

    if (modoOscuro) {
        document.body.classList.add('modo-oscuro');
        document.querySelectorAll('.navbar, .dropdown-menu, .card, .footer, #contacto').forEach(element => {
            element.classList.add('modo-oscuro');
        });
    }

    // Asignar eventos
    document.getElementById("botoncontraste").addEventListener("click", cambiarContexto);
    document.getElementById("botonaumentar").addEventListener("click", aumentarTamanio);
    document.getElementById("botondisminuir").addEventListener("click", disminuirTamanio);
    document.getElementById("botonrelevo").addEventListener("click", irCentroRelevo);
});



// Función para actualizar el reloj
function actualizarReloj() {
    const horaActual = document.getElementById('hora-actual');
    if (horaActual) {
        const ahora = new Date(); // Obtiene la fecha y hora actual
        const opciones = { timeZone: 'America/Bogota' }; // Zona horaria de Colombia (Bogotá)
        const hora = ahora.toLocaleTimeString('es-CO', opciones); // Formato HH:MM:SS
        horaActual.textContent = hora; // Actualiza el contenido del reloj
    }
}

// Actualiza el reloj cada segundo
setInterval(actualizarReloj, 1000);

// Inicia el reloj al cargar la página
window.addEventListener('DOMContentLoaded', () => {
    actualizarReloj();
});

function irCentroRelevo() {
    window.open(
        'https://centroderelevo.gov.co',
        '_blank',
        'noopener,noreferrer'
    );
}


window.addEventListener("load", function() {
    initMenu();
  });

  function initMenu() {
    initSearchBar();

    /////// Prevent closing from click inside dropdown
    document.querySelectorAll('.dropdown-menu').forEach(function(element){
      element.addEventListener('click', function (e) {
        e.stopPropagation();
      });
    });

    document.querySelectorAll('.navbar-menu-govco a.dir-menu-govco').forEach(function(element){
      element.addEventListener("click", eventClickItem, false);
    });
  }

  function eventClickItem() {
    const parentNavbar = this.closest('.navbar-menu-govco');
    parentNavbar.querySelectorAll('a.active').forEach(function(element){
        element.classList.remove('active');
    });

    this.classList.add('active');
    const container = this.closest('.nav-item');
    const itemParent =  container.querySelector('.nav-link');
    itemParent.classList.add('active');
  }


  /** Buscador */
  function methodAssign(event, method, elements) {
    for (let i of elements) {
      i.addEventListener(event, method, false);
    }
  }

  function initSearchBar() {
    const inputSearch = document.querySelectorAll(".input-search-govco:not(.noActive)");
    getElementInputSearchBar(inputSearch);
    methodAssign("keyup", activeInputSearchBar, inputSearch);
    methodAssign("keydown", keydownInputSearchBar, inputSearch);
    methodAssign("blur", blurInputSearchBar, inputSearch);
    methodAssign("focus", focusInputSearchBar, inputSearch);

    const buttonClean = document.querySelectorAll(".search-govco .icon-close-search-govco");
    methodAssign("click", cleanInputSearchBar, buttonClean);
    methodAssign("blur", blurcleanInputSearchBar, buttonClean);
  }

  function getElementInputSearchBar(elements) {
    for (let i of elements) {
      assignFunctionItemsSearchBar(i);
    }
  }

  function activeInputSearchBar(element) {
    const parent = element.target.parentNode;
    const existsClass = parent.classList.contains('active');
    if (element.target.value === '') {
      parent.classList.remove('active', 'exist-content');
    } else if (!existsClass) {
      parent.classList.add('active', 'exist-content');
    }
  }

  function assignFunctionItemsSearchBar(input) {
    const parentInput = input.parentNode;
    const parentItems = parentInput.nextElementSibling;
    const items = parentItems.querySelectorAll("ul li a");

    for (let item of items) {
      item.addEventListener("keydown", function(event) {
        keysUpDownSearchBar(event, parentItems, input);
      });

      item.addEventListener("blur", function() {
        const elementI = item.parentNode
        const elementU = elementI.parentNode
        const elementDivOptions = elementU.parentNode
        const elementDivContainerOptions = elementDivOptions.parentNode;
        const elementDivContainerSearch = elementDivContainerOptions.previousElementSibling;
        existFocusContainerSearchBar(elementDivContainerSearch);
      });

      item.addEventListener("click", function() {
        input.value = '';
        parentInput.classList.remove('active', 'exist-content');
      });
    }
  }

  function keydownInputSearchBar(element) {
    const parentInput = this.parentNode;
    const parentItems = parentInput.nextElementSibling;
    const parentUl = parentItems.querySelector('.options-search-govco');

    if (parentUl) {
      parentUl.onscroll = function() {
        const visibleItems = this.querySelectorAll("li a");
        if (document.activeElement == visibleItems[0]) {
          this.scrollTop = 0;
        }
      };
      keysUpDownSearchBar(element, parentItems, this);
    }
  }

  function keysUpDownSearchBar(e, container, input) {
    // Key up
    if (e.which == 38) {
      upSearchBar(container, input);
    }
    // Key down
    if (e.which == 40) {
      downSearchBar(container, input);
    }
  }

  function downSearchBar(container, input) {
    const active = document.activeElement;
    const items = container.querySelectorAll("li a");
    if (active === input) {
      items[0].focus();
    } else {
      for (let i = 0; i < items.length - 1; i++) {
        if (active === items[i]) {
          items[i + 1].focus();
        }
      }
    }
  }

  function upSearchBar(container, input) {
    const active = document.activeElement;
    const itemsList = container.querySelectorAll("li:not(.none) a");
    if (active === itemsList[0]) {
      input.focus();
    } else {
      for (let i = 1; i < itemsList.length; i++) {
        if (active === itemsList[i]){
          itemsList[i - 1].focus();
        }
      }
    }
  }

  function cleanInputSearchBar() {
    const input = this.previousElementSibling;
    const parent = this.parentNode;
    input.value = '';
    parent.classList.remove('active', 'exist-content');
    input.focus();
  }

  function blurInputSearchBar() {
    const parent = this.parentNode;
    existFocusContainerSearchBar(parent);
  }

  function existFocusContainerSearchBar(element) {
    setTimeout(() => {
      if (!element.parentNode.contains(document.activeElement)) {
        element.classList.remove('active');
      }
    }, 100);
  }

  function focusInputSearchBar(element) {
    activeInputSearchBar(element);
  }

  function blurcleanInputSearchBar() {
    const parent = this.parentNode;
    existFocusContainerSearchBar(parent);
  }


// opasasidad en el boton tramites y servicios




//  animacion de las noticias

    // Opcional: Agregar un pequeño retraso en la animación para cada noticia
    document.querySelectorAll('.news-item').forEach((item, index) => {
        item.style.animationDelay = `${index * 0.2}s`;
    });

    
    // Este script cierra los dropdowns abiertos al abrir otro.
    document.querySelectorAll('.nav-item.dropdown > a.dropdown-toggle').forEach(function(toggle) {
      toggle.addEventListener('click', function() {
        setTimeout(function() {
          document.querySelectorAll('.nav-item.dropdown.show').forEach(function(openDropdown) {
            if (openDropdown !== toggle.parentElement) {
              let instance = bootstrap.Dropdown.getInstance(openDropdown.querySelector('.dropdown-toggle'));
              if (instance) {
                instance.hide();
              }
            }
          });
        }, 10);
      });
    });

