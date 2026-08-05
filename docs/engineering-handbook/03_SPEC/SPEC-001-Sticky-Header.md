# SPEC-001 — Sticky Header

**Estado:** Draft  
**Versión:** 1.0  
**Fecha:** 2026-08-05  
**Proyecto:** Xpendz

---

# 1. Objetivo

Definir la implementación del nuevo encabezado (Header) de la Landing V2 de Xpendz.

Este componente será utilizado en todas las páginas públicas del sitio y representará el principal elemento de navegación del producto.

---

# 2. Contexto

Según lo establecido en:

- RFC-001 Product Vision
- RFC-002 Landing V2 Strategy

La navegación deberá permanecer accesible durante toda la experiencia del usuario.

El Header será un componente compartido entre Desktop y Mobile.

---

# 3. Alcance

Este documento únicamente cubre:

- Header
- Navegación
- Comportamiento Sticky
- Responsive
- CTA principal

No incluye Hero, Footer ni el contenido de las páginas.

---

# 4. Objetivos del Header

El Header debe permitir que el usuario:

- identifique inmediatamente la marca;
- navegue fácilmente entre páginas;
- encuentre rápidamente el botón de descarga;
- nunca pierda el acceso a la navegación principal.

---

# 5. Estructura

## Desktop

```
-------------------------------------------------------------
Logo

Inicio

Funciones

Capturas

Descargar

                         Descargar App
-------------------------------------------------------------
```

---

## Mobile

```
--------------------------------
Logo              ☰
--------------------------------
```

Al abrir el menú:

```
Inicio

Funciones

Capturas

Descargar

Privacidad

Eliminar cuenta
```

---

# 6. Comportamiento

## Estado inicial

El Header aparecerá sobre el Hero.

Diseño limpio.

Sin sombras fuertes.

---

## Durante el Scroll

El Header permanecerá fijo.

Cambiará ligeramente su apariencia mediante:

- fondo semitransparente;
- efecto blur;
- borde inferior muy sutil;
- transición suave.

No deberá cambiar de tamaño.

---

# 7. Navegación

Los enlaces principales serán:

- Inicio
- Funciones
- Capturas
- Descargar

En el menú móvil también aparecerán:

- Privacidad
- Eliminar cuenta

---

# 8. Botón principal

El botón "Descargar App" deberá permanecer visible en Desktop.

En Mobile podrá mostrarse dentro del menú lateral para optimizar el espacio.

En futuras versiones podrá cambiar automáticamente según la plataforma del usuario.

---

# 9. Responsive

Desktop

- navegación horizontal.

Tablet

- transición progresiva.

Mobile

- menú hamburguesa.

No deberán existir elementos superpuestos.

---

# 10. Animaciones

Las animaciones deberán ser discretas.

Tiempo recomendado:

150–250 ms.

No utilizar animaciones llamativas.

La navegación debe sentirse rápida.

---

# 11. Accesibilidad

El Header deberá:

- ser completamente navegable mediante teclado;
- respetar contraste suficiente;
- utilizar etiquetas semánticas;
- indicar el elemento activo;
- mantener un orden lógico de tabulación.

---

# 12. Rendimiento

El Header deberá:

- reutilizar componentes;
- minimizar re-renderizados;
- evitar JavaScript innecesario;
- utilizar CSS para efectos simples siempre que sea posible.

---

# 13. Restricciones

No modificar:

- Hero
- Footer
- Contenido de páginas
- Identidad visual

El objetivo de esta implementación es únicamente reemplazar el sistema de navegación.

---

# 14. Criterios de aceptación

La implementación será aceptada cuando:

- el Header permanezca visible durante todo el scroll;
- funcione correctamente en Desktop;
- funcione correctamente en Mobile;
- el menú móvil sea intuitivo;
- el botón principal sea claramente visible;
- la navegación resulte consistente en todas las páginas.

---

# 15. Tareas para implementación

1. Crear componente Header reutilizable.

2. Implementar Sticky Header.

3. Implementar navegación Desktop.

4. Implementar navegación Mobile.

5. Agregar efecto de fondo durante el scroll.

6. Agregar CTA principal.

7. Validar comportamiento responsive.

8. Verificar accesibilidad.

---

# 16. Referencias

RFC-001 — Product Vision

RFC-002 — Landing V2 Strategy

AI Development Guide

---

# 17. Documento vivo

Este documento podrá evolucionar cuando cambien los requisitos del sistema de navegación.

Toda modificación del Header deberá actualizar este SPEC antes o durante su implementación.


--Contexto obligatorio:


- RFC-001 Product Vision
- RFC-002 Landing V2 Strategy
- AI Development Guide
- SPEC-001 Sticky Header

Objetivo:

Implementar exactamente lo definido en este SPEC.

Antes de modificar el código:

1. Resume el enfoque de implementación.
2. Identifica posibles conflictos con la estructura actual.
3. Propón el plan de ejecución.

Después implementa únicamente el alcance definido en este documento.

# 18. Refinamientos visuales

Durante la revisión de la primera implementación se establecieron los siguientes criterios adicionales:

## Integración Header–Hero

El Header y el Hero deberán percibirse como una única experiencia visual.

No deberá existir una franja de color que genere una separación evidente entre ambos.

El Header será completamente transparente mientras la página se encuentre en la parte superior.

Únicamente después de iniciar el desplazamiento aparecerá un fondo semitransparente con efecto blur.

## Branding

La identidad visual deberá mantener una jerarquía clara.

Debe evitarse la duplicación innecesaria del logotipo o del nombre de la marca dentro del mismo primer bloque visual.

## Navegación móvil

El botón del menú hamburguesa deberá permanecer siempre visible, accesible y correctamente alineado en todos los puntos de quiebre (*breakpoints*).

## Consistencia visual

Toda modificación futura del Header deberá preservar la continuidad visual entre la navegación y el Hero, evitando cambios bruscos de color, espaciado o composición.

# Principios de composición

El Header no constituye una sección independiente.

Forma parte de la composición visual del Hero.

La primera pantalla deberá percibirse como un único bloque.

El Header actuará como una capa superpuesta (Overlay).

Mientras la página permanezca en la parte superior será completamente transparente.

El fondo del Header únicamente aparecerá durante el desplazamiento.

No deberá existir ninguna franja visible entre el Header y el Hero.