<?php 
    require('./libs/database/connect-db.php');
    if(!isset($_GET['officeCode'])){
      header('Location: manager.php?officeCode=J');
      exit();
    }
    $officeCode = $_GET['officeCode'];
    if($officeCode == ""){
      header('Location: manager.php?officeCode=J');
      exit();
    }
    switch ($officeCode) {
      case "J":
        $officeName = "กฟต.1";
        break;
      case "K":
        $officeName = "กฟต.2";
        break;
      case "L":
          $officeName = "กฟต.3";
          break;
      default:
        break;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <title>Manager register</title>
        <!-- css -->
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
        
        <!-- js -->
        <script src="./assets/jquery/jquery-3.3.1.min.js"></script>
        <script src="./assets/bootstrap/js/bootstrap.js"></script>
        <script src="./assets/blockUI/jquery.blockUI.js"></script>
        <script src="./assets/jqueryScrollTableBody/jqueryScrollTableBody.js"></script>
        <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script>
            function copyToClipboard(element) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(element).val()).select();
                document.execCommand("copy");
                $temp.remove();
                alert('คัดลอกไปยัง Clipboard เรียบร้อยแล้ว');
            }

            function editManagerId(managerId){
                var newwindow = window.open("edit_manager.php?manager_id="+managerId, "", "width=500,height=650,left=10,top=10,titlebar=no,toolbar=no,menubar=no,location=no,directories=no,status=no");
                if (window.focus) {
                    newwindow.focus();
                }
                return false;
            }

            function view_manager(officeId){
                var newwindow = window.open("view_manager.php?office_id="+officeId, "รายชื่อผู้จัดการ", "width=900,height=400,left=10,top=10,titlebar=no,toolbar=no,menubar=no,location=no,directories=no,status=no");
                if (window.focus) {
                    newwindow.focus();
                }
                return false;
            }
        </script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>รายชื่อผู้รับการแจ้งเตือนของ <?= $officeName ?></h2>
                        <div class="table-responsive">
                            <table class="table table-hover" id='manager_table'>
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>ตำแหน่ง</th>
                                        <th>การไฟฟ้า</th>
                                        <th>ประเภท กฟฟ.</th>
                                        <th>สถานะ</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $select_manager = "SELECT manager.id AS id, manager.name, manager.surname, manager.position, manager.code, office.office_code, office.office_name, office.office_type, uid FROM tbl_manager manager JOIN tbl_pea_office office ON manager.office_id = office.id WHERE office.office_code LIKE '$officeCode%' AND manager.status = 'A' ORDER BY office.office_code ASC ";
                                        $results_manager = mysqli_query($conn, $select_manager);
                                        $count = 0;
                                        while($manager = mysqli_fetch_array($results_manager)){
                                            ?>
                                    <tr>
                                        <td><?=$count+1 ?></td>
                                        <td><?=$manager['name']." ".$manager['surname'] ?></td>
                                        <td><?=$manager['position'] ?></td>
                                        <td><?=$manager['office_name'] ?></td>
                                        <td><?=$manager['office_type'] ?></td>
                                        <td>
                                            <?=($manager['uid'] == NULL)?"ยังไม่ได้ลงทะเบียน":"ลงทะเบียนแล้ว" ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if($manager['uid'] != NULL){
                                                    $hidden_uid = "uid-".$manager['id'];
                                                    ?>
                                                <button class="btn btn-sm btn-default" onclick="copyToClipboard('#<?=$hidden_uid ?>')">Copy uid</button>
                                                <input type="hidden" name="<?=$hidden_uid ?>" id="<?=$hidden_uid ?>" value="<?=$manager['uid'] ?>" />
                                            <?php 
                                                }
                                                ?>
                                            <button class='btn btn-sm btn-secondary' onclick='editManagerId(<?=$manager['id']?>);'>Edit</button>
                                        </td>
                                    </tr>
                                    <?php 
                                            $count++;
                                        }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    <!-- </form> -->
                    <?php 
                        mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </body>
    <script>
        $(function(){
            $('table').DataTable();

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