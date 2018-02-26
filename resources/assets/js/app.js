
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(function() {
    require('./modules/hamburger');
});

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('projects-dropdown', require('./components/ProjectsDropdown.vue'));
Vue.component('tasks-dropdown', require('./components/TasksDropdown.vue'));

const app = new Vue({
    el: '#app',
});

$('.more-group--button').on('click', function() {
    $(this).siblings('.more-group--list').show();
    return false;
});


$(document).mouseup(function(e) 
{
    var container = $(".more-group--list");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        container.hide();
    }
});