@extends('template.layout')

@section('titulo', 'Estatística')

@section('main')

<br>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-20">
    
            <div class="card" style="">
                <div class="card-header bg-dark text-light" style="font-size: 22px;">Users</div>
                <div class="card-body" style="font-size: 20px;">
                    <p>Total Active User Count: {{ $userCount }}</p>

                    <canvas id="userTypeChart"></canvas>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        var userTypes = {!! json_encode($userTypes) !!};
                        var userTypeCounts = {!! json_encode($userTypeCounts) !!};

                        var ctx = document.getElementById('userTypeChart').getContext('2d');
                        var userTypeChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: userTypes,
                                datasets: [{
                                    label: 'User By Type',
                                    data: userTypes.map(type => userTypeCounts[type] || 0),
                                    backgroundColor: [
                                        'rgba(255, 255, 0, 1)',
                                        'rgba(153, 255, 102, 1)',
                                        'rgba(0, 102, 255, 1)'
                                        ],
                                    borderColor:  [
                                        'rgba(255, 255, 0, 1)',
                                        'rgba(153, 255, 102, 1)',
                                        'rgba(0, 102, 255, 1)'
                                        ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        precision: 0
                                    }
                                }
                            }
                        });
                    </script>


                </div>
            </div>

            <br>

            <div class="card">
                <div class="card-header bg-dark text-light" style="font-size: 22px;">Orders By Status</div>
                <div class="card-body" style="font-size: 20px; content-align: center; display: flex; justify-content: center; align-items: center;">

                <div style="width: 600px; height: 600px; ">
                    <canvas id="orderChart"></canvas>
                </div>

                <script>
                    var ordersByType = {!! $ordersByStatus !!};

                    var labels = ordersByType.map(order => order.status);
                    var data = ordersByType.map(order => order.count);

                    var ctx = document.getElementById('orderChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: data,
                                backgroundColor: [
                                        'rgba(0, 255, 0, 1)',
                                        'rgba(255, 51, 0, 1)',
                                        'rgba(0, 102, 255, 1)',
                                        'rgba(153, 255, 102, 1)'
                                        ],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true
                        }
                    });
                </script>

                </div>
            </div>

        </div>
    </div>
</div>


@endsection