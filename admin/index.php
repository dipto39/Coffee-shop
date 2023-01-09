<?php
session_start();
if (isset($_SESSION['email'])) {
    header("location: ./dashboard.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coffee shop || admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h2 {
            font-size: 22px;
            color: #DA9F5B;
            font-family: 'Courier New', Courier, monospace;
            margin-bottom: 20px;
        }

        .login_body {
            background-color: rgb(248, 255, 218);
            padding: 20px;
            border-radius: 10px;

        }

        .error {
            text-align: center;
            padding: 5px;
            background-color: rgb(243, 38, 38);
            color: white;
            margin-bottom: 4px;
            display: none;
        }

        .login_body input {
            width: 100%;
            padding: 6px;
            font-size: 18px;
            outline: #DA9F5B;
            margin-top: 16px;
            ;
            border: 1px solid #DA9F5B;
            /* outline: 2px solid #DA9F5B; */
        }

        .login_body input[type="submit"] {
            background-color: #DA9F5B;
            border: none;
            color: white;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Coffee Shop login | admin</h2>
        <div class="login_body">
            <div class="error">
                this is a error message
            </div>
            <form id="lform" method="post">
                <label for="email">
                    <input type="email" name="email" placeholder="email" id="email">
                </label>
                <label for="password">
                    <input type="password" name="password" id="password" placeholder="password">
                </label>
                <input type="submit" name="submit" value="Login">
            </form>
        </div>
    </div>
    <script>
        document.querySelector("#lform").addEventListener("submit", function(e) {
            e.preventDefault()
            if (email.value == "" || password.value == "") {
                alert('requere all fild')
            } else {
                fetch("responess.php", {
                        method: "post",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
                        },
                        body: "email="+email.value+"&password="+password.value+"&login="+password.value
                    })
                    .then(function(res) {
                        return res.text()
                    })
                    .then((data) => {
                        data=JSON.parse(data);
                        if (data.status === true) {
                            window.location.href = "./dashboard.php";
                        } else {
                            document.querySelector(".error").innerHTML = "Emali or passowrd not match";
                            document.querySelector(".error").style.display = "block";
                        }
                    })
            }
        })
    </script>
</body>

</html>