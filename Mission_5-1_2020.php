<!DOCTYPE html>
<html lang ="ja">
<head>
    <meta charset="utf-8">
    <title>mission5-1</title>
    
</head>
<body>
    <font size="5"><strong>好きな映画！</strong></font><br>
    <font size="3">おすすめの映画を教えてください！！</font><br><br>
        
<?php



	$dsn ='データベース名';
	$user = 'ユーザ名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = "CREATE TABLE IF NOT EXISTS forum1"
	    ." ("
	    . "id INT AUTO_INCREMENT PRIMARY KEY,"
	    . "name char(32),"
	    . "comment TEXT,"
	    . "pass INT,"
	    . "original_date DATETIME,"
	    .");";
	    
	$stmt = $pdo->query($sql);
	
	 
	
	if (isset($_POST["name"])&&$_POST["name"]!=""&&isset($_POST["comment"])&&
	$_POST["comment"]!=""&&isset($_POST["pass"])&&$_POST["pass"]!=""){
	    if($_POST["editnum"]==""){
	
        
        $sql = $pdo -> prepare("INSERT INTO forum1 (name, comment,pass,original_date) 
        VALUES (:name, :comment,:pass,:original_date)");
	   
	    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':pass', $pass, PDO::PARAM_INT);
	    $sql -> bindParam(':original_date', $original_date, PDO::PARAM_STR);
	    $name=$_POST["name"];
        $comment=$_POST["comment"];
        $pass=$_POST["pass"];
        $original_date=date("Y/m/d H:i:s");
        $sql -> execute();
	    }
	    elseif(isset($_POST["editnum"])&&$_POST["editnum"]!=""){
	    $id=$_POST["editnum"];
	    $name=$_POST["name"];
	    $comment=$_POST["comment"];
	    $original_date=date("Y/m/d H:i:s");
	    $sql='UPDATE forum1 SET name=:name, comment=:comment, original_date=:original_date WHERE id=:id';
	    $stmt=$pdo->prepare($sql);
	    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	    $stmt->bindParam(':comment',$comment, PDO::PARAM_STR);
	    $stmt->bindParam(':original_date',$original_date, PDO::PARAM_STR);
	    $stmt->bindParam(':id',$id, PDO::PARAM_INT);
	    $stmt->execute();
	    }
	}
        
    
	    
	if(isset($_POST["pass1"])&&$_POST["pass1"]!=""&&isset($_POST["erase"])&&$_POST["erase"]!="")
	{
	    $sql ='SELECT * FROM forum1';
	      $stmt=$pdo->query($sql);
	      $results=$stmt->fetchAll();
	      foreach ($results as $row)
	      {
	          if ($_POST["erase"]==$row['id']&&$_POST["pass1"]==$row['pass'])
	          {$id =$_POST["erase"];
            
	                $sql = 'DELETE FROM forum1 WHERE id=:id';
	                $stmt = $pdo->prepare($sql);
	                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	                $stmt->execute();
	            
	          }elseif ($_POST["erase"]==$row['id']&&$_POST["pass1"]!=$row['pass']){
	          echo "パスワードが違います<br>";
	              
	          }
        	}
        }
    if(isset($_POST["edit"])&&$_POST["edit"]!=""&&isset($_POST["pass2"])&&$_POST["pass2"]!=""){
     $edit=$_POST["edit"];
     $sql ='SELECT * FROM forum1';
     $stmt=$pdo->query($sql);
	      $results=$stmt->fetchAll();
	      foreach ($results as $row){
	          if($edit==$row['id']&&$_POST["pass2"]==$row['pass'])
	          {$editnumber=$row['id'];
	           $editname=$row['name'];
	           $editcomment=$row['comment'];
	           
	    
	           
    }elseif($edit==$row['id']&&$_POST["pass2"]!=$row['pass'])
    {
    
                 echo "パスワードが違います";
            
                 }
	      }
    }
      
	
   
    
?>
<form action ="Mission_5-1.php" method="post">    
    <input type="text" name="name" value= "<?php if(isset($editname)&&$editname!=""){echo $editname;} ?>"placeholder="名前"> 
    
    <br>
    <input type="text" name="comment"value="<?php if(isset($editcomment)&&$editcomment!=""){ echo $editcomment;}?>" placeholder="コメント">
    <br>
    <input type="number" name="pass" value="" placeholder="パスワード"inputmode="latin">
    <br>
    <input type="submit" name="submit" value="送信">
    <br>
    <input type="hidden" name="editnum" value= "<?php if(isset($editnumber)&&$editnumber!="") echo $editnumber;?>">

    <br><br>
    <input type="number" name="erase" value="" placeholder="削除対象番号">
    <br>
    <input type="number" name="pass1" value="" placeholder="パスワード">
    <br>
    <input type="submit" name="delete" value="削除">
    <br><br>
    <input type="number" name="edit" value="" placeholder="編集対象番号">
    <br>
    <input type="number" name="pass2" value="" placeholder="パスワード">
    <br>
    <input type="submit" name= "editting"value="編集">
    <br>
</form> 
<?php
	$sql = 'SELECT * FROM forum1';
	    $stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
	    foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id']."<>";
		echo $row['name']."<>";
		echo $row['comment']."<>";
		echo $row['original_date']."<br>";
	    
	    echo "<hr>";
	        
	    }
    ?>
</body>
</html>