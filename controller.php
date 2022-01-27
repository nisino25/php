<?php
    
    if(isset($_POST['submit'])){
      // echo 'sent it ';
      $validationFlag = true;
      $validationList = [
          "email"=> true,
          "password"=> true,
      ];
      
      $email= $_POST['email']; 
      $password = $_POST['password'];

      if(!$email){
        $validationList['email'] = 'メールは必須入力です';
        $validationFlag = false;

      }if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validationList['email'] = 'メールアドレスは正しくご入力ください。';
        $validationFlag = false;
      }

      if(!$password){
        $validationList['password'] = 'パスワードは必須入力です';
        $validationFlag = false;
      }


      
     $_SESSION['validationList'] = $validationList ;
      $_SESSION['validationFlag'] = $validationFlag ;
    // -------------------------------------------------------------

      if(!$validationFlag){

        echo '<br>failed';
        return;
      }else{

        // start login varificataion ------------------------
        // if the user exists -----===================-------------------

        $sql = "SELECT email from users where email = '$email'";
        $result =mysqli_query($GLOBALS['connection'], $sql);

     
        if(!mysqli_num_rows($result)){
            $validationList['email'] = 'メールアドレスか存在しません';
            $validationFlag = false;
            echo '<br>メールアドレスか存在しません';
            return;
        }else{
            // if the password matches --===============----------------------
            $results = $this->Users->getRow($email);
            $hash =$results[0]['password'] !== $password
            if(!password_verify($password, $hash)){
                $validationList['email'] = 'メールアドレスかパスワードが違います';
                $validationFlag = false;
                echo '<br>メールアドレスかパスワードが違います';
                return;
            }else{
                // procced login ---------======---------------  
                $_SESSION['isLoggedin'] = true;
                $_SESSION['logedinEmail'] = $email;
                if($results[0]['role'] == 1){
                  $_SESSION['isAdmin'] = true;
                }else{
                  $_SESSION['isAdmin'] = false;
                }
                header("Location: ./index.php");
                die();
                
            }
            
            
        }

        

      
        
        



      }

      
    }else{
      // echo 'not yet';
    }
  <?php>
