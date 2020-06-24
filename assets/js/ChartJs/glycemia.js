document.addEventListener('DOMContentLoaded', () => {
    let lastSurvey = null, penultimateSurvey = null;
    const ctx = document.getElementById('glycemia');

    fetch('doctor/fetchData/32').then(response => {
        response.json().then(json => {
            lastSurvey = json.lastSurvey
            penultimateSurvey = json.penultimateSurvey
            const glycemia = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: lastSurvey.addedAt,
                    datasets: [{
                        label: 'Cette semaine',
                        data: lastSurvey.value,
                        borderColor: ['rgba(255, 99, 132, 1)'],
                        borderWidth: 3,
                        fill: false,
                    }, {
                        label: 'La semaine dernière',
                        data: penultimateSurvey.value,
                        borderColor: ['rgba(0, 99, 132, 0.5)'],
                        borderWidth: 3,
                        borderDash: [10, 10],
                        fill: false,
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            scaleLabel : {
                                display: true,
                                labelString: 'Taux de glycémie'
                            },
                            ticks: {
                                suggestedMin: 50,
                                suggestedMax: 200
                            }
                        }],
                        xAxes: [{
                            scaleLabel : {
                                display: true,
                                labelString: 'Date et heure'
                            }
                        }]
                    }
                }
            });
        })
    })
})


