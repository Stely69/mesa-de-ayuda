<footer class="bg-white/90 backdrop-blur-md border-t border-[#39A900]/20 relative overflow-hidden mt-16">
    <!-- Fondo decorativo -->
    <div class="absolute inset-0 bg-grid-pattern opacity-10 pointer-events-none"></div>
    <div class="absolute -top-16 -right-16 w-40 h-40 bg-[#39A900]/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-16 -left-16 w-40 h-40 bg-[#39A900]/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 py-10 relative z-10">
        <!-- Logo y descripción -->
        <div class="flex flex-col items-center mb-10">
            <div class="inline-flex items-center gap-2 mb-2">
                <i class="fas fa-cube text-3xl text-[#39A900]"></i>
                <span class="text-2xl font-extrabold tracking-wide text-[#39A900]">GEDAC</span>
            </div>
            <p class="text-gray-600 text-sm max-w-xl text-center">Sistema de Gestión de Activos del CDAE - SENA. Una plataforma diseñada para el control y seguimiento eficiente de activos físicos.</p>
        </div>

        <!-- Grid de secciones -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 mb-8">
            <!-- Información -->
            <div class="footer-section">
                <h3 class="text-lg font-semibold text-[#39A900] mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle"></i> Información
                </h3>
                <ul class="space-y-2 text-gray-700 text-sm">
                    <li class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-[#39A900]"></i> CDAE - SENA</li>
                    <li class="flex items-center gap-2"><i class="fas fa-envelope text-[#39A900]"></i> contacto@gedac.com</li>
                </ul>
            </div>
            <!-- Enlaces -->
            <div class="footer-section">
                <h3 class="text-lg font-semibold text-[#39A900] mb-4 flex items-center gap-2">
                    <i class="fas fa-link"></i> Enlaces
                </h3>
                <ul class="space-y-2 text-gray-700 text-sm">
                    <li><a href="#hero" class="footer-link flex items-center gap-2 hover:text-[#39A900] transition"><i class="fas fa-chevron-right text-xs"></i>Inicio</a></li>
                    <li><a href="#how-it-works" class="footer-link flex items-center gap-2 hover:text-[#39A900] transition"><i class="fas fa-chevron-right text-xs"></i>¿Cómo Funciona?</a></li>
                    <li><a href="#team" class="footer-link flex items-center gap-2 hover:text-[#39A900] transition"><i class="fas fa-chevron-right text-xs"></i>Equipo</a></li>
                    <li><a href="Login/inicio_sesion" class="footer-link flex items-center gap-2 hover:text-[#39A900] transition"><i class="fas fa-chevron-right text-xs"></i>Iniciar Sesión</a></li>
                </ul>
            </div>
            <!-- Servicios -->
            <div class="footer-section">
                <h3 class="text-lg font-semibold text-[#39A900] mb-4 flex items-center gap-2">
                    <i class="fas fa-cogs"></i> Servicios
                </h3>
                <ul class="space-y-2 text-gray-700 text-sm">
                    <li class="flex items-center gap-2"><i class="fas fa-check text-xs text-[#39A900]"></i> Gestión de Activos</li>
                    <li class="flex items-center gap-2"><i class="fas fa-check text-xs text-[#39A900]"></i> Seguimiento</li>
                    <li class="flex items-center gap-2"><i class="fas fa-check text-xs text-[#39A900]"></i> Reportes</li>
                </ul>
            </div>
            <!-- Redes sociales -->
            <div class="footer-section">
                <h3 class="text-lg font-semibold text-[#39A900] mb-4 flex items-center gap-2">
                    <i class="fas fa-share-alt"></i> Redes
                </h3>
                <div class="flex flex-wrap gap-3">
                    <a href="#" target="_blank" class="social-icon flex items-center gap-2 p-2 bg-[#39A900]/10 rounded-lg hover:bg-[#39A900]/20 transition-all duration-300 text-xs text-gray-700 hover:text-[#39A900]"><i class="fab fa-github text-lg"></i>GitHub</a>
                    <a href="#" target="_blank" class="social-icon flex items-center gap-2 p-2 bg-[#39A900]/10 rounded-lg hover:bg-[#39A900]/20 transition-all duration-300 text-xs text-gray-700 hover:text-[#39A900]"><i class="fab fa-linkedin text-lg"></i>LinkedIn</a>
                    <a href="#" target="_blank" class="social-icon flex items-center gap-2 p-2 bg-[#39A900]/10 rounded-lg hover:bg-[#39A900]/20 transition-all duration-300 text-xs text-gray-700 hover:text-[#39A900]"><i class="fab fa-twitter text-lg"></i>Twitter</a>
                    <a href="#" target="_blank" class="social-icon flex items-center gap-2 p-2 bg-[#39A900]/10 rounded-lg hover:bg-[#39A900]/20 transition-all duration-300 text-xs text-gray-700 hover:text-[#39A900]"><i class="fab fa-instagram text-lg"></i>Instagram</a>
                </div>
            </div>
        </div>

        <!-- Línea divisoria -->
        <div class="border-t border-[#39A900]/10 my-4"></div>

        <!-- Copyright y enlaces legales -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2">
                <img src="../pictures/logosena.png" alt="SENA Logo" class="h-6 opacity-80">
                <p class="text-gray-500 text-xs">&copy; <?php echo date('Y'); ?> <strong>SENA</strong> - GEDAC</p>
            </div>
            <div class="flex flex-wrap justify-center gap-2">
                <a href="#" class="footer-link text-xs text-gray-500 hover:text-[#39A900] transition-colors duration-300">Términos</a>
                <a href="#" class="footer-link text-xs text-gray-500 hover:text-[#39A900] transition-colors duration-300">Privacidad</a>
            </div>
        </div>
    </div>

    <script>
        // Animación de entrada para las secciones del footer
        document.addEventListener('DOMContentLoaded', () => {
            const footerSections = document.querySelectorAll('.footer-section');
            const socialIcons = document.querySelectorAll('.social-icon');
            const footerLinks = document.querySelectorAll('.footer-link');

            // Animación de entrada
            footerSections.forEach((section, index) => {
                gsap.from(section, {
                    opacity: 0,
                    y: 30,
                    duration: 0.7,
                    delay: index * 0.15,
                    ease: "power2.out"
                });
            });

            // Efecto hover para los iconos sociales
            socialIcons.forEach(icon => {
                icon.addEventListener('mouseenter', () => {
                    gsap.to(icon, {
                        scale: 1.07,
                        duration: 0.2,
                        ease: "power2.out"
                    });
                });
                icon.addEventListener('mouseleave', () => {
                    gsap.to(icon, {
                        scale: 1,
                        duration: 0.2,
                        ease: "power2.out"
                    });
                });
            });

            // Efecto hover para los enlaces
            footerLinks.forEach(link => {
                link.addEventListener('mouseenter', () => {
                    gsap.to(link, {
                        x: 4,
                        duration: 0.2,
                        ease: "power2.out"
                    });
                });
                link.addEventListener('mouseleave', () => {
                    gsap.to(link, {
                        x: 0,
                        duration: 0.2,
                        ease: "power2.out"
                    });
                });
            });
        });
    </script>

    <style>
        .bg-grid-pattern {
            background-image: linear-gradient(to right, #39A90011 1px, transparent 1px),
                              linear-gradient(to bottom, #39A90011 1px, transparent 1px);
            background-size: 30px 30px;
        }
        .footer-link {
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .footer-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #39A900;
            transition: width 0.3s ease;
        }
        .footer-link:hover::after {
            width: 100%;
        }
    </style>
</footer>
