function login(e){
    e.preventDefault();//will not take the browser to a new URL
    var username = document.getElementById('uname').value;
    var password = document.getElementById('psw').value;
    var if_not_empty = checkfields(username,password);
    if(if_not_empty)
    {
     var data = {};
        data.username = username;
        data.password = password;
        document.getElementById('uname').value = '';
        document.getElementById('psw').value = '';
        check_in_db(data);
    }
    

} 
    
   function checkfields(username, password)
    {
        if(username!=null && password !=null)
        {
           return true; 
        }
        return false;
    }
    
function check_in_db(data){
  console.log("Incoming data",JSON.stringify(data));
 
    $.ajax({
    type: "POST",
    url: "../server_scripts/login.php",
    data: JSON.stringify(data),
    success: function(response){
    //   if(!JSON.parse(response)["logged_in"]){
    //       alert("Successfully login");
    //       //TODO: Redirect to the success page
    //   }
    //   else{
    //       alert("Unsuccessful login Reason: "+ JSON.parse(response)["reason"]);
    //   }
    //     console.log(JSON.parse(response));
    console.log(response);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
     console.log(XMLHttpRequest,textStatus,errorThrown);
  }
});//ajax ends here
 
}