<?php

$first = "first value";

?>

<script>
    function createCookie(name, value, days) {
        var expires;
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        }
        else {
            expires = "";
        }
        document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
        }
    
    function clicked(){
        var second = prompt("enter second value");
        createCookie('second', second);
    }

</script>
<a href="receive.php?first=<?php echo $first?>" onclick="clicked()">click me</a>



