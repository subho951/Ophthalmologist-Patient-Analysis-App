function myFunction() {
  document.getElementById("d-none").style.display = "none";
}

function myFunction2() {
    document.getElementById("d-block").style.display = "block";
}

function formReset() {
    document.getElementById("myForm").reset();
}
function formReset2() {
    document.getElementById("myForm2").reset();
}

// admin pin

var otp_inputs = document.querySelectorAll(".otp__digit");
var mykey = "0123456789".split("");
otp_inputs.forEach((_) => {
  _.addEventListener("keyup", handle_next_input);
});
function handle_next_input(event) {
  let current = event.target;
  let index = parseInt(current.classList[1].split("__")[2]);
  current.value = event.key;

  if (event.keyCode == 8 && index > 1) {
    current.previousElementSibling.focus();
  }
  if (index < 4 && mykey.indexOf("" + event.key + "") != -1) {
    var next = current.nextElementSibling;
    next.focus();
  }
  var _finalKey = "";
  for (let { value } of otp_inputs) {
    _finalKey += value;
  }
  if (_finalKey.length == 4) {
    document.querySelector("#_otp").classList.replace("_notok", "_ok");
    document.querySelector("#_otp").innerText = _finalKey;
  } else {
    document.querySelector("#_otp").classList.replace("_ok", "_notok");
    document.querySelector("#_otp").innerText = _finalKey;
  }
}

//DALAVIRY FORM DATA GET

function formdata(){
    var des = document.getElementById("name").value;
    var fn = document.getElementById("mobileno").value;
    var Streetnames = document.getElementById("Streetname").value;
    var fDiv = document.getElementById("delivery-form"); //fDiv stands for "Form Div"
    var hDiv = document.getElementById("data-show"); // hDiv stands for "Hidden Div"

hDiv.style.display = "block";
    document.getElementById("name1").innerHTML = des;
    document.getElementById("mobileno1").innerHTML = fn;
    document.getElementById("Streetname1").innerHTML = Streetnames;
fDiv.style.display = "none";

}

//PICUP FORM DATA GET

function formdata2(){
    var des2 = document.getElementById("name2").value;
    var fn2 = document.getElementById("mobileno2").value;
    var emails2 = document.getElementById("email2").value;
    var fDiv2 = document.getElementById("pickup-form"); //fDiv stands for "Form Div"
    var hDiv2 = document.getElementById("data-show2"); // hDiv stands for "Hidden Div"

hDiv2.style.display = "block";
    document.getElementById("name3").innerHTML = des2;
    document.getElementById("mobileno3").innerHTML = fn2;
    document.getElementById("email3").innerHTML = emails2;
fDiv2.style.display = "none";

}