<!DOCTYPE html>
<html>
<head>
    <title> Website</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 30px;
        }

        li a {
            display: block;
            padding: 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        li a:hover {
            background-color: #45a049;
        }

        .chart {
            height: 10px;
            background-color: #ddd;
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 5px;
        }

        .chart span {
            display: block;
            height: 100%;
            background-color: #4CAF50;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #888;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1> Website</h1>
        <ul>
            <li>
                <a href="toevoegen_klant.php">Toevoegen Klant</a>
                <div class="chart" style="width: 60%"></div>
            </li>
            <li>
                <a href="inkooporder.php">Inkooporder</a>
                <div class="chart" style="width: 80%"></div>
            </li>
            <li>
                <a href="verkooporder.php">Verkooporder</a>
                <div class="chart" style="width: 40%"></div>
            </li>
            <li>
                <a href="artikel_inzien.php">Artikelen Inzien</a>
                <div class="chart" style="width: 70%"></div>
            </li>
            <li>
                <a href="verkooporder_inzien.php">Verkooporder Inzien</a>
                <div class="chart" style="width: 50%"></div>
            </li>
            <li>
                <a href="inkooporder.php">Inkooporder</a>
                <div class="chart" style="width: 30%"></div>
            </li>
            <li>
                <a href="orderstatusbijwerken.php">Orderstatus Bijwerken</a>
                <div class="chart" style="width: 90%"></div>
            </li>
            <li>
                <a href="klantid finder.php">klantid finder</a>
                <div class="chart" style="width: 75%"></div>
            </li>
            <li>
                <a href="verwijderen.php">Verwijderen</a>
                <div class="chart" style="width: 65%"></div>
            </li>
            <li>
                <a href="verwijderen2.php">Verwijderen2</a>
                <div class="chart" style="width: 100%"></div>
            </li>
            <li>
                <a href="artikelbijwerken.php">artikelbijwerken</a>
                <div class="chart" style="width: 35%"></div>
            </li>
            <li>
                <a href="bijwerken_klant.php">bijwerken klant</a>
                <div class="chart" style="width: 15%"></div>
            </li>
            <li>
                <a href="verkooporderbijwerken.php">verkooporderbijwerken</a>
                <div class="chart" style="width: 10%"></div>
            </li>
        </ul>
        <footer>&copy; 2023 Best Data Website. All rights reserved.</footer>
    </div>
</body>
</html>
