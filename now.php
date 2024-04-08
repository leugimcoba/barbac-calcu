<?php
$currentValue = 0;
$input = [];

function getInputAsString($values){
    $o = "";
    foreach ($values as $value){
        $o .= $value;
    }
    return $o;
}

function calculateInput($userInput){
    // format user input
    $arr = [];
    $char = "";
    foreach ($userInput as $num){
        if(is_numeric($num) || $num == "."){
            $char .= $num;
        }else if(!is_numeric($num)){
            if(!empty($char)){
                $arr[] = $char;
                $char = "";
            }
            $arr[] = $num;
        }
    }
    if(!empty($char)){
        $arr[] = $char;
    }
    // calculate user input

    $current = 0;
    $action = null;
    for($i=0; $i<= count($arr)-1; $i++){
        if(is_numeric($arr[$i])){
            if($action){
                if($action == "+"){
                    $current = $current + $arr[$i];
                }
                if($action == "-"){
                    $current = $current - $arr[$i];
                }
                if($action == "x"){
                    $current = $current * $arr[$i];
                }
                if($action == "/"){
                    $current = $current / $arr[$i];
                }
                if($action == "%"){
                    $current = $current % $arr[$i];
                }
                $action = null;
            }else{
                if($current == 0){
                    $current = $arr[$i];
                }
            }
        }else{
            $action = $arr[$i];
        }
    }
    return $current;
}

$rep="";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['input'])){
        $input = json_decode($_POST['input']);
    }


    if(isset($_POST)){
        
        foreach ($_POST as $key=>$value){
            if($key == 'squareroot'){
                $currentValue = sqrt(floatval(getInputAsString($input)));
                $input = [];
                $input[] = $currentValue;
             }
             elseif($key == 'square'){
                $currentValue = pow(floatval(getInputAsString($input)),2);
                $input = [];
                $input[] = $currentValue;
             }
            elseif($key == 'equal'){
               $currentValue = calculateInput($input);
               $input = [];
               $input[] = $currentValue;
            }elseif($key == "c"){
                $input = [];
                $currentValue = 0;
            }elseif($key == "clearEntry"){ // Handle Clear Entry button
                array_pop($input); // Remove the last entered value
                $currentValue = calculateInput($input); // Recalculate the current value
            }elseif($key == "back"){
                $lastPointer = count($input) -1;
                if(is_numeric($input[$lastPointer])){
                    array_pop($input);
                }
            }elseif($key != 'input'){
                $input[] = $value;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .calculator {
            width: 300px;
            margin: 50px auto;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .calculator h3 {
            text-align: center;
            margin: 10px 0;
            padding: 0;
        }

        .display {
            width: 75%%;
            padding: 10px;
            text-align: right;
            border-bottom: 1px solid #ccc;
            background-color: #f9f9f9;
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            width: 25%;
        }

        .button {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            border: none;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            background-color: #e6e6e6;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #d9d9d9;
        }

        .button:active {
            background-color: #ccc;
        }

        .clear {
            background-color: #ff6666;
            color: #fff;
            font-weight: bold;
        }

        .clear:hover {
            background-color: #ff4d4d;
        }
        @media screen and (min-width: 768px) {
            /* For tablets and desktops */
            .calculator {
                width: 400px;
            }
        }

        @media screen and (min-width: 992px) {
            /* For laptops and desktops */
            .calculator {
                width: 500px;
            }
        }

        @media screen and (max-width: 767px) {
            /* For phones */
            .calculator {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="calculator">
        <h3>GWAPO SIR</h3>
        <div class="display">
            <input type="text" value="<?php echo getInputAsString($input);?>" style="width: 100%; border: none; background: none; text-align: left; font-size: 20px;" readonly>
        </div>
        <form method="post" id="form">
            <table>
                <tr>
                <td><input class="button clear" type="submit" name="clearEntry" value="&#9003;"></td>
                    <td><input class="button clear" type="submit" name="c" value="C"></td>
                    <td><input class="button" type="submit" name="modulus" value="%"></td>
                    <td><input class="button" type="submit" name="squareroot" value="√"></td>
                    
                </tr>
                <tr>
                    <td><input class="button" type="submit" name="7" value="7"></td>
                    <td><input class="button" type="submit" name="8" value="8"></td>
                    <td><input class="button" type="submit" name="9" value="9"></td>
                    <td><input class="button" type="submit" name="divide" value="/"></td>
                </tr>
                <tr>
                    <td><input class="button" type="submit" name="4" value="4"></td>
                    <td><input class="button" type="submit" name="5" value="5"></td>
                    <td><input class="button" type="submit" name="6" value="6"></td>        
                    <td><input class="button" type="submit" name="multiply" value="x"></td>
                </tr>
                <tr>
                    <td><input class="button" type="submit" name="1" value="1"></td>
                    <td><input class="button" type="submit" name="2" value="2"></td>
                    <td><input class="button" type="submit" name="3" value="3"></td>
                    <td><input class="button" type="submit" name="minus" value="-"></td>
                </tr>
                <tr>
                    <td><input class="button" type="submit" name="zero" value="0"></td>
                    <td><input class="button" type="submit" name="." value="."></td>
                    <td><input class="button" type="submit" name="add" value="+"></td>
                    <td><input class="button equal" type="submit" name="equal" value="="></td>
                </tr>
            </table>
            <input class="form-control" type="hidden" name="input" value='<?php echo json_encode($input);?>'>
        </form>
    </div>
</body>
</html>


