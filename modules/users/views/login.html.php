<div class="container-fluid">
    <h2>Log In</h2>
    <p>Please log in to view the page that you requested.</p>
    <?php if (isset($loginError)): ?>
      <p><?php htmlout($loginError); ?></p>
    <?php endif; ?>
    <form action="" method="post">
      <div>
        <label for="email">Username: <input type="text" name="username"
            id="email"></label>
      </div>
      <div>
        <label for="password">Password: <input type="password"
            name="password" id="password"></label>
      </div>
      <div>
        <input type="hidden" name="action" value="login">
        <input type="submit" value="Log in">
      </div>
    </form>
    <p><a href="#">Return to CyberCPR Helpdesk Home</a></p>
</div>

