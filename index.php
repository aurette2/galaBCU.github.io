<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        /* General Styles */
        body {
            background-color: #002147; /* Dark Blue */
            color: #FFD700; /* Gold */
            font-family: 'Arial', sans-serif;
        }

        /* Navbar */
        .navbar-dark .navbar-brand {
            color: #FFD700;
        }

        .navbar-dark .nav-link {
            color: #FFD700;
        }

        .navbar-dark .nav-link:hover {
            color: #e6b800;
        }

        /* Welcome Section */
        .welcome-section {
            margin-top: 100px;
            text-align: center;
        }

        .welcome-section h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .welcome-section p {
            font-size: 1.2rem;
        }

        /* About Section */
        #about {
            background-color: #001f3f; /* Darker Blue */
            padding: 50px 20px;
            border-radius: 10px;
            margin-top: 50px;
        }

        #about h2 {
            color: #FFD700;
            font-size: 2.5rem;
        }

        #about p {
            color: #fff; /* White */
            font-size: 1.2rem;
        }

        #about ul {
            color: #fff;
            font-size: 1.1rem;
            margin-top: 20px;
        }

        /* Contact Section */
        .contact .form-control {
            background-color: #001f3f;
            border: 1px solid #FFD700;
            color: #FFD700;
        }

        .contact .form-control:focus {
            background-color: #002147;
            border-color: #FFD700;
            box-shadow: 0 0 5px #FFD700;
        }

        .contact button {
            background-color: #FFD700;
            color: #002147;
            border: none;
            font-weight: bold;
        }

        .contact button:hover {
            background-color: #e6b800;
        }

        /* Footer */
        footer {
            background-color: #001f3f;
            color: #FFD700;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><?= SITE_NAME ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="buy.php">Acheter un ticket</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Welcome Section -->
    <div class="container welcome-section">
        <h1>Bienvenue au <?= SITE_NAME ?></h1>
        <p>
            Rejoignez-nous le <strong>14 février 2025</strong> pour une soirée mémorable. 
            Le Gala "Berceau des Cœurs Unis" célèbrera l'amour et renforcera notre humanité à travers 
            un dîner de gala savoureux, des prestations artistiques de renom, et un concours de déclaration d'amour.
        </p>
        <a href="buy.php" class="btn btn-primary">Acheter un ticket</a>
    </div>

    <!-- About Section -->
    <div id="about" class="container mt-5">
        <h2 class="text-center">À propos de <?= SITE_NAME ?></h2>
        <p class="text-center">
            Le Gala "Berceau des Cœurs Unis" est une initiative de <strong>Event Joy</strong>, filiale de STANISLAS GROUP, spécialisée 
            dans l'organisation d'événements culturels et corporatifs. Notre mission est de célébrer l'amour et de promouvoir 
            une humanité plus unie et engagée.
        </p>
        <ul>
            <li><strong>Date :</strong> 14 février 2025</li>
            <li><strong>Lieu :</strong> À définir</li>
            <li><strong>Prix :</strong> 30 000 FCFA pour un couple, 20 000 FCFA pour un participant solo</li>
            <li><strong>Activités :</strong> Dîner de gala, prestations artistiques, concours de déclaration d'amour, et surprise-party.</li>
        </ul>
    </div>

    <!-- Contact Section -->
    <section id="contact" class="contact mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="info">
                        <div class="address">
                            <h4>Localisation:</h4>
                            <p>AGBOKOU</p>
                        </div>
                        <div class="email">
                            <h4>Email:</h4>
                            <p>info@example.com</p>
                        </div>
                        <div class="phone">
                            <h4>Tel:</h4>
                            <p>+229 01</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Votre Nom" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Votre Email" required>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Objet" required>
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-3">
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. Tous droits réservés.</p>
    </footer>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
