<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EcoFix - Premium Pricing</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>

  <style>
    body {
      background: linear-gradient(135deg, #e8f5e9, #ffffff);
      font-family: 'Segoe UI', sans-serif;
      color: #333;
    }

    .hero {
      background: linear-gradient(145deg, #2e7d32, #43a047);
      padding: 100px 0;
      color: white;
      text-align: center;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: 700;
    }

    .pricing-container {
      padding: 80px 0;
    }

    .pricing-card {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
      padding: 60px 30px;
      position: relative;
      transition: all 0.4s ease-in-out;
      overflow: hidden;
    }

    .pricing-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 16px 30px rgba(0,0,0,0.2);
    }

    .price {
      font-size: 2.8rem;
      font-weight: bold;
      color: #2e7d32;
    }

    .plan-title {
      font-size: 1.7rem;
      font-weight: 600;
      margin-bottom: 15px;
    }

    .features {
      list-style: none;
      padding: 0;
      margin: 25px 0 30px;
    }

    .features li {
      padding: 10px 0;
      font-size: 1rem;
      border-bottom: 1px solid #e0e0e0;
    }

    .features li i {
      color: #2e7d32;
      margin-right: 8px;
    }

    .btn-choose {
      background: #2e7d32;
      color: #fff;
      border: none;
      padding: 10px 30px;
      border-radius: 30px;
      font-size: 1rem;
      transition: 0.3s ease;
    }

    .btn-choose:hover {
      background-color: #256d28;
      transform: scale(1.05);
    }

    .popular-badge {
      position: absolute;
      top: -10px;
      right: -60px;
      background: #2e7d32;
      color: white;
      padding: 6px 60px;
      transform: rotate(45deg);
      font-size: 0.85rem;
      font-weight: 600;
      z-index: 2;
      box-shadow: 0 0 10px rgba(46, 125, 50, 0.6);
    }

    .pricing-card.popular {
      border: 3px solid #2e7d32;
      z-index: 2;
    }

    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2.2rem;
      }

      .price {
        font-size: 2.2rem;
      }
    }
  </style>
</head>
<body>

  <!-- Hero -->
  <section class="hero">
    <div class="container">
      <h1>Affordable Eco-Friendly Plans</h1>
      <p class="lead mt-3">Flexible solutions to support your green mission 🌍</p>
    </div>
  </section>

  <!-- Pricing Plans -->
  <section class="pricing-container">
    <div class="container">
      <div class="row g-4 justify-content-center">

        <!-- Basic Plan -->
        <div class="col-md-4">
          <div class="pricing-card text-center h-100">
            <div class="plan-title">Basic</div>
            <div class="price">₹499<span class="fs-6"> /mo</span></div>
            <ul class="features">
              <li><i class="fas fa-recycle"></i> 2x Plastic Pickup</li>
              <li><i class="fas fa-leaf"></i> Basic Waste Report</li>
              <li><i class="fas fa-envelope"></i> Email Support</li>
              <li><i class="fas fa-book-open"></i> Monthly EcoTips</li>
            </ul>
            <button class="btn btn-choose">Choose Plan</button>
          </div>
        </div>

        <!-- Standard Plan (Popular) -->
        <div class="col-md-4">
          <div class="pricing-card text-center h-100 popular">
            <div class="popular-badge">Most Popular</div>
            <div class="plan-title">Standard</div>
            <div class="price">₹999<span class="fs-6"> /mo</span></div>
            <ul class="features">
              <li><i class="fas fa-recycle"></i> Weekly Pickup</li>
              <li><i class="fas fa-file-alt"></i> Waste Analysis Report</li>
              <li><i class="fas fa-headset"></i> Priority Email Support</li>
              <li><i class="fas fa-trash-alt"></i> 1 Recycling Bin Free</li>
            </ul>
            <button class="btn btn-choose">Choose Plan</button>
          </div>
        </div>

        <!-- Premium Plan -->
        <div class="col-md-4">
          <div class="pricing-card text-center h-100">
            <div class="plan-title">Premium</div>
            <div class="price">₹1,999<span class="fs-6"> /mo</span></div>
            <ul class="features">
              <li><i class="fas fa-recycle"></i> Daily Pickup</li>
              <li><i class="fas fa-clipboard-check"></i> Sustainability Reports</li>
              <li><i class="fas fa-phone"></i> 24/7 Support</li>
              <li><i class="fas fa-people-group"></i> Community Events</li>
            </ul>
            <button class="btn btn-choose">Choose Plan</button>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
