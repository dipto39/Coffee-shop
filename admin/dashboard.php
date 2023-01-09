<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location: ./");
}
require("./db/pdo.php");
$obj = new database();
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard || coffee shop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            height: 100vh;
            width: 100%;
        }

        header {
            width: 100%;
            background-color: #fff;
            color: #DA9F5B;
            display: flex;
        }

        h3 {
            font-family: 'Courier New', Courier, monospace;
            font-size: 25px;
        }

        .left {
            width: 30%;
            background-color: #341e05;
            padding: 10px;
            text-align: center;

            border-right: 1px solid white;
        }

        .right {
            background-color: #341e05;
            padding: 10px;
            width: 70%;
            display: flex;
            justify-content: space-between;
        }

        .content {
            width: 100%;
            height: 92vh;
            display: flex;

        }

        .leftside {
            background-color: #341e05;
            width: 30%;
            height: 100%;
            border-right: 1px solid white;

        }

        .leftside ul {
            list-style-type: none;
        }

        .leftside li {
            color: #DA9F5B;
            font-size: 18px;
            text-align: center;
            padding: 12px;
            cursor: pointer;
            text-transform: uppercase;
        }

        .leftside li:hover {
            background-color: #493723;
        }

        .active {
            background-color: #755b3d;

        }

        .active_read {
            background-color: rgb(255, 235, 206);
            color: #DA9F5B;
        }

        .rightside {
            width: 70%;
            height: 100%;
            background-color: rgb(255, 235, 206);
            position: relative;
        }

        .d_none {
            display: none;
        }

        a {
            color: red;
        }

        #summery_data {
            height: 100%;
            width: 100%;

        }

        #summery_data .summary_body {
            display: flex;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #summery_data .single {
            padding: 10px;
            text-align: center;
            border: 1px solid #DA9F5B;
            background-color: white;
            border-radius: 10px;
            margin: 10px;
            cursor: pointer;
        }

        .single span {
            font-size: 3rem;
            font-family: 'Courier New', Courier, monospace;
            color: #DA9F5B;
        }

        .single h3 {
            font-size: 20px;
            color: #DA9F5B;
        }

        /*order style */
        #orders {
            padding: 8px;
        }

        #orders h3 {
            text-align: center;
            color: #DA9F5B;
            text-transform: uppercase;
            margin-bottom: 10px;
            ;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ffffff;
        }

        td,
        th,
        tr {
            border: 1px solid #ffffff;
            padding: 5px;
            text-align: center;
        }

        td {
            color: #f18810;
            font-size: 18px;
        }

        th {
            font-size: 22px;
            color: #ffffff;
            background-color: #DA9F5B;
        }

        button {
            outline: none;
            font-size: 17px;
            cursor: pointer;
            border: none;
            background-color: #DA9F5B;
            padding: 5px 7px;
            color: white;
        }

        .modal {
            width: 100%;
            height: 100vh;
            background-color: rgba(199, 127, 19, 0.1);
            position: fixed;
            top: 0;
            display: none;
        }

        .modal_body {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .modal_body span {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 22px;
            color: #DA9F5B;
            cursor: pointer;
        }

        .modal_body h2 {
            color: #DA9F5B;
            margin: 10px 0;
        }

        .modal .action_status {
            display: flex;
            justify-content: space-evenly;
        }

        /* query style */
        .query_head {
            width: 100%;
            display: flex;
            text-align: center;
            font-size: 22px;
            color: #fff;
            background-color: #DA9F5B;

        }

        .unread {
            width: 50%;

            padding: 10px;
            cursor: pointer;
        }

        .read {
            padding: 10px;
            width: 50%;
            cursor: pointer;
        }

        .querys {
            margin-top: 10px;
            padding: 10px;
        }

        /*query model*/
        
        .modal_body input {
            width: 100%;
            margin: 4px 0;
            padding: 6px 8px;
            font-size: 18px;
            text-align: center;
            border: none;
            outline: none;
            background-color: lightgray;
            color: #f18810;
        }

        textarea {
            width: 100%;
            padding: 8px;
            font-size: 18px;
            margin-top: 8px;
        }
        .d-flex{
            display: flex;
            justify-content: space-evenly;
        }
    </style>
</head>

<body>
    <header>
        <div class="left">
            <h3>CS &#9749;</h3>
        </div>
        <div class="right">
            <h3>Dashboard</h3>
            <p>Welcome Admin <a href="logout.php">logout ?</a></p>
        </div>
    </header>
    <div class="content">
        <div class="leftside">
            <ul>
                <li class="active summary_link">summary</li>
                <li class="orders_link">Orders</li>
                <li class="query_link">query</li>
            </ul>

        </div>
        <div class="rightside">

        </div>
    </div>

    <div class="modal">
        <div class="modal_body">
            <span>✖</span>
            <h2>Query Details</h2>
            <form action="">
                <label for="name">
                    Name:
                    <input type="text" value="name" disabled>
                </label>
                <label for="name">
                    Email:
                    <input type="text" value="name" disabled>
                </label>
                <label for="name">
                    Message:
                    <textarea name="" id="" cols="30" rows="10">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Atque, odit sit saepe voluptates animi eos nulla modi corrupti deserunt laboriosam?</textarea>
                </label>

            </form>
            <div class="action_status">
                <button class="confirm">Comfirm</button>
                <button class="delete">Delete</button>
            </div>
        </div>
    </div>
    <script>
        const summary = document.querySelector(".summary_link")
        const order = document.querySelector(".orders_link")
        const query = document.querySelector(".query_link")
        const rightside = document.querySelector(".rightside");

        function get_summary() {
            fetch("responess.php", {
                    method: "post",
                    headers: {
                        "Content-type": "application/x-www-form-urlencoded;charset=UTF-8"
                    },
                    body: "get_summary=ok"
                })
                .then((response) => response.text())
                .then((data) => {
                    rightside.innerHTML = data;
                })


        }
        get_summary();

        //get summary
        summary.addEventListener("click", function() {
            summary.classList.add("active")
            query.classList.remove("active")
            order.classList.remove("active")
            get_summary();
        })

        // get orders
        function get_orders() {
            fetch("responess.php", {
                    method: "post",
                    headers: {
                        "Content-type": "application/x-www-form-urlencoded;charset=UTF-8"
                    },
                    body: "get_orders=ok"
                })
                .then((response) => response.text())
                .then((data) => {
                    rightside.innerHTML = data;
                })

        }
        order.addEventListener("click", function() {
            summary.classList.remove("active")
            query.classList.remove("active")
            order.classList.add("active")
            get_orders();
        })
        //get all query
        function  get_Unread_query() {
            fetch("responess.php", {
                    method: "post",
                    headers: {
                        "Content-type": "application/x-www-form-urlencoded;charset=UTF-8"
                    },
                    body: "get_Unread_query=ok"
                })
                .then((response) => response.text())
                .then((data) => {
                    rightside.innerHTML = data;
                })

        }

        function get_read_query() {
            fetch("responess.php", {
                    method: "post",
                    headers: {
                        "Content-type": "application/x-www-form-urlencoded;charset=UTF-8"
                    },
                    body: "get_read_query=ok"
                })
                .then((response) => response.text())
                .then((data) => {
                    rightside.innerHTML = data;
                })

        }

        /// query button 
        query.addEventListener("click", function() {
            summary.classList.remove("active")
            query.classList.add("active")
            order.classList.remove("active")
            get_read_query()
        })
        document.addEventListener("click", function(e) {

            if (e.target.classList.contains("read")) {
                get_Unread_query()
            }
            if (e.target.classList.contains("unread")) {
                get_read_query()
            }

            // open action model

            if (e.target.classList.contains("take_action")) {
                id = e.target.getAttribute("data-attr");
                document.querySelector(".modal").innerHTML = ` <div class="modal_body">
                    <span class="mclose">✖</span>
                    <h2>Take your Action</h2>
                    <div class="action_status">
                        <button data-attr="` + id + `" class="confirm">Comfirm</button>
                        <button data-attr="` + id + `" class="cancel">Cancel</button>
                    </div>
                </div>`
                document.querySelector(".modal").style.display = "block";
            }
            /// confirm 
            if (e.target.classList.contains('confirm')) {
                id = e.target.getAttribute("data-attr");

                fetch("responess.php", {
                        method: "post",
                        headers: {
                            "Content-type": "application/x-www-form-urlencoded;charset=UTF-8"
                        },
                        body: "confirm_order=" + id
                    })
                    .then((response) => response.text())
                    .then((data) => {
                        data = JSON.parse(data)
                        if (data.status == true) {
                            get_orders();
                            document.querySelector(".modal").style.display = "none";

                        } else {
                            alert("something went worng");
                            document.querySelector(".modal").style.display = "none";

                        }
                    })

            }
            // cancel order
            if (e.target.classList.contains('cancel')) {
                id = e.target.getAttribute("data-attr");

                fetch("responess.php", {
                        method: "post",
                        headers: {
                            "Content-type": "application/x-www-form-urlencoded;charset=UTF-8"
                        },
                        body: "cancel_order=" + id
                    })
                    .then((response) => response.text())
                    .then((data) => {
                        data = JSON.parse(data)
                        if (data.status == true) {
                            get_orders();
                            document.querySelector(".modal").style.display = "none";

                        } else {
                            alert("something went worng");
                            document.querySelector(".modal").style.display = "none";

                        }
                    })

            }

            // close model 
            if (e.target.classList.contains("mclose")) {
                document.querySelector(".modal").style.display = "none";
            }
            // read model
            if (e.target.classList.contains("read_modal")) {
                id = e.target.getAttribute("data-attr");
                fetch("responess.php", {
                        method: "post",
                        headers: {
                            "Content-type": "application/x-www-form-urlencoded;charset=UTF-8"
                        },
                        body: "read_modal=" + id
                    })
                    .then((response) => response.text())
                    .then((data) => {
                        data = JSON.parse(data)
                        if (data.status == true) {
                            document.querySelector(".modal").innerHTML = data.message;
                            document.querySelector(".modal").style.display = "block";
                        } else {
                            alert("something went worng")
                        }
                    })
            }
            // read_it
            if (e.target.classList.contains("read_it")) {
                id = e.target.getAttribute("data-attr");
                fetch("responess.php", {
                        method: "post",
                        headers: {
                            "Content-type": "application/x-www-form-urlencoded;charset=UTF-8"
                        },
                        body: "read_ok=" + id
                    })
                    .then((response) => response.text())
                    .then((data) => {
                        data = JSON.parse(data)
                        if (data.status == true) {
                            document.querySelector(".modal").style.display = "none";
                            get_read_query();
                        } else {
                            alert("something went worng");
                        }
                    })
            }
            // Delet query
            if (e.target.classList.contains("delete_query")) {
                id = e.target.getAttribute("data-attr");
                fetch("responess.php", {
                        method: "post",
                        headers: {
                            "Content-type": "application/x-www-form-urlencoded;charset=UTF-8"
                        },
                        body: "delete_query=" + id
                    })
                    .then((response) => response.text())
                    .then((data) => {
                        data = JSON.parse(data)
                        if (data.status == true) {
                            document.querySelector(".modal").style.display = "none";
                            get_Unread_query();
                        } else {
                            alert("something went worng");
                        }
                    })
            }
        })
    </script>
</body>

</html>