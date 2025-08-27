<?php
/**
 * Template Name: Perfil de Doctor
 * 
 * Una plantilla personalizada para mostrar el perfil del Dr. Flikier
 * sin depender del sistema de autor de WordPress.
 */

get_header();

// ID del usuario (Dr. Flikier) - Ajusta este valor al ID correcto
$doctor_id = 4395; // Cambia esto al ID correcto del Dr. Flikier en WordPress

// Obtener información del doctor
$doctor = get_userdata($doctor_id);

if (!$doctor) {
    // Si no se puede encontrar el usuario, mostrar mensaje de error
    ?>
    <div class="container">
        <div class="error-message" style="padding: 50px 0; text-align: center;">
            <h1>Información no disponible</h1>
            <p>Lo sentimos, no se pudo encontrar la información del doctor.</p>
        </div>
    </div>
    <?php
    get_footer();
    return;
}

// Obtener campos ACF si están disponibles
$author_position = '';
$author_expertise = '';
$doctor_number = '';
$medical_center = '';
$education = '';
$author_twitter = '';
$author_linkedin = '';
$website = '';
$author_schema_image = '';
$professional_experience = array();
$professional_affiliations = array();

if (function_exists('get_field')) {
    $author_position = get_field('author_position', 'user_' . $doctor_id);
    $author_expertise = get_field('author_expertise', 'user_' . $doctor_id);
    $doctor_number = get_field('doctor_number', 'user_' . $doctor_id);
    $medical_center = get_field('medical_center', 'user_' . $doctor_id);
    $education = get_field('education', 'user_' . $doctor_id);
    $author_twitter = get_field('author_twitter', 'user_' . $doctor_id);
    $author_linkedin = get_field('author_linkedin', 'user_' . $doctor_id);
    $website = get_field('website', 'user_' . $doctor_id);
    $author_schema_image = get_field('author_schema_image', 'user_' . $doctor_id);
    $professional_experience = get_field('professional_experience', 'user_' . $doctor_id);
    $professional_affiliations = get_field('professional_affiliations', 'user_' . $doctor_id);
}

// Si los campos ACF no están completos, podemos definir valores predeterminados específicos para el Dr. Flikier
if (empty($author_position)) {
    $author_position = "Médico y Cirujano - Especialista en Otorrinolaringología";
}
if (empty($doctor_number)) {
    $doctor_number = "CMC 2723";
}
if (empty($medical_center)) {
    $medical_center = "Hospital Metropolitano sede San José, Costa Rica";
}
if (empty($author_expertise)) {
    $author_expertise = "Otorrinolaringología, Cirugía de Cabeza y Cuello";
}
if (empty($education) && $doctor_id == 1) { // Solo para el Dr. Flikier
    $education = "Residencia en Otorrinolaringología: Hospitales San Juan de Dios, Hospital México y Hospital Nacional de Niños 1986-1990";
}
if (empty($professional_experience) && $doctor_id == 1) { // Solo para el Dr. Flikier
    $professional_experience = array(
        array('experience_description' => '40 años de experiencia en la Caja Costarricense de Seguro Social', 'experience_years' => 40),
        array('experience_description' => '36 años de experiencia privada en Otorrinolaringología', 'experience_years' => 36)
    );
}
if (empty($professional_affiliations) && $doctor_id == 1) { // Solo para el Dr. Flikier
    $professional_affiliations = array(
        array('affiliation_name' => 'Miembro de la Asociación Costarricense de Otorrinolaringología y Cirugía de Cabeza y Cuello'),
        array('affiliation_name' => 'Miembro de la Academia Americana de Otorrinolaringología y Cirugía de Cabeza y Cuello')
    );
}

// Obtener posts del doctor
$doctor_posts = new WP_Query(array(
    'author' => $doctor_id,
    'post_type' => 'post',
    'posts_per_page' => -1,
    'post_status' => 'publish'
));



/**
 * Función mejorada para generar Schema.org completo para el Dr. Flikier
 * Agrega esta función en template-doctor.php reemplazando la función actual
 * Evita duplicación con otros schemas existentes
 */
function add_doctor_schema_json($doctor, $position, $expertise, $image, $doctor_number, $medical_center, $doctor_id) {
    // Verificar si la función ya fue ejecutada para evitar duplicados
    static $schema_generated = false;
    if ($schema_generated) {
        return;
    }
    $schema_generated = true;
    
    // Estructura básica del schema
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Person',
        'name' => $doctor->display_name,
        'honorificPrefix' => 'Dr.',
        'url' => get_permalink(),
    );
    
    // Dividir el nombre completo en partes (si es posible)
    $name_parts = explode(' ', $doctor->display_name);
    if (count($name_parts) >= 3) {
        $schema['givenName'] = $name_parts[1]; // Samuel
        $schema['familyName'] = $name_parts[2]; // Flikier
        $schema['additionalName'] = 'Felix'; // Agregado manualmente
    }
    
    // Usar additionalName para el apellido adicional en lugar de additionalFamilyName
    $schema['additionalName'] .= ' Frajnd';
    
    // Agregar imagen
    if (!empty($image)) {
        $schema['image'] = $image;
    }
    
    // Agregar posición/cargo
    if (!empty($position)) {
        $schema['jobTitle'] = $position;
    } else {
        $schema['jobTitle'] = 'Especialista en Otorrinolaringología y Cirugía de Cabeza y Cuello';
    }
    
    // Agregar número de colegiado
    if (!empty($doctor_number)) {
        $schema['identifier'] = array(
            '@type' => 'PropertyValue',
            'propertyID' => 'Colegio de Médicos y Cirujanos de Costa Rica',
            'value' => $doctor_number
        );
    } else {
        $schema['identifier'] = array(
            '@type' => 'PropertyValue',
            'propertyID' => 'Colegio de Médicos y Cirujanos de Costa Rica',
            'value' => 'CMC 2723'
        );
    }
    
    // Agregar idiomas
    $schema['knowsLanguage'] = array('es', 'en');
    
    // Agregar centro médico (solo usar el valor fijo, no el de ACF)
    $schema['worksFor'] = array(
        '@type' => 'Hospital',
        'name' => 'Hospital Metropolitano',
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => '300 metros al sur del costado oeste del Parque La Merced, Calle 14, Avenida 8, Edificio Torre Médica B, Piso 2, Consultorio 13',
            'addressLocality' => 'San José',
            'addressCountry' => 'CR'
        )
    );
    
    // Agregar formación académica completa
    $schema['alumniOf'] = array(
        array(
            '@type' => 'EducationalOrganization',
            'name' => 'Universidad de Costa Rica',
            'description' => 'Médico y Cirujano, 1984'
        ),
        array(
            '@type' => 'EducationalOrganization',
            'name' => 'Universidad de Costa Rica',
            'description' => 'Especialidad en Otorrinolaringología, 1986-1990'
        ),
        array(
            '@type' => 'EducationalOrganization',
            'name' => 'Hospital San Juan de Dios'
        ),
        array(
            '@type' => 'EducationalOrganization',
            'name' => 'Hospital México'
        ),
        array(
            '@type' => 'EducationalOrganization',
            'name' => 'Hospital Nacional de Niños'
        )
    );
    
    // Agregar experiencia profesional con datos textuales fijos
    // Usamos SOLO la versión actualizada con occupationLocation y estimatedSalary
    $schema['hasOccupation'] = array(
        array(
            '@type' => 'Occupation',
            'name' => 'Médico Asistente General',
            'occupationLocation' => array(
                '@type' => 'City',
                'name' => 'Puntarenas'
            ),
            'estimatedSalary' => array(
                '@type' => 'MonetaryAmountDistribution',
                'name' => 'Salario Médico Asistente General 1985',
                'currency' => 'CRC',
                'median' => 1350000,
                'percentile10' => 1200000,
                'percentile90' => 1500000,
                'duration' => 'P1M'
            ),
            'startDate' => '1985',
            'endDate' => '1985'
        ),
        array(
            '@type' => 'Occupation',
            'name' => 'Médico Asistente General',
            'occupationLocation' => array(
                '@type' => 'City',
                'name' => 'San José'
            ),
            'estimatedSalary' => array(
                '@type' => 'MonetaryAmountDistribution',
                'name' => 'Salario Médico Asistente General 1986',
                'currency' => 'CRC',
                'median' => 1450000,
                'percentile10' => 1300000,
                'percentile90' => 1600000,
                'duration' => 'P1M'
            ),
            'startDate' => '1986',
            'endDate' => '1986'
        ),
        array(
            '@type' => 'Occupation',
            'name' => 'Especialista en Otorrinolaringología',
            'occupationLocation' => array(
                '@type' => 'City',
                'name' => 'San José'
            ),
            'estimatedSalary' => array(
                '@type' => 'MonetaryAmountDistribution',
                'name' => 'Salario Especialista en Otorrinolaringología 1990-1994',
                'currency' => 'CRC',
                'median' => 2500000,
                'percentile10' => 2200000,
                'percentile90' => 2800000,
                'duration' => 'P1M'
            ),
            'startDate' => '1990',
            'endDate' => '1994'
        ),
        array(
            '@type' => 'Occupation',
            'name' => 'Especialista en Otorrinolaringología',
            'occupationLocation' => array(
                '@type' => 'City',
                'name' => 'Ciudad Quesada'
            ),
            'estimatedSalary' => array(
                '@type' => 'MonetaryAmountDistribution',
                'name' => 'Salario Especialista en Otorrinolaringología 1995-1999',
                'currency' => 'CRC',
                'median' => 2700000,
                'percentile10' => 2400000,
                'percentile90' => 3000000,
                'duration' => 'P1M'
            ),
            'startDate' => '1995',
            'endDate' => '1999'
        ),
        array(
            '@type' => 'Occupation',
            'name' => 'Especialista en Otorrinolaringología',
            'occupationLocation' => array(
                '@type' => 'City',
                'name' => 'Alajuela'
            ),
            'estimatedSalary' => array(
                '@type' => 'MonetaryAmountDistribution',
                'name' => 'Salario Especialista en Otorrinolaringología desde 1999',
                'currency' => 'CRC',
                'median' => 3150000,
                'percentile10' => 2800000,
                'percentile90' => 3500000,
                'duration' => 'P1M'
            ),
            'startDate' => '1999'
        )
    );
    
    // Agregar afiliaciones profesionales
    $schema['memberOf'] = array(
        array(
            '@type' => 'Organization',
            'name' => 'Asociación Costarricense de Otorrinolaringología y Cirugía de Cabeza y Cuello'
        ),
        array(
            '@type' => 'Organization',
            'name' => 'Academia Americana de Otorrinolaringología y Cirugía de Cabeza y Cuello'
        )
    );
    
    // Agregar publicaciones - usando workExample en lugar de publications
    $schema['workExample'] = array(
        array(
            '@type' => 'ScholarlyArticle',
            'name' => 'Tratamiento quirúrgico del vértigo 1985-1989 en el Hospital México',
            'publisher' => array(
                '@type' => 'Organization',
                'name' => 'Revista Neuroeje'
            ),
            'volumeNumber' => '7',
            'issueNumber' => '3',
            'pageStart' => '59',
            'pageEnd' => '62',
            'datePublished' => '1989'
        ),
        array(
            '@type' => 'ScholarlyArticle',
            'name' => 'Cirugía del Vértigo: Conceptos anatómicos y clínicos',
            'publisher' => array(
                '@type' => 'Organization',
                'name' => 'Revista Neuroeje'
            ),
            'volumeNumber' => '7',
            'issueNumber' => '3',
            'pageStart' => '63',
            'pageEnd' => '71',
            'datePublished' => '1989'
        )
    );
    
    // Agregar enlaces externos (LinkedIn y sitio web)
    $schema['sameAs'] = array(
        'https://www.linkedin.com/in/samuel-felix-flikier-6a407827/?originalSubdomain=cr',
        'https://www.drsamuelflikier.com'
    );
    
    // Agregar información de contacto
    $schema['contactPoint'] = array(
        '@type' => 'ContactPoint',
        'telephone' => '+506-2521-9650',
        'email' => 'docflikier@gmail.com',
        'contactType' => 'office'
    );
    
    // Agregar descripción
    $bio = get_the_author_meta('description', $doctor_id);
    if (!empty($bio)) {
        $schema['description'] = $bio;
    } else {
        $schema['description'] = 'El Dr. Samuel F. Flikier es médico y cirujano con más de 40 años de experiencia en la Caja Costarricense del Seguro Social y más de 36 años de práctica privada en otorrinolaringología. Eligió la especialidad de otorrinolaringología debido a su pasión por la cirugía y su afinidad con las ciencias biológicas. Su vocación de servicio lo ha llevado a enfocarse en brindar atención de calidad, combinando técnicas quirúrgicas avanzadas y un trato humano y cercano a sus pacientes.';
    }
    
    // Agregar áreas de conocimiento y servicios ofrecidos (usar datos textuales fijos)
    $schema['knowsAbout'] = array(
        'Otorrinolaringología',
        'Cirugía de Cabeza y Cuello',
        'Diagnóstico de enfermedades del oído, nariz y garganta',
        'Cirugía de senos paranasales',
        'Rinoseptoplastía',
        'Tratamiento de apnea del sueño',
        'Cirugía de cornetes',
        'Manejo de trastornos del sueño',
        'Tratamiento de sinusitis crónica'
    );
    
    // Eliminar cualquier otro schema duplicado antes de imprimir este
    add_action('wp_footer', function() {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtener todos los scripts de tipo application/ld+json
            var scripts = document.querySelectorAll("script[type=\'application/ld+json\']");
            if (scripts.length > 1) {
                // Mantener solo el primero que contiene Person
                var personScripts = [];
                for (var i = 0; i < scripts.length; i++) {
                    if (scripts[i].innerHTML.includes(\'"@type":"Person"\')) {
                        personScripts.push(scripts[i]);
                    }
                }
                // Eliminar los duplicados (mantener solo el primero)
                for (var j = 1; j < personScripts.length; j++) {
                    personScripts[j].parentNode.removeChild(personScripts[j]);
                }
            }
        });
        </script>';
    }, 100);
    
    // Imprimir el schema
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '</script>';
}

?>

<div class="doctor-profile-wrapper">
    <div class="container">
    <?php add_doctor_schema_json($doctor, $author_position, $author_expertise, $author_schema_image, $doctor_number, $medical_center, $doctor_id); ?>

        
        <div class="doctor-header">
            <div class="doctor-avatar">
                <?php if ($author_schema_image) : ?>
                    <img src="<?php echo esc_url($author_schema_image); ?>" alt="<?php echo esc_attr($doctor->display_name); ?>" />
                <?php else : ?>
                    <?php echo get_avatar($doctor_id, 300); ?>
                <?php endif; ?>
            </div>
            
            <div class="doctor-info">
                <h1 class="doctor-title">Dr.  <?php echo esc_html($doctor->display_name); ?></h1>
                
                <?php if ($author_position) : ?>
                <div class="doctor-position">
                    <?php echo esc_html($author_position); ?>
                </div>
                <?php endif; ?>
                
                <?php if ($doctor_number) : ?>
                <div class="doctor-license">
                    <span class="label">N° Colegiado:</span> <?php echo esc_html($doctor_number); ?>
                </div>
                <?php endif; ?>
                
                <?php if ($medical_center) : ?>
                <div class="doctor-workplace">
                    <span class="label">Centro Médico:</span> <?php echo esc_html($medical_center); ?>
                </div>
                <?php endif; ?>
                
                <?php 
                // Descripción del doctor
                $doctor_bio = get_the_author_meta('description', $doctor_id);
                if ($doctor_bio) : 
                ?>
                <div class="doctor-bio">
                    <?php echo wpautop($doctor_bio); ?>
                </div>
                <?php endif; ?>
                
                <?php if ($author_expertise) : ?>
                <div class="doctor-expertise">
                    <h3>Áreas de Especialización:</h3>
                    <p><?php echo esc_html($author_expertise); ?></p>
                </div>
                <?php endif; ?>
                
                <div class="doctor-meta">
                    <div class="meta-left">
                        <?php if (!empty($professional_experience)) : ?>
                        <div class="doctor-experience">
                            <h3>Experiencia Profesional:</h3>
                            <ul>
                                <?php foreach ($professional_experience as $experience) : ?>
                                <li>
                                    <?php 
                                    if (is_array($experience)) {
                                        echo esc_html($experience['experience_description'] ?? '');
                                        if (!empty($experience['experience_years'])) {
                                            echo ' <span class="years">(' . esc_html($experience['experience_years']) . ' años)</span>';
                                        }
                                    } else {
                                        echo esc_html($experience);
                                    }
                                    ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($education) : ?>
                        <div class="doctor-education">
                            <h3>Formación Académica:</h3>
                            <div><?php echo wpautop($education); ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="meta-right">
                        <?php if (!empty($professional_affiliations)) : ?>
                        <div class="doctor-affiliations">
                            <h3>Afiliaciones Profesionales:</h3>
                            <ul>
                                <?php foreach ($professional_affiliations as $affiliation) : ?>
                                <li>
                                    <?php 
                                    if (is_array($affiliation)) {
                                        echo esc_html($affiliation['affiliation_name'] ?? '');
                                    } else {
                                        echo esc_html($affiliation);
                                    }
                                    ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($author_twitter || $author_linkedin || $website) : ?>
                        <div class="doctor-social">
                            <h3>Conecta con <?php echo esc_html($doctor->first_name ? $doctor->first_name : $doctor->display_name); ?>:</h3>
                            <ul class="social-links">
                                <?php if ($author_twitter) : ?>
                                <li>
                                    <a href="<?php echo esc_url('https://twitter.com/' . $author_twitter); ?>" target="_blank" rel="nofollow">
                                        <span class="screen-reader-text">Twitter</span>
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <?php endif; ?>
                                
                                <?php if ($author_linkedin) : ?>
                                <li>
                                    <a href="<?php echo esc_url($author_linkedin); ?>" target="_blank" rel="nofollow">
                                        <span class="screen-reader-text">LinkedIn</span>
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </li>
                                <?php endif; ?>
                                
                                <?php if ($website) : ?>
                                <li>
                                    <a href="<?php echo esc_url($website); ?>" target="_blank" rel="nofollow">
                                        <span class="screen-reader-text">Sitio Web</span>
                                        <i class="fas fa-globe"></i>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div><!-- .doctor-header -->
    </div><!-- .container -->
</div><!-- .doctor-profile-wrapper -->

<?php
// Incluir los estilos CSS directamente en la página
?>
<style>
    .doctor-profile-wrapper {
        padding: 40px 0;
        color: #333;
        font-family: inherit;
    }
    .doctor-header {
        display: flex;
        align-items: flex-start;
        margin-bottom: 50px;
        padding: 30px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    .doctor-avatar {
        flex: 0 0 250px;
        margin-right: 40px;
    }
    .doctor-avatar img {
        width: 100%;
        height: auto;
        border-radius: 6px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .doctor-info {
        flex: 1;
    }
    .doctor-title {
        margin: 0 0 10px;
        font-size: 32px;
        color: #2c3e50;
        font-weight: 700;
    }
    .doctor-position {
        font-size: 20px;
        color: #3498db;
        margin-bottom: 15px;
        font-weight: 500;
    }
    .doctor-license, .doctor-workplace {
        font-size: 16px;
        color: #5a6570;
        margin-bottom: 6px;
    }
    .doctor-license .label, .doctor-workplace .label {
        font-weight: 600;
        color: #34495e;
    }
    .doctor-bio {
        margin: 20px 0;
        font-size: 16px;
        line-height: 1.6;
        color: #444;
        border-top: 1px solid #eee;
        padding-top: 20px;
    }
    .doctor-expertise {
        margin-bottom: 20px;
        padding: 15px;
        background-color: rgba(52, 152, 219, 0.05);
        border-left: 4px solid #3498db;
        border-radius: 4px;
    }
    .doctor-expertise h3, .doctor-experience h3, .doctor-education h3, 
    .doctor-affiliations h3, .doctor-social h3 {
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 18px;
        color: #2c3e50;
        font-weight: 600;
    }
    .doctor-expertise p {
        margin-bottom: 0;
        color: #2c3e50;
    }
    .doctor-meta {
        display: flex;
        flex-wrap: wrap;
        margin-top: 30px;
        border-top: 1px solid #eee;
        padding-top: 25px;
    }
    .meta-left {
        flex: 0 0 60%;
        padding-right: 20px;
    }
    .meta-right {
        flex: 0 0 40%;
        padding-left: 20px;
        border-left: 1px solid #eee;
    }
    .doctor-experience, .doctor-education, .doctor-affiliations, .doctor-social {
        margin-bottom: 25px;
    }
    .doctor-experience ul, .doctor-affiliations ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .doctor-experience li, .doctor-affiliations li {
        position: relative;
        padding-left: 20px;
        margin-bottom: 8px;
        line-height: 1.4;
    }
    .doctor-experience li:before, .doctor-affiliations li:before {
        content: "•";
        color: #3498db;
        font-weight: bold;
        position: absolute;
        left: 0;
    }
    .doctor-experience .years {
        color: #7f8c8d;
        font-size: 0.9em;
    }
    .social-links {
        display: flex;
        padding: 0;
        margin: 10px 0 0;
        list-style: none;
    }
    .social-links li {
        margin-right: 15px;
    }
    .social-links a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        background-color: #3498db;
        color: #fff;
        border-radius: 50%;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .social-links a:hover {
        background-color: #2980b9;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .screen-reader-text {
        border: 0;
        clip: rect(1px, 1px, 1px, 1px);
        clip-path: inset(50%);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width: 1px;
        word-wrap: normal !important;
    }
    .doctor-posts-title {
        margin: 0 0 30px;
        padding-bottom: 15px;
        font-size: 24px;
        border-bottom: 1px solid #eee;
        color: #2c3e50;
    }
    .doctor-posts {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
    }
    .doctor-post-item {
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        background-color: #fff;
    }
    .doctor-post-item:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }
    .doctor-post-item .post-thumbnail img {
        width: 100%;
        height: auto;
        display: block;
    }
    .doctor-post-item .post-content {
        padding: 20px;
    }
    .doctor-post-item .entry-title {
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 18px;
    }
    .doctor-post-item .entry-title a {
        color: #2c3e50;
        text-decoration: none;
    }
    .doctor-post-item .entry-meta {
        font-size: 14px;
        color: #7f8c8d;
        margin-bottom: 10px;
    }
    .doctor-post-item .entry-summary {
        color: #34495e;
        margin-bottom: 15px;
    }
    .doctor-post-item .read-more {
        display: inline-block;
        padding: 5px 15px;
        background-color: #3498db;
        color: #fff;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }
    .doctor-post-item .read-more:hover {
        background-color: #2980b9;
    }
    @media (max-width: 992px) {
        .meta-left, .meta-right {
            flex: 0 0 100%;
            padding: 0;
        }
        .meta-right {
            border-left: none;
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 20px;
        }
    }
    @media (max-width: 768px) {
        .doctor-header {
            flex-direction: column;
            text-align: center;
        }
        .doctor-avatar {
            margin: 0 auto 20px;
        }
        .doctor-posts {
            grid-template-columns: 1fr;
        }
        .doctor-experience li, .doctor-affiliations li {
            text-align: left;
        }
        .social-links {
            justify-content: center;
        }
    }
</style>

<?php get_footer(); ?>