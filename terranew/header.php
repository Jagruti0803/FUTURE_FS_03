<?php
// Start session if not already started
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Count items in cart
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>TerraNew Header</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="style.css">

    <style>
        /* =================================
            0. GLOBAL VARIABLES
        ================================= */
        :root {
            --primary-green: #28a745;       /* Main Accent Color */
            --dark-green: #1d7b34;          /* Darker Hover Color */
            --text-color: #333;             /* Default Text Color */
            --light-bg: #fff;               /* Pure white base for header */
            --header-shadow: rgba(0, 0, 0, 0.1);
            --header-transition: all 0.3s ease-in-out;
            --nav-link-spacing: 1.25rem;    /* Variable for navigation link spacing */
        }

        /* =================================
            1. HEADER BASE & UTILITIES
        ================================= */
        .header-area {
            position: fixed; 
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999;
            background-color: var(--light-bg); 
            backdrop-filter: blur(5px); 
            transition: var(--header-transition);
            padding: 6px 0 !important;
            box-shadow: 0 2px 10px var(--header-shadow);
        }
            .header-area .d-flex {
             padding-top: 0 !important;
             padding-bottom: 0 !important;
        }
        .logo a img {
            max-height: 100px !important; 
            width: auto;
            transition: max-height 0.3s ease; 
        }
        
        .navbar-toggler { border: none; }
        .navbar-toggler .fas {
            background-color: var(--primary-green); 
            padding: 6px;
            border-radius: 5px;
            color: var(--light-bg); 
        }

        /* =================================
            2. NAV LINK ANIMATION (Slide-in Underline - NEW)
        ================================= */
        
        /* Layout and Spacing */
        .navbar-nav {
            display: flex;
            gap: var(--nav-link-spacing); 
        }
        
        /* Base Link Styling */
        .nav-btn-link {
            display: block; 
            padding: 8px 0px !important; /* Reduced vertical padding */
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-color) !important; 
            background-color: transparent !important; 
            border: none !important; /* Removed border */
            transition: color 0.3s ease;
            white-space: nowrap;
            position: relative; /* Essential for the underline */
            overflow: hidden; 
        }
        
        /* The Underline Element */
        .nav-btn-link::before {
            content: '';
            position: absolute;
            bottom: 0; /* Positioned at the bottom of the link */
            left: 0;
            width: 100%;
            height: 2px; /* Thin line for a modern look */
            background-color: var(--primary-green);
            /* Start off the screen to the left */
            transform: translateX(-100%); 
            transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94); 
            z-index: 0; 
        }
        
        /* Hover Effect */
        .nav-btn-link:hover {
            color: var(--dark-green) !important;
            transform: none; /* No lift, just the underline */
            box-shadow: none; /* Removed shadow */
        }

        /* Hover: Slide the underline in from the left */
        .nav-btn-link:hover::before {
            transform: translateX(0); /* Slide across the whole width */
        }

        /* Active State: Keep the underline visible */
        .nav-btn-link.active {
            color: var(--dark-green) !important;
        }

        .nav-btn-link.active::before {
            transform: translateX(0);
        }

        /* =================================
            3. 'GET A QUOTE' BUTTON (Liquid Fill - Kept)
        ================================= */
        .btn-success {
            color: var(--primary-green) !important; 
            background-color: transparent !important;
            border: 2px solid var(--primary-green) !important;
            border-radius: 8px; 
            padding: 8px 20px;
            font-weight: 600;
            position: relative;
            z-index: 1;
            overflow: hidden;
            transition: color 0.4s ease-in-out, transform 0.2s ease;
        }

        .btn-success::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--dark-green);
            transform: scaleY(0); 
            transform-origin: bottom;
            transition: transform 0.4s ease-in-out;
            z-index: -1;
        }

        .btn-success:hover {
            color: var(--light-bg) !important; 
            border-color: var(--dark-green) !important;
            transform: translateY(-2px); 
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
        }
        
        .btn-success:hover::before {
            transform: scaleY(1);
        }
        
        /* =================================
            4. CART ICON ANIMATION (Wiggle/Tada - Kept)
        ================================= */
        .cart-icon-link {
            display: inline-block; 
            color: var(--text-color) !important;
            transition: color 0.3s ease, transform 0.3s ease;
            font-size: 1.25rem; 
        }
        
        @keyframes cartWiggle {
            0%, 100% { transform: scale(1) rotate(0deg); }
            25% { transform: scale(1.1) rotate(3deg); }
            75% { transform: scale(1.1) rotate(-3deg); }
        }
        
        .cart-icon-link:hover .fa-shopping-cart {
            color: var(--dark-green);
            animation: cartWiggle 0.6s ease-in-out;
        }
        
        /* =================================
            5. CTA/UTILITY SEPARATOR (Divider & Spacing - Kept)
        ================================= */
        .cta-divider-group {
            margin-left: 2rem; 
            padding-left: 1.5rem; 
            position: relative;
            display: flex; 
            align-items: center;
        }

        .cta-divider-group::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1px; 
            height: 60%; 
            background-color: #ddd; 
        }

        /* =================================
            6. MEDIA QUERIES
        ================================= */
        @media (max-width: 991.98px) {
            /* Mobile Nav Link Cleanup */
            .navbar-nav {
                display: block;
                gap: 0;
            }
            .nav-btn-link {
                padding: 10px 0 !important; 
            }
            .nav-btn-link::before,
            .nav-btn-link.active::before {
                display: none; /* Hide underline on mobile */
            }
            .nav-btn-link.active {
                 color: var(--primary-green) !important; 
            }
            .nav-btn-link:hover {
                background-color: #f8f8f8 !important; 
                color: var(--primary-green) !important;
            }
            
            /* Mobile CTA/Utility Cleanup */
            .cta-divider-group {
                margin-left: 0.5rem; 
                padding-left: 0;
            }
            .cta-divider-group::before {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="header-area fixed-top">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center py-2">

            <div class="logo">
                <a href="index.php"><img src="images/logo.png" alt="TerraNew Logo" height="100px"/></a>
            </div>

            <nav class="navbar navbar-expand-lg">
                <button class="navbar-toggler bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                    <span class="fas fa-bars text-white"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarMenu">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link nav-btn-link " href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link nav-btn-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link nav-btn-link" href="recycle.php">Recycle</a></li>
                        <li class="nav-item"><a class="nav-link nav-btn-link" href="products.php">Products</a></li>
                        <li class="nav-item"><a class="nav-link nav-btn-link" href="contact.php">Contact</a></li>
                    </ul>
                </div>
            </nav>

            <div class="d-flex align-items-center">
                <a href="getintouch.php" class="btn btn-success">Get a Quote</a>

                <div class="cta-divider-group">
                    <a href="cart.php" class="position-relative text-dark cart-icon-link">
                        <i class="fa fa-shopping-cart fa-lg"></i>
                        <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo $cart_count; ?>
                        </span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Sticky header padding and logo size reduction on scroll
    window.addEventListener('scroll', function () {
        const header = document.querySelector('.header-area');
        const logoImg = document.querySelector('.logo a img');
        
        if (window.scrollY > 20) {
            header.style.padding = '5px 0';
            logoImg.style.maxHeight = '70px'; /* Shrink logo slightly */
        } else {
            header.style.padding = '10px 0';
            logoImg.style.maxHeight = '100px'; /* Restore original logo size */
        }
    });
</script>

</body>
</html>