# ADR-001 — Header Overlay Architecture

**Estado:** Aprobado  
**Versión:** 1.0  
**Fecha:** 2026-08-05  
**Proyecto:** Xpendz

---

# 1. Contexto

Durante la implementación del nuevo Sticky Header para la Landing V2 se evaluaron diferentes alternativas para integrar visualmente el Header con el Hero.

Las primeras implementaciones trataron el Header como un bloque independiente dentro del flujo normal del documento. Aunque funcionalmente correctas, generaban una separación visual entre el Header y el Hero mediante una franja clara que rompía la continuidad de la primera pantalla.

Después de varias iteraciones se concluyó que el problema no era de estilos (padding, márgenes u opacidad), sino de la arquitectura visual del componente.

---

# 2. Decisión

El Header de la Landing de Xpendz se implementará como un **Overlay** sobre el Hero.

Esto significa que:

- El Hero comenzará desde el borde superior de la ventana.
- El Header flotará sobre el Hero.
- Mientras la página permanezca en la parte superior, el Header será completamente transparente.
- El fondo del Header aparecerá únicamente durante el desplazamiento del usuario.
- Header y Hero deberán percibirse como una única composición visual.

---

# 3. Justificación

Esta decisión mejora significativamente la experiencia inicial del usuario porque:

- elimina separaciones visuales innecesarias;
- refuerza la identidad moderna del producto;
- aumenta el protagonismo del Hero;
- reduce la sensación de bloques independientes;
- genera una experiencia similar a la utilizada por productos digitales modernos.

El objetivo es que el usuario perciba una única experiencia visual durante los primeros segundos de navegación.

---

# 4. Consecuencias

Toda implementación futura del Header deberá respetar este principio.

No deberá:

- introducir barras visibles antes del Hero;
- separar visualmente Header y Hero;
- convertir el Header en un bloque tradicional.

El comportamiento Overlay forma parte de la arquitectura oficial de la Landing.

---

# 5. Implementación

La técnica específica (CSS, JavaScript o una combinación de ambos) podrá evolucionar con el tiempo.

Sin embargo, el comportamiento observable deberá mantenerse:

- Header transparente al inicio.
- Hero visible detrás del Header.
- Fondo con blur únicamente durante el scroll.
- Transición fluida entre ambos estados.

La implementación podrá optimizarse sin modificar estos principios.

---

# 6. Impacto

Este ADR afecta a:

- Header
- Hero
- Navegación Desktop
- Navegación Mobile
- Futuras páginas públicas de Xpendz

Cualquier rediseño de la Landing deberá respetar esta decisión, salvo que un nuevo ADR la reemplace explícitamente.

---

# 7. Relación con otros documentos

Este ADR complementa:

- RFC-001 Product Vision
- RFC-002 Landing V2 Strategy
- SPEC-001 Sticky Header

En caso de conflicto entre una implementación y este ADR, prevalecerá la decisión arquitectónica documentada aquí.

---

# 8. Estado

**Aprobado.**

Este documento representa la decisión oficial sobre la arquitectura visual del Header en la Landing V2 de Xpendz.