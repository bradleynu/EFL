<?php 
/** Template Name: redirect */
get_header();
?>
<section style="
    padding: 22px 0 50px 0;
">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Serás redirigido en 5 segundos...</h3>
                <img src="https://efficientlabs.com/wp-content/uploads/2023/03/1488-1.gif" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</section>
<script>
    setTimeout(function() {
        window.location.href = 'https://amzn.to/2SThfo8';
    }, 5000);
</script>
<?php get_footer(); ?>