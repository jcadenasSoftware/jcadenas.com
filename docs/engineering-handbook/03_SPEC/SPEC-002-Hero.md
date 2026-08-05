# SPEC-002 — Hero

**Estado:** Aprobado

**Versión:** 2.0

**Fecha:** 2026-08-05

**Proyecto:** Xpendz

---

# 1. Objetivo

Definir la implementación del Hero de la Landing V2.

El Hero representa el punto de mayor impacto de toda la Landing.

Su misión no consiste en presentar funcionalidades.

Su misión consiste en convencer al visitante de continuar explorando y aumentar significativamente la probabilidad de descargar Xpendz.

---

# 2. Contexto

Este documento se basa en:

- RFC-001 Product Vision
- RFC-002 Landing V2 Strategy
- ADR-001 Header Overlay Architecture
- UX-001 Messaging Strategy
- UX-002 Hero Storyboard
- UX-003 Hero Copy
- AI Development Guide

Todos estos documentos tienen prioridad sobre cualquier interpretación individual.

---

# 3. Propósito

El Hero deberá responder una única pregunta.

¿Por qué debería descargar Xpendz?

No deberá responder:

¿Cómo funciona?

Eso ocurrirá en las siguientes secciones de la Landing.

---

# 4. Objetivo de negocio

Incrementar la intención de descarga.

El Hero deberá generar confianza suficiente para que el usuario continúe explorando la Landing o pulse el CTA principal.

---

# 5. Historia

Toda la experiencia deberá seguir esta secuencia.

Problema

↓

Promesa

↓

Prueba

↓

Acción

No deberá alterarse este orden.

---

# 6. Experiencia esperada

Durante los primeros segundos el usuario deberá pensar:

"Eso me pasa."

↓

"Esta aplicación puede ayudarme."

↓

"Se ve sencilla."

↓

"Quiero probarla."

---

# 7. Arquitectura visual

El Hero forma una única composición junto con el Header Overlay.

No deberá existir ninguna separación visual entre ambos.

La captura de la aplicación será el principal elemento visual del Hero.

Todo el resto del diseño deberá reforzar esa jerarquía.

---

# 8. Contenido

El contenido textual será el definido en:

UX-003 Hero Copy.

No deberá modificarse durante la implementación.

---

# 9. Jerarquía visual

El recorrido esperado será:

1. Problema.

2. Promesa.

3. Captura.

4. CTA.

5. Beneficios.

Todo elemento adicional deberá justificar su existencia.

---

# 10. Responsive

Desktop

Dos columnas.

Mobile

Una columna.

Tablet

Transición progresiva.

La historia deberá conservar exactamente el mismo impacto en los tres formatos.

---

# 11. Microinteracciones

Las animaciones deberán reforzar la experiencia.

Nunca competir con el contenido.

Duración recomendada:

150–300 ms.

---

# 12. Accesibilidad

El Hero deberá ser completamente navegable mediante teclado.

Todos los botones deberán ser identificables.

Las imágenes deberán incluir texto alternativo.

El contraste deberá cumplir criterios de accesibilidad.

---

# 13. Rendimiento

Las imágenes deberán optimizarse.

No utilizar animaciones costosas.

Priorizar rapidez de carga.

---

# 14. Restricciones

No modificar:

- Header

- Footer

- Otras secciones

Este SPEC únicamente define el Hero.

---

# 15. Definition of Done

El Hero se considerará terminado cuando:

✓ Un usuario nuevo comprenda qué hace Xpendz en menos de cinco segundos.

✓ El problema del usuario quede claramente identificado.

✓ La promesa principal sea evidente.

✓ La captura de la aplicación refuerce el mensaje.

✓ El CTA principal sea el elemento de acción dominante.

✓ La experiencia sea consistente en Desktop y Mobile.

✓ El Hero transmita claridad, confianza y profesionalismo.

✓ No existan elementos que distraigan de la acción principal.

---

# 16. Entregables esperados

La implementación deberá incluir:

- HTML.

- CSS.

- JavaScript (únicamente cuando aporte valor).

- Responsive.

- Accesibilidad.

- Optimización.

---

# 17. Relación con otros documentos

RFC-001 Product Vision

RFC-002 Landing V2 Strategy

ADR-001 Header Overlay Architecture

UX-001 Messaging Strategy

UX-002 Hero Storyboard

UX-003 Hero Copy

AI Development Guide

---

# 18. Documento vivo

Toda modificación importante del Hero deberá reflejarse primero en este documento antes de implementarse en código.