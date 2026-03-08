<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About TerraNew</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

</head>

<body>
  <?php include 'header.php'; ?>

  <style>
    <style>
    /* =================================
        0. GLOBAL & PREMIUM PALETTE
    ================================= */
    :root {
        --primary-green: #0d6e2e;     /* Deep, elegant Forest Green */
        --accent-green: #38b863;      /* Bright, vibrant Accent */
        --dark-text: #2c3e50;         
        --light-bg: #fdfdfd;          
        --secondary-bg: #f0f4f0;      
        --shadow-color: rgba(13, 110, 46, 0.1); 
    }
    
    body {
        font-family: 'Poppins', 'Segoe UI', sans-serif;
        background: var(--light-bg);
        color: var(--dark-text);
        scroll-behavior: smooth;
        line-height: 1.6;

        /* 👇 Add padding so content doesn't stick to fixed navbar */
        padding-top: 80px; /* adjust as per your navbar height */
    }

    /* Subtler Background Texture */
    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-image: url('images/20.jfif');
        background-size: cover;
        background-attachment: fixed;
        background-position: center;
        opacity: 0.05; 
        z-index: -1;
    }

    .text-primary-green { color: var(--primary-green) !important; }

    /*
    =================================
    1. SLIDER/HERO SECTION 
    =================================
    */
    .slider-bg {
        height: 90vh;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    /* 👇 Add margin above carousel to push it down from navbar */
    #recyclingCarousel {
        margin-top: 20px;
    }

    /* THIS IS YOUR TRANSPARENT BLACK OVERLAY */
    .slider-bg::before {
        content: "";
        position: absolute;
        top: 3; left: 0; right: 0; bottom: 0;
        background-color: rgba(0, 0, 0, 0.65); 
        z-index: 1;
    }

        .carousel-caption {
        /* Core Centering CSS */
        position: absolute; 
        top: 50%; 
        left: 50%; 
        transform: translate(-50%, -50%); 
        
        /* Layout & Style */
        z-index: 2;
        color: #ffffff;
        max-width: 90%;
        width: 800px;
        padding: 0;
        text-align: center !important; 
    }

    /* ANIMATION DEFINITION */
    @keyframes slideInUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    /* Apply animation to H1 */
    .carousel-item.active .carousel-caption h1 {
        animation: slideInUp 0.8s ease-out 0.2s both;
    }
    
    /* Apply animation to H6 with a slight delay */
    .carousel-item.active .carousel-caption h6 {
        animation: slideInUp 0.8s ease-out 0.4s both;
    }

    /* CRITICAL ADJUSTMENT: Reset margins for true vertical centering */
    .carousel-caption h1 {
        font-size: 3rem; 
        font-weight: 800 !important;
        letter-spacing: -1px;
        margin: 0 !important; 
    }
    .carousel-caption h6 {
        font-size: 1.25rem; 
        margin-top: 0.75rem !important; 
        margin-bottom: 0 !important; 
        font-weight: 300;
        line-height: 1.4;
    }
    /*
    =================================
    2. SECTION TITLES
    =================================
    */
    .section-title, .text-muted2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--dark-text);
        text-align: center;
        margin-bottom: 0.5rem;
    }
    
    .section-title::after {
        content: '';
        width: 100px;
        height: 4px;
        background: var(--accent-green);
        display: block;
        margin: 15px auto 0;
        border-radius: 5px;
    }

    /* 👇 REDUCED SUBTITLE BOTTOM MARGIN FOR TIGHTER SPACING */
    .section-subtitle {
        color: #6c757d;
        font-size: 1.15rem;
        text-align: center;
        margin-bottom: 2rem; /* Reduced from 3rem */
    }
    
    .text-muted1 {
        color: var(--primary-green) !important;
    }

    /*
    =================================
    3. FEATURE BOXES (Icon Boxes)
    =================================
    */
    .icon-box {
        padding: 40px;
        background: var(--light-bg); 
        border-radius: 10px;
        box-shadow: 0 5px 20px var(--shadow-color);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        text-align: center;
        border: 1px solid #eee;
        height: 100%; 
    }
    
    .icon-box:hover {
        transform: translateY(-5px); 
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1); 
        border-color: var(--accent-green);
    }

    .icon-box img {
        height: 80px;
        transition: transform 0.3s;
    }

    .icon-box:hover img {
        transform: scale(1.1);
    }
    
    .icon-box h5, .icon-box h6 {
        color: var(--primary-green);
        margin-top: 15px;
        font-weight: 600;
    }

    /*
    =================================
    4. RECYCLING PROCESS
    =================================
    */
    #recycle-process {
        background: var(--secondary-bg);
    }
    
    #recycle-process h5 {
        color: var(--dark-text);
        font-weight: 700;
        margin-top: 15px;
    }
    
    /*
    =================================
    5. CTA BANNER
    =================================
    */
    /* 👇 REDUCED TOP/BOTTOM MARGIN FOR TIGHTER SPACING */
    .cta-banner {
        background: var(--primary-green);
        color: #fff;
        padding: 60px 20px;
        border-radius: 10px;
        margin: 40px auto; /* Reduced from 60px auto */
        box-shadow: 0 8px 30px rgba(0,0,0,0.25);
    }

    .cta-banner .btn {
        background: #fff;
        color: var(--primary-green);
        font-weight: 700;
        padding: 14px 40px;
        border-radius: 50px;
        transition: all 0.3s ease;
        border: none;
    }

    .cta-banner .btn:hover {
        background: var(--dark-text);
        color: #fff;
    }

    /*
    =================================
    6. TESTIMONIALS
    =================================
    */
    .testimonial-box {
        background: var(--secondary-bg); 
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: 0.3s ease;
        text-align: center;
        border-left: 5px solid var(--accent-green); 
        height: 100%;
    }

    .testimonial-box p {
        font-style: italic;
        color: #555;
    }
    .testimonial-box h6 {
        color: var(--dark-text);
    }
    .testimonial-box:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    /*
    =================================
    7. SCROLL REVEAL ANIMATION 
    =================================
    */
    .reveal-item {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    .reveal-item.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Staggered Delay */
    .reveal-item[data-delay="1"] { transition-delay: 0.1s; }
    .reveal-item[data-delay="2"] { transition-delay: 0.2s; }
    .reveal-item[data-delay="3"] { transition-delay: 0.3s; }
    .reveal-item[data-delay="4"] { transition-delay: 0.4s; }

    /* Media Query Adjustments */
    @media (max-width: 991px) {
        .carousel-caption h1 { 
            font-size: 2.5rem; 
        }
        .carousel-caption h6 { 
            font-size: 1rem; 
        }
    }
  </style>

<div id="recyclingCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <div class="slider-bg" style="background-image: url('images/15.jpeg');">
        <div class="carousel-caption">
          <h1 class="fw-bold">Recycling for a Greener Tomorrow</h1>
          <h6 class="lead">Together, we can build a sustainable future—one bottle at a time.</h6>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <div class="slider-bg" style="background-image: url('images/3.jpeg');">
        <div class="carousel-caption">
          <h1 class="fw-bold">Waste is Only Waste If We Waste It</h1>
          <h6 class="lead">Transforming plastic into purpose with innovation and impact.</h6>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <div class="slider-bg" style="background-image: url('images/8.jpeg');">
        <div class="carousel-caption">
          <h1 class="fw-bold">From Trash to Treasure</h1>
          <h6 class="lead">Reimagine recycling. Redesign the future. Reclaim the planet.</h6>
        </div>
      </div>
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#recyclingCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#recyclingCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<section class="py-4"> <div class="container py-4"> <div class="text-center mb-4 reveal-item"> <h2 class="section-title">Why Choose TerraNew?</h2>
      <p class="section-subtitle">We're not just recycling plastic — we're building a movement with impact and innovation.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-4 reveal-item" data-delay="1">
        <div class="icon-box">
          <img src="images/a1.png" class="img-fluid mb-3" style="height:80px;">
          <h5 class="fw-bold mt-3">Plastic Awareness</h5>
          <p>Educating communities about reducing and recycling plastic waste with strong local programs.</p>
        </div>
      </div>
      <div class="col-md-4 reveal-item" data-delay="2">
        <div class="icon-box">
          <img src="images/a2.png" class="img-fluid mb-3" style="height:80px;">
          <h5 class="fw-bold mt-3">Community Engagement</h5>
          <p>Collaborating with students, societies, and NGOs to create real, measurable impact on the ground.</p>
        </div>
      </div>
      <div class="col-md-4 reveal-item" data-delay="3">
        <div class="icon-box">
          <img src="images/a3.png" class="img-fluid mb-3" style="height:80px;">
          <h5 class="fw-bold mt-3">Innovative Tech</h5>
          <p>Using smart dashboards and modern tools to track plastic submissions and maximize awareness reach.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-4" style="background: var(--secondary-bg);"> <div class="container py-4"> <div class="text-center mb-4 reveal-item"> <h2 class="text-muted1 section-title">Who We Are</h2>
      <p class="section-subtitle">TerraNew is a leading provider of sustainable waste management and recycling services.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-6 reveal-item" data-delay="1">
        <div class="icon-box">
           <img src="images/a4.png" class="img-fluid mb-3" style="height:80px;">
           <h5 class="fw-bold">Our Mission</h5>
          <p>To lead the way in sustainable waste management and make a meaningful impact on our environment by offering smart, eco-friendly solutions.</p>
        </div>
      </div>
      <div class="col-md-6 reveal-item" data-delay="2">
        <div class="icon-box">
          <img src="images/a5.png" class="img-fluid mb-3" style="height:80px;">
        <h5 class="fw-bold">Our Vision</h5>
          <p>To be the most trusted name in recycling and waste reduction, promoting a zero-waste future through innovation and education across the globe.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<section id="recycle-process" class="py-4"> <div class="container py-4"> <h2 class="text-muted2 section-title mb-4 reveal-item">Our Recycling Process</h2> <div class="row text-center g-4">

      <div class="col-md-3 reveal-item" data-delay="1">
        <img src="images/collection.png" class="img-fluid mb-3" style="height:80px;">
      <h5>Step 1: Collect</h5>
        <p class="text-muted1">Plastic is efficiently collected from users and sorted by polymer type.</p>
      </div>
      <div class="col-md-3 reveal-item" data-delay="2">
        <img src="images/clean.png" class="img-fluid mb-3" style="height:80px;">
        <h5>Step 2: Clean</h5>
       <p class="text-muted1">Contaminants are removed, and the plastic is washed and prepared for processing.</p>
      </div>
      <div class="col-md-3 reveal-item" data-delay="3">
        <img src="images/process.png" class="img-fluid mb-3" style="height:80px;">
        <h5>Step 3: Process</h5>
        <p class="text-muted1">Plastic is shredded into flakes, melted, and reformed into high-quality pellets.</p>
      </div>
      <div class="col-md-3 reveal-item" data-delay="4">
        <img src="images/reuse.png" class="img-fluid mb-3" style="height:80px;">
        <h5>Step 4: Reuse</h5>
        <p class="text-muted1">Recycled material is used by manufacturers to create fresh, sustainable products.</p>
      </div>
    </div>
  </div>
</section>


<section class="core-values-section py-4" style="background: var(--secondary-bg);"> <div class="container py-4"> <div class="text-center mb-4 reveal-item"> <h2 class="section-title">Our Core Values</h2>
      <p class="section-subtitle">We believe in making the world better through dedication, integrity, and green innovation.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-4 reveal-item" data-delay="1">
        <div class="icon-box">
           <img src="images/a6.png" class="img-fluid mb-3" style="height:80px;">
           <h6 class="fw-bold">Environmental Responsibility</h6>
          <p>We prioritize eco-conscious decisions that contribute to a cleaner, healthier planet for generations.</p>
        </div>
      </div>
      <div class="col-md-4 reveal-item" data-delay="2">
        <div class="icon-box">
           <img src="images/a7.png" class="img-fluid mb-3" style="height:80px;">
          <h6 class="fw-bold">Community Empowerment</h6>
          <p>We actively engage and empower communities to join our sustainable movement and share the impact.</p>
        </div>
      </div>
      <div class="col-md-4 reveal-item" data-delay="3">
        <div class="icon-box">
           <img src="images/a8.png" class="img-fluid mb-3" style="height:80px;">
          <h6 class="fw-bold">Innovation-Driven</h6>
          <p>Our recycling strategies are constantly powered by forward-thinking, data-driven solutions and research.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="testimonials-section py-4 bg-white"> <div class="container py-4"> <div class="text-center mb-4 reveal-item"> <h2 class="text-muted2 section-title">What Our Clients Say</h2>
      <p class="section-subtitle">Terranew transformed the way our community approaches recycling.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-6 reveal-item" data-delay="1">
        <div class="testimonial-box">
          <p class="fst-italic">"TerraNew made our office recycling seamless, efficient, and genuinely impactful. Their commitment to sustainability is unmatched!"</p>
          <h6 class="fw-bold mt-3 mb-0">— GreenTech Solutions, CEO</h6>
        </div>
      </div>
      <div class="col-md-6 reveal-item" data-delay="2">
        <div class="testimonial-box">
          <p class="fst-italic">"The team's dedication and transparency are truly inspiring. We're proud to be partners in promoting a cleaner future."</p>
          <h6 class="fw-bold mt-3 mb-0">— Clean Future Org, Director</h6>
        </div>
      </div>
    </div>
  </div>
</section>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // =================================
    // SCROLL REVEAL JAVASCRIPT (UNCHANGED)
    // =================================
    document.addEventListener('DOMContentLoaded', () => {
        const revealItems = document.querySelectorAll('.reveal-item');

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                // Check if the element is currently in the viewport
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    // Stop observing once it's visible
                    observer.unobserve(entry.target); 
                }
            });
        }, {
            // Options: Start observing when 10% of the element is visible
            threshold: 0.1 
        });

        // Loop over every reveal element and observe it
        revealItems.forEach(item => {
            observer.observe(item);
        });
    });
    
    // =================================
    // CAROUSEL ANIMATION RESET (UNCHANGED)
    // =================================
    const recyclingCarousel = document.getElementById('recyclingCarousel');
    if (recyclingCarousel) {
      recyclingCarousel.addEventListener('slide.bs.carousel', (event) => {
        // Get the element of the next slide
        const nextSlide = event.relatedTarget;
        
        // Find all animated elements in the current active slide and clear their animation class
        const activeSlide = recyclingCarousel.querySelector('.carousel-item.active');
        if (activeSlide) {
          activeSlide.querySelectorAll('.carousel-caption h1, .carousel-caption h6').forEach(el => {
            el.style.animation = 'none';
            // Force reflow to ensure animation reset
            void el.offsetHeight;
          });
        }
        
        // Re-apply the animation styles to the elements in the new active slide after a brief moment
        // This makes the animation play as the slide becomes active.
        setTimeout(() => {
          nextSlide.querySelectorAll('.carousel-caption h1').forEach(el => {
            el.style.animation = 'slideInUp 0.8s ease-out 0.2s both';
          });
          nextSlide.querySelectorAll('.carousel-caption h6').forEach(el => {
            el.style.animation = 'slideInUp 0.8s ease-out 0.4s both';
          });
        }, 50); // Small delay to ensure the slide is active before starting animation
      });
    }

</script>
<?php include 'footer.php'; ?>
</body>
</html>