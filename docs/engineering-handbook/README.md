# Xpendz Engineering Handbook

> **La documentación es la fuente de verdad del proyecto.**

Bienvenido al **Engineering Handbook de Xpendz**.

Este repositorio contiene la documentación oficial utilizada para diseñar, desarrollar, revisar y evolucionar todo el ecosistema Xpendz.

No es únicamente una colección de documentos técnicos.

Es el conocimiento acumulado del proyecto.

Toda decisión importante deberá quedar documentada aquí antes de convertirse en código.

---

# Nuestra filosofía

En Xpendz creemos que el mejor software no es el que tiene más funcionalidades.

Es el que resuelve mejor los problemas de las personas.

Nuestra metodología sigue un principio muy sencillo:

> **Pensar primero. Documentar después. Implementar al final.**

La documentación reduce la incertidumbre.

La implementación materializa esa visión.

La auditoría garantiza la calidad.

---

# Estructura del Engineering Handbook

```
engineering-handbook/

README.md

00_PROJECT/
    PROJECT-001-Engineering-Philosophy.md
    PLAYBOOK-001-AI-Collaboration.md

01_RFC/
    Product Vision
    Product Strategy
    ...

02_ADR/
    Architecture Decision Records

03_SPEC/
    Functional Specifications

04_UX/
    UX Strategy
    UX Copy
    UX Storyboards

05_EPICS/
    Product Epics

06_SPRINTS/
    Sprint Planning

07_ARCHITECTURE/
    Architecture Documents

08_REFERENCE/
    Reference Material

09_BRANDING/
    Brand Identity
    Messaging

10_REVIEWS/
    Project Reviews
    Readiness Reviews
```

---

# Cómo utilizar esta documentación

Toda nueva funcionalidad deberá seguir el siguiente flujo.

```
Idea

↓

RFC

↓

ADR (si aplica)

↓

Branding

↓

UX

↓

SPEC

↓

Implementación

↓

Auditoría

↓

Release
```

Cada documento responde una pregunta diferente.

| Documento | Pregunta que responde |
|-----------|-----------------------|
| PROJECT | ¿Por qué trabajamos así? |
| PLAYBOOK | ¿Cómo colaboramos? |
| RFC | ¿Qué queremos construir? |
| ADR | ¿Por qué elegimos esta solución? |
| BRAND | ¿Cómo habla Xpendz? |
| UX | ¿Qué experiencia queremos crear? |
| SPEC | ¿Cómo debe implementarse? |
| REVIEW | ¿Cumple realmente con lo diseñado? |

---

# Filosofía de desarrollo

Nuestra ingeniería se basa en cinco principios.

## Claridad antes que complejidad.

El software debe ser fácil de comprender.

---

## El usuario antes que la tecnología.

Las decisiones técnicas existen para mejorar la experiencia.

Nunca al contrario.

---

## Documentar antes de construir.

Pensar reduce el retrabajo.

---

## Calidad antes que velocidad.

Preferimos avanzar un poco más lento si eso produce un producto mejor.

---

## Confianza antes que marketing.

La calidad del producto debe generar la confianza.

No las promesas.

---

# Colaboración con Inteligencia Artificial

La IA forma parte del proceso de desarrollo.

Sin embargo, cada modelo trabaja con un rol específico.

## Arquitecto

Diseña.

Analiza.

Documenta.

No implementa.

---

## Constructor

Implementa exactamente lo definido por la documentación.

No rediseña.

---

## Auditor

Verifica que la implementación cumpla la documentación.

No agrega nuevas funcionalidades.

---

# Estado del proyecto

| Área | Estado |
|------|:------:|
| Filosofía | ✅ |
| Metodología | ✅ |
| Branding | 🟡 |
| Landing V2 | 🟡 |
| Android | 🔵 |
| Desktop | 🔵 |

Leyenda:

- ✅ Consolidado
- 🟡 En desarrollo
- 🔵 Planificado

---

# Convenciones

Toda documentación deberá:

- estar escrita en Markdown;
- tener versión;
- tener estado;
- indicar documentos relacionados;
- mantenerse actualizada.

La documentación es la referencia oficial del proyecto.

---

# Regla de Oro

Si una modificación importante no está documentada...

**Aún no forma parte del proyecto.**

---

# Objetivo final

Xpendz no busca construir únicamente una aplicación de finanzas.

Busca construir una experiencia que ayude a las personas a comprender mejor su dinero mediante un producto claro, sencillo y confiable.

Cada documento de este Handbook existe para acercarnos a ese objetivo.

---

# Evolución

Este Engineering Handbook es un documento vivo.

Crecerá junto con el proyecto.

Cada decisión importante deberá fortalecer la claridad, la consistencia y la calidad del ecosistema Xpendz.

---

> **"La documentación guía el desarrollo.  
> El desarrollo materializa la visión.  
> La calidad nace de la coherencia entre ambos."**