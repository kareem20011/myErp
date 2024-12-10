<script>
    $(document).ready(function() {
        const colors = ["#021F59", "#0455BF", "#59100A", "#F27329", "#BF3326"];
        $(".mainCategory").each(function(index) {
            const randomIndex = Math.floor(Math.random() * colors.length);
            const randomColor = colors[randomIndex];
            $(this).css("background-color", randomColor);
        });
    });
</script>
