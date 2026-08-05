# MEMORY-001 — Lessons Learned

**Estado:** Activo

**Versión:** 1.0

**Fecha:** 2026-08-05

**Proyecto:** Xpendz

---

# 1. Objetivo

Este documento conserva los aprendizajes obtenidos durante el desarrollo de Xpendz.

No registra cambios de código.

No registra commits.

Registra conocimiento.

Su propósito es evitar que el equipo vuelva a recorrer el mismo camino para resolver un problema ya comprendido.

---

# 2. Filosofía

Cada problema resuelto representa una inversión de tiempo.

Ese conocimiento no debe perderse.

Cuando una experiencia produce un aprendizaje significativo, deberá documentarse aquí.

La memoria del proyecto es un activo de ingeniería.

---

# 3. Qué registrar

Registrar únicamente aprendizajes relevantes.

Ejemplos:

- problemas difíciles de diagnosticar;
- decisiones que cambiaron la arquitectura;
- mejoras importantes de metodología;
- descubrimientos sobre herramientas;
- errores que consumieron mucho tiempo;
- soluciones que podrán reutilizarse.

---

# 4. Qué NO registrar

No registrar:

- errores menores;
- correcciones triviales;
- cambios de formato;
- commits diarios.

Para eso ya existe Git.

---

# 5. Formato

Cada aprendizaje deberá documentarse utilizando la siguiente estructura.

---

## Fecha

---

## Contexto

¿Qué intentábamos hacer?

---

## Problema

¿Qué ocurrió?

---

## Investigación

¿Cómo fue analizado?

¿Qué hipótesis se descartaron?

---

## Causa raíz

¿Cuál fue finalmente el origen del problema?

---

## Solución

¿Cómo se resolvió?

---

## Aprendizaje

¿Qué deberíamos hacer diferente la próxima vez?

---

## Documentos relacionados

RFC

ADR

SPEC

etc.

---

# 6. Lección 001

## Fecha

2026

---

## Contexto

Implementación del inicio de sesión con Google para Android.

---

## Problema

La autenticación funcionaba correctamente durante el desarrollo local.

Sin embargo, la aplicación instalada desde Google Play regresaba a la pantalla de inicio de sesión después de seleccionar la cuenta de Google.

No aparecía ningún mensaje de error visible para el usuario.

---

## Investigación

Durante el análisis se revisaron múltiples posibilidades.

Entre ellas:

- configuración OAuth;
- SHA-1;
- SHA-256;
- google-services.json;
- Firebase Authentication;
- Google Play App Signing;
- versión Release;
- configuración Gradle;
- targetSdk;
- registros Logcat.

El problema no se encontraba en la lógica de autenticación implementada.

---

## Causa raíz

La autenticación distribuida mediante Google Play depende de certificados y configuraciones diferentes a los utilizados durante el desarrollo local.

El ecosistema completo debe estar correctamente configurado para que el flujo OAuth funcione en producción.

---

## Solución

Actualizar la configuración correspondiente y validar el comportamiento utilizando la versión distribuida por Google Play.

---

## Aprendizaje

Los problemas de autenticación no siempre están relacionados con el código.

Antes de modificar la implementación es necesario revisar toda la cadena de configuración del ecosistema.

---

## Acción preventiva

Crear un checklist para futuras publicaciones en Google Play que incluya:

- certificados;
- Play App Signing;
- Firebase;
- OAuth;
- google-services.json;
- pruebas en versión publicada.

---

# 7. Lección 002

## Contexto

Rediseño completo de la Landing.

---

## Aprendizaje

Comenzar por documentación redujo significativamente la incertidumbre durante la implementación.

La mayor parte de las decisiones difíciles se resolvieron antes de escribir código.

---

# 8. Lección 003

## Contexto

Colaboración con Inteligencia Artificial.

---

## Aprendizaje

Separar los roles de Arquitecto, Constructor y Auditor produjo respuestas más precisas, prompts más pequeños y revisiones más objetivas.

---

# 9. Principios

La experiencia adquirida forma parte del patrimonio del proyecto.

Cada problema resuelto hace más fuerte a Xpendz.

Siempre que un aprendizaje pueda ahorrar tiempo en el futuro, deberá registrarse.

---

# 10. Relación con otros documentos

Este documento complementa:

- CHANGELOG.md
- PROJECT-001 Engineering Philosophy
- PLAYBOOK-001 AI Collaboration

---

# 11. Documento vivo

La memoria del proyecto crecerá durante toda la vida de Xpendz.

Su objetivo es preservar el conocimiento que no aparece en el código ni en los commits.

---

> **"El código muestra cómo funciona el sistema.  
> La memoria explica cómo aprendimos a construirlo."**