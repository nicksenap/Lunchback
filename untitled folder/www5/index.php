<?php
require_once('config.php');
require_once('db.php');
if ($config['Client_ID'] === '' || $config['Client_Secret'] === '') {
  echo 'You need a API Key and Secret Key to test the sample code. Get one from <a href="https://www.linkedin.com/secure/developer">https://www.linkedin.com/secure/developer</a>';
  exit;
}
if(isset($_GET['code']))
{
    $url    = 'https://www.linkedin.com/uas/oauth2/accessToken';
    $param  = 'grant_type=authorization_code&code='.$_GET['code'].'&redirect_uri='.$config['callback_url'].'&client_id='.$config['Client_ID'].'&client_secret='.$config['Client_Secret'];
    $return = (json_decode(post_curl($url,$param),true));
    if($return['error'])
    {
        echo 'Some error occured<br><br>'.$return['error_description'].'<br><br>Please Try again.';
    }
    else   
    {
        $url    = 'https://api.linkedin.com/v1/people/~:(id,firstName,lastName,pictureUrls::(original),headline,publicProfileUrl,location,industry,positions,email-address)?format=json&oauth2_access_token='.$return['access_token'];
        $User   = json_decode(post_curl($url));
        $id             = isset($User->id) ? $User->id : '';
        $firstName      = isset($User->firstName) ? $User->firstName : '';
        $lastName       = isset($User->lastName) ? $User->lastName : '';
        $emailAddress   = isset($User->emailAddress) ? $User->emailAddress : '';
        $headline       = isset($User->headline) ? $User->headline : '';
        $pictureUrls    = isset($User->pictureUrls->values[0]) ? $User->pictureUrls->values[0] : '';
        $location       = isset($User->location->name) ? $User->location->name : '';
        $positions      = isset($User->positions->values[0]->company->name) ? $User->positions->values[0]->company->name : '';
        $positionstitle = isset($User->positions->values[0]->title) ? $User->positions->values[0]->title : '';
        $publicProfileUrl = isset($User->publicProfileUrl) ? $User->publicProfileUrl : '';

        $query = "SELECT tag FROM lunchback_user_tags, lunchback_user_profiles
                  WHERE lunchback_user_profiles.id = lunchback_user_tags.user_id
                  AND email = $emailAddress
                  AND lunchback_user_tags.tag_type = 'offering'";
        // mysqli_query($connection,$query);
        // $result = $connection->query($query);



        echo "
        <table border='1' cellpadding='7' style='border-collapse: collapse;'>
            <tr style='text-align: center;'>
                <td colspan='2'><img src='".$pictureUrls."' width='100' /><br>".$headline."</td>
            </tr>
            <tr>
                <td>ID: </td>
                <td>".$id."</td>
            </tr>
            <tr>
                <td>First Name: </td>
                <td>".$firstName."</td>
            </tr>
            <tr>
                <td>last Name: </td>
                <td>".$lastName."</td>
            </tr>
            <tr>
                <td>Email: </td>
                <td>".$emailAddress."</td>
            </tr>
            <tr>
                <td>Job Position: </td>
                <td>".$positionstitle.": ".$positions."</td>
            </tr>
            <tr>
                <td>Location: </td>
                <td>".$location."</td>
            </tr>
            <tr>
                <td>Tags: </td>
                <td><a href='".$publicProfileUrl."' target='_blank'>".$publicProfileUrl."</a></td>
            </tr>
            <tr>
            <th>Offering</th>
            </tr>";
        if($result->num_rows != 0) {
            $rows= $result->fetch_assoc();
        while ($rows= $result->fetch_assoc()){
           $offering = $rows["tag"];
            echo "
            <tr>
            <td>$offering</td>
            </tr>
            ";
            }
        }
       echo "
        </table>
        ";


        
    
}
}
elseif(isset($_GET['error']))
{
    echo 'Some error occured<br><br>'.$_GET['error_description'].'<br><br>Please Try again.';
}
else
{
    echo '<a href="https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id='.$config['Client_ID'].'&redirect_uri='.$config['callback_url'].'&state=98765EeFWf45A53sdfKef4233&scope=r_basicprofile r_emailaddress"><img src="./images/linkedin_connect_button.png" alt="Sign in with LinkedIn"/></a>';
}


function post_curl($url,$param="")
{
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    if($param!="")
        curl_setopt($ch,CURLOPT_POSTFIELDS,$param);
        
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    
    return $result;
}