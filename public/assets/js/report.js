window.onload = function() {
if ($('#canvas-1').length) {
    var ctx = $('#canvas-1');
    window.myBar = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['3/25/2019', '3/26/2019'],
            datasets: [{
                type: 'bar',
                label: 'Số lượng TT',
                backgroundColor: 'rgb(54, 162, 235)',
                yAxisID: 'y-axis-1',
                data: [200,1350]
            }, {
                type: 'bar',
                label: 'Số lượng KH',
                backgroundColor: 'rgb(255, 159, 64)',
                yAxisID: 'y-axis-1',
                data: [220,840]
            }]
        },
        options: {
            responsive: true,
            title: {
                display: false,
                text: 'Biểu đồ so sánh kế hoạch và thực tế'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                enabled: false
            },
            animation: {
                onComplete: function () {
                    var ctx = this.chart.ctx;
                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';
                    ctx.fillStyle = "#fff";
                    this.data.datasets.forEach(function (dataset)
                    {
                        for (var i = 0; i < dataset.data.length; i++) {
                            for(var key in dataset._meta)
                            {
                                var model = dataset._meta[key].data[i]._model;
                                ctx.fillText(dataset.data[i], model.x, (model.y + 25));
                            }
                        }
                    });
                }
            },
            scales: {
                yAxes: [{
                    type: 'linear',
                    display: true,
                    position: 'left',
                    id: 'y-axis-1',
                    ticks: {
                        beginAtZero: true,
                        suggestedMax: 2000
                    }
                }],
            }
        }
    });
}
if ($('#canvas-2').length) {
    var ctx = $('#canvas-2');
    window.myBar = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['3/25/2019', '3/26/2019','3/27/2019', '3/28/2019'],
            datasets: [{
                type: 'line',
                label: 'Số lượng TT',
                borderWidth: 2,
                borderColor: 'rgb(255, 205, 86)',
                backgroundColor: 'rgb(54, 162, 235)',
                yAxisID: 'y-axis-1',
                fill: false,
                data: [200,450,150,750]
            }, {
                type: 'line',
                label: 'Số lượng KH',
                borderWidth: 2,
                borderColor: 'rgb(201, 203, 207)',
                backgroundColor: 'rgb(255, 159, 64)',
                yAxisID: 'y-axis-1',
                fill: false,
                data: [120,240,310,840]
            }]
        },
        options: {
            responsive: true,
            title: {
                display: false,
                text: 'Biểu đồ so sánh kế hoạch và thực tế'
            },
            tooltips: {
                mode: 'index',
                intersect: true,
                enabled: false
            },
            animation: {
                onComplete: function () {
                    var ctx = this.chart.ctx;
                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';
                    ctx.fillStyle = "#444";
                    this.data.datasets.forEach(function (dataset)
                    {
                        for (var i = 0; i < dataset.data.length; i++) {
                            for(var key in dataset._meta)
                            {
                                var model = dataset._meta[key].data[i]._model;
                                ctx.fillText(dataset.data[i], model.x, model.y);
                            }
                        }
                    });
                }
            },
            scales: {
                yAxes: [{
                    type: 'linear',
                    display: true,
                    position: 'left',
                    id: 'y-axis-1',
                    ticks: {
                        beginAtZero: true,
                        suggestedMax: 900
                    }
                }],
            }
        }
    });
}
if ($('#canvas-3').length) {
        var ctx = $('#canvas-3');
        window.myHorizontalBar = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ['3/25/2019', '3/26/2019'],
                datasets: [{
                    label: 'Số lượng TT',
                    backgroundColor: 'rgb(54, 162, 235)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1,
                    data: [200,1350]
                }, {
                    label: 'Số lượng KH',
                    backgroundColor: 'rgb(255, 159, 64)',
                    borderColor: 'rgb(255, 159, 64)',
                    data: [220,840]
                }]

            },
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                legend: {
                    position: 'right',
                },
                title: {
                    display: false,
                    text: 'Chart.js Horizontal Bar Chart'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    enabled: false
                },
                animation: {
                    onComplete: function () {
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.fillStyle = "#fff";
                        this.data.datasets.forEach(function (dataset)
                        {
                            for (var i = 0; i < dataset.data.length; i++) {
                                for(var key in dataset._meta)
                                {
                                    var model = dataset._meta[key].data[i]._model;
                                    ctx.fillText(dataset.data[i], (model.x - 15), (model.y + 8));
                                }
                            }
                        });
                    }
                }
            }
        });
    }
if ($('#canvas-4').length) {
    var ctx = $('#canvas-4');
    window.myBar = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['3/25/2019', '3/26/2019'],
            datasets: [{
                data: [67, 33],
                backgroundColor: ['rgb(255, 159, 64)', 'rgb(54, 162, 235)']
            }]
        },
        options: {
            responsive: true
        }
    });
}
// Chart Product Chanel
    if ($('#product-canvas-1').length) {
        var ctx = $('#product-canvas-1');
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['3/25/2019', '3/26/2019'],
                datasets: [{
                    type: 'bar',
                    label: 'Số lượng TT',
                    backgroundColor: 'rgb(54, 162, 235)',
                    yAxisID: 'y-axis-1',
                    data: [200,350]
                }, {
                    type: 'bar',
                    label: 'Số lượng KH',
                    backgroundColor: 'rgb(255, 159, 64)',
                    yAxisID: 'y-axis-1',
                    data: [220,840]
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: false,
                    text: 'Biểu đồ so sánh kế hoạch và thực tế'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    enabled: false
                },
                legend: {
                    position: 'right',
                },
                animation: {
                    onComplete: function () {
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.fillStyle = "#fff";
                        this.data.datasets.forEach(function (dataset)
                        {
                            for (var i = 0; i < dataset.data.length; i++) {
                                for(var key in dataset._meta)
                                {
                                    var model = dataset._meta[key].data[i]._model;
                                    ctx.fillText(dataset.data[i], model.x, (model.y + 25));
                                }
                            }
                        });
                    }
                },
                scales: {
                    yAxes: [{
                        type: 'linear',
                        display: true,
                        position: 'left',
                        id: 'y-axis-1',
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                }
            }
        });
    }
    if ($('#product-canvas-2').length) {
        var ctx = $('#product-canvas-2');
        window.myBar = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['3/25/2019', '3/26/2019','3/27/2019', '3/28/2019'],
                datasets: [{
                    type: 'line',
                    label: 'Số lượng TT',
                    borderWidth: 2,
                    borderColor: 'rgb(255, 205, 86)',
                    backgroundColor: 'rgb(54, 162, 235)',
                    yAxisID: 'y-axis-1',
                    fill: false,
                    data: [200,450,150,750]
                }, {
                    type: 'line',
                    label: 'Số lượng KH',
                    borderWidth: 2,
                    borderColor: 'rgb(201, 203, 207)',
                    backgroundColor: 'rgb(255, 159, 64)',
                    yAxisID: 'y-axis-1',
                    fill: false,
                    data: [120,240,310,840]
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: false,
                    text: 'Biểu đồ so sánh kế hoạch và thực tế'
                },
                tooltips: {
                    mode: 'index',
                    intersect: true,
                    enabled: false
                },
                animation: {
                    onComplete: function () {
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.fillStyle = "#444";
                        this.data.datasets.forEach(function (dataset)
                        {
                            for (var i = 0; i < dataset.data.length; i++) {
                                for(var key in dataset._meta)
                                {
                                    var model = dataset._meta[key].data[i]._model;
                                    ctx.fillText(dataset.data[i], model.x, model.y);
                                }
                            }
                        });
                    }
                },
                scales: {
                    yAxes: [{
                        type: 'linear',
                        display: true,
                        position: 'left',
                        id: 'y-axis-1',
                        ticks: {
                            beginAtZero: true,
                            suggestedMax: 900
                        }
                    }],
                }
            }
        });
    }
    if ($('#product-canvas-3').length) {
        var ctx = $('#product-canvas-3');
        window.myHorizontalBar = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ['3/25/2019', '3/26/2019'],
                datasets: [{
                    label: 'Số lượng TT',
                    backgroundColor: 'rgb(54, 162, 235)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1,
                    data: [200,1350]
                }, {
                    label: 'Số lượng KH',
                    backgroundColor: 'rgb(255, 159, 64)',
                    borderColor: 'rgb(255, 159, 64)',
                    data: [220,840]
                }]

            },
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                legend: {
                    position: 'right',
                },
                title: {
                    display: false,
                    text: 'Chart.js Horizontal Bar Chart'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    enabled: false
                },
                animation: {
                    onComplete: function () {
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.fillStyle = "#fff";
                        this.data.datasets.forEach(function (dataset)
                        {
                            for (var i = 0; i < dataset.data.length; i++) {
                                for(var key in dataset._meta)
                                {
                                    var model = dataset._meta[key].data[i]._model;
                                    ctx.fillText(dataset.data[i], (model.x - 15), (model.y + 8));
                                }
                            }
                        });
                    }
                }
            }
        });
    }
    if ($('#product-canvas-4').length) {
        var ctx = $('#product-canvas-4');
        window.myBar = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['3/25/2019', '3/26/2019'],
                datasets: [{
                    data: [67, 33],
                    backgroundColor: ['rgb(255, 159, 64)', 'rgb(54, 162, 235)']
                }]
            },
            options: {
                responsive: true
            }
        });
    }
// Chart Hourly
// Chart Product Chanel
    if ($('#hourly-canvas-1').length) {
        var ctx = $('#hourly-canvas-1');
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['3/25/2019', '3/26/2019'],
                datasets: [{
                    type: 'bar',
                    label: 'Số lượng TT',
                    backgroundColor: 'rgb(54, 162, 235)',
                    yAxisID: 'y-axis-1',
                    data: [200,350]
                }, {
                    type: 'bar',
                    label: 'Số lượng KH',
                    backgroundColor: 'rgb(255, 159, 64)',
                    yAxisID: 'y-axis-1',
                    data: [220,840]
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: false,
                    text: 'Biểu đồ so sánh kế hoạch và thực tế'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    enabled: false
                },
                legend: {
                    position: 'right',
                },
                animation: {
                    onComplete: function () {
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.fillStyle = "#fff";
                        this.data.datasets.forEach(function (dataset)
                        {
                            for (var i = 0; i < dataset.data.length; i++) {
                                for(var key in dataset._meta)
                                {
                                    var model = dataset._meta[key].data[i]._model;
                                    ctx.fillText(dataset.data[i], model.x, (model.y + 25));
                                }
                            }
                        });
                    }
                },
                scales: {
                    yAxes: [{
                        type: 'linear',
                        display: true,
                        position: 'left',
                        id: 'y-axis-1',
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                }
            }
        });
    }
    if ($('#hourly-canvas-2').length) {
        var ctx = $('#hourly-canvas-2');
        window.myBar = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['3/25/2019', '3/26/2019','3/27/2019', '3/28/2019'],
                datasets: [{
                    type: 'line',
                    label: 'Số lượng TT',
                    borderWidth: 2,
                    borderColor: 'rgb(255, 205, 86)',
                    backgroundColor: 'rgb(54, 162, 235)',
                    yAxisID: 'y-axis-1',
                    fill: false,
                    data: [200,450,150,750]
                }, {
                    type: 'line',
                    label: 'Số lượng KH',
                    borderWidth: 2,
                    borderColor: 'rgb(201, 203, 207)',
                    backgroundColor: 'rgb(255, 159, 64)',
                    yAxisID: 'y-axis-1',
                    fill: false,
                    data: [120,240,310,840]
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: false,
                    text: 'Biểu đồ so sánh kế hoạch và thực tế'
                },
                tooltips: {
                    mode: 'index',
                    intersect: true,
                    enabled: false
                },
                animation: {
                    onComplete: function () {
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.fillStyle = "#444";
                        this.data.datasets.forEach(function (dataset)
                        {
                            for (var i = 0; i < dataset.data.length; i++) {
                                for(var key in dataset._meta)
                                {
                                    var model = dataset._meta[key].data[i]._model;
                                    ctx.fillText(dataset.data[i], model.x, model.y);
                                }
                            }
                        });
                    }
                },
                scales: {
                    yAxes: [{
                        type: 'linear',
                        display: true,
                        position: 'left',
                        id: 'y-axis-1',
                        ticks: {
                            beginAtZero: true,
                            suggestedMax: 900
                        }
                    }],
                }
            }
        });
    }
    if ($('#hourly-canvas-3').length) {
        var ctx = $('#hourly-canvas-3');
        window.myHorizontalBar = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ['3/25/2019', '3/26/2019'],
                datasets: [{
                    label: 'Số lượng TT',
                    backgroundColor: 'rgb(54, 162, 235)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1,
                    data: [200,1350]
                }, {
                    label: 'Số lượng KH',
                    backgroundColor: 'rgb(255, 159, 64)',
                    borderColor: 'rgb(255, 159, 64)',
                    data: [220,840]
                }]

            },
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                legend: {
                    position: 'right',
                },
                title: {
                    display: false,
                    text: 'Chart.js Horizontal Bar Chart'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    enabled: false
                },
                animation: {
                    onComplete: function () {
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.fillStyle = "#fff";
                        this.data.datasets.forEach(function (dataset)
                        {
                            for (var i = 0; i < dataset.data.length; i++) {
                                for(var key in dataset._meta)
                                {
                                    var model = dataset._meta[key].data[i]._model;
                                    ctx.fillText(dataset.data[i], (model.x - 15), (model.y + 8));
                                }
                            }
                        });
                    }
                }
            }
        });
    }
    if ($('#hourly-canvas-4').length) {
        var ctx = $('#hourly-canvas-4');
        window.myBar = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['3/25/2019', '3/26/2019'],
                datasets: [{
                    data: [67, 33],
                    backgroundColor: ['rgb(255, 159, 64)', 'rgb(54, 162, 235)']
                }]
            },
            options: {
                responsive: true
            }
        });
    }
}

    $(document).on('click','.list-group',function(){
        $('body').append('<div class="card-load uk-flex uk-flex-center uk-flex-middle"><div class="card-loader"><i class="feather icon-radio rotate-refresh"></i></div></div>');
        // var  formURL = '/olm-admin-php/public/report/adgroup';
        var formURL = $(this).attr('data-action');
        var postData = $('#filter-data').serializeArray();
        var adgroup_id = $(this).attr('data-id');
        $.post(formURL, {post: postData,adgroup_id :adgroup_id }, function(data){
            $('.card-load.uk-flex').remove();
             $( "#myModal .modal-body" ).html(data);
             $('#myModal').modal('show')
        });
    });

    
    $(document).on('click','#ajax_page .page-link',function(){
        $('body').append('<div class="card-load uk-flex uk-flex-center uk-flex-middle"><div class="card-loader"><i class="feather icon-radio rotate-refresh"></i></div></div>');
        var page = $(this).attr('href');
        var postData = $('#filter-data').serializeArray();
        var url = $('#filter-data1').attr('action');
        $.post(url, {post: postData,page :page }, function(data){
            $('.card-load.uk-flex').remove();
             $( "#myModal .modal-body" ).html(data);
             $('#myModal').modal('show')
        });
        return false;
    });


