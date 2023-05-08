import {Tooltip, Tab, Toast} from 'bootstrap'

import './styles/app.scss';

const $ = require('jquery')
import './bootstrap';


/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)

// start the Stimulus application
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
document.addEventListener('turbo:load', function (e) {
  let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Tooltip(tooltipTriggerEl)
  })
})

document.addEventListener('turbo:load', function (e) {
  if (document.body.classList.contains('offcanvas-backdrop')) {
    const modalEl = document.querySelector('.offcanvas-backdrop');
    const modal = Modal.getInstance(modalEl);
    modalEl.classList.remove('fade');
    modal._backdrop._config.isAnimated = false;
  }
});

document.addEventListener('turbo:load', function (e) {
  $("a[role='tab']").on("click", function (event) {
    event.preventDefault();
    history.pushState("object or string", "Page title", $(this).attr("href"));
  });

  let selectedTab = window.location.hash;
  console.log(selectedTab)
  let tabTrigger = new Tab($('.nav-link[href="' + selectedTab + '"]:first'));
  tabTrigger.show();
});
document.addEventListener('turbo:load', function (e) {
  const toastElList = document.querySelectorAll('.toast')
  const toastList = [...toastElList].map(toastEl => new Toast(toastEl, option));
});
