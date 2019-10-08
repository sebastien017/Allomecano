document.addEventListener('DOMContentLoaded', () => {

    // Gestion des steps (confirmation rendez-vous)
    bulmaSteps.attach();

    // Ajout de l'événement sur l'anchor-search de la page d'accueil
    $('.anchor-search').click(function() {
      // Animation scroll -> .content-home
      $('html, body').animate({
        scrollTop: $('.content-home').offset().top
      }, 1200); 
      // Focus de l'input permettant de saisir l'adresse
      $( ".input--home-address" ).focus();
    });

    // Récupération de tous les éléments "navbar-burger"
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
  
    if ($navbarBurgers.length > 0) {
  
      // Ajout d'un évenement
      $navbarBurgers.forEach( el => {
        el.addEventListener('click', () => {
  
          // Récupère la cible à partir de l'attribut "data-target"
          const target = el.dataset.target;
          const $target = document.getElementById(target);
  
          // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
          el.classList.toggle('is-active');
          $target.classList.toggle('is-active');
  
        });
      });
    }
  
  });