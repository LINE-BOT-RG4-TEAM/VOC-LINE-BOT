<?php 
    require('./libs/database/connect-db.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <title>Manager register</title>
        <!-- css -->
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.css" />

        <script>
            function copyToClipboard(element) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(element).val()).select();
                document.execCommand("copy");
                $temp.remove();
                alert('คัดลอกไปยัง Clipboard เรียบร้อยแล้ว');
            }
        </script>

        <!-- js -->
        <script src="./assets/jquery/jquery-3.3.1.min.js"></script>
        <script src="./assets/bootstrap/js/bootstrap.js"></script>
        <script src="./assets/blockUI/jquery.blockUI.js"></script>
        <script src="./assets/jqueryScrollTableBody/jqueryScrollTableBody.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 offsets-lg-4">
                    <form name="manager-regis-form" id="manager-regis-form" method="POST">
                        <h1>ลงทะเบียนผู้จัดการ</h1>
                        <div class="form-group">
                            <label for="name">ชื่อ</label>
                            <input type="text" class="form-control" id="name" placeholder="กรอกชื่อจริง" required>
                        </div>
                        <div class="form-group">
                            <label for="surname">นามสกุล</label>
                            <input type="text" class="form-control" id="surname" placeholder="กรอกนามสกุล" required>
                        </div>
                        <div class="form-group">
                            <label for="position">ตำแหน่ง</label>
                            <input type="text" class="form-control" id="position" placeholder="กรอกตำแหน่งพร้อมระดับของท่าน" required>
                        </div>
                        <div class="form-group">
                            <label for="pea_office">การไฟฟ้าสังกัด</label>
                            <select class="form-control" name="pea_office" id="pea_office">
                            <?php 
                                $fetch_office = "SELECT * FROM tbl_pea_office WHERE status = 'A'";
                                $office_result = mysqli_query($conn, $fetch_office);
                                while($office = $office_result->fetch_assoc()){
                            ?>
                                <option value="<?=$office['id'] ?>"><?=$office['office_name'] ?></option>
                            <?php 
                                }
                            ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="regisCode">Register Code</label>
                            <input type="text" class="form-control" id="regisCode" readonly/>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="สมัคร" />
                        </div>
                    </form>
                </div>
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>ตำแหน่ง</th>
                                    <th>การไฟฟ้า</th>
                                    <th>รหัสสมัคร</th>
                                    <th>สถานะ</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $select_manager = "SELECT manager.id AS id, manager.name, manager.surname, manager.position, manager.code, office.office_name, uid FROM tbl_manager manager JOIN tbl_pea_office office ON manager.office_id = office.id WHERE manager.status = 'A'";
                                    $results_manager = mysqli_query($conn, $select_manager);
                                    $count = 0;
                                    while($manager = $results_manager->fetch_assoc()){
                                ?>
                                <tr>
                                    <td><?=$count+1 ?></td>
                                    <td><?=$manager['name']." ".$manager['surname'] ?></td>
                                    <td><?=$manager['position'] ?></td>
                                    <td><?=$manager['office_name'] ?></td>
                                    <td><?=$manager['code'] ?></td>
                                    <td>
                                        <?=($manager['uid'] == NULL)?"ยังไม่ได้ลงทะเบียน":"ลงทะเบียนแล้ว" ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if($manager['uid'] != NULL){
                                                $hidden_uid = "uid-".$manager['id'];
                                        ?>
                                            <button class="btn btn-default" onclick="copyToClipboard('#<?=$hidden_uid ?>')">Copy uid</button>
                                            <input type="hidden" name="<?=$hidden_uid ?>" id="<?=$hidden_uid ?>" value="<?=$manager['uid'] ?>" />
                                        <?php 
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <?php 
                                        $count++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        $(function(){

            $('table').scrollTableBody({ rowsToDisplay:10 });

            $.ajax({
                type: "GET",
                url: './api/find_regis_code.php',
                dataType: 'text',
                success: function(response) {
                    $("#regisCode").val(response);
                }
            });

            $('[id="manager-regis-form"]').submit(function(event){
                event.preventDefault();
                var formData = new FormData();
                formData.append('name', $("#name").val());
                formData.append('surname', $("#surname").val());
                formData.append('position', $("#position").val());
                formData.append('pea_office', $("#pea_office").val());
                formData.append('regisCode', $("#regisCode").val());
                $.ajax({
                    url: './api/add_manager_data.php',
                    method: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $.blockUI({ message:'<h3>กำลังนำเข้าสู่ระบบ...</h3>' });
                    },
                    success: function(response) {
                        alert(response);
                    },
                    complete: function() {
                        $.unblockUI();
                        location.reload();
                    }
                });
                return false;
            });
        });
    </script>
</html>