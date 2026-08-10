# SPEC-010 — Download Experience

Estado: Propuesto
Autor: Ingeniería — jcadenas.com
Última actualización: 2026-08-09
Ámbito: Sitio público modular de producto (Xpendz)
Relaciones: RFC-003, PROJECT-001, PLAYBOOK-001, UX-014, SPEC-008, SPEC-009

## Objective
Definir el estándar de la experiencia de Descarga (Download) para el sitio público modular del producto. Esta página no vende Xpendz nuevamente: elimina la última fricción antes de instalar e iniciar uso. La meta es que la visita termine pensando “en pocos minutos ya estaré usando Xpendz”.

## Background
- La arquitectura pública es modular (RFC-003) y sigue una narrativa continua (UX-014):
  - Landing (Discover) → Features (Understand) → Privacy & Security (Trust) → Download (Decide & Start)
- SPEC-009 estableció el Product Explorer en Features, y SPEC-008 describe lineamientos previos de descarga. SPEC-010 aterriza la experiencia final, lista para implementar, sin redefinir IA ni narrativa.

## Problem Statement
Visitantes que ya entienden el producto y confían en él aún dudan ante la instalación por preguntas no resueltas (tiempo, pasos, compatibilidad, costo, primera ejecución). La página de Descarga debe disipar esas dudas sin ruido ni repetición de contenido anterior.

## Goals
- Reducir incertidumbre previa a la instalación.
- Hacer obvio el camino: descargar → abrir → empezar.
- Asegurar compatibilidad percibida y real.
- Comunicar la primera experiencia con evidencia real.
- Mantener foco en una única acción dominante: Descargar Xpendz.

## Design Principles
- Claridad por encima de volumen de información.
- Evidencia real sobre discurso: capturas y estados de la app.
- Tono calmo, confiado y útil. Sin lenguaje de marketing.
- Jerarquía visual simple con una acción principal inequívoca.
- No repetir la página de Features: complementar, no reexplicar.
- Accesibilidad como requisito, no como extra.

## Narrative Model
- El visitante ya pasó por entender y confiar; aquí debe sentir que solo faltan minutos para usar Xpendz.
- La historia guía desde “descarga” hasta “primeros pasos listos” sin enseñar todo el producto.

## Section Responsibilities
1) Hero
- Propósito: Enmarcar que este es el inicio del uso, no otra venta. Mostrar la acción primaria “Descargar Xpendz”.
- Contenido: Título breve orientado a comienzo, subtítulo que reduce ansiedad (“en pocos minutos estarás usando Xpendz”), botón dominante de descarga.

2) Installation Journey
- Propósito: Reducir ansiedad mostrando un flujo simple y visual de los pasos.
- Contenido (secuencia visual con textos cortos; no tutorial):
  - Instalar → Iniciar sesión o crear cuenta → Crear tu primera cuenta → Empieza a usar Xpendz.
- Reglas: Usar ilustraciones/capturas reales y concisas; sin instrucciones detalladas ni descripciones de características.

3) First Experience
- Propósito: Anticipar qué verá el usuario inmediatamente después de instalar.
- Contenido: Evidencia real (capturas) de los primeros estados: dashboard inicial, estado sin cuentas, diálogo/acción para crear la primera cuenta, registro de primer movimiento. Evitar repetir argumentos de Features; enfocarse en “qué veré al abrir”.

4) Compatibility
- Propósito: Resolver dudas de dispositivo/sistema antes de descargar.
- Contenido: Plataformas soportadas, requisitos mínimos, enlaces a notas de versión si aplica. Mensaje claro si una plataforma no está disponible.
- Reglas: Siempre accesible, conciso y actualizado; evitar tablas densas.

5) Essential Questions
- Propósito: Responder antes de que el visitante pregunte.
- Contenido (FAQ breve, directo):
  - ¿Qué pasa después de instalar?
  - ¿Cuánto tardo en empezar?
  - ¿Necesito cuenta?
  - ¿Es gratis?
  - ¿Mi dispositivo es compatible?
  - ¿Qué veré la primera vez?
- Reglas: Respuestas cortas, orientadas a resultado/próximo paso. Sin marketing.

6) Final CTA
- Propósito: Cerrar el recorrido con la acción primaria de descarga.
- Contenido: Un único botón dominante “Descargar Xpendz”. Acciones secundarias solo si no compiten (p. ej., descarga para otro sistema si está disponible).

## Installation Journey (Detailed Behavior)
- Presentación en 4 pasos con evidencia real o mock fiel del producto. Texto por paso de 1 línea máximo.
- No enseñar flujos avanzados ni configuraciones. Objetivo: “es sencillo, toma minutos”.
- Orden invariable: Instalar → Iniciar sesión/crear cuenta → Crear primera cuenta → Empezar a usar.
- Estados de accesibilidad: cada paso debe ser navegable por teclado y legible por lector de pantalla.

## First Experience (Detailed Behavior)
- Mostrar cómo luce la app abierta por primera vez y los primeros gestos: crear la primera cuenta, registrar primer movimiento, ver dashboard inicial.
- Priorizar capturas limpias y actuales. Sin repasar módulos en profundidad (eso es parte de Features).
- Microcopy orientada a expectativas: “verás…”, “podrás…”, “en minutos tendrás…”.

## Download CTA
- Debe existir una sola acción dominante por defecto: “Descargar Xpendz”.
- Detección de plataforma puede preseleccionar el binario adecuado; alternativas aparecen como secundarios visibles pero no competitivos.
- Evitar cualquier CTA que desvíe del objetivo (p. ej., enlaces de marketing, newsletter, etc.).

## Microcopy
- Tono: calmo, confiado, útil. Evitar superlativos y promesas vagas.
- Preferir resultados prácticos sobre descripciones de funciones.
- Longitud: títulos 5–8 palabras; descripciones 1–2 oraciones.
- Evitar repetir argumentos ya cubiertos en Landing/Features/Privacy & Security.

## Accessibility
- Teclado: todo elemento interactivo es alcanzable en orden lógico; foco visible consistente.
- Lectores de pantalla: imágenes relevantes con alt significativo; secuencia de encabezados lógica; labels descriptivos en botones y enlaces.
- Jerarquía de botones: un primario por vista; secundarios con contraste y roles claros.
- Estados: mensajes y cambios relevantes deben anunciarse (sin dictar tecnología).

## Responsive Behavior
- Desktop/Tablet/Mobile cuentan la misma historia; cambia solo el layout.
- Hero: acción primaria visible sin scroll en desktop; en mobile puede quedar en primer pliegue superior si el header es alto.
- Installation Journey: 4 pasos en fila (desktop) o carriles/stack cómodo (tablet/mobile) sin convertirlo en carrusel pesado.
- First Experience: capturas legibles, con tamaños que prioricen evidencia frente a texto.
- Compatibility y Essential Questions: bloques escaneables, sin densidad excesiva.

## Acceptance Criteria
- Una única acción primaria “Descargar Xpendz” claramente predominante.
- Sección “Installation Journey” con 4 pasos exactos en el orden establecido.
- “First Experience” muestra evidencia real y concreta de primeros minutos de uso.
- “Compatibility” responde disponibilidad por plataforma y requisitos mínimos de forma comprensible.
- “Essential Questions” responde, al menos, las seis preguntas definidas.
- Microcopy sin marketing, orientada a reducir incertidumbre.
- Accesibilidad básica cubierta según requisitos.
- La página no repite contenido de Features ni Trust; complementa el recorrido.

## Long-term Vision
- La sección de compatibilidad puede incorporar matrices por versión o notas de release, manteniendo la simplicidad.
- El CTA puede adaptarse a múltiples destinos (MSI, APK, Store) sin perder unicidad de la acción primaria.
- La primera experiencia puede enlazar a guías específicas post-instalación, sin interferir con la descarga.

## Relationship with RFC-003
- Es la etapa final del flujo público. No crea nuevas rutas ni reorganiza páginas.
- Hereda shell compartido y tokens visuales para consistencia del sitio.

## Relationship with UX-014
- Cumple el modelo Discover → Understand → Trust → Decide/Start.
- Su responsabilidad emocional es reducir ansiedad y facilitar acción.

## Relationship with SPEC-009
- SPEC-009 prepara al visitante con evidencia por módulo. SPEC-010 toma el relevo para convertir comprensión y confianza en instalación inmediata.
- No revive el explorador; lo complementa con los “primeros minutos”.

## Document Lifecycle
- Responsables: Ingeniería Web (owner), Producto (co-owner), Diseño (consultado). 
- Cambios se gatillan por: nuevas plataformas/formatos de distribución, cambios de onboarding, actualizaciones de compatibilidad.
- Versionado semántico del documento; actualizar fecha y relaciones cuando cambie cualquiera de las especificaciones relacionadas.
