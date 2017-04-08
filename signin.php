<?php
include 'connect.php';
include 'header.php';

echo '<h3>Sign in</h3>';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
  echo 'You are already signed in';
}
else
{
  if($_SERVER['REQUEST_METHOD'] != 'POST')
  {
    echo '<form method="post" action="">
    Username(email): <input type="email" name="user_name" />
    Password: <input type="password" name="user_pass" />
    <input type="submit" value="Sign in" />
    </form>';
  }
  else
  {
    $errors = array();

    if(!isset($_POST['user_name']))
    {
      $errors[] = 'The username field can not be blank.';
    }

    if(!isset($_POST['user_pass']))
    {
      $errors[] = 'The password field can not be blank.';
    }

    if(!empty($errors))
    {
      echo 'There were errors filling our the form.';
      echo '<ul>';
      foreach($errors as $key => $value)
      {
        echo '<li>' .$value. '</li>';
      }
      echo '</ul>';
    }
    else
    {
      $sql = "SELECT
                        user_id,
                        user_name,
                        user_level
                    FROM
                        users
                    WHERE
                        user_email = '" . mysql_real_escape_string($_POST['user_name']) . "'
                    AND
                        user_pass = '" . sha1($_POST['user_pass']) . "'";
      $result = mysql_query($sql);
      if(!result)
      {
        echo 'Please try again later.';
      }
      else
      {
        if(mysql_num_rows($result) == 0)
        {
          echo 'Invalid credentials. Please try again later.';
        }
        else
        {
          $_SESSION['signed_in'] = true;

          while($row = mysql_fetch_assoc($result))
          {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_level'] = $row['user_level'];
          }

          echo 'Welcome, ' . $_SESSION['user_name'] . ' <a href="index.php"> Proceed to the forum overview</a>.';
        }
      }
    }
  }
}
include 'footer.php';
 ?>
