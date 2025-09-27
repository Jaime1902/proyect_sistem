<?php
date_default_timezone_set('America/Managua');
session_start();

if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'alumno')) {
  header("location: ../../index.php");
  exit;
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) {
  session_unset();
  session_destroy();
  header("location: ../../index.php");
  exit;
}

$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    

  </head>
  <style>
    body {
      font-family: 'Noto Sans', sans-serif;
    }
    .navbar-custom {
      background-color: #ffffff;
      box-shadow: -2px 5px 10px rgba(0.1, 1, 1, 0.5);
      border-bottom: 5px solid #00b400ff;
      padding: 15px;
    }
    .navbar-custom .navbar-nav .nav-link,
    .navbar-custom .navbar-brand {
      color: #000000;
      transition: color 0.3s;
    }
    .navbar-brand {
    display: flex;
    margin: 0;
    align-items: center;
  }

    .navbar-toggle {
      border: 0px solid #ffffff;
      padding: 1px;
      border-radius: 5px;
    }
    .navbar-toggle i {
      color: #1eb400ff;
      font-size: 20px;
      margin-top: 5px; /* Ajusta este valor según sea necesario */
    }
    .navbar-spacing {
      margin-bottom: 50px;
    }
    @media only screen and (max-width: 767px) {
  #slide-navbar-collapse {
    position: fixed;
    top: 0;
    left: 15px;
    z-index: 999999;
    width: 250px;
    height: 100%;
    background-color: #ffffff;
    overflow: auto;
    bottom: 0;
    max-height: inherit;
    padding-top: 80px; /* Ajusta según sea necesario */
  }
  .menu-overlay {
    display: none;
    background-color: #000;
    bottom: 0;
    left: 0;
    opacity: 0.5;
    filter: alpha(opacity=50);
    /* IE7 & 8 */
    position: fixed;
    right: 0;
    top: 0;
    z-index: 49;
  }
  .navbar-fixed-top {
    position: initial !important;
  }
  .navbar-nav .open .dropdown-menu {
    background-color: #ffffff;
  }
  ul.nav.navbar-nav li {
    border-bottom: 1px solid #eee;
  }
  .navbar-nav .open .dropdown-menu .dropdown-header,
  .navbar-nav .open .dropdown-menu>li>a {
    padding: 10px 20px 10px 15px;
  }
}

.dropdown-submenu {
  position: relative;
}

.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
}

li.dropdown a {
  display: block;
  position: relative;
}

li.dropdown>a:before {
  content: "\f107";
  font-family: FontAwesome;
  position: absolute;
  right: 6px;
  top: 5px;
  font-size: 15px;
}

li.dropdown-submenu>a:before {
  content: "\f107";
  font-family: FontAwesome;
  position: absolute;
  right: 6px;
  top: 10px;
  font-size: 15px;
}

ul.dropdown-menu li {
  border-bottom: 1px solid #eee;
}

.dropdown-menu {
  padding: 0px;
  margin: 0px;
  border: none !important;
}

li.dropdown.open {
  border-bottom: 0px !important;
}

li.dropdown-submenu.open {
  border-bottom: 0px !important;
}

li.dropdown-submenu>a {
  font-weight: bold !important;
}

li.dropdown>a {
  font-weight: bold !important;
}

.navbar-default .navbar-nav>li>a {
  font-weight: bold !important;
  padding: 10px 20px 20px 15px;
}

li.dropdown>a:before {
  content: "\f107";
  font-family: FontAwesome;
  position: absolute;
  right: 6px;
  top: 9px;
  font-size: 15px;
}

@media (min-width: 767px) {
  li.dropdown-submenu>a {
    padding: 10px 20px 10px 15px;
  }
  li.dropdown>a:before {
    content: "\f107";
    font-family: FontAwesome;
    position: absolute;
    right: 3px;
    top: 12px;
    font-size: 15px;
  }
  .navbar-custom {
      border-bottom: 5px solid #B40000;
    }
  body {
    padding-top: 150px; /* Ajusta según sea necesario */
  }
}
  </style>
  <body>
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top navbar-spacing border-custom ">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header ">
          <button type="button" class="navbar-toggle collapsed" data-toggle="slide-collapse" data-target="#slide-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
          <a class="navbar-brand" href="#">
            <img src="../../img/logo/newLogo.jpg" alt="Logo" style="height: 60px; width: auto; margin-left: -15px;">
          </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse " id="slide-navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a  class="nav-item nav-link" href="index.php">Inicio</a></li>
            <li><a class="nav-item nav-link" href="view_asignatura.php">Calificaciones</a></li>
            <li><a class="nav-item nav-link" href="close.php">Cerrar sesion</a></li>
          </ul>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
    </nav>
    <div class="menu-overlay"></div>
    <div class="container" id="content"></div>

  </body>

    <script>
      $('[data-toggle="slide-collapse"]').on('click', function() {
  $navMenuCont = $($(this).data('target'));
  $navMenuCont.animate({
    'width': 'toggle'
  }, 350);
  $(".menu-overlay").fadeIn(500);
});

$(".menu-overlay").click(function(event) {
  $(".navbar-toggle").trigger("click");
  $(".menu-overlay").fadeOut(500);
});

// if ($(window).width() >= 767) {
//     $('ul.nav li.dropdown').hover(function() {
//         $(this).find('>.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
//     }, function() {
//         $(this).find('>.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
//     });

//     $('ul.nav li.dropdown-submenu').hover(function() {
//         $(this).find('>.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
//     }, function() {
//         $(this).find('>.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
//     });


//     $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
//         event.preventDefault();
//         event.stopPropagation();
//         $(this).parent().siblings().removeClass('open');
//         $(this).parent().toggleClass('open');
//         $('b', this).toggleClass("caret caret-up");
//     });
// }

// $(window).resize(function() {
//     if( $(this).width() >= 767) {
//         $('ul.nav li.dropdown').hover(function() {
//             $(this).find('>.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
//         }, function() {
//             $(this).find('>.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
//         });
//     }
// });

var windowWidth = $(window).width();
if (windowWidth > 767) {
  // $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
  //     event.preventDefault();
  //     event.stopPropagation();
  //     $(this).parent().siblings().removeClass('open');
  //     $(this).parent().toggleClass('open');
  //     $('b', this).toggleClass("caret caret-up");
  // });

  $('ul.nav li.dropdown').hover(function() {
    $(this).find('>.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
  }, function() {
    $(this).find('>.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
  });

  $('ul.nav li.dropdown-submenu').hover(function() {
    $(this).find('>.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
  }, function() {
    $(this).find('>.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
  });


  $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).parent().siblings().removeClass('open');
    $(this).parent().toggleClass('open');
    // $('b', this).toggleClass("caret caret-up");
  });
}
if (windowWidth < 767) {
  $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).parent().siblings().removeClass('open');
    $(this).parent().toggleClass('open');
    // $('b', this).toggleClass("caret caret-up");
  });

}
// $('.dropdown a').append('Some text');
    </script>
</html>
