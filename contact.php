<?php include "header.php"; ?>
<div class="container mt-5">
  <h2>Contact Us</h2>
  <p>Have questions, feedback, or need help with an order? We’re here to help!</p>

  <div class="row">
    <div class="col-md-6">
      <form action="send_message.php" method="post">
        <div class="form-group">
          <label for="name">Your Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="email">Your Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="message">Message</label>
          <textarea name="message" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
      </form>
    </div>
    <div class="col-md-6">
      <h5>Our Office</h5>
      <p><strong>Tech Shop HQ</strong><br>
      Daffodil Smart City,<br>
      Dhaka, Bangladesh<br>
      Email: support@techshop.com<br>
      Phone: 123456-7890</p>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
