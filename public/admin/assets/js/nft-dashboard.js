(function () {
    "use strict";

    /* Revenue */
    var total = {
        chart: {
            height: 100,
            sparkline: {
                enabled: true
            },
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 7,
                left: 1,
                blur: 3,
                color: '#000',
                opacity: 0.2
            },
        },
        plotOptions: {
            bar: {
                columnWidth: '100%'
            }
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: [1.5, 1.5],
            dashArray: [0, 0],
        },
        grid: {
            borderColor: 'transparent',
            padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.1,
                stops: [0, 90, 100],
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "var(--primary01)",
                            opacity: 1
                        },
                        {
                            offset: 75,
                            color: "var(--primary01)",
                            opacity: 1
                        },
                        {
                            offset: 100,
                            color: "var(--primary01)",
                            opacity: 1
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'Last Year',
            data: [
                [0, 49.331065063219285],
                [1, 48.79814898366035],
                [2, 50.61793547911337],
                [3, 53.31696317779434],
                [4, 54.78560952831719],
                [5, 53.84293992505776],
                [6, 54.682958355082874],
                [7, 56.742547193381654],
                [8, 56.99677491680908],
                [9, 56.144488388681445],
                [10, 56.567122269843885],
                [11, 60.355022877262684],
                [12, 58.7457726121753],
                [13, 61.445407102315514],
                [14, 61.112870581452086],
                [15, 58.57202276349258],
                [16, 54.72497594269612],
                [17, 52.070341498681124],
                [18, 51.09867716530438],
                [19, 47.48185519192089],
                [20, 48.57861168097493],
                [21, 48.99789250679436],
                [22, 53.582491800119456],
                [23, 50.28407438696142],
                [24, 46.24606628705599],
                [25, 48.614330310543856],
                [26, 51.75313497797672],
                [27, 51.34463925296746],
                [28, 50.217320673443936],
                [29, 54.657281647073304],
                [30, 52.445057217757245],
                [31, 53.063914668561345],
                [32, 57.07494250387825],
                [33, 52.970403392565515],
                [34, 48.723854145068756],
                [35, 52.69064629353968],
                [36, 53.590890118378205],
                [37, 58.52332126105745],
                [38, 55.1037709679581],
                [39, 58.05347017020425],
                [40, 61.350810521199946],
                [41, 57.746188675088575],
                [42, 60.276910973029786],
                [43, 61.00841651851749],
                [44, 57.786733623457636],
                [45, 56.805721677811356],
                [46, 58.90301959619822],
                [47, 62.45091969566289],
                [48, 58.75007922945926],
                [49, 58.405842466185355],
                [50, 56.746633122658444],
                [51, 52.76631598845634],
                [52, 52.3020769891715],
                [53, 50.56370473325533],
                [54, 55.407205992344544],
                [55, 50.49825590435839],
                [56, 52.4975614755482],
                [57, 48.79614749316488],
                [58, 47.46776704767111],
                [59, 43.317880548036456],
                [60, 38.96296121124144],
                [61, 34.73218432559628],
                [62, 31.033700732272116],
                [63, 32.637987000382296],
                [64, 36.89513637594264],
                [65, 35.89701755609185],
                [66, 32.742284578187544],
                [67, 33.20516407297906],
                [68, 30.82094321791933],
                [69, 28.64770271525896],
                [70, 28.44679026902145],
                [71, 27.737654438195236],
                [72, 27.755190738237744],
                [73, 25.96228929938593],
                [74, 24.38197394166947],
                [75, 21.95038772723346],
                [76, 22.08944448751686],
                [77, 23.54611335622507],
                [78, 27.309610481106425],
                [79, 30.276849322378055],
                [80, 27.25409223418214],
            ],
            type: 'bar',
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            axisBorder: {
                show: false
            },
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ["rgba(255, 255, 255,0.1)"],
        tooltip: {
            enabled: false,
        }
    }
    var total = new ApexCharts(document.querySelector("#revenue1"), total);
    total.render();
    /* Revenue */

    /* Revenue */
    var total = {
        chart: {
            height: 100,
            sparkline: {
                enabled: true
            },
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 7,
                left: 0,
                blur: 3,
                color: '#000',
                opacity: 0.2
            },
        },
        plotOptions: {
            bar: {
                columnWidth: '100%'
            }
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: [1.5, 1.5],
            dashArray: [0, 0],
        },
        grid: {
            borderColor: 'transparent',
            padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.1,
                stops: [0, 90, 100],
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "rgba(215, 124, 247, 0.15)",
                            opacity: 1
                        },
                        {
                            offset: 75,
                            color: "rgba(215, 124, 247, 0.15)",
                            opacity: 1
                        },
                        {
                            offset: 100,
                            color: "rgba(215, 124, 247, 0.15)",
                            opacity: 1
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'This Year',
            data: [
                [0, 48.11708650372481],
                [1, 44.83834104995953],
                [2, 45.727409628208974],
                [3, 44.69213146554142],
                [4, 44.92113232835135],
                [5, 44.200874587557415],
                [6, 41.750527715312444],
                [7, 44.84511185791557],
                [8, 46.04672992189592],
                [9, 45.9480092098883],
                [10, 46.9249480823427],
                [11, 43.600609487921346],
                [12, 40.29988975207692],
                [13, 42.03310106988357],
                [14, 39.457750445961125],
                [15, 40.540159797957294],
                [16, 37.277912393740806],
                [17, 41.43887402339309],
                [18, 39.47430428214318],
                [19, 36.91189415889479],
                [20, 36.42847097453014],
                [21, 36.96844325047937],
                [22, 35.54647151074562],
                [23, 32.998974290143025],
                [24, 30.43526314490385],
                [25, 31.14797888879888],
                [26, 27.20589032036549],
                [27, 25.777592542626508],
                [28, 30.052675048145275],
                [29, 30.92837408600937],
                [30, 34.190241658736014],
                [31, 37.57718922878679],
                [32, 41.18083316913268],
                [33, 41.27110666976231],
                [34, 36.33819281943194],
                [35, 37.39239238651191],
                [36, 37.046485292242615],
                [37, 34.594801853250495],
                [38, 31.488044618299227],
                [39, 34.69970813498227],
                [40, 39.66083111892072],
                [41, 40.203292838001616],
                [42, 36.089709320758985],
                [43, 40.31141091738469],
                [44, 44.170004784953846],
                [45, 48.84998014705778],
                [46, 43.93624560052546],
                [47, 40.62473022491363],
                [48, 39.154068738786684],
                [49, 42.803089612673666],
                [50, 40.6511024461858],
                [51, 38.34516630158569],
                [52, 39.546885205159555],
                [53, 42.50715860274628],
                [54, 38.1455129028495],
                [55, 33.87761157196474],
                [56, 37.30125615378047],
                [57, 38.799409423316405],
                [58, 39.185431079286275],
                [59, 43.32737024276462],
                [60, 41.52185070435002],
                [61, 41.613587244137946],
                [62, 44.23763577861365],
                [63, 44.91439321362589],
                [64, 42.18546432611939],
                [65, 41.0624926886062],
                [66, 44.24453261527582],
                [67, 47.34794952778721],
                [68, 48.10833243543891],
                [69, 43.640893412371504],
                [70, 40.614056030997666],
                [71, 42.9374730102888],
                [72, 46.1355421298619],
                [73, 48.995759760197956],
                [74, 52.19926195857424],
                [75, 49.2778849176981],
                [76, 52.46274689069702],
                [77, 56.74969793098863],
                [78, 60.92623317241021],
                [79, 57.70969775380601],
                [80, 57.35168105637668],
            ],
            type: 'area'
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            axisBorder: {
                show: false
            },
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ["rgb(215, 124, 247)"],
        tooltip: {
            enabled: false,
        }
    }
    var total = new ApexCharts(document.querySelector("#revenue"), total);
    total.render();
    /* Revenue */

})();