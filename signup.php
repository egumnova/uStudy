</<?php
include 'connect.php';
include 'header.php';

echo '<h3>Sign up</h3>';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    echo'<form method="post" action="">
    Name: <input type="text" name="user_name" />
    Last Name: <input type="text" name="user_lname" />
    E-mail: <input type="email" name="user_email" />
    Password: <input type="password" name="user_pass" />
    Retype password: <input type="password" name="user_pass_check" />
    <input type="submit" value="Submit" />
    </form>';
}

else
{
    $errors = array();

    if(isset($_POST['user_name']))#
    {
      if(!ctype_alpha($_POST['user_name']))
          {$errors[] = 'The name can only contain letters.';}
      if(strlen($_POST['user_name']) > 30)
          {$errors[] = 'The name cannot exceed 30 characters.';}
    }
    else
    {
      $errors[] = 'The name field cannot be empty.';  # code...
    }

    if(isset($_POST['user_lname']))#
    {
      if(!ctype_alpha($_POST['user_lname']))
          {$errors[] = 'The last name can only contain letters.';}
      if(strlen($_POST['user_lname']) > 30)
          {$errors[] = 'The last name cannot exceed 30 characters.';}
    }
    else
    {
      $errors[] = 'The last name field cannot be empty.';  # code...
    }

    if(!isset($_POST['user_email']))#
    {
      $errors[] = 'The name field cannot be empty.';  # code...
    }

    if(isset($_POST['user_pass']))
    {
      if($_POST['user_pass'] != $_POST['user_pass_check'])
      {
        $errors[] = 'Passwords do not match.';
      }
    }
    else
    {
      $errors[] = 'The password field can not be left empty.';  # code...
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
                        user_id
                    FROM
                        users
                    WHERE
                        user_email = '" . mysql_real_escape_string($_POST['user_email']) . "'";
      $result = mysql_query($sql);
      if(mysql_num_rows($result))
      {
        //user email already registered
        echo 'This email is already registered';
      }
      else
      {
        $sql = "INSERT INTO users(user_name, user_lname, user_email, user_pass, user_level) VALUES('" . mysql_real_escape_string($_POST['user_name']) . "', '" . mysql_real_escape_string($_POST['user_lname']) . "', '" . mysql_real_escape_string($_POST['user_email']) . "', '" . sha1($_POST['user_pass']) . "', 0)";
        $result = mysql_query($sql);
        if(!$result)
        {
          echo 'Registration failed. Please try again later.';
        }
        else
        {
          echo 'Successfully registered. You can now <a href="signin.php">sign in</a>';
        }
      }
    }
}
include 'footer.php';
 ?>
