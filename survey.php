<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Information</title>

      <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>

  <body>
    <div id="myModal" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" style='font-weight:bold;'>
              Information
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="row">
                <div class="welcome-column col-md-8 offset-md-2">
                  <div class="text-center">
                    <h4 style="font-weight:bold;">ยินดีต้อนรับ</h4>
                    <h5 id="welcome-text" style="font-weight:bold;"></h5>
                    <br/>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="first-column col-md-6 offset-md-3">
                  <div class="text-center">
                    <img id="avatar" style="height:100px;width:100px;border-radius: 50%;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" />
                  </div>
                </div>
              </div>
              <br/>
              <div class="row">
                <div class="col-12">
                  <p style="text-indent: 20px" class="text-justify">
                    เพื่อปรับปรุงโปรแกรมอัตโนมัติ 'VOC Alert Bot' ให้มีคุณภาพและประสิทธิผลมากยิ่งขึ้น ทางคณะผู้จัดทำ VOC Alert Bot กบว.(ภ4) 
                    ได้จัดทำแบบสอบถาม เพื่อเป็นข้อมูลในการปรับปรุงโปรแกรมอัตโนมัติให้มีประสิทธิภาพ และตรงกับความต้องการมากยิ่งขึ้น
                  </p>
                  <p style="text-indent: 20px" class="text-justify">
                    ทางคณะผู้จัดทำ VOC Alert Bot จึงใคร่ขอความอนุเคราะห์ผู้บริหารสายงานการไฟฟ้า ภาค 4 ทุกท่าน
                    ตอบแบบสอบถาม จักขอบคุณยิ่ง
                  </p>
                  <p class="text-right font-weight-bold font-italic text-justify">
                    คณะผู้จัดทำ VOC Alert Bot กบว.(ภ4)
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิดหน้าต่างนี้</button>
          </div>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
    <script>
      function showLINEProfile(){
        liff.getProfile().then(function (profile) {
          var welcome_text = document.getElementById("welcome-text");
          welcome_text.textContent = "คุณ " + profile.displayName;

          var avatar = document.getElementById("avatar");
          avatar.src = avatar.src = profile.pictureUrl;
        }).catch(function (error) {
            window.alert("Error getting profile: " + error);
        });
      }
    window.onload = function (e) {
      liff.init(function (data) {
        showLINEProfile()
        $('#myModal').modal('show')
        $("#myModal").on('hidden.bs.modal', function(){
          window.location = "https://goo.gl/forms/1TRgTk6TWUpx5O072"
        })
      });
    };
    </script>
  </body>
</html>