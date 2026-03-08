<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Professional Footer - TerraNew (Compact)</title>
<style>
  /* Import a modern Google Font */
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

  /* Reset */
  *, *::before, *::after {
    box-sizing: border-box;
  }

  body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #f4f6f8;
    color: #333;
  }

  /* Footer Styles */
  footer {
    background-color: #1a3c30; /* Dark, earthy green */
    color: #ffffff;
    padding: 30px 20px 0; /* Reduced top padding */
    border-top: 5px solid #779f58; /* Reduced border thickness */
  }

  .footer-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    /* Streamlined grid layout: Brand/Mission (2 parts) | Contact (1 part) */
    grid-template-columns: 2fr 1fr; 
    gap: 40px; /* Reduced gap */
    padding-bottom: 20px; /* Reduced bottom padding */
  }

  /* Brand/About Section */
  .brand-info {
    padding-right: 20px;
  }

  .brand-info h3 {
    font-size: 1.6rem; /* Smaller font size */
    color: #a3c48f;
    margin-bottom: 5px;
    font-weight: 700;
  }

  .brand-info h3 span {
    color: #779f58;
    font-size: 1rem; /* Smaller tagline font */
    display: block;
    margin-top: 3px;
    font-weight: 400;
  }

  .brand-info p {
    font-size: 0.85rem; /* Smaller body text */
    line-height: 1.6;
    color: #d1d9d4;
    margin-top: 15px; /* Reduced margin */
    padding-bottom: 10px;
    border-bottom: 1px dashed #3e5b45;
  }

  /* Key Actions Section (Simplified) */
  .key-actions {
    margin-top: 10px;
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
  }

  .key-actions li {
    display: inline-flex;
    align-items: center;
    color: #a3c48f;
    font-size: 0.85rem;
    background-color: #274c3e;
    padding: 5px 10px;
    border-radius: 3px;
    list-style: none;
    margin: 0;
  }

  .key-actions li i {
    font-size: 0.9rem;
    margin-right: 6px;
    color: #779f58;
  }


  /* Footer headings */
  .footer-column h4 {
    margin-bottom: 15px; /* Reduced margin */
    font-weight: 600;
    font-size: 1.1rem; /* Slightly smaller heading */
    color: #a3c48f;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  /* Decorative line under headings removed for compactness */
  .footer-column h4::after {
    content: none;
  }

  /* Contact Info */
  .contact-info p {
    margin: 12px 0; /* Reduced margin */
    font-size: 0.85rem; /* Smaller text */
    color: #d1d9d4;
    line-height: 1.4;
  }
  .contact-info p strong {
    color: #ffffff;
    font-weight: 600;
  }
  .contact-info i {
      color: #779f58;
      margin-right: 10px;
      font-size: 1rem;
  }

  /* Social Media */
  .social-links {
    margin-top: 15px; /* Reduced margin */
    display: flex;
    gap: 15px;
  }

  .social-links a {
    color: #d1d9d4;
    font-size: 1.4rem; /* Smaller icons */
    transition: color 0.3s ease;
  }

  .social-links a:hover {
    color: #a3c48f;
  }

  /* Bottom bar (Copyright) */
  .footer-bottom {
    background-color: #0f241a;
    padding: 15px 0; /* Reduced padding */
    text-align: center;
    font-size: 0.8rem; /* Smallest font size */
    color: #a3c48f;
    border-top: 1px solid #3e5b45;
  }

  /* Responsive Design */
  @media (max-width: 900px) {
    .footer-container {
      grid-template-columns: 1fr; /* Single column stack */
      gap: 30px;
    }
    .brand-info {
      padding-right: 0;
    }
  }

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<footer>
  <div class="footer-container">
    <div class="footer-column brand-info">
      <h3>TerraNew <span>Plastic Recycling & Awareness</span></h3>
      <p>Driving the Circular Economy through innovative processing and dedicated community education.</p>
      
      <ul class="key-actions">
          <li><i class="fas fa-search-dollar"></i> Purchase Waste Plastic</li>
          <li><i class="fas fa-recycle"></i> Recycling PET & HDPE </li>
          <li><i class="fas fa-users"></i> Global Awareness </li>
      </ul>

      <div class="social-links">
        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
        <a href="#" aria-label="Twitter"><i class="fab fa-twitter-square"></i></a>
        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-square"></i></a>
        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
      </div>
    </div>

    <div class="footer-column contact-column">
      <h4>Connect with TerraNew</h4>
      <div class="contact-info">
        <p>
          <i class="fas fa-map-marker-alt"></i>
          <strong>HQ:</strong> 45 Recycling Parkway, TerraNew City
        </p>
        <p>
          <i class="fas fa-envelope"></i>
          <strong>Sales:</strong> sales@terranew.com
        </p>
        <p>
          <i class="fas fa-phone-alt"></i>
          <strong>Hotline:</strong> +1 (800) BUY-WASTE
        </p>
        <p>
          <i class="fas fa-info-circle"></i>
          <strong>General:</strong> info@terranew.com
        </p>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    &copy; 2025 TerraNew. All Rights Reserved. | Dedicated to a cleaner tomorrow.
  </div>
</footer>

</body>
</html>