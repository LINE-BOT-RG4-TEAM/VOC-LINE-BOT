<html>
  <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>LIFF Starter</title>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </head>

  <body>
    <div class="buttongroup">
      <div class="buttonrow">
        <button id="getprofilebutton">Get Profile</button>
      </div>
    </div>

      <div id="profileinfo">
        <h2>Profile</h2>
        <div id="profilepicturediv">
        </div>
        <table border="1">
          <tr>
            <th>userId</th>
            <td id="useridprofilefield"></td>
          </tr>
          <tr>
            <th>displayName</th>
            <td id="displaynamefield"></td>
          </tr>
          <tr>
            <th>statusMessage</th>
            <td id="statusmessagefield"></td>
          </tr>
        </table>
      </div>

      <div id="liffdata">
          <h2>LIFF Data</h2>
          <table border="1">
              <tr>
                  <th>language</th>
                  <td id="languagefield"></td>
              </tr>
              <tr>
                  <th>context.viewType</th>
                  <td id="viewtypefield"></td>
              </tr>
              <tr>
                  <th>context.userId</th>
                  <td id="useridfield"></td>
              </tr>
              <tr>
                  <th>context.utouId</th>
                  <td id="utouidfield"></td>
              </tr>
              <tr>
                  <th>context.roomId</th>
                  <td id="roomidfield"></td>
              </tr>
              <tr>
                  <th>context.groupId</th>
                  <td id="groupidfield"></td>
              </tr>
          </table>
      </div>
      
      <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
      <script>
      window.onload = function (e) {
        liff.init(function (data) {
            initializeApp(data);
        });
      };

      function showLINEProfile(){
        liff.getProfile().then(function (profile) {
          document.getElementById('useridprofilefield').textContent = profile.userId;
          document.getElementById('displaynamefield').textContent = profile.displayName;

          var profilePictureDiv = document.getElementById('profilepicturediv');
          if (profilePictureDiv.firstElementChild) {
              profilePictureDiv.removeChild(profilePictureDiv.firstElementChild);
          }
          var img = document.createElement('img');
          img.src = profile.pictureUrl;
          img.alt = "Profile Picture";
          profilePictureDiv.appendChild(img);

          document.getElementById('statusmessagefield').textContent = profile.statusMessage;
        }).catch(function (error) {
            window.alert("Error getting profile: " + error);
        });
      }
      showLINEProfile()
      </script>
  </body>
</html>