# RFC-002 — Landing V2 Strategy

**Estado:** Draft  
**Versión:** 1.0  
**Fecha:** 2026-08-05  
**Proyecto:** Xpendz  
**Autor:** Joel Cadenas + ChatGPT

---

# 1. Objetivo

Este documento define la estrategia de diseño y comunicación para la Landing V2 de Xpendz.

Su propósito es servir como guía para el desarrollo de la página web, garantizando que todas las decisiones de diseño, contenido y experiencia de usuario mantengan una dirección coherente.

La Landing no debe ser simplemente una página bonita; debe convertirse en la principal herramienta de adquisición de nuevos usuarios para Xpendz.

---

# 2. Objetivo principal

La Landing tiene un único objetivo:

> Convencer al visitante de que Xpendz es la herramienta adecuada para comenzar a controlar sus finanzas personales y motivarlo a descargar la aplicación.

Todo el contenido deberá contribuir a ese objetivo.

---

# 3. Filosofía de la Landing

La Landing deberá transmitir la misma personalidad que la aplicación:

- moderna;
- simple;
- confiable;
- profesional;
- rápida;
- elegante.

La experiencia debe generar confianza desde los primeros segundos.

---

# 4. Principios de diseño

Toda decisión relacionada con la Landing deberá respetar los siguientes principios.

## 4.1 Un objetivo por página

Cada página tendrá una misión claramente definida.

No se mezclarán múltiples objetivos dentro de la misma vista.

---

## 4.2 Un mensaje por sección

Cada bloque deberá comunicar una única idea.

Cuando una sección intente explicar demasiadas cosas, deberá dividirse o simplificarse.

---

## 4.3 Mostrar antes que explicar

Siempre que sea posible, una captura de pantalla o una demostración visual tendrá prioridad sobre un bloque de texto.

La interfaz de Xpendz es uno de sus principales activos y debe utilizarse para generar confianza.

---

## 4.4 Menos texto

Los textos deberán ser breves, directos y fáciles de escanear.

Cada palabra deberá aportar valor.

---

## 4.5 Cada scroll debe aportar información nueva

El usuario nunca debe sentir que está leyendo la misma información con distintas palabras.

Cada sección deberá responder una nueva pregunta.

---

# 5. Arquitectura del sitio

La Landing dejará de ser una página extremadamente larga.

El sitio estará organizado en varias páginas con responsabilidades específicas.

```
Inicio
│
├── Funciones
├── Capturas
├── Descargar
├── Privacidad
└── Eliminar cuenta
```

Cada página tendrá un propósito claramente definido.

---

# 6. Objetivo de cada página

## Inicio

Convencer.

Debe responder:

¿Por qué debería instalar Xpendz?

---

## Funciones

Explicar.

Aquí se describirán las principales capacidades del producto con mayor nivel de detalle.

---

## Capturas

Demostrar.

Permitirá explorar la interfaz mediante imágenes reales de la aplicación.

---

## Descargar

Convertir.

Facilitar la instalación desde Google Play y futuras plataformas.

---

## Privacidad

Cumplimiento legal y generación de confianza.

---

## Eliminar cuenta

Cumplimiento de requisitos de Google Play y soporte al usuario.

---

# 7. Arquitectura de la página Inicio

La página principal tendrá únicamente los bloques necesarios para lograr la conversión.

```
Hero

↓

Beneficios principales

↓

Vista rápida del Dashboard

↓

¿Por qué Xpendz?

↓

Descargar

↓

Footer
```

Cada bloque deberá tener una única misión.

---

# 8. Navegación

El encabezado permanecerá visible durante toda la navegación.

## Requisitos

- Sticky Header.
- Disponible en Desktop.
- Disponible en móvil.
- Logo siempre visible.
- Menú siempre accesible.
- Botón de descarga visible.
- Fondo con efecto al hacer scroll para mejorar la legibilidad.

El usuario nunca deberá perder el acceso a la navegación principal.

---

# 9. Estrategia de conversión

La Landing deberá responder progresivamente las principales preguntas del visitante.

1. ¿Qué es Xpendz?
2. ¿Qué problema resuelve?
3. ¿Por qué es diferente?
4. ¿Cómo funciona?
5. ¿Puedo confiar en la aplicación?
6. ¿Dónde la descargo?

Cada sección deberá responder únicamente una de estas preguntas.

---

# 10. Contenido que se eliminará o reducirá

Durante el rediseño se buscará eliminar:

- información repetida;
- textos excesivamente largos;
- listas redundantes;
- explicaciones técnicas innecesarias;
- capturas duplicadas;
- bloques cuyo único propósito sea aumentar la longitud de la página.

La simplicidad tendrá prioridad sobre la cantidad de contenido.

---

# 11. Principios visuales

La Landing deberá transmitir la imagen de un producto consolidado.

Se priorizarán:

- espacios en blanco;
- buena jerarquía visual;
- tipografía consistente;
- imágenes reales de la aplicación;
- iconografía uniforme;
- animaciones discretas;
- llamadas a la acción claramente visibles.

---

# 12. Principios de UX

La navegación deberá sentirse natural tanto en Desktop como en dispositivos móviles.

Siempre deberá ser evidente:

- dónde se encuentra el usuario;
- qué puede hacer a continuación;
- cómo regresar;
- cómo descargar la aplicación.

La experiencia deberá minimizar el esfuerzo cognitivo.

---

# 13. Roadmap de implementación

## Sprint 1

- Nuevo Header.
- Nueva navegación.
- Hero.
- Footer.
- Reorganización inicial.

## Sprint 2

- Página Funciones.
- Página Capturas.
- Página Descargar.

## Sprint 3

- Animaciones.
- Optimización.
- SEO.
- Accesibilidad.
- Ajustes finales.

---

# 14. Criterios de éxito

La Landing V2 será considerada exitosa cuando:

- comunique claramente el valor de Xpendz en pocos segundos;
- reduzca la longitud de la página principal;
- facilite la navegación entre contenidos;
- mantenga una experiencia consistente en Desktop y móvil;
- transmita una imagen profesional y confiable;
- aumente la probabilidad de descarga de la aplicación.

---

# 15. Documento vivo

Este RFC constituye la referencia oficial para el diseño de la Landing V2.

Toda modificación significativa de la arquitectura, navegación o estrategia de comunicación deberá reflejarse en este documento mediante una nueva versión.