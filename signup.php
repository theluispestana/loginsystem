<?php
  include_once 'header.php';
 ?>

<!-- test -->
<section class="main-container">
  <div class="main-wrapper">
    <h2>Sign Up</h2>
    <form class="signup-form" action="index.html" method="post">
      <input type="text" name="first" placeholder="First Name" value="">
      <input type="text" name="last" placeholder="Last Name" value="">
      <input type="text" name="email" placeholder="E-mail" value="">
      <input type="text" name="uid" placeholder="Username" value="">
      <input type="text" name="pwd" placeholder="Password" value="">
      <button type="submit"name="submit">Sign Up</button>
    </form>
  </div>
</section>

<?php
  include_once 'footer.php';
 ?>
