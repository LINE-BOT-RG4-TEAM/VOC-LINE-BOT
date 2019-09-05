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
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
        
        <!-- js -->
        <script src="./assets/jquery/jquery-3.3.1.min.js"></script>
        <script src="./assets/bootstrap/js/bootstrap.js"></script>
        <script src="./assets/blockUI/jquery.blockUI.js"></script>
        <script src="./assets/jqueryScrollTableBody/jqueryScrollTableBody.js"></script>
        <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>ลงทะเบียนการรับการแจ้งเตือนผ่าน LINE Notify</h2>
                    <form>
                        <div class="form-group row">
                            <label for="name" class="offset-sm-3 col-sm-2 col-form-label">ชื่อผู้รับ/ชื่อกลุ่ม</label>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="name" placeholder="ชื่อผู้รับ/กลุ่ม LINE Notify" maxlength="100">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" id="createLink" type="button">สร้างลิงก์</button>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <h4 class="text-center">ลิงก์สำหรับลงทะเบียนการรับการแจ้งเตือน</h4>
                            </div>
                            <div class="offset-sm-3 col-sm-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="authorize_uri" name="authorize_uri" disabled="disabled" />
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" id="copyLink" type="button">คัดลอกลิงก์</button>
                                    </div>
                                </div>
                            </div>                        
                        </div>                  
                    </form>
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
                                        <?=($manager['uid'] == NULL)?"<b style='color:red;'>ยังไม่ได้ลงทะเบียน</b>":"<b style='color:green;'>ลงทะเบียนแล้ว</b>" ?>
                                    </td>
                                    <td>
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
                    <?php 
                        mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </body>
    <script>
        $(function(){
            $("#createLink").click(function(){
                var name = $("#name").val() || "";
                if(name.length === 0) {
                    alert("กรุณากรอกชื่อผู้ใช้ หรือกลุ่มเพื่อรับการแจ้งเตือน");
                    return;
                }
                var authoirze_uri = "https://voc-bot.herokuapp.com/notify_authorize_callback.php?payload="+btoa(name);
                $("#authorize_uri").val(authoirze_uri);
            });

            $("#copyLink").click(function(){

                /* Get the text field */
                var copyText = document.getElementById("authorize_uri");

                if(copyText.value.length === 0){
                    alert("ไม่สามารถคัดลอกได้ เนื่องจากท่านยังไม่ได้กรอกชื่อผู้รับการแจ้งเตือน หรือกดสร้างลิงก์");
                    $("#name").focus();
                    return;
                }

                /* Select the text field */
                copyText.select(); 
                copyText.setSelectionRange(0, 99999); /*For mobile devices*/

                /* Copy the text inside the text field */
                document.execCommand("copy");

                /* Alert the copied text */
                alert("Copied the text: " + copyText.value);
            });
        });
    </script>
</html>