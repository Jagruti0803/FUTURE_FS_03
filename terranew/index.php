<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: auth.php");
    exit;
}
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About TerraNew</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <link rel="stylesheet" href="https://cdn.lineicons.com/3.0/line-awesome/css/line-awesome.min.css">

    <link rel="stylesheet" href="style.css">

    <style>
        /* =============================
           LOGO SIZE INCREASE (UPDATED FOR BIGGER SIZE)
        ============================= */
        /* This CSS increases the width of the logo to 300px (adjust this value if needed) */
        .logo, .navbar-brand img, .header .logo-container img {
           max-height: 100px !important;
            height:"100";
        }

        /* =============================
           ANIMATIONS 
        ============================= */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn { 
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes slideInLeft { 
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes subtleFloating { 
            0% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0px); }
        }
        
        /* =============================
           GLOBAL + RESET
        ============================= */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #2d2d2d;
            background: #f9fafc;
            scroll-behavior: smooth;
            animation: fadeIn 1s ease-in-out; 
        }

        /* Utility Class for Primary Green */
        .color-primary { color: #2e7d32; }
        .bg-primary-light { background-color: #e8f5e9; }


        /* =============================
           HERO SECTION 
        ============================= */
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            background: linear-gradient(135deg, #1e5631 0%, #2e7d32 100%); 
            color: white; 
            padding: 80px 10%; 
            flex-wrap: wrap; 
            overflow: hidden; 
        }

        .header-content { 
            max-width: 550px; 
            flex: 1 1 50%; 
        }
        
        .header-content h1 { 
            margin: 0; 
            font-size: 3em; 
            font-weight: 800; 
            letter-spacing: -1px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
            animation: slideInLeft 0.8s ease-out; 
        }

        .header-content h1 span {
            display: block;
            font-size: 0.5em;
            font-weight: 400;
            margin-top: 5px;
        }

        .header-content p { 
            font-size: 1.1em; 
            margin: 25px 0; 
            font-weight: 300;
            animation: slideInLeft 0.8s ease-out 0.2s backwards; 
        }

        .header-content .btn { 
            background-color: #a3c48f; 
            color: #1e5631; 
            padding: 12px 28px; 
            border: 2px solid #a3c48f;
            border-radius: 50px; 
            cursor: pointer; 
            font-size: 1em; 
            font-weight: 700; 
            transition: all 0.3s ease-in-out; 
            text-transform: uppercase;
            animation: slideInUp 0.8s ease-out 0.4s backwards; 
        }

        .header-content .btn:hover { 
            background-color: #fff; 
            color: #1e5631; 
            transform: translateY(-2px); 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .header img { 
            max-width: 450px; 
            height: auto; 
            border-radius: 15px; 
            flex: 1 1 40%; 
            object-fit: cover;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3); 
            animation: slideInUp 1s ease-out 0.2s backwards, subtleFloating 4s ease-in-out infinite alternate; 
        }

        /* =============================
           STATS/CARDS SECTION
        ============================= */
        .content { 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 80px 20px; 
            text-align: center; 
        }

        .why-recycle { 
            margin: 0; 
        }
        
        .why-recycle h2 { 
            color: #1e5631; 
            font-size: 2.2rem; 
            font-weight: 700;
            margin-bottom: 20px; 
            animation: scaleIn 0.8s ease-out; 
        }

        .why-recycle p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 40px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            animation: fadeIn 1s ease-out 0.2s backwards; 
        }

        .why-recycle .cards { 
            display: flex; 
            justify-content: center; 
            gap: 30px; 
            flex-wrap: wrap; 
            margin-top: 30px; 
        }

        .card { 
            background-color: #fff; 
            border: 1px solid #e0e0e0;
            padding: 30px 20px; 
            width: 250px; 
            border-radius: 12px; 
            font-weight: 600; 
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            /* Initial state for staggered animation */
            opacity: 0;
            transform: scale(0.9);
        }

        .card:nth-child(1) { animation: slideInUp 0.6s ease-out 0.3s forwards; } 
        .card:nth-child(2) { animation: slideInUp 0.6s ease-out 0.5s forwards; }
        .card:nth-child(3) { animation: slideInUp 0.6s ease-out 0.7s forwards; }
        .card:nth-child(4) { animation: slideInUp 0.6s ease-out 0.9s forwards; }

        .card:hover { 
            transform: translateY(-8px) scale(1.02); 
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-color: #2e7d32;
        }
        
        .card strong {
            display: block;
            font-size: 1.8em; 
            color: #2e7d32;
            margin-bottom: 5px;
            font-weight: 800;
        }
        
        .card p {
            font-size: 0.9em;
            color: #555;
            font-weight: 400;
            line-height: 1.4;
            margin: 0;
        }
        
        .card i {
            font-size: 2em;
            color: #2e7d32;
            margin-bottom: 10px;
            display: block;
        }


        /* =============================
           RESPONSIVE 
        ============================= */
        @media (max-width: 992px) { 
            .header { 
                flex-direction: column; 
                text-align: center; 
                padding: 60px 5%;
            } 
            .header img { 
                margin-top: 30px; 
                max-width: 80%; 
            } 
            /* Reset hero text animations on small screens to standard slideUp */
            .header-content h1, .header-content p, .header-content .btn {
                animation: slideInUp 0.8s ease-out !important; 
            }
            .header-content h1 { animation-delay: 0s !important; }
            .header-content p { animation-delay: 0.2s !important; }
            .header-content .btn { animation-delay: 0.4s !important; }
        }
        
        @media (max-width: 576px) { 
            .header-content h1 { 
                font-size: 2rem; 
            } 
            .header-content p { 
                font-size: 1em; 
            } 
            .why-recycle .cards { 
                gap: 20px;
            }
            .card { 
                width: 90%; 
                max-width: 300px;
            } 
        }

    </style>
</head>
<body>

    <div class="header">
        <div class="header-content">
            <h1>Welcome, <?php echo $_SESSION['user_name']; ?> <span>Join the TerraNew Movement 🌍</span></h1>
            <p>Transform Plastic Waste into Sustainable Resources. Join the eco-friendly recycling revolution. Our innovative solutions help reduce environmental impact and create a circular economy for plastic.</p>
            <a href="logout.php" class="btn">Logout</a>
        </div>
        <img src="images/img1.jpg" alt="Plastic recycling conveyor belt">
    </div>

    <div class="content">
        <div class="why-recycle">
            <h2>The TerraNew Impact: Why Recycling Matters</h2>
            <p>Every year, millions of tons of plastic waste threaten our environment. Recycling is not just a solution—it's a massive opportunity for resource recovery and sustainability.</p>
            <div class="cards">
                
                <div class="card">
                    <i class="fas fa-water"></i>
                    <strong>8 Million Tons</strong>
                    <p>Plastic waste enters the world's oceans annually, threatening marine life.</p>
                </div>
                
                <div class="card">
                    <i class="fas fa-globe"></i>
                    <strong>Only 9%</strong>
                    <p>Of all plastic waste ever produced has been recycled globally.</p>
                </div>
                
                <div class="card">
                    <i class="fas fa-bolt"></i>
                    <strong>50% Less</strong>
                    <p>Energy used when producing new products from recycled plastic.</p>
                </div>
                
                <div class="card">
                    <i class="fas fa-clock"></i>
                    <strong>1000+ Years</strong>
                    <p>The average time it takes for plastic to decompose naturally.</p>
                </div>
                
            </div>
        </div>
    </div>
    
    <?php
    include 'footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>