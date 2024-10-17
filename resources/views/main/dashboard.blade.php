<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dashboard</title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        
        <!-- CSS FILES -->      
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;700&display=swap" rel="stylesheet">

        <link href="css/bootstrap.min.css" rel="stylesheet"> 

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/apexcharts.css" rel="stylesheet">

        <link href="css/tooplate-mini-finance.css" rel="stylesheet">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </head>
    
    <body>

        @include('navbar.header')

        <div class="container-fluid">
            <div class="row">
            
            @extends('navbar.sidenav')

                <main class="main-wrapper col-md-9 ms-sm-auto py-4 col-lg-9 px-md-4 border-start">
                    <div class="title-group mb-3">
                        <h1 class="h2 mb-0">Overview</h1>

                        <small class="text-muted">Hello {{ Auth::user()->name }}, welcome back!</small>
                    </div>

                    <div class="row my-4">
                        <div class="col-lg-7 col-12">
                            <div class="custom-block custom-block-balance">
                                <small>Your Account Balance</small>

                               
                                <a href="{{ route('budget.index')}}"><h2 class="mt-2 mb-3">RM {{ $balance }}</h2></a>
                                


                                <div class="custom-block-numbers d-flex align-items-center">
                                </div>

                                <div class="d-flex">
                                    <div>
                                        <small>Valid Date</small>
                                        <p>12/2028</p>
                                    </div>

                                    <div class="ms-auto">
                                        <small>Card Holder</small>
                                        <p>{{ Auth::user()->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="custom-block bg-white" style="margin-bottom:0px;">
                                <h5 class="mb-2">Spending History by Category</h5>

                                <div id="pie-chart"></div>
                            </div>


                        </div>

                        <div class="col-lg-5 col-12">

                            <div class="custom-block custom-block-transactions">
                                <h6 class="mb-4">Recent Transactions</h6>

                                @foreach($latestTransactions as $transaction)
                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <!-- Transaction details -->
                                                <p class="mb-0">{{ $transaction->title }}</p>
                                                <small class="text-muted">
                                                    {{ $transaction->category->name }} - 
                                                    RM {{ $transaction->amount }} - 
                                                    {{ $transaction->date->format('d M, Y') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="border-top pt-4 mt-4 text-center">
                                    <a class="btn custom-btn" href="{{ route('expenses.index') }}">
                                        View all transactions
                                        <i class="bi-arrow-up-right-circle-fill ms-2"></i>
                                    </a>
                                </div>
                            </div>

                        </div>

                        <div style="display: flex; justify-content: space-between;">
                            <div class="custom-block primary-bg">
                                <a href="{{ route('apparel.index')}}" >
                                    <h5 class="text-white mb-4">Total Apparel</h5>
                                    <p class="text-white" style="font-weight:bold; text-align:center;">{{ number_format($totalApparelCount) }}</p>
                                </a>
                            </div>

                            <div class="custom-block custom-block-exchange">
                                <a href="{{ route('event.index')}}" >
                                    <h5 class="mb-4">Total Event</h5>
                                    <p class="text-black" style="font-weight:bold; text-align:center;">{{ number_format($totalEventCount) }}</p>
                                </a>
                            </div>

                            <div class="custom-block primary-bg">
                                <a href="{{ route('budget.index')}}" >
                                    <h5 class="text-white mb-4">Total Spending</h5>
                                    <p class="text-white" style="font-weight:bold; text-align:center;">RM {{ number_format($totalSpendingCount) }}</p>
                                </a>
                            </div>
                        </div>


                        <div class="custom-block bg-white" style="padding-top:0px;">
                            <h5 class="mb-3">Spending History every Month</h5>
                            <canvas id="chart"></canvas>
                            </div>
                    </div>

                    <footer class="site-footer">
                        <div class="container">
                            <div class="row">
                                
                                <div class="col-lg-12 col-12">
                                    <p class="copyright-text">Copyright © Daily Me 2024 </p>
                                </div>

                            </div>
                        </div>
                    </footer>
                </main>

            </div>
        </div>

        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>


        <script>
    // Pie chart for spending by category
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawPieChart);

    function drawPieChart() {
        var data = google.visualization.arrayToDataTable([
            ['Category', 'Total Spent (RM)'],
            @foreach($chartDataCategory as $data)
                ['{{ $data['category'] }}',{{ $data['total_spent'] }}],
            @endforeach
        ]);

        var options = {
            title: 'Spending by Category',
            pieHole: 0.4,
            width: '100%',
            height: 400
        };

        var chart = new google.visualization.PieChart(document.getElementById('pie-chart'));
        chart.draw(data, options);
    }

    // Bar chart for spending by month
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('chart').getContext('2d');

        var chartData = @json($chartDataMonth);
        
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.months,
                datasets: [{
                    label: 'Total Spent RM',
                    data: chartData.totalSpent,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Spent'
                        }
                    }
                }
            }
        });
    });
</script>


    </body>
</html>