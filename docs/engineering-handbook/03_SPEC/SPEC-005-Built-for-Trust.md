# SPEC-005 — Built for Trust Section

**Estado:** Aprobado

**Versión:** 1.0

**Fecha:** 2026-08-05

**Proyecto:** Xpendz

---

# 1. Objetivo

Definir la implementación de la sección **Construido para inspirar confianza** de la Landing V2.

Esta sección tiene como propósito reforzar la confianza del visitante mediante hechos, principios de diseño y decisiones de producto.

No sustituye un bloque de testimonios.

Lo reemplaza completamente.

---

# 2. Contexto

Este documento se basa en:

- RFC-001 Product Vision
- RFC-002 Landing V2 Strategy
- Product Design Principles
- UX-008 Trust Strategy
- UX-009 Built for Trust Copy
- AI Development Guide

---

# 3. Objetivo de negocio

Antes del CTA final, el visitante deberá pensar:

> "Esta aplicación parece seria, bien diseñada y merece una oportunidad."

---

# 4. Pregunta que responde

¿Por qué puedo confiar en Xpendz?

---

# 5. Arquitectura

La sección estará compuesta por:

- un título principal;
- un párrafo introductorio;
- cuatro principios;
- un mensaje de cierre.

No incluirá testimonios.

No incluirá calificaciones.

No incluirá estrellas.

No incluirá cifras inventadas.

---

# 6. Principios

## Claridad

Toda la información importante debe ser fácil de entender.

---

## Simplicidad

Administrar las finanzas no debería sentirse complicado.

---

## Organización

Cada elemento tiene un lugar y un propósito.

---

## Evolución

Xpendz mejora continuamente para ofrecer una mejor experiencia.

---

# 7. Diseño

Desktop

Cuatro tarjetas organizadas en una cuadrícula equilibrada.

Cada tarjeta incluirá:

- icono;
- título;
- breve descripción.

---

Mobile

Una sola columna.

Espaciado amplio.

Lectura cómoda.

---

# 8. Microinteracciones

Cada tarjeta podrá incluir:

- elevación ligera;
- transición suave;
- animación sutil del icono.

No utilizar efectos llamativos.

---

# 9. Rendimiento

La implementación deberá utilizar:

- HTML semántico;
- CSS nativo;
- JavaScript únicamente si aporta valor.

No utilizar librerías externas.

---

# 10. Accesibilidad

- Navegable mediante teclado.
- Contraste suficiente.
- Iconos decorativos correctamente marcados.
- Jerarquía semántica correcta.

---

# 11. Restricciones

Eliminar cualquier bloque de:

- testimonios;
- estrellas;
- valoraciones;
- opiniones ficticias.

Esta sección será la única responsable de construir confianza antes del CTA.

---

# 12. Definition of Done

La sección se considerará terminada cuando:

✓ Refuerce la credibilidad del producto.

✓ Mantenga coherencia con toda la Landing.

✓ No utilice recursos de marketing poco verificables.

✓ Sea completamente responsive.

✓ Mantenga un alto rendimiento.

---

# 13. Checklist de implementación

## Arquitectura

- [ ] Mantener estructura existente.
- [ ] No romper componentes actuales.

## HTML

- [ ] HTML semántico.
- [ ] Estructura accesible.

## CSS

- [ ] Variables existentes.
- [ ] Responsive.
- [ ] Espaciados consistentes.

## JavaScript

- [ ] Solo si aporta valor.
- [ ] Sin dependencias externas.

## Rendimiento

- [ ] Sin bloqueo del renderizado.
- [ ] Recursos optimizados.

## Accesibilidad

- [ ] Navegación por teclado.
- [ ] Contraste adecuado.
- [ ] Etiquetas semánticas.

---

# 14. Relación con otros documentos

- UX-008 Trust Strategy
- UX-009 Built for Trust Copy
- EPIC-001 Landing V2

---

# 15. Documento vivo

Toda modificación importante de esta sección deberá documentarse aquí antes de implementarse en código.