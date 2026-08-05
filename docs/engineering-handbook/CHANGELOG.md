# CHANGELOG

Toda evolución importante del Engineering Handbook y del proyecto Xpendz deberá registrarse en este documento.

Este archivo no reemplaza el historial de Git.

Git documenta **qué cambió**.

Este documento explica **por qué cambió**.

---

# Versionado

El CHANGELOG sigue un esquema simple.

```
Mayor.Menor.Revisión
```

Ejemplo.

```
1.0.0
```

- Mayor → Cambios importantes de filosofía o arquitectura.
- Menor → Nuevos documentos o funcionalidades relevantes.
- Revisión → Correcciones menores y mejoras editoriales.

---

# Formato

Cada entrada deberá incluir:

- Fecha
- Versión
- Tipo de cambio
- Documentos afectados
- Descripción
- Motivo

---

# Historial

---

## [1.0.0] — 2026-08-05

### Tipo

Creación inicial del Engineering Handbook.

### Documentos

- PROJECT-001 Engineering Philosophy
- PLAYBOOK-001 AI Collaboration
- RFC-001 Product Vision
- RFC-002 Landing V2 Strategy
- ADR-001 Header Overlay
- UX Series
- SPEC Series
- BRAND-001 Brand Messaging
- README

### Descripción

Se establece oficialmente la metodología de desarrollo de Xpendz.

Se crea la estructura documental del proyecto.

Se define el flujo oficial de trabajo basado en:

Proyecto

↓

RFC

↓

ADR

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

### Motivo

Eliminar improvisación.

Reducir incertidumbre.

Mejorar consistencia.

Facilitar colaboración entre humanos e IA.

---

## [1.1.0]

Pendiente.

---

# Tipos de cambios

## Added

Nuevo documento.

Nueva metodología.

Nueva arquitectura.

Nueva funcionalidad.

---

## Changed

Cambio importante.

Nueva estrategia.

Cambio de filosofía.

Cambio de flujo.

---

## Improved

Mejoras sin alterar el comportamiento.

Claridad.

Rendimiento.

UX.

Documentación.

---

## Deprecated

Elemento que deja de recomendarse.

Todavía existe.

Pero será reemplazado.

---

## Removed

Elemento eliminado definitivamente.

---

## Fixed

Correcciones.

Errores.

Inconsistencias.

---

# Qué debe registrarse

Registrar únicamente cambios importantes.

Ejemplos.

✓ Nuevo RFC.

✓ Nuevo ADR.

✓ Cambio de arquitectura.

✓ Cambio metodológico.

✓ Cambio de Branding.

✓ Nueva filosofía.

✓ Nuevo flujo de trabajo.

✓ Cambio importante en UX.

✓ Cambio del proceso de colaboración con IA.

---

# Qué NO registrar

No registrar.

- cambios de formato;
- errores ortográficos;
- pequeñas correcciones;
- commits diarios;
- cambios internos de implementación.

Git ya conserva esa información.

---

# Filosofía

El CHANGELOG existe para preservar la memoria del proyecto.

No solo queremos saber qué decisiones tomamos.

Queremos recordar por qué las tomamos.

---

# Regla de Oro

Si una decisión cambia la forma de construir Xpendz...

Debe aparecer aquí.

---

# Relación con otros documentos

Este documento complementa:

- README.md
- PROJECT-001 Engineering Philosophy
- PLAYBOOK-001 AI Collaboration

---

# Documento vivo

El CHANGELOG crecerá junto con Xpendz.

Cada entrada representa una decisión importante en la evolución del proyecto.

Su objetivo es preservar el conocimiento adquirido durante el desarrollo.

---

> **"Un buen repositorio conserva el código.  
> Un buen CHANGELOG conserva la historia del proyecto."**