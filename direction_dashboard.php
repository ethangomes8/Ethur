<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passerelle de Gestion - Bilan Financier et Commercial</title>
    <link rel="stylesheet" href="public/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f1e5;
            color: #3e2723; 
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
        }

        .passerelle-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin-top: 20px;
            text-align: center;
        }

        h2 {
            color: #3e2723; 
            text-align: center;
        }

        button {
            background-color: #3e2723; 
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin: 10px 0;
        }

        button:hover {
            background-color: #5a3e1b;
        }
    </style>
</head>
<body>
    <h2>Passerelle de Gestion des Bilans</h2>

    <div class="passerelle-container">
        <p>Choisissez le bilan que vous souhaitez consulter :</p>
        <button onclick="window.location.href='finance.php'">Bilan Financier</button>
        <button onclick="window.location.href='Commercial.php'">Bilan Commercial</button>
        <br><br>
        <button onclick="window.location.href='logout.php'">Deconnexion</button>
    </div>
</body>
</html>