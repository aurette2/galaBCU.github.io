<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Style général */
        body {
            background-color: #002147; /* Bleu nuit */
            color: #FFD700; /* Or */
            font-family: 'Arial', sans-serif;
        }

        /* Navbar */
        .navbar-dark .navbar-brand {
            color: #FFD700; /* Or */
        }

        .navbar-dark .nav-link {
            color: #FFD700; /* Or */
        }

        .navbar-dark .nav-link:hover {
            color: #e6b800; /* Or plus foncé */
        }

        /* Section Accueil */
        .container h1 {
            margin-top: 100px;
            font-size: 3rem;
            font-weight: bold;
        }

        .container p {
            font-size: 1.2rem;
        }

        .btn-primary {
            background-color: #FFD700; /* Or */
            color: #002147; /* Bleu nuit */
            border: none;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #e6b800; /* Or légèrement plus foncé */
            color: #001f3f; /* Bleu nuit plus foncé */
        }

        /* Section À propos */
        #about {
            background-color:rgb(4, 53, 101); /* Bleu nuit foncé */
            padding: 50px 20px;
            border-radius: 10px;
            margin-top: 50px;
        }

        #about h2 {
            color: #FFD700; /* Or */
            font-size: 2.5rem;
        }

        #about p {
            color: #fff; /* Blanc */
            font-size: 1.2rem;
        }

        /* Footer */
        footer {
            background-color: #001f3f;
            color: #FFD700;
        }
        .carousel-caption {
            position: absolute; /* Nécessaire pour le placement au-dessus de l'image */
            top: 50%; /* Place le centre verticalement */
            left: 50%; /* Place le centre horizontalement */
            transform: translate(-50%, -50%); /* Ajuste pour centrer exactement */
            background: rgba(0, 0, 0, 0.5); /* Fond semi-transparent */
            padding: 20px;
            border-radius: 10px;
            text-align: center; /* Aligne le texte au centre */

        }

        .carousel-caption h1 {
            font-size: 0.9rem;
            font-weight: bold;
            color: #FFD700; /* Or */
        }

        .carousel-caption p {
            font-size: 1rem;
            color: #fff; /* Blanc */
        }

        .carousel .btn-primary {
            background-color: #FFD700; /* Or */
            color: #002147; /* Bleu nuit */
            border: none;
            font-weight: bold;
        }

        .carousel .btn-primary:hover {
            background-color: #e6b800; /* Or plus foncé */
        }

        .carousel-item img {
            height: 39vh;
            object-fit: cover;
        }
        /* Section des lieux */
        #gala-location-carousel .carousel-item img {
            height: 80vh;
            object-fit: cover;
            border-radius: 10px;
        }

        #gala-location-carousel .carousel-caption {
            background: rgba(0, 0, 0, 0.6);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
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
                        <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
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

    <!-- Section Accueil avec carousel -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/images/slide1.jpg" class="d-block w-100" alt="Gala Image 1">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="text-uppercase">Bienvenue au GALA BCU </h1>
                    <p>Rejoignez-nous pour une soirée exceptionnelle célébrant l'amour et l'humanité.</p>
                    <a href="buy.php" class="btn btn-primary">Acheter un ticket</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/slide2.jpg" class="d-block w-100" alt="Gala Image 2">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="text-uppercase">14 Février 2025</h1>
                    <p>Une soirée mémorable avec un dîner, des prestations artistiques et des surprises.</p>
                    <a href="buy.php" class="btn btn-primary">Acheter un ticket</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/slide3.jpeg" class="d-block w-100" alt="Gala Image 3">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="text-uppercase">Cœurs Unis pour une Humanité Sensible</h1>
                    <p>Un gala pour célébrer l'amour et renforcer les liens humains.</p>
                    <a href="buy.php" class="btn btn-primary">Acheter un ticket</a>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>

    <!-- Section Lieu du Gala -->
    <div id="gala-location" class="container mt-5">
        <h2 class="text-center mb-4">Quelques details en images</h2>
        <div id="gala-location-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/images/img01.png" class="d-block w-100" alt="Lieu 1">
                    <!-- <div class="carousel-caption d-none d-md-block">
                        <p>Un cadre élégant et prestigieux pour une soirée mémorable.</p>
                    </div> -->
                </div>
                <div class="carousel-item">
                    <img src="assets/images/img02.png" class="d-block w-100" alt="Lieu 2">
                    <!-- <div class="carousel-caption d-none d-md-block">
                        <p>Des décors somptueux pour célébrer l'amour.</p>
                    </div> -->
                </div>
                <div class="carousel-item">
                    <img src="assets/images/img03.png" class="d-block w-100" alt="Lieu 3">
                    <!-- <div class="carousel-caption d-none d-md-block">
                        <p>Une ambiance chaleureuse et festive vous attend.</p>
                    </div> -->
                </div>
                <div class="carousel-item">
                    <img src="assets/images/img04.png" class="d-block w-100" alt="Lieu 2">
                    <!-- <div class="carousel-caption d-none d-md-block">
                        <p>Des décors somptueux pour célébrer l'amour.</p>
                    </div> -->
                </div>
                <div class="carousel-item">
                    <img src="assets/images/img05.png" class="d-block w-100" alt="Lieu 3">
                    <!-- <div class="carousel-caption d-none d-md-block">
                        <p>Une ambiance chaleureuse et festive vous attend.</p>
                    </div> -->
                </div>
                <div class="carousel-item">
                    <img src="assets/images/img06.png" class="d-block w-100" alt="Lieu 2">
                    <!-- <div class="carousel-caption d-none d-md-block">
                        <p>Des décors somptueux pour célébrer l'amour.</p>
                    </div> -->
                </div>
                <div class="carousel-item">
                    <img src="assets/images/img07.png" class="d-block w-100" alt="Lieu 3">
                    <!-- <div class="carousel-caption d-none d-md-block">
                        <p>Une ambiance chaleureuse et festive vous attend.</p>
                    </div> -->
                </div>
                <div class="carousel-item">
                    <img src="assets/images/img08.png" class="d-block w-100" alt="Lieu 2">
                    <!-- <div class="carousel-caption d-none d-md-block">
                        <p>Des décors somptueux pour célébrer l'amour.</p>
                    </div> -->
                </div>
                <div class="carousel-item">
                    <img src="assets/images/" class="d-block w-100" alt="Lieu 3">
                    <!-- <div class="carousel-caption d-none d-md-block">
                        <p>Une ambiance chaleureuse et festive vous attend.</p>
                    </div> -->
                </div>
                <div class="carousel-item">
                    <img src="assets/images/" class="d-block w-100" alt="Lieu 2">
                    <!-- <div class="carousel-caption d-none d-md-block">
                        <p>Des décors somptueux pour célébrer l'amour.</p>
                    </div> -->
                </div>
                <div class="carousel-item">
                    <img src="assets/images/" class="d-block w-100" alt="Lieu 3">
                    <!-- <div class="carousel-caption d-none d-md-block">
                        <p>Une ambiance chaleureuse et festive vous attend.</p>
                    </div> -->
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#gala-location-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#gala-location-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    </div>

    <!-- Section À propos -->
    <div id="about" class="container mt-5" style="max-width: 800px; margin: 0 auto;">
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
        <p>
            Rejoignez-nous le <strong>14 février 2025</strong> pour une soirée mémorable. 
            Le Gala "Berceau des Cœurs Unis" célèbrera l'amour et renforcera notre humanité à travers 
            un dîner de gala savoureux, des prestations artistiques de renom, et un concours de déclaration d'amour.
        </p>
    <!-- <p class="text-center">Nous organisons un événement spécial pour célébrer la Saint-Valentin. <br>Venez profiter d'une soirée inoubliable avec des activités, des spectacles et bien plus encore !</p> -->
</div>

<!-- Social Media Section -->
<div id="contact" class="container mt-5">
    <h2 class="text-center mb-4">Suivez-nous sur nos réseaux sociaux</h2>
    <div class="row text-center">
        <div class="col-4">
            <a href="https://www.facebook.com/" target="_blank" class="text-decoration-none">
                <i class="fab fa-facebook-square fa-3x" style="color: #1877f2;"></i>
                <p style="color: #fff;">Facebook</p>
            </a>
        </div>
        <div class="col-4">
            <a href="https://www.tiktok.com/@eventjoy.gala" target="_blank" class="text-decoration-none">
                <i class="fab fa-tiktok fa-3x" style="color: #000;"></i>
                <p style="color: #fff;" >TikTok</p>
            </a>
        </div>
        <div class="col-4">
            <a href="mailto:eventjoy.gala@gmail.com" target="_blank" class="text-decoration-none">
                <i class="fas fa-envelope fa-3x" style="color: #FFD700;"></i>
                <p style="color: #fff;" >Email</p>
            </a>
        </div>
    </div>
</div>

<br><br>

    <!-- Footer -->
    <footer class="text-center py-3">
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. Tous droits réservés.</p>
    </footer>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
