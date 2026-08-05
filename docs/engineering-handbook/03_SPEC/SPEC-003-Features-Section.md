# SPEC-003 — Features Section

**Estado:** Aprobado

**Versión:** 1.0

**Fecha:** 2026-08-05

**Proyecto:** Xpendz

---

# 1. Objetivo

Definir la implementación de la sección **Funciones** de la Landing V2.

Esta sección continúa la historia iniciada por el Hero.

Su misión consiste en demostrar, mediante ejemplos concretos, cómo Xpendz ayuda al usuario a recuperar el control de sus finanzas.

No pretende enumerar todas las funcionalidades de la aplicación.

Debe transformar la curiosidad en confianza.

---

# 2. Contexto

Este documento se basa en:

- RFC-001 Product Vision
- RFC-002 Landing V2 Strategy
- UX-001 Messaging Strategy
- UX-002 Hero Storyboard
- UX-003 Hero Copy
- UX-004 Features Story
- Product Design Principles
- AI Development Guide

---

# 3. Objetivo de negocio

Después de recorrer esta sección el usuario deberá pensar:

> "Ahora entiendo cómo Xpendz puede ayudarme."

La sección debe aumentar la confianza antes de mostrar capturas detalladas de la aplicación.

---

# 4. Pregunta que responde

Esta sección responde únicamente a la siguiente pregunta:

**¿Cómo me ayuda Xpendz?**

No deberá responder ninguna otra.

---

# 5. Historia

La historia deberá seguir exactamente este recorrido.

Registrar

↓

Comprender

↓

Organizar

↓

Planificar

↓

Decidir

Cada bloque representa un paso en la evolución del usuario.

---

# 6. Estructura

La sección estará compuesta por cinco tarjetas principales.

Cada tarjeta representa un beneficio.

No una funcionalidad.

---

## Tarjeta 1

### Registrar

Título

**Registra cada movimiento.**

Descripción

Registra ingresos y gastos de forma rápida y mantén un historial financiero siempre disponible.

---

## Tarjeta 2

### Comprender

Título

**Comprende cómo se mueve tu dinero.**

Descripción

Visualiza claramente tus ingresos y gastos para identificar hábitos y oportunidades de mejora.

---

## Tarjeta 3

### Organizar

Título

**Mantén todo organizado.**

Descripción

Administra cuentas y categorías desde un único lugar con una estructura sencilla y clara.

---

## Tarjeta 4

### Planificar

Título

**Planifica tus objetivos.**

Descripción

Define presupuestos y metas que te ayuden a avanzar hacia tus objetivos financieros.

---

## Tarjeta 5

### Decidir

Título

**Decide con información.**

Descripción

Utiliza gráficos y reportes para tomar decisiones financieras con mayor confianza.

---

# 7. Diseño

Cada tarjeta deberá incluir:

- un icono representativo;
- un título;
- una descripción breve;
- suficiente espacio en blanco;
- una jerarquía visual clara.

Las tarjetas deberán mantener el mismo tamaño visual.

---

# 8. Responsive

## Desktop

Disposición en dos filas equilibradas.

Espaciado amplio.

Lectura cómoda.

---

## Tablet

Reorganización progresiva.

Sin pérdida de jerarquía.

---

## Mobile

Una única columna.

El recorrido deberá conservar el orden narrativo.

Registrar → Comprender → Organizar → Planificar → Decidir.

---

# 9. Microinteracciones

Las tarjetas podrán incorporar:

- elevación suave al pasar el cursor;
- transición de 150–250 ms;
- ligera animación del icono.

Las animaciones deberán reforzar la interacción.

Nunca distraer.

---

# 10. Accesibilidad

Las tarjetas deberán:

- mantener contraste adecuado;
- ser completamente navegables mediante teclado;
- utilizar títulos semánticos;
- respetar el orden lógico de lectura.

---

# 11. Restricciones

No modificar:

- Hero.
- Header.
- Footer.
- Capturas.
- CTA.

Este SPEC únicamente define la sección Funciones.

---

# 12. Definition of Done

La sección se considerará terminada cuando:

✓ Explique claramente cómo Xpendz ayuda al usuario.

✓ Las cinco tarjetas mantengan una jerarquía consistente.

✓ El recorrido narrativo se conserve en Desktop y Mobile.

✓ Los beneficios tengan mayor protagonismo que las funcionalidades.

✓ La sección se perciba ligera y fácil de leer.

✓ No existan bloques visuales innecesarios.

✓ La experiencia resulte coherente con el Hero.

---

# 13. Entregables esperados

La implementación deberá incluir:

- HTML.
- CSS.
- JavaScript únicamente si aporta valor.
- Diseño responsive.
- Accesibilidad.
- Optimización visual.

---

# 14. Relación con otros documentos

Este documento complementa:

- RFC-001 Product Vision
- RFC-002 Landing V2 Strategy
- UX-001 Messaging Strategy
- UX-002 Hero Storyboard
- UX-003 Hero Copy
- UX-004 Features Story
- EPIC-001 Landing V2

---

# 15. Documento vivo

Toda modificación importante en la sección Funciones deberá realizarse primero en este documento antes de implementarse en código.

El objetivo es mantener la coherencia entre estrategia, diseño e implementación durante toda la evolución de la Landing.