function validate() {
    // alert("hello");
    let vname = /^[a-z A-Z]+$/;
    var phoneno = /^\d{10}$/;
    let n = document.getElementById("fname").value;
    let m = document.getElementById("lname").value;

    let mregx =
        /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    let em = document.getElementById("email").value;
    let p = document.getElementById("password").value;
    let c_p = document.getElementById("c_password").value;
    let phone = document.getElementById("phone").value;
    let passlen = c_p.length;
    let phlen = phone.length;

    if (n == "") {
        document.getElementById("fname").innerHTML;
        alert("empty feild, please enter the name");
        return false;
    } else if (m == "") {
        document.getElementById("lname").innerHTML;
        alert("empty feild, please enter the name");
        return false;
    } else if (!vname.test(n)) {
        document.getElementById("fname").innerHTML;
        alert("Please enter your fullname");
        return false;
    } else if (!vname.test(m)) {
        document.getElementById("lname").innerHTML;
        alert("Please enter your fullname");
        return false;
    } else if (em == "") {
        document.getElementById("email").innerHTML;
        alert("enter your email id");
        return false;
    } else if (!mregx.test(em)) {
        document.getElementById("email").innerHTML;
        alert("Please include an '@' in the email address. ");
        return false;
    } else if (p != c_p) {
        alert("Passwords do not match.");
        return false;
    } else if (passlen <= 7) {
        document.getElementById("c_password").innerHTML;
        alert("Password length must be atleast 8 characters");
        return false;
    } else if (phone == "") {
        document.getElementById("phone").innerHTML;
        alert("empty feild, please enter the phone number");
        return false;
    } else if (!phoneno.test(phone)) {
        document.getElementById("phone").innerHTML;
        alert("Enter valid phone number");
        return false;
    } else if (phlen != 10) {
        document.getElementById("phone").innerHTML;
        alert("Please enter 10 digit phone number");
        return false;
    } else {
        return true;
    }
}
function login_validate() {
    let mregx =
        /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    let em = document.getElementById("email").value;
    let p = document.getElementById("password").value;
    if (em == "") {
        document.getElementById("email").innerHTML;
        alert("enter your email id");
        return false;
    } else if (!mregx.test(em)) {
        document.getElementById("email").innerHTML;
        alert("Please include an '@' in the email address. ");
        return false;
    } else {
        return true;
    }
}
$(document).ready(function () {
    $(".owl-carousel").owlCarousel({
        items: 1,
        autoplay: true,
        autoplayTimeout: 7000,
        loop: true,
        nav: true,
        dots: false,
    });
});
function showSelect() {
    var selectBox = document.getElementById("mySelect");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    var select2 = document.getElementById("select2");
    var select3 = document.getElementById("select3");
    var btn = document.getElementById("sub-btn");

    if (selectedValue === "option2") {
        select2.style.display = "block";
        select3.style.display = "none";
        btn.style.display = "block";
    } else {
        select2.style.display = "none";
        select3.style.display = "block";
        btn.style.display = "block";
    }
}
