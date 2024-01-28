<!DOCTYPE html>
<html lang="en-US">

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
    <!-- AJAX Math Kütüphanesi -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/10.6.4/math.min.js"
        integrity="sha512-iphNRh6dPbeuPGIrQbCdbBF/qcqadKWLa35YPVfMZMHBSI6PLJh1om2xCTWhpVpmUyb4IvVS9iYnnYMkleVXLA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        #container {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            background-color: #d1d1d1;
            border: 2px solid #333;
            border-radius: 30px;
            max-width: 320px;
            margin: 50px auto;
            padding: 20px 20px;
        }

        #calculator-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: flex 0.5s;
        }

        #calculator {
            border-collapse: collapse;
            width: 100%;
            justify-content: space-between;
        }

        #history-container {
            flex: 1;
            border: 2px solid #333;
            border-radius: 30px;
            flex-direction: column;
            justify-content: space-between;
            padding: 5px;
            margin-top: 4px;
            margin-left: 10px;
            max-height: 442px;
            overflow-y: auto;
            display: flex;
            display: none;
            transition: flex 0.5s;
            box-shadow: 0 0px 8px rgba(0, 0, 0, 0.2);
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
            border-radius: 30px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            display: block;
            width: 60px;
            height: 60px;
            box-sizing: border-box;
            margin: 2px;
            padding: 15px;
            color: black;
            font-size: 22px;
            font-weight: bold;
            border: none;
            border-radius: 30px;
            box-shadow: 0 0px 6px rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        input[type="submit"]:hover::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(51, 51, 51, 0.3);
            border-radius: inherit;
            z-index: -1;
        }

        input[type="submit"]:hover {
            box-shadow: 0 0px 12px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
            color: white;
        }

        input.buttonnumber {
            background-color: rgba(255, 215, 0, 1);
        }

        input.buttonoperator {
            background-color: rgba(76, 175, 80, 1);
        }

        input.buttonoperatorfonk {
            background-color: rgba(255, 87, 51, 1);
        }

        input.buttonenter {
            height: 124px;
            background-color: rgba(162, 214, 153, 1);
        }

        input.buttondelete {
            background-color: rgba(208, 154, 177, 1);
        }

        input.buttonhistory {
            background-color: rgba(184, 160, 203, 1);
        }

        #history-container::-webkit-scrollbar {
            width: 12px;
        }

        #history-container::-webkit-scrollbar-thumb {
            background-color: rgba(51, 51, 51, 0.5);
            border-radius: 6px;
        }

        #history-container::-webkit-scrollbar-track {
            background-color: transparent;
        }
    </style>
</head>

<body>
    <?php
    echo "
    <div id=\"container\">
        <div id=\"calculator-container\">
            <table id=\"calculator\">
                <tr>
                    <td colspan=\"4\">
                        <input type=\"text\" id=\"answer\">
                    </td>
                    <td colspan=\"1\">
                        <input type=\"submit\" class=\"buttonhistory\" value=\"G\" onclick=\"toggleHistory()\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type=\"submit\" class=\"buttonoperatorfonk\" value=\"cos\" onclick=\"calculateCos()\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonoperator\" value=\"(\" onclick=\"res('(')\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonoperator\" value=\")\" onclick=\"res(')')\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttondelete\" value=\"C\" onclick=\"clearfield()\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttondelete\" value=\"AC\" onclick=\"clear_input()\" onkeydown=\"ans(event)\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type=\"submit\" class=\"buttonoperatorfonk\" value=\"sin\" onclick=\"calculateSin()\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonoperator\" value=\"^\" onclick=\"res('^')\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonoperator\" value=\"%\" onclick=\"calculatePercentage()\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonoperator\" value=\"/\" onclick=\"res('/')\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonoperator\" value=\"*\" onclick=\"res('*')\" onkeydown=\"ans(event)\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type=\"submit\" class=\"buttonoperatorfonk\" value=\"◯\" onclick=\"calculateCircleArea()\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonnumber\" value=\"7\" onclick=\"res('7')\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonnumber\" value=\"8\" onclick=\"res('8')\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonnumber\" value=\"9\" onclick=\"res('9')\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonoperator\" value=\"-\" onclick=\"res('-')\" onkeydown=\"ans(event)\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type=\"submit\" class=\"buttonoperatorfonk\" value=\"^³\" onclick=\"calculateCube()\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonnumber\" value=\"4\" onclick=\"res('4')\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonnumber\" value=\"5\" onclick=\"res('5')\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonnumber\" value=\"6\" onclick=\"res('6')\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonoperator\" value=\"+\" onclick=\"res('+')\" onkeydown=\"ans(event)\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type=\"submit\" class=\"buttonoperatorfonk\" value=\"√\" onclick=\"calculateSqrt()\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonnumber\" value=\"1\" onclick=\"res('1')\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonnumber\" value=\"2\" onclick=\"res('2')\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonnumber\" value=\"3\" onclick=\"res('3')\" onkeydown=\"ans(event)\">
                    </td>
                    <td rowspan=\"2\">
                        <input type=\"submit\" class=\"buttonenter\" value=\"=\" onclick=\"calculate()\">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type=\"submit\" class=\"buttonoperatorfonk\" value=\"π\" onclick=\"calculatePi()\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonnumber\" value=\"0\" onclick=\"res('0')\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonnumber\" value=\"00\" onclick=\"doubleZero()\" onkeydown=\"ans(event)\">
                    </td>
                    <td>
                        <input type=\"submit\" class=\"buttonoperator\" value=\".\" onclick=\"res('.')\" onkeydown=\"ans(event)\">
                    </td>
                </tr>
            </table>
        </div>
        <div id=\"history-container\">
            <div>
                <h3>Geçmiş İşlemler</h3>
            </div>
            <div>
                <ul id=\"history-list\">
                    <!-- Hesaplamalar burada listelenecek -->
                </ul>
            </div>
        </div>
    </div>";
    ?>
    <script>
        function toggleHistory() {
            var container = document.getElementById('container');
            var calculatorContainer = document.getElementById('calculator-container');
            var historyContainer = document.getElementById('history-container');

            // Geçmiş container'ının görünürlüğünü toggle et
            if (historyContainer.style.display == "none" || historyContainer.style.display == "") {
                container.style.maxWidth = "600px";
                historyContainer.style.display = "flex";
                //calculatorContainer.style.flex = '0 1 auto'; // Calculator alanını sıfıra ayarla
            } else {
                historyContainer.style.display = "none";
                container.style.maxWidth = "320px";
                //calculatorContainer.style.flex = '1'; // Calculator alanını geri ayarla
            }
        }

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
            let a = document.getElementById("answer").value;
            let b = math.evaluate(a);
            document.getElementById("answer").value = b;

            // Hesaplama yapıldığında ifadeyi geçmişe ekle
            addToHistory(a + " = " + b);
        }

        function addToHistory(expression) {
            // Geçmiş listesini al
            let historyList = document.getElementById("history-list");

            // Yeni bir liste öğesi oluştur
            let listItem = document.createElement("li");
            listItem.textContent = expression;

            // Listeye öğeyi ekle
            historyList.appendChild(listItem);
        }

        // Diğer fonksiyonlar buraya ekleniyor

        function clear_input() {
            document.getElementById("answer").value = ""
        }

        function doubleZero() {
            document.getElementById("answer").value += "00";
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