<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Design</title>
</head>
<style>
    /* Global Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(135deg, palevioletred, #ffb6c1, #eeb9c1); /* Palevioletred to White Gradient */
        background-size: 400% 400%;
        animation: gradientFlow 15s ease infinite;
        color: #333333; /* Darker text for contrast */
        height: 100vh;
        overflow: hidden;
    }

    /* Keyframes for smooth flowing gradient background */
    @keyframes gradientFlow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 50px;
    }

    nav .logo img {
        width: 50px;
    }

    nav .nav-links {
        list-style: none;
        display: flex;
        gap: 30px;
    }

    nav .nav-links li a {
        color: #333333; /* Dark text for nav links */
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease, text-shadow 0.3s ease;
    }

    nav .nav-links li a:hover {
        color: palevioletred; /* Palevioletred glow on hover */
        text-shadow: 0 0 15px palevioletred, 0 0 30px rgba(219, 112, 147, 0.5);
    }

    .hero {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        height: 100%;
        position: relative;
    }

    .hero-text h1 {
        font-size: 64px;
        font-weight: bold;
        margin-bottom: 20px;
        max-width: 600px;
        color: white; /* Palevioletred for main title */
        text-shadow: 2px 2px 20px rgba(219, 112, 147, 0.5);
    }

    .hero-text p {
        font-size: 20px;
        color: white; /* Darker gray for description */
        max-width: 500px;
        margin-bottom: 40px;
    }

    .cta-btn {
        background-color: palevioletred; /* Palevioletred button */
        color: #ffffff;
        padding: 15px 30px;
        border: none;
        border-radius: 30px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.5s ease, box-shadow 0.5s ease;
        box-shadow: 0 4px 10px rgba(219, 112, 147, 0.4);
    }

    .cta-btn:hover {
        background-color: #db7093; /* Slightly darker pink on hover */
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(219, 112, 147, 0.6);
    }

    .background-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(219, 112, 147, 0.6) 10%, rgba(255, 182, 193, 0.4) 40%, rgba(255, 255, 255, 0.3) 100%);
        z-index: -1;
        clip-path: circle(70% at 50% 50%);
    }

</style>
<body>
    <!-- Main Hero Section -->
    <section class="hero">
        <div class="hero-text">
            <h1>FashionFix</h1>
            <p>"Style is a way to say who you are without having to speak"</p>
            <form action="" method="post">
            <button type="submit" name="submit" class="cta-btn" id="hireBtn">Let's shop</button>
            </form>
        </div>
        <div class="background-shapes"></div>
    </section>
    <?php
        if(isset($_POST['submit'])){
            header('location:customers/custmrdshbrd.php');        }
    ?>
    
</body>
</html>
