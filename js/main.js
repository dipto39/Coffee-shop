const caro1 = document.querySelector('.caro1');
const caro2 = document.querySelector('.caro2');
const caro3 = document.querySelector('.caro3');
const next = document.querySelector('.next')
const prev = document.querySelector('.prev')

// hide extra carosoul
// caro2.style.display = "none";
// caro3.style.display = "none";

// next 
next.addEventListener("click", function (e) {
    if (!caro1.hasAttribute("style")) {
        caro1.setAttribute("style", "display:none")
        caro2.removeAttribute("style")
        caro3.setAttribute("style", "display:none")
        return false
    }
    if (!caro2.hasAttribute("style")) {
        caro1.setAttribute("style", "display:none")
        caro3.removeAttribute("style")
        caro2.setAttribute("style", "display:none")
        return false

    }
    if (!caro3.hasAttribute("style")) {
        caro2.setAttribute("style", "display:none")
        caro1.removeAttribute("style")
        caro3.setAttribute("style", "display:none")
        return false

    }
})
// prev 
prev.addEventListener("click", function (e) {
    if (!caro1.hasAttribute("style")) {
        caro1.setAttribute("style", "display:none")
        caro3.removeAttribute("style")
        caro2.setAttribute("style", "display:none")
        return false
    }
    if (!caro3.hasAttribute("style")) {
        caro1.setAttribute("style", "display:none")
        caro2.removeAttribute("style")
        caro3.setAttribute("style", "display:none")
        return false

    }
    if (!caro2.hasAttribute("style")) {
        caro2.setAttribute("style", "display:none")
        caro1.removeAttribute("style")
        caro3.setAttribute("style", "display:none")
        return false
    }

})
// start carosul
setInterval(() => {
    next.click();
}, 3000);

// show and hide menu
document.querySelector(".menu_bar").addEventListener("click", function (e) {
    if (!document.querySelector('.menu').hasAttribute("style")) {
        document.querySelector('.menu').style.display = "none"
    } else {
        document.querySelector('.menu').removeAttribute('style')
    }
})
// responsive problem on resize
window.addEventListener("resize", function () {
    if (document.body.clientWidth > 700) {
        document.querySelector('.menu').style.display = "block"

    } else {
        document.querySelector('.menu').style.display = "none"

    }
})
if (document.body.clientWidth < 700) {
    document.querySelector('.menu').style.display = "none"

}
// get loading
function loadingOn() {
    document.querySelector('.loader').style.display = "block";
}

function loadingOff() {
    document.querySelector('.loader').style.display = "none";
}
// pas data in database by fetch api

// send contact data
document.addEventListener("submit", function (e) {
    e.preventDefault();
    if (e.target == cform) {
        if (cname.value == "" || cmessage.value == "" || cemail == "") {
            alert("please fillup all field");
        } else {
            if (cmessage.value.length > 100) {
                alert("Your message is too long");
            } else {
                var datad = "name=" + cname.value + "&email=" + cemail.value + "&message=" + cmessage.value + "&contact=ok"
                fetch("responess.php", {
                        method: "post",
                        headers: {
                            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                        },
                        body: datad,
                        beforesend:loadingOn()
                    })
                    .then((res) => res.text())
                    .then((data) => {
                        loadingOff()
                        data = JSON.parse(data)
                        if (data.status == true) {
                            cform.reset();
                            alert("we will contact you")
                        }
                        if (data.status == false) {
                            alert(data.message)
                        }
                    })
            }
        }
    }

})

// send booking data
document.addEventListener("submit", function (e) {
    e.preventDefault();
    if (e.target == bform) {
        if (bname.value == "" || mobile.value == "" || bdate.value == "" || ttyp.value == "" || btime.value == "") {
            alert("please fillup all field");
        } else {
            if (/(^(\+88|0088)?(01){1}[3456789]{1}(\d){8})$/gi.test(mobile.value)) {
                var datad = "name=" + bname.value + "&mobile=" + mobile.value + "&date=" + bdate.value + "&ttyp=" + ttyp.value + "&time=" + btime.value + "&placeOrder=ok"
                fetch("responess.php", {
                        method: "post",
                        headers: {
                            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                        },
                        body: datad,
                        beforesend:loadingOn()
                    })
                    .then((res) => res.text())
                    .then((data) => {
                        loadingOff()
                        data = JSON.parse(data)
                        if (data.status == false) {
                            if (data.error == "name") {
                                alert("Name is invalid")
                                bname.focus();
                            }
                            if (data.error == "mobile") {
                                alert("mobile is invalid")
                                mobile.focus();
                            }
                            if (data.error == "date") {
                                alert("date is invalid")
                                bdate.focus();
                            }
                            if (data.error == "time") {
                                alert("Time is invalid")
                                btime.focus();
                            }
                            if (data.error == "bussy") {
                                alert("Something went wrong")
                                bdate.focus();
                                btime.focus();
                            }
                            if (data.error == "insert") {
                                alert("somethin went wrong")
                            }
                        } else if (data.status == true) {
                            alert("Thank you... we will contact you.")
                            bform.reset()
                        }
                    })
            } else {
                alert("please inter a valid phone number")
                mobile.focus();
            }
        }
    }

})