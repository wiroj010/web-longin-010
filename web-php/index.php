<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบสมัครสมาชิก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-8"><br>
                <h4>ระบบสมัครสมาชิก : </h4>
                <form action="" method="post">
                    <div class="mb-2">
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" required minlength="3" placeholder="ชื่อ">
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="col-sm-9">
                            <input type="text" name="surname" class="form-control" required minlength="3" placeholder="นามสกุล">
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="col-sm-9">
                            <input type="text" name="username" class="form-control" required minlength="3" placeholder="username">
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="col-sm-9">
                            <input type="text" name="password" class="form-control" required minlength="3" placeholder="password">
                        </div>
                    </div>
                    <div class="d-grid grap-2 col-sm-9 mb-3">
                        <button type="submit" class="btn btn-primary">สมัครสมาชิก</button>
                    </div>
                </form>
                <hr>
                    <p>เป็นสมาชิกอยู่หรือไม่ คลิกเพื่อเข้าสู่ระบบ</p>
                    <a href="signin.php">เข้าสู่ระบบ</a>
            </div>
        </div>
    </div>
    
</body>
</html>
<?php 
    //รับค่าจากฟอร์ม
        if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['username']) && isset($_POST['password'])) {
            //alert
        echo '
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>;
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>;
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

        //เชื่อมต่อฐานข้อมูล
        require_once'connect.php';
        //ประกาศตัวแปร
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $password = sha1($_POST['password']);

        //check Duplicate
        $stmt = $conn->prepare("SELECT id FROM regis_tb WHERE username = :username");
        $stmt->execute(array(':username' => $username));

        if($stmt->rowCount() > 0){
            echo '<script>
                    setTimeout(function(){
                        swal({
                            title: "Username ซ้ำ !!",
                            text: "กรุณาสมัครใหม่อีกครั้ง",
                            type: "warning"
                        }, function(){
                            window.location = "index.php";
                        });
                    }, 1000);
                </script>';
        }else{
            //insert sql
            $stmt = $conn->prepare("INSERT INTO regis_tb (name, surname, username, password)
            VALUES (:name, :surname, :username, :password");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $result = $stmt->execute();
            if($result){
                echo '<script>
                    setTimeout(function() {
                    swal({
                        title: "สมัครสมาชิกสำเร็จ",
                        text : "กรุณารอระบบ Login",
                        type: "success"
                    }, function() {
                        window.location = "pqge1.php";
                    });
                }, 1000);
                </script>';
            }else{
                echo '<script>
                    setTimeout(function() {
                    swal({
                        title: "เกิดข้อผิดพลาด",
                        text : "error",
                        type: "success"
                    }, function() {
                        window.location = "index.php";
                    });
                }, 1000);
                </script>';
            }
            $conn = null;

            }
        }      
?>