<!DOCTYPE html>
<html>

<?php
ini_set('display_errors', 0);

if (isset($_REQUEST['calculator'])) {
    $op = $_REQUEST['operator'];
    $num1 = $_REQUEST['firstnum'];
    $num2 = $_REQUEST['secondnum'];

    if ($op == "+") {
        $res = $num1 + $num2;
    }
    if ($op == "-") {
        $res = $num1 - $num2;
    }
    if ($op == "*") {
        $res = $num1 * $num2;
    }
    if ($op == "/") {
        $res = $num1 / $num2;
    }
    if ($op == "^") {
        $res = pow($num1, $num2);
    }
    if ($op == "%") {
        $res = $num1 % $num2;
    }

    if ($_REQUEST['firstnum'] == NULL || $_REQUEST['secondnum'] == NULL) {
        echo "<script language=javascript> alert(\"Enter values.\");</script>";
    }
}
?>

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/10.6.4/math.min.js"
        integrity="sha512-iphNRh6dPbeuPGIrQbCdbBF/qcqadKWLa35YPVfMZMHBSI6PLJh1om2xCTWhpVpmUyb4IvVS9iYnnYMkleVXLA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        #container {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            background-color: #d1d1d1;
            border: 3px solid #333;
            border-radius: 20px;
            width: 750px;
            margin: 50px auto;
            padding: 20px 20px;
        }

        #calculator-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        #calculator {
            border-collapse: collapse;
            width: 100%;
            justify-content: space-between;
        }

        #history-container {
            flex: 1;
            border: 2px solid #333;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 5px;
            margin-left: 5px;
            max-height: 424px;
            overflow-y: auto;
        }

        #history-container h3 {
            margin-top: 0;
            margin-bottom: 0;
            text-align: center;
            padding: 10px;
        }

        #history-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        #history-list li {
            border-top: 1px solid #ccc;
            padding: 5px;
            font-size: 16px;
        }

        td {
            border: 0px solid #333;
            text-align: center;
        }

        input[type="text"] {
            width: calc(100% - 4px);
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            border: 2px solid #333;
            border-radius: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="button"]:hover {
            background: linear-gradient(to left top, #773DB6, #FFA800);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            transform: scale(1.05);
            transition: background 0.3s, box-shadow 0.3s, transform 0.3s;
        }

        input[type="button"] {
            display: block;
            width: calc(100% - 4px);
            box-sizing: border-box;
            margin: 2px;
            padding: 15px;
            background: linear-gradient(to left top, #9932CC, #FFD700);
            color: white;
            font-size: 22px;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div id="container">
        <div id="calculator-container">
            <table id="calculator">
                <tr>
                    <td colspan="5">
                        <input type="text" id="answer">
                    </td>
                </tr>
                <tr>
                    <td colspan="1">
                        <input type="button" value="AC" onclick="clear_input()" onkeydown="ans(event)">
                    </td>
                    <td colspan="2">
                        <input type="button" value="sin" onclick="calculateSin()">
                    </td>
                    <td colspan="2">
                        <input type="button" value="cos" onclick="calculateCos()">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" value="C" onclick="clearfield()" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="(" onclick="res('(')" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value=")" onclick="res(')')" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="^" onclick="res('^')" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="%" onclick="calculatePercentage()" onkeydown="ans(event)">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" value="◯" onclick="calculateCircleArea()" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="7" onclick="res('7')" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="8" onclick="res('8')" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="9" onclick="res('9')" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="/" onclick="res('/')" onkeydown="ans(event)">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" value="^³" onclick="calculateCube()" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="4" onclick="res('4')" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="5" onclick="res('5')" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="6" onclick="res('6')" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="*" onclick="res('*')" onkeydown="ans(event)">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" value="√" onclick="calculateSqrt()" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="1" onclick="res('1')" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="2" onclick="res('2')" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="3" onclick="res('3')" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="-" onclick="res('-')" onkeydown="ans(event)">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" value="π" onclick="calculatePi()" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="0" onclick="res('0')" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="." onclick="res('.')" onkeydown="ans(event)">
                    </td>
                    <td>
                        <input type="button" value="=" onclick="calculate()">
                    </td>
                    <td>
                        <input type="button" value="+" onclick="res('+')" onkeydown="ans(event)">
                    </td>
                </tr>
            </table>
        </div>
        <div id="history-container">
            <div>
                <h3>Geçmiş İşlemler</h3>
            </div>
            <div>
                <ul id="history-list">
                    <!-- Hesaplamalar burada listelenecek -->
                </ul>
            </div>
        </div>
    </div>

    <script>

        function res(val) {
            document.getElementById("answer").value += val;
        }

        function clearfield() {
            let st = document.getElementById("answer").value;
            document.getElementById("answer").value =
                st.substring(0, st.length - 1);
        }

        function ans(event) {
            if (event.key == '0' || event.key == '1'
                || event.key == '2' || event.key == '3'
                || event.key == '4' || event.key == '5'
                || event.key == '6' || event.key == '7'
                || event.key == '8' || event.key == '9'
                || event.key == '+' || event.key == '-'
                || event.key == '*' || event.key == '/')
                document.getElementById("answer").value += event.key;
        }

        var cal = document.getElementById("calculator");
        cal.onkeyup = function (event) {
            if (event.keyCode === 13) {
                console.log("Enter");
                let a = document.getElementById("answer").value;
                console.log(a);
                calculate();
            }
        }

        function calculate() {
            let expression = document.getElementById("answer").value;
            if (!expression.trim()) {
                return;
            }
            if (!/[\+\-\*\/\(\)\.^]/.test(expression)) {
                alert("Geçersiz giriş. İşlem alanında en az bir matematiksel terim olmalıdır.");
                return;
            }
            let result = math.evaluate(expression);
            if (result === undefined) {
                alert("Geçersiz giriş. Lütfen geçerli bir matematik ifadesi girin.");
                return;
            }
            document.getElementById("answer").value = result;
            addToHistory(expression + " = " + result);
        }

        function addToHistory(expression) {
            let historyList = document.getElementById("history-list");
            let listItem = document.createElement("li");
            listItem.textContent = expression;
            historyList.appendChild(listItem);
        }

        // Diğer fonksiyonlar buraya ekleniyor

        function clear_input() {
            document.getElementById("answer").value = ""
        }

        function calculateCos() {
            let val = document.getElementById("answer").value;
            let result = Math.cos(parseFloat(val));
            document.getElementById("answer").value = result;
            addToHistory("cos(" + val + ") = " + result);
        }

        function calculateSin() {
            let val = document.getElementById("answer").value;
            let result = Math.sin(parseFloat(val));
            document.getElementById("answer").value = result;
            addToHistory("sin(" + val + ") = " + result);
        }

        function calculatePercentage() {
            let val = document.getElementById("answer").value;
            let num = parseFloat(val);
            if (!isNaN(num)) {
                let result = num / 100;
                document.getElementById("answer").value = result;
                addToHistory("Yüzde(" + num + ") = " + result);
            } else {
                alert("Geçersiz giriş. Lütfen geçerli bir sayı/değer girin.");
            }
        }

        function calculateCircleArea() {
            let val = document.getElementById("answer").value;
            let radius = parseFloat(val);
            if (!isNaN(radius)) {
                let result = Math.PI * Math.pow(radius, 2);
                document.getElementById("answer").value = result;
                addToHistory("Daire Alanı(" + val + ") = " + result);
            } else {
                alert("Geçersiz giriş. Lütfen geçerli bir sayı/değer girin.");
            }
        }

        function calculateCube() {
            let val = document.getElementById("answer").value;
            let num = parseFloat(val);
            if (!isNaN(num)) {
                let result = Math.pow(num, 3);
                document.getElementById("answer").value = result;
                addToHistory("Küp(" + num + ") = " + result);
            } else {
                alert("Geçersiz giriş. Lütfen geçerli bir sayı/değer girin.");
            }
        }

        function calculateSqrt() {
            let val = document.getElementById("answer").value;
            let num = parseFloat(val);
            if (!isNaN(num) && num >= 0) {
                let result = Math.sqrt(num);
                document.getElementById("answer").value = result;
                addToHistory("Karekök(" + num + ") = " + result);
            } else {
                alert("Geçersiz giriş. Lütfen geçerli bir sayı/değer girin.");
            }
        }

        function calculatePi() {
            let val = document.getElementById("answer").value;
            document.getElementById("answer").value += Math.PI;
        }

    </script>
</body>

</html>