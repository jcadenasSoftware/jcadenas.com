<?php
require_once dirname(__DIR__) . '/config.php';

if (!function_exists('electricistaSectionData')) {
    function electricistaSectionData(): array {
        static $data = null;

        if ($data !== null) {
            return $data;
        }

        $basePath = 'electricista';
        $whatsappNumber = '573187488738';
        $whatsappDisplay = '+57 318 748 8738';
        $heroImage = 'assets/img/electricista/hero/hero-electricista.webp';

        $services = [
            [
                'slug' => 'instalaciones-electricas',
                'icon' => '⚡',
                'name' => 'Instalaciones eléctricas y adecuaciones',
                'short_description' => 'Instalaciones nuevas, adecuaciones y organización de circuitos para viviendas, locales y proyectos.',
                'image' => 'assets/img/electricista/services/instalaciones-soluciones-electricas.webp',
                'whatsapp_message' => 'Hola Joel, vi tu página y estoy interesado en Instalaciones eléctricas y adecuaciones.',
                'future_detail_url' => siteUrl($basePath . '/instalaciones-electricas'),
            ],
            [
                'slug' => 'reparaciones-electricas',
                'icon' => '🔧',
                'name' => 'Reparaciones y mantenimiento eléctrico',
                'short_description' => 'Diagnóstico, mantenimiento preventivo y correctivo para resolver fallas eléctricas.',
                'image' => 'assets/img/electricista/services/reparaciones-mantenimiento.webp',
                'whatsapp_message' => 'Hola Joel, vi tu página y necesito un servicio de reparaciones y mantenimiento eléctrico.',
                'future_detail_url' => siteUrl($basePath . '/reparaciones-electricas'),
            ],
            [
                'slug' => 'iluminacion',
                'icon' => '💡',
                'name' => 'Iluminación interior y exterior',
                'short_description' => 'Soluciones de iluminación funcional, decorativa y técnica para diferentes espacios.',
                'image' => 'assets/img/electricista/services/iluminacion.webp',
                'whatsapp_message' => 'Hola Joel, vi tu página y estoy interesado en iluminación interior y exterior.',
                'future_detail_url' => siteUrl($basePath . '/iluminacion'),
            ],
            [
                'slug' => 'redes-cableado-estructurado',
                'icon' => '🌐',
                'name' => 'Redes y cableado estructurado',
                'short_description' => 'Cableado estructurado y organización de puntos de red para conectividad estable.',
                'image' => 'assets/img/electricista/services/redes-cableado-estructurado.webp',
                'whatsapp_message' => 'Hola Joel, vi tu página y necesito un servicio de redes y cableado estructurado.',
                'future_detail_url' => siteUrl($basePath . '/redes-cableado-estructurado'),
            ],
            [
                'slug' => 'obras-proyectos',
                'icon' => '🏗️',
                'name' => 'Electricidad para obras y proyectos',
                'short_description' => 'Apoyo eléctrico para obras, adecuaciones y proyectos técnicos en ejecución.',
                'image' => 'assets/img/electricista/services/obras-proyectos.webp',
                'whatsapp_message' => 'Hola Joel, vi tu página y estoy interesado en electricidad para obras y proyectos.',
                'future_detail_url' => siteUrl($basePath . '/obras-proyectos'),
            ],
            [
                'slug' => 'videovigilancia',
                'icon' => '📹',
                'name' => 'Sistemas de videovigilancia',
                'short_description' => 'Instalación y soporte para soluciones de videovigilancia y seguridad electrónica.',
                'image' => 'assets/img/electricista/services/seguridad-electronica-videovigilancia.webp',
                'whatsapp_message' => 'Hola Joel, vi tu página y necesito un servicio de videovigilancia.',
                'future_detail_url' => siteUrl($basePath . '/videovigilancia'),
            ],
            [
                'slug' => 'deteccion-incendios',
                'icon' => '🔥',
                'name' => 'Sistemas de detección y alarma de incendios',
                'short_description' => 'Sistemas de detección, alarma y revisión técnica de puntos del sistema.',
                'image' => 'assets/img/electricista/services/deteccion-incendios.webp',
                'whatsapp_message' => 'Hola Joel, vi tu página y necesito un servicio de detección y alarma de incendios.',
                'future_detail_url' => siteUrl($basePath . '/deteccion-incendios'),
            ],
            [
                'slug' => 'mantenimiento-ups',
                'icon' => '🔋',
                'name' => 'Mantenimiento de UPS y respaldo eléctrico',
                'short_description' => 'Revisión de UPS, respaldo eléctrico y continuidad operativa para tu espacio.',
                'image' => 'assets/img/electricista/services/mantenimiento-ups-respaldo-electrico.webp',
                'whatsapp_message' => 'Hola Joel, vi tu página y necesito mantenimiento de UPS y respaldo eléctrico.',
                'future_detail_url' => siteUrl($basePath . '/mantenimiento-ups'),
            ],
        ];

        $data = [
            'section_name' => 'Electricista Bogotá',
            'brand_name' => 'Joel Cadenas',
            'base_path' => $basePath,
            'whatsapp_number' => $whatsappNumber,
            'whatsapp_display' => $whatsappDisplay,
            'whatsapp_e164' => '+573187488738',
            'whatsapp_message_general' => 'Hola Joel, vi tu página de servicios eléctricos y quiero solicitar información.',
            'hero_image' => $heroImage,
            'default_og_image' => 'assets/img/electricista/og/electricista-home-og.webp',
            'coverage' => 'Bogotá y zonas cercanas, según disponibilidad.',
            'services' => $services,
        ];

        return $data;
    }
}

if (!function_exists('electricistaData')) {
    function electricistaData(?string $key = null) {
        $data = electricistaSectionData();
        if ($key === null) {
            return $data;
        }
        return $data[$key] ?? null;
    }
}

if (!function_exists('electricistaPageUrl')) {
    function electricistaPageUrl(string $suffix = ''): string {
        $path = trim((string) electricistaData('base_path'), '/');
        $suffix = trim($suffix, '/');
        if ($suffix !== '') {
            $path .= '/' . $suffix;
        }
        return siteUrl($path);
    }
}

if (!function_exists('electricistaWorksUrl')) {
    function electricistaWorksUrl(string $slug = ''): string {
        $slug = trim($slug, '/');
        if ($slug === '') {
            return electricistaPageUrl('trabajos');
        }
        return electricistaPageUrl('trabajos/' . rawurlencode($slug));
    }
}

if (!function_exists('electricistaAbsoluteUrl')) {
    function electricistaAbsoluteUrl(string $path): string {
        if (preg_match('~^https?://~i', $path)) {
            return $path;
        }
        return siteUrl(ltrim($path, '/'));
    }
}

if (!function_exists('electricistaFilePath')) {
    function electricistaFilePath(string $projectRelativePath): string {
        $normalized = str_replace('\\', '/', ltrim($projectRelativePath, '/'));
        return dirname(__DIR__) . '/' . $normalized;
    }
}

if (!function_exists('electricistaAdminUrl')) {
    function electricistaAdminUrl(string $suffix = ''): string {
        $basePath = 'admin/electricista';
        $suffix = ltrim($suffix, '/');
        return siteUrl($suffix === '' ? ($basePath . '/index.php') : ($basePath . '/' . $suffix));
    }
}

if (!function_exists('electricistaAssetVersion')) {
    function electricistaAssetVersion(): string {
        return '20260826-1';
    }
}

if (!function_exists('electricistaAssetExists')) {
    function electricistaAssetExists(string $projectRelativePath): bool {
        return is_file(electricistaFilePath($projectRelativePath));
    }
}

if (!function_exists('electricistaWhatsappUrl')) {
    function electricistaWhatsappUrl(?string $serviceSlug = null): string {
        $number = preg_replace('/\D+/', '', (string) electricistaData('whatsapp_number'));
        $message = (string) electricistaData('whatsapp_message_general');

        if ($serviceSlug) {
            $service = electricistaServiceBySlug($serviceSlug);
            if ($service && !empty($service['whatsapp_message'])) {
                $message = (string) $service['whatsapp_message'];
            }
        }

        return 'https://wa.me/' . $number . '?text=' . rawurlencode($message);
    }
}

if (!function_exists('electricistaServiceBySlug')) {
    function electricistaServiceBySlug(string $slug): ?array {
        $services = electricistaData('services') ?? [];
        foreach ($services as $service) {
            if (($service['slug'] ?? '') === $slug) {
                return $service;
            }
        }
        return null;
    }
}

if (!function_exists('electricistaNavigation')) {
    function electricistaNavigation(?string $activeSection = null): array {
        $home = electricistaPageUrl();
        $activeSection = $activeSection !== null ? trim($activeSection) : null;
        $activeMap = [
            'home' => 0,
            'services' => 1,
            'works' => 2,
            'coverage' => 3,
            'whatsapp' => 4,
        ];

        return [
            [
                'label' => 'Inicio',
                'href' => $home . '#hero',
                'external' => false,
                'primary' => false,
                'active' => $activeSection === 'home',
            ],
            [
                'label' => 'Servicios',
                'href' => $home . '#servicios',
                'external' => false,
                'primary' => false,
                'active' => $activeSection === 'services',
            ],
            [
                'label' => 'Trabajos',
                'href' => electricistaWorksUrl(),
                'external' => false,
                'primary' => false,
                'active' => $activeSection === 'works',
            ],
            [
                'label' => 'Cobertura',
                'href' => $home . '#cobertura',
                'external' => false,
                'primary' => false,
                'active' => $activeSection === 'coverage',
            ],
            [
                'label' => 'WhatsApp',
                'href' => electricistaWhatsappUrl(),
                'external' => true,
                'primary' => true,
                'active' => $activeSection === 'whatsapp',
            ],
        ];
    }
}

if (!function_exists('electricistaLandingSchema')) {
    function electricistaLandingSchema(): array {
        $services = electricistaData('services') ?? [];
        $itemList = [];

        foreach ($services as $index => $service) {
            $itemList[] = [
                '@type' => 'Service',
                'position' => $index + 1,
                'name' => $service['name'],
                'description' => $service['short_description'],
                'url' => electricistaPageUrl(),
                'areaServed' => [
                    '@type' => 'City',
                    'name' => 'Bogotá',
                ],
            ];
        }

        $imagePath = electricistaData('default_og_image');
        if (!$imagePath || !electricistaAssetExists($imagePath)) {
            $imagePath = electricistaData('hero_image');
        }
        if (!$imagePath || !electricistaAssetExists($imagePath)) {
            $imagePath = 'assets/img/logo.webp';
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => ['Electrician', 'LocalBusiness'],
            'name' => 'Joel Cadenas',
            'url' => electricistaPageUrl(),
            'image' => electricistaAbsoluteUrl($imagePath),
            'description' => 'Servicios eléctricos y soporte técnico local en Bogotá.',
            'areaServed' => [
                '@type' => 'City',
                'name' => 'Bogotá',
            ],
            'telephone' => (string) electricistaData('whatsapp_e164'),
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'contactType' => 'customer service',
                    'telephone' => (string) electricistaData('whatsapp_e164'),
                    'availableLanguage' => ['es'],
                    'areaServed' => 'Bogotá',
                ],
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Servicios eléctricos',
                'itemListElement' => $itemList,
            ],
        ];
    }
}
