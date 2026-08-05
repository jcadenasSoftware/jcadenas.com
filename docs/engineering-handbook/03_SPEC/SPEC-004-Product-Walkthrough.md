# SPEC-004 — Product Walkthrough

**Estado:** Aprobado

**Versión:** 1.0

**Fecha:** 2026-08-05

**Proyecto:** Xpendz

---

# 1. Objetivo

Definir la implementación de la sección **Product Walkthrough** de la Landing V2.

Esta sección demuestra el funcionamiento de Xpendz mediante un recorrido guiado que permite al visitante imaginar cómo utilizaría la aplicación en su vida diaria.

No es una galería de capturas.

Es una demostración del producto.

---

# 2. Contexto

Este documento se basa en:

- RFC-001 Product Vision
- RFC-002 Landing V2 Strategy
- UX-005 Product Walkthrough Strategy
- UX-006 Product Walkthrough Script
- UX-007 Product Walkthrough Copy
- Product Design Principles
- AI Development Guide

---

# 3. Objetivo de negocio

Incrementar la confianza del visitante.

Reducir la incertidumbre antes del CTA principal.

Conseguir que el usuario piense:

> "Ya puedo imaginarme usando Xpendz."

---

# 4. Pregunta que responde

Esta sección responde una sola pregunta:

**¿Cómo sería utilizar Xpendz?**

No deberá explicar todas las funciones de la aplicación.

---

# 5. Arquitectura

El Product Walkthrough estará compuesto por seis bloques narrativos:

1. Dashboard
2. Transacciones
3. Reportes
4. Cuentas y Categorías
5. Presupuestos y Metas
6. Transición al CTA

Cada bloque representa un momento del recorrido del usuario.

---

# 6. Layout

## Desktop

La sección se dividirá en dos áreas principales.

### Área izquierda

Contenido textual.

- Título
- Descripción
- Indicador de progreso (opcional)

### Área derecha

Mockup del teléfono.

La estructura del teléfono permanecerá fija.

Únicamente cambiará la pantalla mostrada dentro del dispositivo.

---

## Mobile

Cada bloque se presentará en el siguiente orden:

Título

↓

Descripción

↓

Captura

↓

Separación visual

↓

Siguiente bloque

No se utilizarán columnas.

---

# 7. Comportamiento

La transición entre bloques deberá ser suave.

No se utilizarán:

- sliders;
- carruseles automáticos;
- autoplay;
- librerías externas para animación.

El desplazamiento natural de la página será el mecanismo principal de navegación.

---

# 8. Rendimiento

La implementación deberá priorizar:

- HTML semántico;
- CSS nativo;
- JavaScript mínimo;
- imágenes optimizadas en WebP;
- lazy loading para capturas posteriores;
- ausencia de dependencias externas.

La primera carga deberá permanecer rápida incluso en dispositivos móviles.

---

# 9. Accesibilidad

Cada captura deberá incluir texto alternativo.

El recorrido deberá respetar el orden lógico de lectura.

Toda la sección deberá ser navegable mediante teclado.

Los contrastes deberán cumplir criterios de accesibilidad.

---

# 10. Restricciones

No modificar:

- Header
- Hero
- Features
- CTA
- Footer

Este SPEC únicamente define el Product Walkthrough.

---

# 11. Definition of Done

La sección se considerará terminada cuando:

✓ El visitante comprenda cómo utilizar Xpendz.

✓ El recorrido resulte natural.

✓ El teléfono mantenga una posición visual consistente.

✓ Las capturas apoyen la historia.

✓ La experiencia sea idéntica en Desktop y Mobile.

✓ El rendimiento permanezca alto.

✓ No existan elementos visuales innecesarios.

---

# 12. Checklist de implementación

## Arquitectura

- [ ] Mantener la estructura actual del proyecto.
- [ ] No incorporar frameworks.
- [ ] No romper componentes existentes.

## HTML

- [ ] HTML semántico.
- [ ] Estructura accesible.
- [ ] Etiquetas correctas.

## CSS

- [ ] Variables CSS existentes.
- [ ] Responsive.
- [ ] Espaciados consistentes.
- [ ] Animaciones CSS ligeras.

## JavaScript

- [ ] JavaScript mínimo.
- [ ] Sin dependencias externas.
- [ ] Eventos optimizados.

## Rendimiento

- [ ] Lazy loading.
- [ ] Imágenes optimizadas.
- [ ] Sin bloqueo del renderizado.

## Accesibilidad

- [ ] Navegación mediante teclado.
- [ ] Textos alternativos.
- [ ] Contraste suficiente.

---

# 13. Entregables

La implementación deberá incluir únicamente:

- HTML
- CSS
- JavaScript (si aporta valor)

No deberán incorporarse nuevas tecnologías.

---

# 14. Relación con otros documentos

- RFC-001 Product Vision
- RFC-002 Landing V2 Strategy
- UX-005 Product Walkthrough Strategy
- UX-006 Product Walkthrough Script
- UX-007 Product Walkthrough Copy
- EPIC-001 Landing V2

---

# 15. Documento vivo

Toda modificación importante de esta sección deberá reflejarse primero en este documento antes de implementarse en código.