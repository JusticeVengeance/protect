<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Protect Sale and Create Customer</title>
    </head>
    <style>
    div {
      height: 200px;
      width: 70%;
    }
    </style>
    <body>
      <?php

     /* This code will shows how to access and make a request of OAuth token  */

     include 'PhpApiSettings.php';
     include 'Utilities.php';
     include 'Json.php';


     //call a function of Utilities.php to generate oAuth toaken
     $oauth_result = oAuthTokenGenerator();

     $oauth_moveforward = isFoundOAuthTokenError($oauth_result);

     //If IsFoundOAuthTokenError results True, means no error
     //next is to move forward for the actual request

     if(!$oauth_moveforward){
         //Decode the Raw Json response.
         $json = jsonDecode($oauth_result['temp_json_response']);
         //displayOAuth($json);
         //set Authentication value based on the successful oAuth response.
         //Add a space between 'Bearer' and access _token
         $oauth_token = sprintf("Bearer %s",$json['access_token']);

     }
     //call a function in Utilities.php to generate Protect Auth toaken
     $clientKeyResult= ProtectAuthTokenGenerator($oauth_token);
     $json = jsonDecode($clientKeyResult['temp_json_response']);
     //displayProtectAuth($json);
     $clientkey = "IQLp6EoJIDkyBosiZnMpSw==.RcPpK3voHBHGKRBWctkvaPm3ATYlWbt4j0pbJqxuju4Gas3xiX/klKO9XOpaYXn68D+5VkxzHSh881doT5wTx/Sze7RcbcwH/xgMyP9+e4iPR5+Nx3zf6N7txroAaYdYnEtBE1Jlnr5LgbyS3yw3+041XB/+iQlw1lwL/mDe++jnKFginWrdTTsMhf+8pzvjznfsz1SW1FGvQinkVL/CCGwPQcSzz36UA7CnJ5R1TANoHu4hf0hhdpIRBQIgrAW0jCpCtnYDSKJGMc/rkitvq4hnFOMfUkbL5awSpqnurf3EL2gT8P6rmkjG22LFMUuz5eToMk11V4c8xAwga/sQ5J467/Pq1TUCpsDUn13v26j2hGyI7tyVCIPu9hDTQ2/a0kHWOctTouQlj7vlzlIR9y+EjCmG9D2zj1L7TgBcFYehW7KgqqfZC4kTOvUHx3XJJW1bBXeQcxN2BMfOkJJThH7cN0Fm/eHSPrRc2HE6BI0=";



     //function to display the individual keys of successful OAuth Json response
     function displayOAuth($json_string){

         //Display the output
         echo "<br><br> OAuth Response : ";
         echo "<br>access_token : ".$json_string['access_token'] ;
         echo "<br>token_type : ".$json_string['token_type'] ;
         echo "<br>expires_in : ".$json_string['expires_in'] ;
     }

     //function to display the individual keys of successful OAuth Json response
     function displayProtectAuth($json_string){

         //Display the output
         echo "<br><br> OAuth Response : ";
         echo "<br><br>clientkey : ".$json_string['clientKey'] ;

     }

      ?>
        <form id="ProtectForm"  action="ProtectSaleCreateCustomerJSON.php" method="post"  >
            <div id='pt_hpf_form'>
              <script src='https://protect.paytrace.com/js/protect.min.js'></script>
              <script>

              document.getElementById("ProtectForm").addEventListener("submit",function(e){
                e.preventDefault();
                e.stopPropagation();

              });

                PTPayment.setup({

                  authorization:
                  {
                      'clientKey': "<?php echo $clientkey;?>"
                  }
                }).then(function(instance){
                  document.getElementById("ProtectForm").addEventListener("submit",function(e){
                    e.preventDefault();
                    e.stopPropagation();


      instance.process()
      .then( (r) => submitPayment(r))
      .catch( (err) => handleError(err));

});
});

function handleError(err){
  document.write(JSON.stringify(err));
}

function submitPayment(r){

  var hpf_token = document.getElementById("HPF_Token");
  var enc_key = document.getElementById("enc_key");
  var oAuth = document.getElementById("oAuth");
  hpf_token.value = r.message.hpf_token;
  enc_key.value = r.message.enc_key;
  //document.write ("hpf token = " + hpf_token.value + " enc_key = " + enc_key.value + "oAuth = " + oAuth.value);
  //document.getElementById("ProtectForm").submit();
        console.log(enc_key.value);
        console.log(hpf_token.value);
}
              </script>
            </div>
            <input type="txt" id=HPF_Token name= HPF_Token hidden>
            <input type="txt" id=enc_key name = enc_key hidden>
            <input type="txt" id=oAuth name = oAuth hidden>
            <p>Amount:<input type="txt" id=amount name = amount ></p>
            <p>Customer Id:<input type="txt" id=customerId name = customerId ></p>
            <p>Name:<input type="txt" id=name name = name ></p>
            <p>AddressId:<input type="txt" id=address name = address ></p>
            <p>City:<input type="txt" id=city name = city ></p>
            <p>State:<input type="txt" id=state name = state ></p>
            <p>Zip:<input type="txt" id=zip name = zip ></p>
            <input type="submit" value="Submit" id="SubmitButton"/>

        </form>

        <br>
            <a href="Default.html">Back to Home </a>
        <br>

    </body>
</html>
