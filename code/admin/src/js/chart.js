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

            const dataLabelArray = entries.map(([_, value]) => {
                return {
                    dato: value.numero_recensioni,
                    etichetta: `${value.mese} ${value.anno}`
                };
            });

            dataLabelArray.sort((a, b) => {
                var mesi = ["gen", "feb", "mar", "apr", "mag", "giu", "lug", "ago", "set", "ott", "nov", "dic"];

                var aParti = a.etichetta.split(" ");
                var bParti = b.etichetta.split(" ");

                var aMese = mesi.indexOf(aParti[0]);
                var bMese = mesi.indexOf(bParti[0]);

                var aAnno = parseInt(aParti[1]);
                var bAnno = parseInt(bParti[1]);

                var aData = new Date(aAnno, aMese, 1);
                var bData = new Date(bAnno, bMese, 1);

                return aData - bData;
            });

            const values = dataLabelArray.map(item => item.dato);
            const labels = dataLabelArray.map(item => item.etichetta);


            ctx.height = 100;
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
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
});
