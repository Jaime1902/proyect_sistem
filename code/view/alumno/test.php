<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      font-family: 'Noto Sans', sans-serif;
    }
    .navbar-custom {
      background-color: #ffffff;
      box-shadow: 1px 5px 10px rgba(0.1, 1, 1, 0.5);
      border-bottom: 2.5px solid #B40000;
    }
    .navbar-custom .navbar-nav .nav-link,
    .navbar-custom .navbar-brand {
      color: #000000;
      transition: color 0.3s;
    }
    .navbar-toggler {
      border: 1px solid #ffffff;
      padding: 10px;
      border-radius: 10px;
    }
    .navbar-toggler i {
      color: #B40000;
      font-size: 30px;
    }
    .navbar-spacing {
      margin-bottom: 50px;
    }
    /* Estilo para el enlace activo */
    .nav-link.active {
      color: #B40000;
      font-weight: bold; 
    }
    /* Modificaciones para el menú lateral */
    @media (max-width: 992px) { /* Para dispositivos más pequeños */
      .navbar-collapse {
        position: fixed;
        top: 0;
        right: -100%; /* Empujar el menú fuera de la pantalla */
        width: 250px; /* Ancho del menú */
        height: 100%;
        background-color: #ffffff;
        box-shadow: -2px 0px 10px rgba(0, 0, 0, 0.5);
        transition: right 0.3s ease-in-out;
        z-index: 100; /* Asegura que el menú se muestre encima de otros elementos */
      }
      .navbar-collapse.show {
        right: 0; /* Cuando está abierto, se mueve hacia la derecha */
      }
      .navbar-nav {
        flex-direction: column;
        margin-top: 50px;
      }
      /* Desenfoque del contenido cuando el menú está abierto */
      .content-blur {
        filter: blur(5px); /* Aplica desenfoque */
        pointer-events: none; /* Deshabilita interacción con el contenido mientras está desenfocado */
      }
      /* Estilo para el icono de cerrar */
      .close-icon {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 30px;
        color: #B40000;
        cursor: pointer;
        z-index: 101; /* Asegura que el menú se muestre encima de otros elementos */
      }
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom border-custom navbar-spacing">
  <a class="navbar-brand" href="#">
    <img src="../../img/logo/logo.png" alt="Logo" style="height: 60px; width: auto;">
  </a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa-solid fa-bars-staggered"></i>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="index.php" data-section="inicio">Inicio</a>
      <a class="nav-item nav-link" href="view_asignatura.php" data-section="calificaciones">Calificaciones</a>
      <a class="nav-item nav-link" href="close.php" data-section="salir">Salir</a>
    </div>
  </div>
</nav>
<!-- Contenido debajo del header -->
<div class="container" id="content">
  <!-- Aquí iría el contenido de la página -->
</div>
<!-- Icono de cerrar -->
<i class="fas fa-times close-icon" id="closeBtn"></i>
<script>
  // Obtener el menú y el contenido
  const menu = document.querySelector('.navbar-collapse');
  const closeBtn = document.getElementById('closeBtn');
  const content = document.getElementById('content');

  // Función para abrir el menú
  function openMenu() {
    menu.classList.add('show'); // Mostrar el menú
    content.classList.add('content-blur'); // Aplicar desenfoque al contenido
  }

  // Función para cerrar el menú
  function closeMenu() {
    menu.classList.remove('show'); // Ocultar el menú
    content.classList.remove('content-blur'); // Quitar el desenfoque
  }

  // Agregar el event listener al botón de cerrar
  closeBtn.addEventListener('click', closeMenu);

  // Lógica para abrir el menú al hacer clic en el botón de la hamburguesa
  document.querySelector('.navbar-toggler').addEventListener('click', openMenu);

  // Obtener todos los enlaces en el nav
  const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

  // Obtener la sección activa desde localStorage (si existe)
  let activeSection = localStorage.getItem('activeSection');

  // Si no hay ninguna sección activa guardada, seleccionar "inicio" como predeterminado
  if (!activeSection) {
    activeSection = "inicio";
    localStorage.setItem('activeSection', activeSection);
  }

  // Aplicar la clase 'active' al enlace correspondiente
  navLinks.forEach(link => {
    if (link.getAttribute('data-section') === activeSection) {
      link.classList.add('active');
    }
  });

  // Agregar un event listener a cada enlace
  navLinks.forEach(link => {
    link.addEventListener('click', function(event) {
      const section = this.getAttribute('data-section');
      
      // Si el enlace es "salir", borrar la sección activa en localStorage y redirigir
      if (section === "salir") {
        localStorage.removeItem('activeSection'); // Eliminar la sección activa de localStorage
        return; // No hacemos más acciones, ya que el "Salir" probablemente redirigirá
      }

      // Eliminar la clase 'active' de todos los enlaces
      navLinks.forEach(link => link.classList.remove('active'));
      
      // Agregar la clase 'active' al enlace seleccionado
      this.classList.add('active');

      // Guardar la sección activa en localStorage
      localStorage.setItem('activeSection', section);
    });
  });
</script>
<!-- JS de Bootstrap y Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>