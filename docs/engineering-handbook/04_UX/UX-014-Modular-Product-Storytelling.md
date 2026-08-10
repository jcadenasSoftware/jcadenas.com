# UX-014 — Modular Product Storytelling

**Estado:** Aprobado

**Versión:** 1.0

**Fecha:** 2026-08-09

**Proyecto:** Xpendz

---

# 1. Objetivo

Definir la filosofía de storytelling del sitio público modular de Xpendz.

Este documento formaliza cómo cada página contribuye a una narrativa continua que guía al visitante desde el descubrimiento hasta la instalación y el primer uso, sin convertirse en documentación ni en material legal.

No es una especificación de UI ni un documento técnico. Es una guía de producto y experiencia que orienta la redacción, el orden de la información y la conexión entre páginas.

---

# 2. Antecedentes

Tras adoptar la arquitectura modular del sitio (RFC-003) y su flujo de información (UX-013), se implementaron las páginas esenciales definidas por SPEC-006 (Funciones), SPEC-007 (Privacidad y Seguridad) y SPEC-008 (Descarga).

Las observaciones actuales son:

- Landing introduce el producto con claridad.
- Funciones demuestra capacidades reales.
- Privacidad y Seguridad consolida confianza.
- Descargar remueve fricción y convierte.

Persisten, sin embargo, señales de narrativa fragmentada: algunas secciones suenan a documentación, otras repiten ideas y no siempre se siente un hilo conductor único. El sitio debe leerse como una sola historia, no como cuatro páginas independientes.

---

# 3. Planteamiento del problema

- La arquitectura es modular, pero la narrativa aún puede simplificarse y ganar continuidad.
- Existen repeticiones conceptuales que interrumpen el avance natural del visitante.
- Algunas secciones adoptan un tono de documentación, debilitando la voz de producto.
- Las transiciones entre páginas no siempre dejan claro “qué sigue” ni “por qué ahora”.

Este documento define reglas para resolver estos puntos sin contradecir la arquitectura aprobada ni los SPEC existentes.

---

# 4. Principios

Los principios siguientes son decisiones duraderas. Deberán respetarse en toda evolución del sitio.

## 4.1 Un propósito primario por página
Cada página existe para cumplir una función narrativa específica dentro del recorrido. No debe asumir funciones ajenas.

## 4.2 Un objetivo emocional por página
Además de informar, cada página debe provocar un estado emocional claro (curiosidad, comprensión, confianza, disposición a instalar).

## 4.3 Cada scroll responde una pregunta
La progresión vertical debe sentirse como una secuencia de respuestas que reduce incertidumbre.

## 4.4 Divulgación progresiva
Primero relevancia y claridad; después, profundidad y evidencia. Evitar la complejidad prematura.

## 4.5 Evitar redundancia
No repetir una idea ya comprendida salvo para añadir una capa nueva de valor.

## 4.6 Evidencia real sobre claims
Priorizar capturas, recorridos y coherencia del producto frente a promesas abstractas.

## 4.7 Imágenes al servicio del entendimiento
Visuales que expliquen y orienten, no que distraigan ni cubran carencias de contenido.

## 4.8 CTA como puente natural
Cada llamada a la acción debe conducir de forma orgánica a la siguiente etapa del recorrido.

---

# 5. Modelo narrativo

El sitio se concibe como una historia modular y continua. Cada módulo (página) resuelve una parte de la conversación y entrega el relevo a la siguiente.

- Introducir (¿qué es y para quién?)
- Demostrar (¿cómo me ayuda?)
- Tranquilizar (¿puedo confiar?)
- Convertir (¿cómo instalo sin fricción?)
- Conectar con el uso (¿qué ocurre inmediatamente después?)

Este modelo complementa UX-013. Donde UX-013 separa “Validar” como etapa explícita, UX-014 integra la validación como práctica transversal que aparece de forma visible en “Demostrar” (evidencia funcional) y “Tranquilizar” (evidencia de confianza), manteniendo la compatibilidad con la arquitectura y los SPEC vigentes.

---

# 6. Recorrido del usuario

La narrativa adoptará la siguiente secuencia:

Descubrir

↓

Comprender

↓

Confiar

↓

Instalar

↓

Usar

Justificación de propiedad por página:

- Landing: Descubrir
- Funciones: Comprender (incluye validación visible del producto)
- Privacidad y Seguridad: Confiar (sin duplicar contenido legal)
- Descargar: Instalar (remover fricción)
- Producto (posterior al sitio): Usar (fuera del alcance de este documento, indicado para continuidad narrativa)

---

# 7. Responsabilidades de cada página

Las siguientes decisiones asignan una función clara y un objetivo emocional a cada página.

## 7.1 Landing — Introducción
- Propósito: Presentar Xpendz y su relevancia en una promesa simple.
- Objetivo emocional: “Quiero saber más.”
- Resultado: Interés activado y transición natural hacia Funciones.
- No debe: profundizar en módulos, legal o soporte.

## 7.2 Funciones — Demostración
- Propósito: Explicar cómo Xpendz ayuda con evidencias reales y comprensibles.
- Objetivo emocional: “Ahora entiendo lo que puede hacer por mí.”
- Resultado: Imagen mental de uso cotidiano y transición hacia confianza.
- No debe: convertirse en documentación exhaustiva.

## 7.3 Privacidad y Seguridad — Confianza
- Propósito: Traducir la seriedad del producto en tranquilidad para el visitante.
- Objetivo emocional: “Puedo confiar en este producto.”
- Resultado: Inquietudes resueltas y disposición a instalar.
- No debe: reemplazar ni duplicar la Política de Privacidad.

## 7.4 Descargar — Conversión
- Propósito: Remover fricción y facilitar la instalación.
- Objetivo emocional: “Estoy listo para instalar.”
- Resultado: Acción de descarga iniciada sin distracciones.
- No debe: reabrir la explicación del producto.

## 7.5 Política de Privacidad — Transparencia legal
- Propósito: Formalizar la transparencia de forma permanente y pública.
- Objetivo emocional: “Sé dónde consultar la referencia oficial.”
- Resultado: Cumplimiento visible y coherente.
- No debe: competir con páginas de adquisición.

## 7.6 Eliminar cuenta — Control del usuario
- Propósito: Garantizar derechos y procedimientos claros de salida.
- Objetivo emocional: “Puedo irme cuando lo necesite.”
- Resultado: Mayor confianza sistémica.
- No debe: introducirse en el flujo principal de adquisición.

---

# 8. Reglas de diseño narrativo

Las siguientes reglas gobiernan la redacción y el orden del contenido.

## 8.1 Una pregunta por bloque
Cada sección responde una única pregunta relevante. Los títulos deben ser claros y orientados a respuesta.

## 8.2 Progresar sin retrocesos
Evitar “bucle” informativo entre secciones o páginas. Cada salto debe añadir algo nuevo.

## 8.3 CTAs encadenados
Cada CTA conduce a la etapa siguiente sin rutas laterales innecesarias.

## 8.4 Evidencia antes que adjetivos
Priorizar capturas, recorridos y casos de uso por encima de calificativos generales.

## 8.5 Tono de producto, no de documentación
Explicar lo esencial para decidir, no listar exhaustivamente.

## 8.6 Evitar contenido legal fuera de su ámbito
Las páginas de confianza pueden resumir en lenguaje claro y derivar a la política legal.

## 8.7 Coherencia transversal
Mensajes, imágenes y ejemplos deben mantener una sola voz a lo largo del sitio.

---

# 9. Criterios de éxito

La estrategia se considera exitosa cuando:

- cada página cumple un propósito y objetivo emocional únicos;
- cada scroll responde una pregunta y reduce incertidumbre;
- la validación del producto es visible sin convertir la experiencia en documentación;
- la confianza crece progresivamente sin afirmaciones no sustentadas;
- los CTAs conectan páginas como una sola historia;
- la ruta hacia la descarga se siente natural y sin fricción;
- el sitio prepara al usuario para instalar y empezar a usar la app.

---

# 10. Visión a largo plazo

La narrativa modular deberá escalar sin perder claridad. Nuevos módulos (p. ej., Casos de uso, Integraciones futuras o Historias de usuarios) solo se incorporarán si aportan una capa narrativa nueva y mantienen:

- un propósito único y un objetivo emocional claro;
- divulgación progresiva y ausencia de redundancia;
- compatibilidad con RFC-003 y con los SPEC de cada página.

El sitio seguirá siendo una conversación única y continua, aun cuando aumente la profundidad del producto.

---

# 11. Relación con otros documentos

Este documento complementa y extiende, sin contradecir:

- PROJECT-001 Engineering Philosophy
- PLAYBOOK-001 AI Collaboration
- RFC-003 Website Information Architecture
- UX-013 Website Information Flow
- SPEC-006 Features Page
- SPEC-007 Privacy & Security Page
- SPEC-008 Download Experience

Los SPEC futuros deberán traducir estas decisiones narrativas en contenido, estructura y ejecución sin alterar los principios aquí definidos.
