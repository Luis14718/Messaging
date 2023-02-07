<?php ?>

<div class="container messaging">
  <div class="row">
    <div class="col-12 align-items-center text-center">
    <h1>Messaging Form </h1>
    </div>
    <div class="col-12">
    <form action="" class="mx-auto" method="post">
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" pattern="\d*" required></p>
        <p><label for="message">Message:</label>
        <textarea name="message" id="message" rows="5" required></textarea></p>
        <p><input class="primary" type="submit" name="submit" value="Send Message"></p>
        </form>
    </div>
  </div>
</div>
