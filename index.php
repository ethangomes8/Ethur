<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BTS - Ethur</title>
    <link rel="stylesheet" href="public/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f1e5;
            color: #5a3e1b;
            display : flex;
        }
        header {
            background-color: #3e2723;
            color: white;
            padding: 20px;
            text-align: center;
            margin-left: 10px;
        }
        nav {
            background-color: #3e2723;
            color: white;
            width: 200px;
            height: 100vh; 
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        nav ul li {
            margin: 20px 0;
            text-align: center;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            display: block;
            padding: 10px;
        }
        nav ul li a:hover {
            background-color: #5a3e1b;
            border-radius: 5px;
        }
        main {
            margin-left: 150px; 
            padding: 10px;
            padding-top: 50px;
            flex: 1; 
        }
        .banner {
            width : 100%;
            height: auto;
            max-height: 400px;
            object-fit : cover;
            margin-bottom: 20px;
        }

        #production {
            margin: 40px 0;
            text-align: center;
        }

        .production-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .production-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

        #production p {
            max-width: 800px;
            font-size: 16px;
            line-height: 1.6;
            color: #5a3e1b;
            text-align: justify;
        }

        .beer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .beer-item {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .beer-item img {
            max-width: 100%;
            border-radius: 8px;
        }
        .beer-item button {
            background-color: #3e2723;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .contact-form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .contact-form button {
            background-color: #3e2723;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center; 
        }
        .login-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-form button {
            background-color: #3e2723;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .large-button {
            background-color: #3e2723;
            color: white;
            padding: 20px 30px; 
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 20px; 
            margin: 20px 0; 
            width: 100%; 
        }
        .large-button:hover {
            background-color: #5a3e1b;
        }


        footer {
            background-color: #3e2723;
            color: white;
            text-align: center;
            padding: 2px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        @media screen and (max-width: 400px) {
            nav {
                width: 100%;
                position: relative;
            }
            nav ul {
                display: flex;
                justify-content: space-around;
            }
            nav ul li {
                margin: 0;
            }
            main {
                margin-left: 0;
            }
            .banner {
                max-height: 200px;
            }
            
        }

    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="#ap">À propos</a></li>
                <li><a href="#production">Production</a></li>
                <li><a href="#beer-grid">Nos Bières</a></li>
                <li><a href="#contact-form">Contact</a></li>
                <li><a href="#login-form">Connexion</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="ap">
            <h1>Brasserie Ethur</h1>
            <img src="public/images/banniere.jpg" alt="Bannière" class="banner">
            <h2>Bienvenue sur Brasserie Terroir & Savoirs</h2>
            <p>La brasserie Terroir & Savoir Ethur est née de l'amour fou des bières de deux étudiants Lillois, 3 gammes de prduits sont aujourd'hui disponibles à l'achat découvrez les mainteannt ci dessous ! </p>
        </section>

        <section id="production">
            <h2>Notre Production</h2>
            <div class="production-content">
                <img src="public/images/chaine.jpg" alt="Chaînes de production" class="production-image">
                <p>Découvrez nos chaînes de production modernes et respectueuses de l'environnement Chaque étape de fabrication est réalisée avec soin pour garantir une qualité exceptionnelle à nos bières artisanales
                </p>
            </div>
        </section>

        <section>
            <h2>Nos Bières</h2>
            <div class="beer-grid" id="beer-grid">
                <div class="beer-item">
                    <img src="public/images/blonde.png" alt="Bière 1">
                    <h3>Bière Blonde</h3>
                    <p>Une bière blonde légère et rafraîchissante</p>
                    <p>Prix : 4€</p>
                    <button>Acheter</button>
                </div>
                <div class="beer-item">
                    <img src="public/images/brune.webp" alt="Bière 2">
                    <h3>Bière Brune</h3>
                    <p>Une bière riche avec des notes de café et chocolat</p>
                    <p>Prix : 5€</p>
                    <button>Acheter</button>
                </div>
                <div class="beer-item">
                    <img src="public/images/rouge2.jpg" alt="Bière 3">
                    <h3>Bière Rouge</h3>
                    <p>Une bière fruité avec des notes de framboise</p>
                    <p>Prix : 6€</p>
                    <button>Acheter</button>
                </div>
            </div>
        </section>
        <section>
            <h2>Contactez-nous</h2>
            <div class="contact-form" id="contact-form">
                <form action="contact.php" method="POST">
                    <input type="text" name="nom" placeholder="Votre nom" required>
                    <input type="email" name="email" placeholder="Votre email" required>
                    <textarea name="message" placeholder="Votre message" required></textarea>
                    <button type="submit">Envoyer</button>
                </form>
            </div>
        </section>
        <section>
            <h2>Connexion</h2>
            <div class="login-form" id="login-form">
                <form action="connexion.php" method="GET">
                    <button type="submit" name="action" value="login" class="large-button">Me connecter !</button>
                    <button type="submit" name="action" value="register" class="large-button">M'inscrire !</button>
                </form>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Ethur - Tous droits réservés.</p>
    </footer>
</body>
</html>