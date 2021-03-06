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
            step: 1,
            range: {
                'min': 40,
                'max': 250
            },
        });
        slider.noUiSlider.on('update', function (values, handle) {
            gValue.innerHTML = parseInt(values[0])
        });

    const $glycemiTarget = $('#ardoise');

        const left = $glycemiTarget.position().left;
        const top = $glycemiTarget.position().top;
        const width = 165;
        const height = 75;

        const glycemytext = $('#glycemy-value');

        //glycemytext.css('top', top).css('left', left).css('width', width).css('height', height);
        glycemytext.html('100');

        const sender = document.getElementById('send-button-svg');

        // BOUTON NON
        $('#send-button-svg').mousedown(function () {
            $('#btn-up').css('display', 'none');
            $('#btn-down').css('display', 'block');
        }).mouseup(function () {
            $('#btn-up').css('display', 'block');
            $('#btn-down').css('display', 'none');
            $('#btn-up').addClass('rotate');
            const value = parseInt(glycemytext.html());

            fetch('/patient/measure/' + value + '/haseaten/0', {
                method: "put"
            })
                .then(response => {
                    return response.json()
                }).then(data => {
                   if (data.response === 201) {
                       fetch('/check/badge')
                           .then(response => response.json())
                           .then(data => {
                               console.log(data, 'badge')
                           })
                       $('#doc-calque-3').css('display', 'block');
                       $('#btn-up').removeClass('rotate');
                       $('#send-button').addClass('d-none');
                       $('#success').removeClass('d-none');
                       $('#assiette').addClass('d-none');
                       $('#merci').css('display', 'block');
                       $('#glycemy-value').hide();
                       $('#ardoise').hide();
                       $('#success').removeClass('d-none');
                       $('#' + data.state).removeClass('d-none');
                       document.getElementById('slider').classList.add('d-none');
                   }
            });
        })

    // BOUTON VERT
    $('#btn-send-yes').mousedown(function () {
        $('#btn-ok-up').css('display', 'none');
        $('#btn-ok-down').css('display', 'block');
    }).mouseup(function () {
        $('#btn-ok-up').css('display', 'block');
        $('#btn-ok-down').css('display', 'none');
        $('#btn-ok-up').addClass('rotate');
        const value = parseInt(glycemytext.html());

        fetch('/patient/measure/' + value + '/haseaten/1', {
            method: "put"
        })
            .then(response => {
                return response.json()
            }).then(data => {
            if (data.response === 201) {
                fetch('/check/badge')
                    .then(response => response.json())
                    .then(data => {
                        console.log(data, 'badge')
                    })
                $('#doc-calque-3').css('display', 'block');
                $('#btn-ok-up').removeClass('rotate');
                $('#send-button').addClass('d-none');
                $('#success').removeClass('d-none');
                $('#assiette').addClass('d-none');
                $('#merci').css('display', 'block');
                $('#glycemy-value').hide();
                $('#ardoise').hide();
                $('#success').removeClass('d-none');
                $('#' + data.state).removeClass('d-none');
                document.getElementById('slider').classList.add('d-none');
            }
        });
    })






    const chapos = document.getElementsByClassName('chapo');
    for (let i=0; i<chapos.length; i++) {
        chapos[i].addEventListener('click', (e) => {
            $('.chapo-c').each(function() {
                $(this).css('display', 'none');
            })
            $('.chapo').each(function() {
                $(this).css('display', 'block');
            })
            let id = chapos[i].getAttribute('id');
            id = id.split('chapo');
            id = id[1];
            $('#chapo-c-' + id).css('display', 'block');
            $('#chapo' + id).css('display', 'none');
        })
    }
})
