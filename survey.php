<html>
  <head>
    <title></title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
    <script>
      console.log($)
      var name
      liff.init(function(data){
        // var userId = data.context.userId;
        // alert(userId)
      },function(err){
        alert(err)
      });

      liff.getProfile().then(function(profile){
        name = profile.displayName
        alert(name)
      }).catch(function(err){
        console.log('error', err)
      })
    </script>
  </head>
  <body>
    <iframe src="https://goo.gl/forms/6soeXkYmScDaWJ1I2"></iframe>
  </body>
</html>