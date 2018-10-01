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
require('../../node_modules/jquery-ui/ui/widgets/accordion')
//var $ = require('jquery');
// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
var app = {

    init: function () {
        setTimeout(app.hideFlashNote, 4000);


        $(function () {
            var icons = {
                header: "fas fa-plus-circle mr-2",
                activeHeader: "fas fa-minus-circle mr-2"
            };

            
            $('.resum')
                  .hover(function () {
                    $(this)
                    .children('.divDetails')
                    .toggleClass("actived")
                    .next()
                      .stop(true, true)
                      .slideToggle();
                });

            $("#accordion").accordion({
                heightStyle: "content",
                icons: icons
            });

        });

        console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

        /**
         * ! en standby de l'ajax pour l'ajout de question.
         * $('#nextQuestion').on('submit', app.nextQuestion);
         */
    },


    hideFlashNote: function () {

        console.log('yep', $('.m-flash'))
        $('.m-flash').alert('close');
        $('#newQuestion-title').show();
    },

    nextQuestion: function (event) {
        event.preventDefault();

        $form = $('#nextQuestion');
        var dataToSend = $(this).serialize();

        $.ajax({
            url: '',

            method: 'POST',
            cache: false,
            data: dataToSend,
            success: function (html) {
                console.log('success')
                $('#nextQuestion').remove();

                var newQuestion = $(html).find('#nextQuestion')
                $('#formDiv').html(newQuestion);

                $('#nextQuestion').on('submit', app.nextQuestion);
            }
        })
    },
}
$(app.init);