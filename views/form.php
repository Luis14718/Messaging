<?php ?>



<div class="container messaging">
  <div class="row">
    <div class="col-12 align-items-center text-center">
      <h1>Messaging Form</h1>
    </div>
    <div class="col-12">
      <form id="messaging-form" action="" class="mx-auto" method="post">
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required>
        <br>
        <label for="message">Message:</label>
        <textarea name="message" id="message" rows="5" required></textarea>
        <br>
        <input class="primary" type="submit" name="submit" value="Send Message">
      </form>
    </div>
  </div>
</div>

<script>
var form = document.getElementById('messaging-form');

form.addEventListener('submit', function(event) {
  var phone = document.getElementById('phone').value;
  var message = document.getElementById('message').value;
  var phoneRegex = /^[\+\d]+$/;

  if (!phoneRegex.test(phone) || !message) {
    alert('Invalid Phone Number or Message');
    event.preventDefault();
  }
});
</script>