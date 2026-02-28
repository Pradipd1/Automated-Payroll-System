<?php if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"){ ?>
    </div>
<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
setTimeout(function(){
    var alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert){
        alert.style.transition = "opacity 0.5s ease";
        alert.style.opacity = "0";
        setTimeout(() => alert.remove(), 500);
    });
}, 3000);
</script>

</body>
</html>