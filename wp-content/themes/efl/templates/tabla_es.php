<?php 
   /* 
    * Template Name: tabla_es 
    */
   
   get_header(); 
   ?>
<style>
body {
	margin-top: 0px!important;
}
header, footer, .logo-floted, .xoo-wsc-markup {
	display: none!important;
   }
   .container-table {
   max-width: 1200px;
   margin: 0 auto;
   padding: 20px;
   }
   /* Header Styles */
   .header-table {
   background-color: #0277bd;
   color: white;
   padding: 20px;
   text-align: center;
   border-radius: 8px 8px 0 0;
   }
   .logo {
   display: flex;
   align-items: center;
   justify-content: center;
   margin-bottom: 15px;
   }
   .logo-icon {
   width: 30px;
   height: 30px;
   margin-right: 10px;
   }
   .logo-text {
   font-size: 22px;
   font-weight: bold;
   letter-spacing: 1px;
   }
   .header-table p {
   color: #fff;
   font-size: 14px;
   line-height: 1.4;
   margin-bottom: 8px;
   }
   /* Table styles */
   .comparison-table {
   width: 100%;
   background-color: white;
   border-radius: 0 0 8px 8px;
   overflow: hidden;
   box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
   }
   .products-row {
   display: grid;
   grid-template-columns: 180px repeat(8, 1fr);
   background-color: #f0f0f0;
   }
   .product-cell {
   padding: 10px 5px;
   text-align: center;
   border-right: 1px solid #e0e0e0;
   }
   /* Product image container styles with hover effect */
   .product-image-container {
   position: relative;
   margin: 0 auto 8px;
   height: 120px;
   overflow: hidden;
   display: flex;
   justify-content: center;
   align-items: center;
   }
   .product-image {
   height: 120px;
   transition: all 0.3s ease;
   }
   /* Buy button styles */
   .buy-button {
   position: absolute;
   bottom: -40px;
   left: 50%;
   transform: translateX(-50%);
   background-color: #0277bd;
   color: white!important;
   padding: 6px 12px;
   border-radius: 4px;
   font-size: 12px;
   font-weight: bold;
   text-transform: uppercase;
   cursor: pointer;
   transition: all 0.3s ease;
   opacity: 0;
   box-shadow: 0 2px 4px rgba(0,0,0,0.2);
   border: none;
   text-decoration: none;
   display: inline-block;
   }
   /* Hover effect for product image container */
   .product-image-container:hover .product-image {
   opacity: 0.7;
   transform: scale(1.05);
   }
   .product-image-container:hover .buy-button {
   bottom: 10px;
   opacity: 1;
   }
   .buy-button:hover {
   background-color: #015b8e;
   }
   .product-name {
   font-size: 12px;
   font-weight: bold;
   line-height: 1.2;
   }
   /* Symptom rows */
   .symptom-row {
   display: grid;
   grid-template-columns: 180px repeat(8, 1fr);
   border-bottom: 1px solid #e0e0e0;
   }
   .symptom-cell {
   padding: 15px 10px;
   background-color: #2e7d32;
   color: white;
   font-size: 14px;
   font-weight: 500;
   border-bottom: 1px solid white;
   }
   .result-cell {
   display: flex;
   justify-content: center;
   align-items: center;
   border-right: 1px solid #e0e0e0;
   background-color: #e1f5fe;
   }
   .x-mark {
   color: #0277bd;
   font-size: 24px;
   font-weight: bold;
   }
   /* Responsive styles */
   @media (max-width: 1024px) {
   .products-row, .symptom-row {
   grid-template-columns: 150px repeat(8, 1fr);
   }
   .product-name {
   font-size: 11px;
   }
   .symptom-cell {
   font-size: 12px;
   padding: 12px 5px;
   }
   }
   @media (max-width: 768px) {
   /* Stack layout for mobile */
   .mobile-accordion {
   display: block;
   }
   .desktop-table {
   display: none;
   }
   .mobile-symptom {
   background-color: #2e7d32;
   color: white;
   padding: 12px 15px;
   margin-bottom: 1px;
   cursor: pointer;
   position: relative;
   }
   .mobile-products {
   display: grid;
   grid-template-columns: repeat(4, 1fr);
   gap: 10px;
   padding: 15px;
   background-color: #e1f5fe;
   border-bottom: 1px solid #ccc;
   }
   .mobile-product {
   text-align: center;
   padding: 10px 5px;
   }
   /* Mobile product image container with hover effect */
   .mobile-product-image-container {
   position: relative;
   height: 180px;
   margin: 0 auto 5px;
   overflow: hidden;
   display: flex;
   justify-content: center;
   align-items: center;
   }
   .mobile-product img {
   height: 130px;
   transition: all 0.3s ease;
   object-fit: contain;
   }
   /* Mobile buy button styles */
   .mobile-buy-button {
   position: absolute;
   bottom: -40px;
   left: 50%;
   transform: translateX(-50%);
   background-color: #0277bd;
   color: white!important;
   padding: 4px 8px;
   border-radius: 4px;
   font-size: 10px;
   font-weight: bold;
   text-transform: uppercase;
   cursor: pointer;
   transition: all 0.3s ease;
   opacity: 0;
   box-shadow: 0 2px 4px rgba(0,0,0,0.2);
   border: none;
   text-decoration: none;
   display: inline-block;
   }
   /* Hover effect for mobile product image container */
   .mobile-product-image-container:hover img {
   opacity: 0.7;
   transform: scale(1.05);
   }
   .mobile-product-image-container:hover .mobile-buy-button {
   bottom: 5px;
   opacity: 1;
   }
   .mobile-product p {
   font-size: 11px;
   line-height: 1.2;
   }
   .has-symptom {
   position: relative;
   }
   .has-symptom::after {
   content: "✓";
   position: absolute;
   top: -5px;
   right: -5px;
   background-color: #0277bd;
   color: white;
   width: 20px;
   height: 20px;
   border-radius: 50%;
   display: flex;
   align-items: center;
   justify-content: center;
   font-size: 12px;
   }
   /* For larger phones, show 4 products per row */
   @media (max-width: 600px) {
   .mobile-products {
   grid-template-columns: repeat(3, 1fr);
   }
   }
   /* For smaller phones, show 2 products per row */
   @media (max-width: 400px) {
   .mobile-products {
   grid-template-columns: repeat(2, 1fr);
   }
   }
   }
   /* For touch devices - make the buy button visible on first touch */
   @media (hover: none) {
   .buy-button, .mobile-buy-button {
   bottom: 10px;
   opacity: 0.9;
   }
   }
</style>
<div class="container-table">
   <!-- Header Section -->
   <div class="header-table">
      <p>Todos nuestros productos son a base de miel, excepto Rompe Pecho® SF y SF FLU que son sin azúcar.</p>
      <p>Nuestros productos contienen extractos de hierbas como la equinácea y el mentol que son conocidos por estimular el sistema inmunológico y tratar los síntomas de forma natural.</p>
   </div>
   <!-- Comparison Table - Desktop Version -->
   <div class="comparison-table desktop-table">
      <!-- Product Images and Names -->
      <div class="products-row">
         <div class="product-cell" style="background-color: #2e7d32; color: white;">
            <!-- Empty cell for the corner -->
         </div>
         <div class="product-cell">
            <div class="product-image-container">
               <img class="product-image" src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_9784-min.png" alt="Rompe Pecho SF FLU">
               <a href="https://efficientlabs.com/es/product/rompe-pecho-sf-flu-6oz-2/" class="buy-button" target="_blank">Comprar</a>
            </div>
            <p class="product-name">Rompe Pecho® SF FLU</p>
         </div>
         <div class="product-cell">
            <div class="product-image-container">
               <img class="product-image" src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7829.png" alt="Rompe Pecho MAX">
               <a href="https://efficientlabs.com/es/product/rompe-pecho-max-2/" class="buy-button" target="_blank">Comprar</a>
            </div>
            <p class="product-name">Rompe Pecho® MAX</p>
         </div>
         <div class="product-cell">
            <div class="product-image-container">
               <img class="product-image" src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7816.png" alt="Rompe Pecho SF sin Azúcar">
               <a href="https://efficientlabs.com/es/product/rompe-pecho-sf-6oz-2/" class="buy-button" target="_blank">Comprar</a>
            </div>
            <p class="product-name">Rompe Pecho® SF sin Azúcar</p>
         </div>
         <div class="product-cell">
            <div class="product-image-container">
               <img class="product-image" src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7823.png" alt="Rompe Pecho EX">
               <a href="https://efficientlabs.com/es/product/rompe-pecho-ex-6oz/" class="buy-button" target="_blank">Comprar</a>
            </div>
            <p class="product-name">Rompe Pecho® EX</p>
         </div>
         <div class="product-cell">
            <div class="product-image-container">
               <img class="product-image" src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_9788-min.png" alt="Rompe Pecho CF">
               <a href="https://efficientlabs.com/es/product/rompe-pecho-cf-6oz-2/" class="buy-button" target="_blank">Comprar</a>
            </div>
            <p class="product-name">Rompe Pecho® CF</p>
         </div>
         <div class="product-cell">
            <div class="product-image-container">
               <img class="product-image" src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7831.png" alt="Rompe Pecho DM">
               <a href="https://efficientlabs.com/es/product/rompe-pecho-dm-6oz-2/" class="buy-button" target="_blank">Comprar</a>
            </div>
            <p class="product-name">Rompe Pecho® DM</p>
         </div>
         <div class="product-cell">
            <div class="product-image-container">
               <img class="product-image" src="https://efficientlabs.com/wp-content/uploads/2020/06/IMG_9782-min.png" alt="Rompe Pecho NT">
               <a href="https://efficientlabs.com/es/product/rompe-pecho-nt-6oz-3/" class="buy-button" target="_blank">Comprar</a>
            </div>
            <p class="product-name">Rompe Pecho® NT</p>
         </div>
         <div class="product-cell">
            <div class="product-image-container">
               <img class="product-image" src="https://efficientlabs.com/wp-content/uploads/2023/09/Rompepechito_ing_2__1_-removebg-preview-1-1.png" alt="Rompe Pecho Para niños">
               <a href="https://efficientlabs.com/es/product/rompe-pechito/" class="buy-button" target="_blank">Comprar</a>
            </div>
            <p class="product-name">Rompe Pecho® Para niños</p>
         </div>
      </div>
      <!-- Symptom Rows -->
      <!-- Goteo nasal -->
      <div class="symptom-row">
         <div class="symptom-cell">Goteo nasal</div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
      </div>
      <!-- Congestión nasal -->
      <div class="symptom-row">
         <div class="symptom-cell">Congestión nasal</div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
      </div>
      <!-- Sin azúcar -->
      <div class="symptom-row">
         <div class="symptom-cell">Sin azúcar (ideal para diabéticos)</div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
      </div>
      <!-- Congestión bronquial -->
      <div class="symptom-row">
         <div class="symptom-cell">Congestión bronquial</div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
      </div>
      <!-- Ojos lagrimosos -->
      <div class="symptom-row">
         <div class="symptom-cell">Ojos lagrimosos</div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
      </div>
      <!-- Saca la flema del pecho -->
      <div class="symptom-row">
         <div class="symptom-cell">Saca la flema del pecho</div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
      </div>
      <!-- Picazón en la garganta -->
      <div class="symptom-row">
         <div class="symptom-cell">Picazón en la garganta</div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
      </div>
      <!-- Fiebre y dolores de cuerpo -->
      <div class="symptom-row">
         <div class="symptom-cell">Fiebre y dolores de cuerpo</div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
      </div>
      <!-- Estornudos -->
      <div class="symptom-row">
         <div class="symptom-cell">Estornudos</div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
      </div>
      <!-- Tos -->
      <div class="symptom-row">
         <div class="symptom-cell">Tos</div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"></div>
         <div class="result-cell"></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
         <div class="result-cell"><span class="x-mark">X</span></div>
      </div>
   </div>
   <!-- Mobile Accordion Version -->
   <div class="mobile-accordion">
      <!-- Mobile Symptom Accordion -->
      <div class="mobile-section">
         <div class="mobile-symptom">Goteo nasal</div>
         <div class="mobile-products">
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_9784-min.png" alt="Rompe Pecho SF FLU">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-sf-flu-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® SF FLU</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_9788-min.png" alt="Rompe Pecho CF">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-cf-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® CF</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2020/06/IMG_9782-min.png" alt="Rompe Pecho NT">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-nt-6oz-3/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® NT</p>
            </div>
         </div>
      </div>
      <div class="mobile-section">
         <div class="mobile-symptom">Congestión nasal</div>
         <div class="mobile-products">
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7829.png" alt="Rompe Pecho MAX">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-max-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® MAX</p>
            </div>
         </div>
      </div>
      <div class="mobile-section">
         <div class="mobile-symptom">Sin azúcar (ideal para diabéticos)</div>
         <div class="mobile-products">
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_9784-min.png" alt="Rompe Pecho SF FLU">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-sf-flu-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® SF FLU</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7816.png" alt="Rompe Pecho SF sin Azúcar">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-sf-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® SF sin Azúcar</p>
            </div>
         </div>
      </div>
      <div class="mobile-section">
         <div class="mobile-symptom">Congestión bronquial</div>
         <div class="mobile-products">
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7829.png" alt="Rompe Pecho MAX">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-max-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® MAX</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7816.png" alt="Rompe Pecho SF sin Azúcar">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-sf-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® SF sin Azúcar</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7823.png" alt="Rompe Pecho EX">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-ex-6oz/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® EX</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7831.png" alt="Rompe Pecho DM">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-dm-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® DM</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2023/09/Rompepechito_ing_2__1_-removebg-preview-1-1.png" alt="Rompe Pecho Para niños">
                  <a href="https://efficientlabs.com/es/product/rompe-pechito/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® Para niños</p>
            </div>
         </div>
      </div>
      <div class="mobile-section">
         <div class="mobile-symptom">Ojos lagrimosos</div>
         <div class="mobile-products">
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_9784-min.png" alt="Rompe Pecho SF FLU">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-sf-flu-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® SF FLU</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_9788-min.png" alt="Rompe Pecho CF">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-cf-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® CF</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2020/06/IMG_9782-min.png" alt="Rompe Pecho NT">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-nt-6oz-3/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® NT</p>
            </div>
         </div>
      </div>
      <div class="mobile-section">
         <div class="mobile-symptom">Saca la flema del pecho</div>
         <div class="mobile-products">
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7829.png" alt="Rompe Pecho MAX">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-max-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® MAX</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7816.png" alt="Rompe Pecho SF sin Azúcar">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-sf-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® SF sin Azúcar</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7823.png" alt="Rompe Pecho EX">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-ex-6oz/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® EX</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7831.png" alt="Rompe Pecho DM">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-dm-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® DM</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2023/09/Rompepechito_ing_2__1_-removebg-preview-1-1.png" alt="Rompe Pecho Para niños">
                  <a href="https://efficientlabs.com/es/product/rompe-pechito/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® Para niños</p>
            </div>
         </div>
      </div>
      <div class="mobile-section">
         <div class="mobile-symptom">Picazón en la garganta</div>
         <div class="mobile-products">
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_9784-min.png" alt="Rompe Pecho SF FLU">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-sf-flu-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® SF FLU</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_9788-min.png" alt="Rompe Pecho CF">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-cf-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® CF</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2020/06/IMG_9782-min.png" alt="Rompe Pecho NT">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-nt-6oz-3/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® NT</p>
            </div>
         </div>
      </div>
      <div class="mobile-section">
         <div class="mobile-symptom">Fiebre y dolores de cuerpo</div>
         <div class="mobile-products">
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7829.png" alt="Rompe Pecho MAX">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-max-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® MAX</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2020/06/IMG_9782-min.png" alt="Rompe Pecho NT">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-nt-6oz-3/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® NT</p>
            </div>
         </div>
      </div>
      <div class="mobile-section">
         <div class="mobile-symptom">Estornudos</div>
         <div class="mobile-products">
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_9784-min.png" alt="Rompe Pecho SF FLU">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-sf-flu-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® SF FLU</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_9788-min.png" alt="Rompe Pecho CF">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-cf-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® CF</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2020/06/IMG_9782-min.png" alt="Rompe Pecho NT">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-nt-6oz-3/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® NT</p>
            </div>
         </div>
      </div>
      <div class="mobile-section">
         <div class="mobile-symptom">Tos</div>
         <div class="mobile-products">
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_9784-min.png" alt="Rompe Pecho SF FLU">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-sf-flu-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® SF FLU</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7829.png" alt="Rompe Pecho MAX">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-max-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® MAX</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_9788-min.png" alt="Rompe Pecho CF">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-cf-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® CF</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2018/08/IMG_7831.png" alt="Rompe Pecho DM">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-dm-6oz-2/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® DM</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2020/06/IMG_9782-min.png" alt="Rompe Pecho NT">
                  <a href="https://efficientlabs.com/es/product/rompe-pecho-nt-6oz-3/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® NT</p>
            </div>
            <div class="mobile-product has-symptom">
               <div class="mobile-product-image-container">
                  <img src="https://efficientlabs.com/wp-content/uploads/2023/09/Rompepechito_ing_2__1_-removebg-preview-1-1.png" alt="Rompe Pecho Para niños">
                  <a href="https://efficientlabs.com/es/product/rompe-pechito/" class="mobile-buy-button" target="_blank">Comprar</a>
               </div>
               <p>Rompe Pecho® Para niños</p>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   // JavaScript to handle responsive switching - not strictly necessary but enhances experience
   function adjustViewBasedOnScreenSize() {
       const desktopTable = document.querySelector('.desktop-table');
       const mobileAccordion = document.querySelector('.mobile-accordion');
       
       if (window.innerWidth <= 768) {
           desktopTable.style.display = 'none';
           mobileAccordion.style.display = 'block';
       } else {
           desktopTable.style.display = 'block';
           mobileAccordion.style.display = 'none';
       }
   }
   
   // Run on load and resize
   window.addEventListener('load', adjustViewBasedOnScreenSize);
   window.addEventListener('resize', adjustViewBasedOnScreenSize);
</script>
<?php get_footer(); ?>