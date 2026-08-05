# PLAYBOOK-001 — AI Collaboration Playbook

**Estado:** Aprobado

**Versión:** 1.0

**Fecha:** 2026-08-05

**Proyecto:** Xpendz

---

# 1. Objetivo

Definir la metodología oficial para colaborar con modelos de Inteligencia Artificial durante el desarrollo de Xpendz.

Este documento establece los roles, responsabilidades, flujo de trabajo y estándares que deberán seguirse para mantener un proceso de desarrollo consistente, eficiente y de alta calidad.

---

# 2. Filosofía

La Inteligencia Artificial no reemplaza la arquitectura del proyecto.

La IA acelera la implementación de decisiones ya tomadas.

La calidad del resultado depende directamente de la calidad de la documentación entregada.

Pensar primero.

Documentar después.

Implementar al final.

---

# 3. Principios

Toda colaboración con IA deberá seguir estos principios.

## 3.1 Documentación antes que código

Ninguna funcionalidad importante deberá implementarse sin documentación previa.

---

## 3.2 Una responsabilidad por interacción

Cada conversación con la IA deberá tener un único objetivo.

Evitar mezclar:

- arquitectura;
- UX;
- branding;
- implementación;
- revisión.

---

## 3.3 Contexto mínimo necesario

Cada modelo recibirá únicamente la documentación necesaria para resolver la tarea.

Reducir contexto mejora:

- velocidad;
- precisión;
- consumo de tokens.

---

## 3.4 La documentación es la fuente de verdad

Si existe una diferencia entre el código y la documentación, la documentación tiene prioridad.

Toda modificación importante deberá reflejarse primero en los documentos oficiales.

---

# 4. Roles de la IA

---

## Arquitecto

### Objetivo

Diseñar soluciones.

Analizar alternativas.

Cuestionar decisiones.

Redactar documentación.

### Produce

- RFC
- ADR
- UX
- SPEC
- Branding
- Epics

### No debe

Implementar código salvo que se solicite expresamente.

---

## Constructor

### Objetivo

Implementar exactamente lo definido en la documentación.

### Entrada

- RFC
- ADR
- UX
- SPEC
- Branding

### Produce

- HTML
- CSS
- JavaScript
- Kotlin
- Java
- PHP

### No debe

Cambiar el diseño.

Modificar la experiencia.

Agregar funcionalidades.

Reinterpretar requisitos.

---

## Auditor

### Objetivo

Comparar la implementación contra la documentación.

### Produce

Informes de revisión.

### Debe verificar

- cumplimiento del SPEC;
- accesibilidad;
- rendimiento;
- consistencia visual;
- deuda técnica.

### No debe

Agregar nuevas funcionalidades.

---

# 5. Flujo oficial

Toda funcionalidad importante seguirá este recorrido.

Idea

↓

RFC

↓

ADR (si aplica)

↓

UX

↓

SPEC

↓

Implementación

↓

Auditoría

↓

Aprobación

---

# 6. Prompts

Todo prompt deberá indicar claramente el rol esperado.

Ejemplo.

ROLE:

Senior Frontend Engineer

MISSION:

Implement exactly what is defined in the referenced documents.

Do not redesign.

Do not change UX.

Do not add features.

---

# 7. Referencias

Cada prompt deberá incluir únicamente los documentos necesarios.

Ejemplo.

RFC-001

RFC-002

UX-004

SPEC-003

No enviar documentación innecesaria.

---

# 8. Formato esperado de respuesta

Toda implementación deberá finalizar con un informe estructurado.

## Resumen técnico

Descripción general.

---

## Archivos modificados

Lista completa.

---

## Archivos nuevos

Lista completa.

---

## Decisiones tomadas

Explicación técnica.

---

## Riesgos encontrados

Problemas detectados.

---

## Archivos para subir manualmente

Listado completo.

---

## Recomendaciones

Siguientes pasos.

---

# 9. Criterios de calidad

Toda implementación deberá ser:

- simple;
- mantenible;
- consistente;
- accesible;
- responsive;
- rápida.

Siempre deberá reutilizar componentes existentes antes de crear nuevos.

---

# 10. Gestión del contexto

El contexto deberá mantenerse pequeño.

Cada tarea deberá utilizar únicamente la documentación necesaria.

Evitar conversaciones largas con múltiples objetivos.

---

# 11. Revisión

Toda implementación importante será auditada antes de darse por terminada.

El código deberá compararse contra el SPEC correspondiente.

No contra interpretaciones personales.

---

# 12. Gestión de cambios

Si durante la implementación surge una mejor idea:

NO modificar el código inmediatamente.

Primero:

Actualizar la documentación.

Después:

Aprobar el cambio.

Finalmente:

Implementarlo.

---

# 13. Definición de terminado (Definition of Done)

Una tarea estará terminada únicamente cuando:

✓ Cumpla el SPEC.

✓ Pase la auditoría.

✓ Mantenga consistencia con RFC y UX.

✓ No introduzca regresiones.

✓ La documentación permanezca actualizada.

---

# 14. Modelos recomendados

## Arquitectura

Modelos con alta capacidad de razonamiento y diseño.

Objetivo:

Pensar.

---

## Implementación

Modelos especializados en generación de código.

Objetivo:

Construir.

---

## Auditoría

Modelos con capacidad de análisis detallado.

Objetivo:

Verificar.

---

# 15. Filosofía del proyecto

En Xpendz no utilizamos Inteligencia Artificial para improvisar.

La utilizamos para ejecutar con excelencia una visión previamente diseñada.

La documentación guía el desarrollo.

La implementación materializa la documentación.

La auditoría garantiza la calidad.

---

# 16. Mejora continua

Este playbook evolucionará conforme el equipo descubra mejores prácticas.

Toda mejora deberá:

1. ser utilizada en un caso real;
2. demostrar beneficios;
3. documentarse aquí;
4. aplicarse a futuros desarrollos.

---

# 17. Principio final

**Una buena IA puede escribir código.**

**Una buena metodología permite construir productos excepcionales.**

Xpendz adopta la segunda filosofía.