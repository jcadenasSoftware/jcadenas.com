# Xpendz AI Development Guide

**Estado:** Activo  
**Versión:** 1.0  
**Fecha:** 2026-08-05  
**Proyecto:** Xpendz

---

# 1. Propósito

Este documento define las reglas de trabajo para cualquier asistente de inteligencia artificial que participe en el desarrollo del proyecto Xpendz.

Su objetivo es garantizar consistencia técnica, arquitectónica y de experiencia de usuario, independientemente de la herramienta utilizada.

Este documento aplica a ChatGPT, Devin y cualquier otra IA que participe en el proyecto.

---

# 2. Filosofía del proyecto

Xpendz es un producto de software, no un conjunto de funcionalidades.

Cada decisión debe fortalecer la experiencia completa del usuario.

La simplicidad tendrá prioridad sobre la complejidad.

La calidad tendrá prioridad sobre la velocidad.

La consistencia tendrá prioridad sobre la creatividad aislada.

---

# 3. Antes de comenzar cualquier tarea

Toda IA deberá:

1. Comprender completamente el objetivo solicitado.
2. Revisar la documentación relacionada.
3. Detectar posibles conflictos con decisiones anteriores.
4. Confirmar el alcance de la tarea.
5. Proponer mejoras cuando aporten valor real.

Nunca deberá comenzar a modificar código sin comprender el contexto.

---

# 4. Orden de consulta de la documentación

Antes de implementar una funcionalidad deberá consultarse, cuando aplique:

1. RFC (visión y estrategia)
2. ADR (decisiones de arquitectura)
3. SPEC (especificaciones de implementación)
4. UX (principios de experiencia)
5. CHANGELOG (historial de cambios)

La documentación oficial siempre tendrá prioridad sobre cualquier interpretación.

---

# 5. Principios de desarrollo

Toda implementación deberá buscar:

- código limpio;
- bajo acoplamiento;
- alta legibilidad;
- componentes reutilizables;
- nombres claros;
- consistencia con la arquitectura existente.

La solución más simple que resuelva correctamente el problema será la opción preferida.

---

# 6. Principios de UX

Toda modificación deberá respetar los principios definidos para Xpendz:

- simplicidad;
- claridad;
- rapidez;
- consistencia;
- accesibilidad;
- confianza.

La experiencia del usuario tendrá prioridad sobre la incorporación de nuevas funcionalidades.

---

# 7. Modificaciones permitidas

La IA podrá:

- refactorizar código cuando exista una mejora clara;
- simplificar implementaciones;
- reutilizar componentes existentes;
- mejorar el rendimiento;
- proponer mejoras de accesibilidad.

---

# 8. Modificaciones restringidas

La IA NO deberá:

- cambiar la arquitectura sin justificación;
- modificar decisiones documentadas en un ADR;
- eliminar funcionalidades sin autorización;
- introducir dependencias innecesarias;
- duplicar componentes existentes;
- alterar la identidad visual del producto sin aprobación.

---

# 9. Proceso de trabajo esperado

Cada tarea deberá seguir el siguiente flujo:

Comprender el problema

↓

Consultar documentación

↓

Analizar alternativas

↓

Implementar

↓

Verificar funcionamiento

↓

Documentar cambios relevantes

---

# 10. Calidad del código

Toda implementación deberá procurar:

- funciones pequeñas;
- componentes cohesivos;
- comentarios solo cuando aporten contexto;
- evitar código muerto;
- evitar duplicación;
- mantener consistencia de estilo.

---

# 11. Relación con la documentación

Si una tarea modifica una decisión importante del proyecto, deberá indicarse que es necesario actualizar el documento correspondiente.

Ejemplos:

- Cambio de visión → actualizar RFC.
- Cambio arquitectónico → actualizar ADR.
- Cambio funcional → actualizar SPEC.
- Cambio visible para el usuario → actualizar CHANGELOG si corresponde.

---

# 12. Comunicación

Las respuestas deberán ser:

- claras;
- concretas;
- justificadas técnicamente;
- orientadas a resolver el problema.

Cuando exista una alternativa mejor, deberá proponerse explicando sus ventajas y desventajas.

---

# 13. Objetivo final

Todas las decisiones deberán contribuir a construir una aplicación que transmita:

- simplicidad;
- confianza;
- velocidad;
- calidad;
- profesionalismo.

El éxito de Xpendz no dependerá únicamente de la cantidad de funcionalidades implementadas, sino de la calidad de la experiencia que ofrece a sus usuarios.

---

# 14. Documento vivo

Este documento evolucionará junto con el proyecto.

Cada nueva práctica, estándar o metodología adoptada por el equipo deberá incorporarse mediante una nueva versión.

Su propósito es preservar la forma de trabajar del proyecto y garantizar que cualquier asistente de IA pueda integrarse rápidamente al desarrollo manteniendo los mismos principios y estándares.

---

# 15. Conocer el proyecto antes de modificarlo


Antes de implementar cualquier cambio, la IA deberá inspeccionar la estructura existente del proyecto.

Las implementaciones deberán adaptarse a la arquitectura actual y no asumir el uso de frameworks, herramientas de compilación o tecnologías que no formen parte del proyecto.

Las recomendaciones deberán ser compatibles con la estructura real del repositorio.


---


# 16. Flujo de trabajo recomendado

Toda implementación deberá seguir el siguiente proceso.

## Fase 1 — Análisis

La IA deberá:

- comprender el objetivo;
- revisar la documentación;
- inspeccionar el código existente;
- identificar conflictos;
- proponer un plan de implementación.

No deberá modificar código durante esta fase.

---

## Fase 2 — Aprobación

El plan será revisado por el responsable del proyecto.

Podrán solicitarse ajustes antes de comenzar la implementación.

---

## Fase 3 — Implementación

Una vez aprobado el plan, la IA implementará únicamente el alcance definido.

No deberá incorporar funcionalidades adicionales.

---

## Fase 4 — Revisión

Después de implementar, el resultado será evaluado desde el punto de vista:

- técnico;
- visual;
- experiencia de usuario;
- rendimiento;
- accesibilidad.

---

## Fase 5 — Refinamiento

Las observaciones derivadas de la revisión generarán una nueva iteración.

Esta fase tiene como objetivo mejorar la calidad del producto sin modificar el alcance funcional.