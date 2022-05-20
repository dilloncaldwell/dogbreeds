<?php
$curl = curl_init();
$search_breed = 'pitbull';
if(isset($_POST['breed-select'])){
    $search_breed = $_POST['breed-select'];
}
$url = "https://dog.ceo/api/breed/$search_breed/images";
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
$result_json = json_decode($result);
$images = $result_json->message;
curl_close($curl);
// pulls images of dog breeds from this api https://dog.ceo/dog-api/documentation/
// php to get images & javascript to fill the select dropdown
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dog Images by Breed</title>
    <style>
        body{
            display:flex; 
            flex-direction:column; 
            width:100%; 
            min-height:100vh;
            align-items:center;
            background: linear-gradient(#cccccc, #696969);
            overscroll-behavior: none;
        }
        .form-container{
            margin:30px 0;
        }
        select[name='breed-select']{
            padding:10px;
            width:500px;
        }
        input[type='submit']{
            padding:10px;
            background-color:#577396;
            border:1px solid #577396;
            color:#ffffff;
        }
        input[type='submit']:hover{
            background-color:#575298;
            color:#ffffff;
        }
        .images-container{
            display:flex; 
            width:100%; 
            flex-wrap:wrap; 
            Justify-content:center; 
            gap:10px;
        }
    </style>
</head>
<body>
    <h1>Select A Dog Breed</h1>
    <div class="form-container">
        <form method="post">
            <!-- <input type="text" name="breed" placeholder="Enter Dog Breed..."> -->
            <select name="breed-select" id="breed-select">
            <option selected disabled hidden>Select a breed.. </option>
            </select>
            <input type="submit" value="Request Images">
        </form>
        
    </div>
    <div class="images-container" >
        <?php
            for($i=0; $i<count($images); $i++){
                echo "<img src='$images[$i]' width='300px' >";
            }
        ?>
    </div>
<script>
    const breedSelect = document.getElementById("breed-select");
    const getBreeds = async () => {
        const response = await fetch("https://dog.ceo/api/breeds/list");
        const breeds = await response.json();
        return breeds.message;
    }
    document.addEventListener("DOMContentLoaded", async () => {
        try {
            const options = await getBreeds();
            for(let j=0; j<options.length; j++){
                const newOption = document.createElement("option");
                newOption.value = options[j];
                newOption.text = options[j];
                breedSelect.appendChild(newOption);
            }
        } catch (e) {
            console.log("Error!");
            console.log(e);
        }
    });
</script>

</body>
</html>
