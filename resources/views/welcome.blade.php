<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name','Laravel') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
    <body class="antialiased">
        <div class="container mt-5 mx-auto">
            <div id="chart"></div>
        </div>

        <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js" type="text/javascript"></script>

        <script>
            const chart = LightweightCharts.createChart(document.getElementById('chart'), {
                width: 600,
                height: 300,
                layout: {
                    backgroundColor: '#000000',
                    textColor: 'rgba(255, 255, 255, 0.9)',
                },
                grid: {
                    vertLines: {
                        color: 'rgba(197, 203, 206, 0.5)',
                    },
                    horzLines: {
                        color: 'rgba(197, 203, 206, 0.5)',
                    },
                },
                crosshair: {
                    mode: LightweightCharts.CrosshairMode.Normal,
                },
                rightPriceScale: {
                    visible: false
                },
                leftPriceScale: {
                    visible: true,
                    borderColor: 'rgba(197, 203, 206, 0.8)',
                    textColor: 'rgba(255, 255, 255, 0.9)',
                },
                timeScale: {
                    borderColor: 'rgba(197, 203, 206, 0.8)',
                },
            });

            @php($stock = \App\Models\Stock::with('histories')->find(3))

            const stockData = @json($stock->histories);

            const formattedData = stockData.map(h => {
                return {
                    open: h.open,
                    high: h.high,
                    low: h.low,
                    close: h.close,
                    time: h.date,
                }
            }).sort((a, b) => {
                return Date.parse(a.time) - Date.parse(b.time)
            })
            console.log(formattedData)

            const candlestickSeries = chart.addCandlestickSeries({ priceScaleId: 'left' });
            candlestickSeries.setData(formattedData);
        </script>
    </body>
</html>
