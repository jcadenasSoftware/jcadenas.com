# SPEC-009 — Interactive Product Explorer

**Estado:** Aprobado

**Versión:** 1.0

**Fecha:** 2026-08-09

**Proyecto:** Xpendz

---

# 1. Objetivo

Definir la especificación de producto para reemplazar la página **Funciones** lineal por un **Explorador de Producto interactivo** (Product Explorer) que preserve la narrativa modular definida en UX-014 y mejore la comprensión activa del visitante.

Este documento especifica el comportamiento esperado a nivel de experiencia e interacción. No define HTML, CSS ni JavaScript. Su finalidad es orientar una implementación coherente, mantenible y compatible con la arquitectura vigente.

---

# 2. Antecedentes

Xpendz evolucionó desde una Landing única a un sitio público modular (RFC-003) con filosofía narrativa aprobada (UX-013, UX-014). La página **Funciones** (SPEC-006) estableció la responsabilidad de explicar cómo Xpendz ayuda en la práctica.

La versión actual de Funciones organiza capacidades en una secuencia vertical. Aunque aporta información valiosa, el formato incentiva el consumo pasivo y la repetición de bloques. El Product Explorer propone una experiencia guiada que fomenta la exploración activa sin alterar identidad visual ni arquitectura.

Este SPEC extiende SPEC-006 llevando la misma responsabilidad a un modelo interactivo, sin contradecir UX-013 ni UX-014.

---

# 3. Planteamiento del problema

- La página Funciones apila secciones similares y exige desplazamientos largos.
- La estructura favorece lectura secuencial tipo documentación.
- La repetición formal dificulta priorizar lo más relevante.
- La interacción actual no impulsa descubrimiento activo ni comparación rápida entre capacidades.

---

# 4. Metas

El Product Explorer debe:

- reducir desplazamiento innecesario;
- mejorar jerarquía de información y foco de lectura;
- aumentar descubrimiento de capacidades (discoverability);
- incentivar interacción ligera y comprensible;
- reforzar entendimiento con evidencia real del producto;
- preservar la narrativa de UX-014 (Descubrir → Comprender → Confiar → Instalar) en su tramo de “Comprender/Validar”.

---

# 5. Principios de diseño

- Un propósito por superficie: la página sigue siendo “Comprender” (SPEC-006), ahora en formato explorador.
- Interacción al servicio de la historia: cada acción responde una pregunta concreta.
- Evidencia antes que adjetivos: las capturas reales tienen prioridad sobre gráficos decorativos.
- Progresión sin redundancia: cada vista agrega comprensión; no repite lo anterior con otras palabras.
- Estabilidad visual: el marco de la página permanece; solo cambia el panel de contenido.
- Peso ligero: transiciones discretas y rendimiento percibido alto.
- Accesibilidad integral: teclado, lectores de pantalla, foco visible y orden lógico siempre consistentes.

---

# 6. Modelo de Product Explorer

La página deja de apilar módulos verticalmente. En su lugar, adopta un explorador persistente con dos zonas lógicas:

1) **Panel de navegación** (selector de funciones)
2) **Panel de contenido** (detalle de la función activa)

Flujo conceptual por función:

Seleccionar una función

↓

Entender su propósito

↓

Ver evidencia real del producto (captura obligatoria)

↓

Descubrir 3 beneficios prácticos

↓

Continuar explorando (volver al selector o CTA contextual)

El “lienzo” de la página se mantiene estable; el contenido cambia en el panel.

---

# 7. Arquitectura de la información

- La lista de funciones en el panel de navegación se presenta en un orden lógico que ayude a comprender el uso cotidiano (alineado con SPEC-006):
  - Panorama / Dashboard
  - Cuentas
  - Transacciones
  - Categorías
  - Presupuestos
  - Metas
  - Préstamos
  - Reportes
  - Sincronización
  - Respaldos
- Cada elemento del selector corresponde a una vista única del panel de contenido.
- El estado activo debe ser inequívoco (texto, color y/o indicador accesible) sin depender solo del color.
- Debe existir un identificador estable por función (para anclaje, deeplink y restauración de estado del explorador cuando sea posible en el futuro).

---

# 8. Reglas de interacción

- Activación:
  - Clic o Enter/Espacio sobre un ítem del panel de navegación activa su contenido.
  - Flechas arriba/abajo/navegación por tabulación recorren ítems.
- Estado activo:
  - Debe mantenerse mientras el usuario navega en el mismo documento.
  - Debe anunciarse a lectores de pantalla (p. ej., aria-current="page" o rol equivalente) y con foco visible.
- Transiciones:
  - Usar fade/crossfade breve o cambio discreto de contenido; sin deslizamientos tipo carrusel.
  - Duración sugerida: 120–200ms; sin animaciones automáticas periódicas.
- Teclado:
  - El orden de tabulación sigue la jerarquía: navegación → contenido → CTA(s) del contenido → volver a navegación.
  - Escape puede devolver el foco al panel de navegación (opcional, si no interfiere con accesibilidad estándar del navegador).
- Control de estado:
  - La selección debe ser persistente mientras el usuario permanezca en la página (sin recargas).
  - Es recomendable permitir deep-linking opcional (p. ej., hash o query) para abrir una función específica.

---

# 9. Comportamiento del panel de contenido

Cada función mostrará:

- Título conciso
- Explicación breve (2–3 frases orientadas al valor)
- Captura real obligatoria (evidencia del producto)
- 3 beneficios prácticos con lenguaje claro y no redundante
- CTA opcional hacia el siguiente paso de descubrimiento (p. ej., “Ver cómo sincroniza” si se está en Transacciones)

Reglas:

- La captura debe tener atributo de texto alternativo significativo (no “screenshot”).
- El contenido del panel debe ser autosuficiente: se entiende sin leer primero otras funciones.
- No usar deslizadores, carruseles ni animaciones automáticas dentro del panel.
- El CTA no debe competir con la navegación principal; guía, no desvía.

---

# 10. Navegación (panel selector)

- Selector accesible con rol adecuado (p. ej., listbox/list/menubar según patrón elegido) y estados claros.
- Active state visible por estilo y anunciado vía ARIA (p. ej., aria-current o aria-selected).
- Orden lógico (ver Sección 7) con etiquetas inequívocas y, si se usan, íconos descriptivos no esenciales.
- Etiquetas concisas, consistentes con el resto del sitio (no introducir terminología nueva).
- Soporte de teclado: Tab/Shift+Tab, Flechas, Home/End para salto al primero/último (recomendado si el patrón lo permite).
- Tamaño táctil adecuado en dispositivos móviles.

---

# 11. Transiciones

Permitidas:

- Fade / crossfade corto al cambiar de función
- Pequeñas transiciones de estado (hover/focus/press) en ítems del selector

Evitar:

- Carruseles, sliders y autorrotaciones
- Transiciones complejas con trayectorias largas
- Animaciones que distraigan o afecten rendimiento

La interacción debe sentirse ligera, profesional y estable.

---

# 12. Comportamiento responsivo

## 12.1 Escritorio
- Dos paneles persistentes: navegación (izquierda) y contenido (derecha).
- El alto del panel de contenido se adapta sin forzar scroll excesivo del documento.
- El selector permanece visible mientras se explora (sin fijación obligatoria si no es necesaria).

## 12.2 Tableta
- Mantener dos paneles cuando el ancho lo permita; si no, usar panel de navegación colapsable (acordeón o drawer) accesible.
- El selector debe ser rápido de mostrar/ocultar sin perder el estado activo.

## 12.3 Móvil
- Reemplazar la barra lateral por un selector interactivo compacto (lista/tabs/menú) antes del panel de contenido.
- Evitar scroll vertical excesivo: el panel de contenido cambia al seleccionar una función.
- Preservar la misma filosofía: página estable, cambio de contenido sin apilar módulos.

---

# 13. Accesibilidad

- Teclado: todas las funciones deben activarse sin mouse.
- Foco visible: indicadores claros, con contraste suficiente y no dependientes solo del color.
- ARIA: roles y estados correctos (p. ej., aria-selected, aria-controls, aria-labelledby) para el patrón de navegación elegido.
- Lectores de pantalla: anunciar cambios en el panel de contenido (p. ej., live region discreta o gestión de foco al título del panel).
- Orden lógico de tabulación: navegación → contenido → CTA(s) → volver a navegación.
- Imágenes: alt text descriptivo y contextual.

---

# 14. Consideraciones de rendimiento

- Cargar de forma diferida capturas no visibles hasta que se seleccione la función.
- Minimizar trabajo en main thread; evitar animaciones costosas.
- Reutilizar el contenedor del panel de contenido para evitar recalcular layout completo.
- Evitar dependencias pesadas solo para transiciones menores.
- Mantener tamaño total de la página coherente con el resto del sitio.

---

# 15. Criterios de aceptación

La implementación se considerará conforme cuando:

- La página Funciones opera como explorador interactivo estable (no apila todas las secciones).
- La navegación permite seleccionar funciones con mouse y teclado, con estado activo claro.
- El panel de contenido muestra: título, explicación, captura real, 3 beneficios y CTA opcional.
- Las transiciones son discretas (fade/crossfade corto) sin carruseles/sliders.
- El comportamiento responsivo cumple: dos paneles en escritorio; selector accesible en móvil.
- Accesibilidad validada: foco visible, roles/estados ARIA correctos, orden de tabulación lógico, alt text adecuado.
- Se respeta UX-014: progresión, evidencia real, CTAs como puente natural.
- No se introducen estilos ni patrones visuales ajenos a la identidad vigente.

---

# 16. Visión a largo plazo

- Permitir deep-linking a funciones específicas (p. ej., /xpendz/funciones#reportes) sin romper la experiencia.
- Habilitar persistencia opcional de la última función visitada.
- Escalar a nuevas funciones manteniendo orden lógico y sin costo cognitivo adicional.
- Integrar métricas no invasivas para entender qué funciones requieren mejor explicación (fuera del alcance de este SPEC).

---

# 17. Relación con UX-014

Este SPEC implementa la filosofía de **UX-014 — Modular Product Storytelling** para la superficie de comprensión del producto:

- Una historia continua donde cada interacción responde una pregunta.
- Evidencia real por encima de claims abstractos.
- CTAs que conectan con la siguiente etapa del recorrido sin dispersión.

Compatibilidad adicional:

- RFC-003 (arquitectura modular)
- UX-013 (flujo de información)
- SPEC-006 (responsabilidad de la página Funciones)
- No contradice SPEC-007 ni SPEC-008; se limita a la fase de “Comprender/Validar”.

---

# 18. Documento vivo

Toda modificación sustancial del Product Explorer deberá reflejarse en este SPEC antes de llegar a diseño, contenido o desarrollo. Este documento es la referencia canónica para futuras implementaciones de exploradores de producto dentro del ecosistema jcadenas.com.
