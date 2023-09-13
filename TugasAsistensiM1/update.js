document.addEventListener("DOMContentLoaded", function () {
    function updateCheckBox() {
        console.log("test");
        let icon1 = document.getElementById("icon1").checked;
        let icon2 = document.getElementById("icon2").checked;
        let icon3 = document.getElementById("icon3").checked;
        console.log(icon1);
        console.log(icon2);
        console.log(icon3);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("product").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "index.php?icon1=" + icon1 + "&icon2=" + icon2 + "&icon3=" + icon3 + "&update=true", true);
        xmlhttp.send();
    }
    window.updateCheckBox = updateCheckBox;
});

