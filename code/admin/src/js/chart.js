async function getData(range) {
    var service = null;
    if (range == "mese") {
        service = "../services/mounthReview.php"
    }
    else if (range == "anno") {
        service = "../services/yearReview.php"
    }
    else {
        return null;
    }

    try {
        const response = await fetch(service);
        const data = await response.json();

        if (data.success) {
            return data.data;
        }
        else {
            throw new Error(data.message)
        }
    }
    catch (error) {
        console.error(error);
        throw error;
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    try {
        var ctx = document.getElementById("mouth-review");
        if (ctx) {
            var data = await getData("mese");
            const entries = Object.entries(data);
            const keys = entries.map(([key, _]) => key);
            const values = entries.map(([_, value]) => value);

            ctx.height = 100;
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: keys,
                    type: 'line',
                    defaultFontFamily: 'Poppins',
                    datasets: [{
                        data: values,
                        label: "Expense",
                        backgroundColor: 'rgba(0,103,255,.15)',
                        borderColor: 'rgba(0,103,255,0.5)',
                        borderWidth: 3.5,
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: 'transparent',
                        pointBackgroundColor: 'rgba(0,103,255,0.5)',
                    },]
                },
                options: {
                    responsive: true,
                    tooltips: {
                        mode: 'index',
                        titleFontSize: 12,
                        titleFontColor: '#000',
                        bodyFontColor: '#000',
                        backgroundColor: '#fff',
                        titleFontFamily: 'Poppins',
                        bodyFontFamily: 'Poppins',
                        cornerRadius: 3,
                        intersect: false,
                    },
                    legend: {
                        display: false,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            fontFamily: 'Poppins',
                        },
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: false,
                                labelString: 'Month'
                            },
                            ticks: {
                                fontFamily: "Poppins"
                            }
                        }],
                        yAxes: [{
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Value',
                                fontFamily: "Poppins"
                            },
                            ticks: {
                                fontFamily: "Poppins"
                            }
                        }]
                    },
                    title: {
                        display: false,
                    }
                }
            });
        }
    }
    catch (error) {
        console.log(error);
    }


    try {
        var ctx = document.getElementById("year-review");
        if (ctx) {
            var data = await getData("anno");
            const entries = Object.entries(data);
            const numeroRecensioniArray = entries.map(([_, value]) => value.numero_recensioni);
            const meseAnnoArray = entries.map(([_, value]) => `${value.mese} ${value.anno}`);

            meseAnnoArray.sort((a, b) => {
                const [meseA, annoA] = a.split(' ');
                const [meseB, annoB] = b.split(' ');
                if (annoA === annoB) {
                    return parseInt(meseA.slice(0, 3), 10) - parseInt(meseB.slice(0, 3), 10);
                } else {
                    return parseInt(annoA, 10) - parseInt(annoB, 10);
                }
            });

            ctx.height = 100;
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: meseAnnoArray,
                    type: 'line',
                    defaultFontFamily: 'Poppins',
                    datasets: [{
                        data: numeroRecensioniArray,
                        label: "Expense",
                        backgroundColor: 'rgba(0,103,255,.15)',
                        borderColor: 'rgba(0,103,255,0.5)',
                        borderWidth: 3.5,
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: 'transparent',
                        pointBackgroundColor: 'rgba(0,103,255,0.5)',
                    },]
                },
                options: {
                    responsive: true,
                    tooltips: {
                        mode: 'index',
                        titleFontSize: 12,
                        titleFontColor: '#000',
                        bodyFontColor: '#000',
                        backgroundColor: '#fff',
                        titleFontFamily: 'Poppins',
                        bodyFontFamily: 'Poppins',
                        cornerRadius: 3,
                        intersect: false,
                    },
                    legend: {
                        display: false,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            fontFamily: 'Poppins',
                        },
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: false,
                                labelString: 'Month'
                            },
                            ticks: {
                                fontFamily: "Poppins"
                            }
                        }],
                        yAxes: [{
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Value',
                                fontFamily: "Poppins"
                            },
                            ticks: {
                                fontFamily: "Poppins"
                            }
                        }]
                    },
                    title: {
                        display: false,
                    }
                }
            });
        }
    }
    catch (error) {
        console.log(error);
    }
});
