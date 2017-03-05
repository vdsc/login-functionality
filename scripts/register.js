function register(e){
    e.preventDefault();//will not take the browser to a new URL
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var confirmation = document.getElementById('password_confirm').value;
    var isValid = validatePassword(password,confirmation) && validateUsername(username);
    //For testing
    //var isValid = true;
    if(isValid){
        var data = {};
        data.username = username;
        data.password = password;
        document.getElementById('username').value = '';  // clears fields
        document.getElementById('password').value = '';
        document.getElementById('password_confirm').value = '';
        //Post the data here
        postForm(data)
    }
    else{
        console.log("Invalid Password");
    }
}

function validatePassword(password,confirm){
    if(confirm == password){
        if(password.length > 7){//If its at least 8 characters
            if(password.match(".*\\d+.*")){//If it contains a digit
                if((/[a-z]/.test(password)) && (/[A-Z]/.test(password))){//If it has one lower and one upper
                    //Other validating
                    return true;
                }    
            }
        }
    }
    return false;
}

function validateUsername(username){
    //Validate username rules
    return username.length > 0;
}

function postForm(data){
  //This ugliness would be how to make an AJAX call w/o jQuery
  /*var xhttp = new XMLHttpRequest();
  xhttp.setRequestHeader("Content-type", "application/json");
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(JSON.parse(xhttp.responseText) == true){
          alert("Successfully registered");
      }
      else{
          alert("Retrieved but registered unsuccessfully");
      }
    }
  };
  xhttp.open("POST", "../server_scripts/register.php", true);
  xhttp.send(JSON.stringify(data));*/
  console.log("Incoming data" + data);
  $.ajax({
    type: "POST",
    url: "../server_scripts/register.php",
    data: JSON.stringify(data),
    success: function(response){
    //   if(JSON.parse(response)["error"]==true){
    //       alert("username already exists, try another one");
    //   }
    //   else{
    //       alert("Unsuccessful registration Reason: "+ JSON.parse(response)["reason"]);
    //   }
        // console.log(JSON.parse(response));
        console.log(response);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
     console.log(XMLHttpRequest,textStatus,errorThrown);
  }
});//ajax ends here
}
postForm({"username":"ekhaembb","password":"moynahan"});

