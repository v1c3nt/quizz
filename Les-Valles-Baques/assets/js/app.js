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
// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// var $ = require('jquery');
var app = {

    init: function () {

        console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

        $('#nextQuestion').on('submit', app.nextQuestion);
        $('#reset').on('click', app.nextQuestionReset);
    },

    nextQuestion: function (event) {
        event.preventDefault();
        console.log('submit blocked');
        $form = $('#nextQuestion');
        var dataToSend = $(this).serialize();

        $.ajax({
            url: $form.attr('action'),

            method: 'POST',
            cache: false,
            data: dataToSend,
            success: function (html) {
                console.log('success')
                $('#nextQuestion').remove(
                    // ... with the returned one from the AJAX response.
                    // $(html).find('#nextquestion')
                    //$('#nextquestion').remove;
                );

                var newQuestion = $(html).find('#nextQuestion')
                $('#formDiv').html(newQuestion);
                $('#nextQuestion').on('submit', app.nextQuestion);
            }
        })
    },
}
$(app.init);