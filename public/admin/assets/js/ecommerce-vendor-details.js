// Sales Report
var options = {
    series: [{
        name: "Sales",
        data: [20, 38, 38, 72, 55, 63, 43, 76, 55, 80, 40, 80]
    }],
    chart: {
        height: 245,
        type: 'line',
        zoom: {
            enabled: false
        },
        dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 5,
            left: 0,
            blur: 3,
            color: '#000',
            opacity: 0.1
        },
        toolbar: { show: false }
    },
    dataLabels: {
        enabled: false
    },
    legend: {
        position: "top",
        horizontalAlign: "center",
        offsetX: -15,
        fontWeight: "bold",
    },
    stroke: {
        curve: 'smooth',
        width: '2',
        dashArray: [0, 5],
    },
    grid: {
        borderColor: '#f1f1f1',
        strokeDashArray: 3
    },
    colors: ["var(--primary-color)"],
    yaxis: {
        labels: {
            formatter: function (y) {
                return y.toFixed(0) + "";
            }
        }
    },
    xaxis: {
        type: 'month',
        categories: ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'],
        axisBorder: {
            show: true,
            color: 'rgba(119, 119, 142, 0.05)',
            offsetX: 0,
            offsetY: 0,
        },
        axisTicks: {
            show: true,
            borderType: 'solid',
            color: 'rgba(119, 119, 142, 0.05)',
            width: 6,
            offsetX: 0,
            offsetY: 0
        },
        labels: {
            rotate: -90
        }
    }
};
var chart = new ApexCharts(document.querySelector("#sales-report"), options);
chart.render();
// Sales Report

/* Order Summary */
var options = {
    series: [{
        name: 'Total Orders',
        type: 'column',
        data: [23, 17, 22, 27, 13, 22, 37, 21, 44, 22, 45, 35]
    }, {
        name: 'Delivered Orders',
        type: 'column',
        data: [17, 12, 18, 23, 10, 17, 25, 18, 35, 18, 37, 28]
    }, {
        name: 'Cancelled Orders',
        type: 'line',
        data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43, 27]
    },
    ],
    chart: {
        toolbar: {
            show: false
        },
        height: 362,
        type: 'line',
        stacked: false,
        fontFamily: 'Poppins, Arial, sans-serif',
    },
    grid: {
        borderColor: '#f1f1f1',
        strokeDashArray: 3
    },
    dataLabels: {
        enabled: false
    },
    title: {
        text: undefined,
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    },
    yaxis: [
        {
            show: true,
            axisTicks: {
                show: true,
            },
            axisBorder: {
                show: false,
                color: '#4eb6d0'
            },
            labels: {
                style: {
                    colors: '#4eb6d0',
                }
            },
            title: {
                text: undefined,
            },
            tooltip: {
                enabled: true
            }
        },
        {
            seriesName: 'Projects',
            opposite: true,
            axisTicks: {
                show: true,
            },
            axisBorder: {
                show: false,
            },
            labels: {
                style: {
                    colors: '#00E396',
                }
            },
            title: {
                text: undefined,
            },
        },
        {
            seriesName: 'Revenue',
            opposite: true,
            axisTicks: {
                show: true,
            },
            axisBorder: {
                show: false,
            },
            labels: {
                show: false,
            },
            title: {
                text: undefined,
            }
        },
    ],
    tooltip: {
        enabled: true,
    },
    legend: {
        show: true,
        position: 'top',
        offsetX: 40,
        fontSize: '13px',
        fontWeight: 'normal',
        labels: {
            colors: '#acb1b1',
        },
        markers: {
            width: 10,
            height: 10,
        },
    },
    stroke: {
        width: [2, 2, 1.5],
        curve: 'smooth',
        lineCap: 'round',
        dashArray: [0, 0, 0],
    },
    plotOptions: {
        bar: {
            columnWidth: "40%",
            borderRadius: 2
        }
    },
    colors: ["var(--primary-color)", "var(--primary02)", "rgb(215, 124, 247)"]
};
var chart1 = new ApexCharts(document.querySelector("#order-summary"), options);
chart1.render();
/* Order Summary */