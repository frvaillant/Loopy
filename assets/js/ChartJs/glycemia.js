import Chart from 'chart.js';
import * as ChartAnnotation from 'chartjs-plugin-annotation';
Chart.plugins.register([ChartAnnotation]); // Global

document.addEventListener('DOMContentLoaded', () => {
    let patientId = document.getElementById('PatientId').getAttribute('data-id');
    let lastSurvey = null, penultimateSurvey = null, threshold = null;
    const ctx = document.getElementById('glycemia');

    fetch('/doctor/fetchData/' + patientId).then(response => {
        response.json().then(json => {
            lastSurvey = json.lastSurvey
            penultimateSurvey = json.penultimateSurvey
            threshold = json.threshold
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
                        pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                        pointRadius: 5,
                        pointHoverRadius: 10
                    }, {
                        label: 'La semaine dernière',
                        data: penultimateSurvey.value,
                        borderColor: ['rgba(0, 99, 132, 0.5)'],
                        borderWidth: 3,
                        borderDash: [10, 10],
                        fill: false,
                        pointBackgroundColor: 'rgba(0, 99, 132, 0.5)',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }]
                },
                options: {
                    tooltips: {
                        mode: 'index',
                    },
                    annotation: {
                        annotations: [{
                            type: 'line',
                            mode: 'horizontal',
                            scaleID: 'y-axis-0',
                            value: threshold.min,
                            borderColor: 'rgba(75, 192, 192, 0.5)',
                            borderWidth: 2,
                            label: {
                                enabled: true,
                                position: 'right',
                                content: 'Seuil bas',
                                fontSize: 10,
                                backgroundColor: 'rgb(75, 192, 192)',
                                fontFamily: "Oswald, sans-serif",
                            }
                        }, {
                            type: 'line',
                            mode: 'horizontal',
                            scaleID: 'y-axis-0',
                            value: threshold.max,
                            borderColor: 'rgba(75, 192, 192, 0.5)',
                            borderWidth: 2,
                            label: {
                                enabled: true,
                                position: 'right',
                                content: 'Seuil haut',
                                fontSize: 10,
                                backgroundColor: 'rgb(75, 192, 192)',
                                fontFamily: "Oswald, sans-serif",
                            }
                        }]
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel : {
                                display: true,
                                labelString: 'Glycémie ( mg/dL )'
                            },
                            ticks: {
                                suggestedMin: 50,
                                suggestedMax: 220
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
