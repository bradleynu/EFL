<?php /** Template Name: seotemplate */
get_header();
$hero = get_field('hero');
$contenido = get_field('contenido');
$btnTitle = get_field('titulo');
$btnGroup = get_field('btn_group');
?>
<style>
	/* Estilos para la firma del doctor */
.doctor-signature {
   border-top: 1px solid #e0e0e0;
   margin-top: 40px;
   padding-top: 20px;
   text-align: center;
   font-style: italic;
   color: #555;
}
.doctor-signature img {
   max-width: 150px;
   margin-bottom: 10px;
}
.doctor-name {
   font-weight: bold;
   color: #0ba42c;
}
   body.page-template-seotemplate {
      margin-top: 113px;
   }
	#hero1 {
		    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
	}
   #hero1 .info {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      padding: 63px 0px;
   }

   #hero1 .info h1 {
      color: white;
      font-size: 6rem;
      text-transform: uppercase;
      border-bottom: 5px solid #0ba42c;
   }

   #hero1 .info h2 {
      color: white;
      font-size: 30px
   }

   #pgrid .cont {
      text-align: center;
      padding: 25px 0;
   }

   #pgrid .cont p {
      font-size: 23px;
   }

   #pgrid .pgridinfo .item {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 31px 0;
   }

   #pgrid {
      padding: 40px 0;
   }

   p span a {
      border-bottom: 1px solid #0ba42c;
      font-size: inherit;
      color: #0ba42c !important;
      font-weight: 600;
   }


   .btn-group-buy {
      margin-bottom: 10px;
   }

   .btn-group-buy>.amazon {
      background: #f2c961;
      padding: 10px 25px;
      color: black;
      font-weight: bold;
      border-radius: 10px;
      width: 100%;
      display: block;
   }

   .btn-group-buy>.pts-venta {
      background: #297abb;
      padding: 10px 25px;
      color: white;
      font-weight: bold;
      border-radius: 10px;
      width: 100%;
      display: block;
   }

   .btn-group-buy>.carrito {
      background: #094d75;
      padding: 10px 25px;
      color: white;
      font-weight: bold;
      border-radius: 10px;
      width: 100%;
      display: block;
   }

   /* 
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/

   @media (min-width: 320px) and (max-width: 480px) {

      #hero1 .info h1 {
         font-size: 3rem;
         max-width: 80%;
      }

      #hero1 .info h2 {
         font-size: 20px;
         margin: 0 8%;
         text-align: center;
      }

      #pgrid .cont p {
         font-size: 20px;
         text-align: justify;
      }

      #pgrid .cont {
         padding-right: 15px;
         padding-left: 15px;
      }

	   p a img {
   		 margin: 0px auto;
    	 display: flex;
	  }	
	   
      .pgridinfo {
         display: grid;
         grid-template-columns: repeat(2, 1fr);
      }

      .btn-group-vertical>.btn-group:after,
      .btn-group-vertical>.btn-group:before,
      .btn-toolbar:after,
      .btn-toolbar:before,
      .clearfix:after,
      .clearfix:before,
      .container-fluid:after,
      .container-fluid:before,
      .container:after,
      .container:before,
      .dl-horizontal dd:after,
      .dl-horizontal dd:before,
      .form-horizontal .form-group:after,
      .form-horizontal .form-group:before,
      .modal-footer:after,
      .modal-footer:before,
      .modal-header:after,
      .modal-header:before,
      .nav:after,
      .nav:before,
      .navbar-collapse:after,
      .navbar-collapse:before,
      .navbar-header:after,
      .navbar-header:before,
      .navbar:after,
      .navbar:before,
      .pager:after,
      .pager:before,
      .panel-body:after,
      .panel-body:before,
      .row:after,
      .row:before {
         display: none;
      }

   }
	.btn-group-buy {
		display: flex; 
		justify-content: center; 
		align-content: center;
	}
	.btn-group-buy a {
		width: 100%;
		text-align: center;
		padding: 10px 20px;
		border-radius: 10px;
		font-weight: bold;
	}
	.btn-group-buy.amazon a {
		color: black;
		background-color: #f1c557;
	}
	.btn-group-buy.amazon a:hover {
		background-color: #dcb24a;
	}
	.btn-group-buy.pts-venta a {
		color: white;
		background-color: #297abb;
	}
	.btn-group-buy.pts-venta a:hover {
		background-color: #226ba5;
	}
	.btn-group-buy.carrito a {
		color: white;
		background-color: #094d75;
	}
	.btn-group-buy.carrito a:hover {
		background-color: #073e5f;
	}
	#buy-container {
		padding: 40px 0px;
	}
	#buy-container h2 {
		margin-bottom: 30px;
	}
</style>
<section id="hero1" style="background-image: url('<?php echo $hero['background'] ?>')">
   <div class="container">
      <div class="row">
         <div class="col-md-12 info">
            <?php echo $hero['maintitle'] ?>
         </div>
      </div>
   </div>
</section>

<section id="buy-container">
   <div class="container">
	   <div class="row">
		   <div class="col-md-12 text-center">
			   <h2><strong><?php echo $btnTitle; ?></strong></h2>
		   </div>
	   </div>
      <div class="row row-center flex">
    <?php foreach ($btnGroup as $index => $button): ?>
        <?php
            $class = '';
            $iconClass = '';
            $defaultText = '';
            $defaultUrl = '';

            // Obtener el idioma actual con Polylang
            $idioma = function_exists('pll_current_language') ? pll_current_language() : 'es';

            // Definir clases, iconos y textos predeterminados según el índice
            switch ($index) {
                case 0:
                    $class = 'amazon';
                    $iconClass = 'fa-amazon';
                    $defaultText = ($idioma == 'es') ? 'Comprar en Amazon' : 'Buy on Amazon';
                    $defaultUrl = '#';
                    break;
                case 1:
                    $class = 'pts-venta';
                    $iconClass = 'fa-location-arrow';
                    $defaultText = ($idioma == 'es') ? 'Puntos de venta' : 'Points of Sale';
                    $defaultUrl = ($idioma == 'es') ? 'https://efficientlabs.com/localizador-de-tiendas/' : 'https://efficientlabs.com/en/store-locator/';
                    break;
                case 2:
                    $class = 'carrito';
                    $iconClass = 'fa-shopping-cart';
                    $defaultText = ($idioma == 'es') ? 'Comprar en línea' : 'Buy online';
                    $defaultUrl = ($idioma == 'es') ? 'https://efficientlabs.com/localizador-de-tiendas/' : 'https://efficientlabs.com/en/store-locator/';
                    break;
            }
        ?>

        
            <?php
                // Verificar el idioma y asignar la URL por defecto si es necesario
                $url = ((($idioma == 'es') || ($idioma == 'en')) && empty($button['url_boton'])) ? $defaultUrl : $button['url_boton'];
				
				if ($url != '#'): ?>
		  		<div class="col-md-4 btn-group-buy <?php echo $class; ?>">
					<a target="_blank" href="<?= $url ?>">
						<i class="fa <?= $iconClass ?>" style="margin-right: 5px;"></i>
						<?= ($button['texto_boton'] == "") ? $defaultText : $button['texto_boton'] ?>
					</a>
				</div>
				<?php endif; ?>
			
			
            
        
    <?php endforeach; ?>
</div>
     
   </div>
</section>

<section id="pgrid">
   <div class="container">
      <div class="row">
         <?php foreach ($contenido as $i => $content): ?>
            <div class="col-md-12 cont">
               <?php echo $content['content'] ?>
            </div>
            <?php if ($content['grid']): ?>
               <div class="col-md-12">
                  <div class="row pgridinfo">
                     <?php foreach ($content['grid'] as $x => $item): ?>
                        <div class="col-6 col-md-3 item">
                           <?php echo $item['html'] ?>
                        </div>
                     <?php endforeach; ?>
                  </div>
               </div>
            <?php endif; ?>
         <?php endforeach; ?>
      </div>
   </div>
</section>
<!-- Sección de firma del doctor -->
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="doctor-signature">
            <?php
// Obtener el ID del Dr. Flikier
$doctor_id = 4395; // Asegúrate de usar el ID correcto

// Obtener información del usuario
$doctor = get_userdata($doctor_id);

if ($doctor) {
   // Idioma actual (si usas Polylang)
   $idioma = function_exists('pll_current_language') ? pll_current_language() : 'es';
   
   // Texto según el idioma
   $texto_revisado = ($idioma == 'es') ? 'Revisado y aprobado por:' : 'Reviewed and approved by:';
   
   // Mostrar la firma con formato mejorado
   echo '<p>' . $texto_revisado . ' <span class="doctor-name">Dr. ' . $doctor->display_name . '</span></p>';
   
   // Información del colegio médico con mejor formato
   echo '<p>Colegio de Médicos y Cirujanos de Costa Rica · CMC 2723</p>';
} else {
   // Fallback si no encuentra el usuario
   echo '<p>Revisado y aprobado por: <span class="doctor-name">Dr. Samuel F. Flikier</span></p>';
   echo '<p>Colegio de Médicos y Cirujanos de Costa Rica · CMC 2723</p>';
}
?>
         </div>
      </div>
   </div>
</div>
<?php get_footer(); ?>