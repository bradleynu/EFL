<?php 
/** Template Name: contact */
   get_header();
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mapcontact">
            <?php echo do_shortcode('[ultimate_maps id="1"]'); ?>
        </div>
    </div>
    <div class="row" style="padding-bottom: 90px;">
        <div class="col-md-6">
            <div class="contact-form-content">
                <div class="media">
                <div class="pull-left rounded"><i class="fa fa-home">&nbsp;</i></div>
                <div class="media-body">Efficient Laboratories, Inc.<br>
                7715 N.W. 64th Street,&nbsp;Miami, FL 33166</div>
                </div>
                <div class="media">
                <div class="pull-left rounded"><i class="fa fa-phone">&nbsp;</i></div>
                <div class="media-body"><a href="tel:305 805 3456">Llamar: 305 805 3456</a></div>
                </div>
                <div class="media">
                <div class="pull-left rounded"><i class="fa fa-flag-o">&nbsp;</i></div>
                <div class="media-body"><a href="mailto:info@efficientlabs.com">info@efficientlabs.com</a></div>
                </div>
                <div class="media">
                <div class="pull-left rounded"><i class="fa fa-check">&nbsp;</i></div>
                <div class="media-body">De lunes a viernes de<br>
                9:00 a.m. to 5:00 p.m. EST</div>
                </div>
            </div>
            <div class="contact-form-content">
                <p><small>Servicio al cliente / Retornos y reembolsos:</small><br>
                <a href="mailto:info@efficientlabs.com">info@efficientlabs.com</a></p>
            </div>
        </div>
        <div class="col-md-6">
            <?php echo do_shortcode('[contact-form-7 id="5" title="Contact form 1"]'); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>