<div class="toast -success" id="toast">
    <?= $toast ?>
</div> 

<script>
    var toast = document.getElementById('toast');

    if(toast){
        toast.classList.add("launch");
    }

    toast.addEventListener("animationend", function() {
        toast.classList.remove("launch");
    }
);
</script>