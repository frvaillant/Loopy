import noUiSlider from 'noUiSlider';

$(document).ready(function() {

    $('.carousel').carousel('pause')

    const slider = document.getElementById('slider');
    const gValue = document.getElementById('glycemy-value');

        noUiSlider.create(slider, {
            start: [100],
            connect: true,
            direction: 'rtl',
            orientation: 'vertical',
            step: 10,
            range: {
                'min': 0,
                'max': 250
            },
        });
        slider.noUiSlider.on('update', function (values, handle) {
            gValue.innerHTML = parseInt(values[0])
            console.log(values[0]);
        });

    const $glycemiTarget = $('#Calque_2');

        const left = $glycemiTarget.position().left;
        const top = $glycemiTarget.position().top;
        const width = 165;
        const height = 75;

        const glycemytext = $('#glycemy-value');

        glycemytext.css('top', top).css('left', left).css('width', width).css('height', height);
        glycemytext.html('100');

        const sender = document.getElementById('send-button-svg');
        $('#send-button-svg').mousedown(function () {
            $('#button-calque-1').css('display', 'none');
            $('#button-calque-2').css('display', 'block');
        }).mouseup(function () {
            $('#button-calque-1').css('display', 'block');
            $('#button-calque-2').css('display', 'none');
            $('#doc-calque-3').css('display', 'block');
        })



})
