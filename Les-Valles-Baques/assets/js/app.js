/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

const $ = require('jquery');
// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');
require('../scss/app.scss');
require('bootstrap');
require('jquery-ui')
  $(function () {
      $("#accordion").accordion();
  });
// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// var $ = require('jquery');
/*var app = {

        init: function () {
            //! TODO à effacer 
            console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

            $('#signup').on('submit', app.signup);
        },

        signup: function(evt){
            evt.preventDefault();
            console.log('submit ok');
            var dataToSend = $(this).serialize();

            console.log(dataToSend);
            
            var jqXHR =$.ajax({
                url: '/inscription',
                method: 'POST',
                dataType:'json',
                data: dataToSend
            }).done(function (response) {

                if (response.code == 0) {

                    // Pas AJAX donc à ne pas privilegier mais plus rapide pour nous ;-)
                   alert('Cool on y est');
                } else {

                    alert('response.errorMsg');
                }
            }).fail(function () {

                alert('Une erreur est survenue...');
            });

        }


    };

$(app.init);*/