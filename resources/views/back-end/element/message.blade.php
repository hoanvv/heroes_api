<div id="flash-message" class="alert {{ $alert_color }} alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>{{ $flash }}</strong>
</div>
<script>
    var timer = setTimeout(function(){
        var x = document.getElementById("flash-message");
        x.style.display = "none";
        clearInterval(timer);
    }, 7000);
</script>