# RFC-003 — Website Information Architecture

**Estado:** Draft  
**Versión:** 1.0  
**Fecha:** 2026-08-08  
**Proyecto:** Xpendz  
**Autor:** Joel Cadenas + ChatGPT

---

# 1. Objetivo

Este documento formaliza la arquitectura de información del sitio público de Xpendz como una decisión estratégica de producto.

Su propósito es establecer una estructura clara, escalable y coherente para todas las páginas públicas relacionadas con Xpendz, garantizando que la adquisición, la comprensión del producto, la generación de confianza y el cumplimiento legal no compitan entre sí dentro de una única página.

La etapa inicial de la Landing V2 permitió consolidar una presencia pública creíble y profesional.

La siguiente evolución ya no depende de cambios visuales, sino de una mejor distribución de responsabilidades entre páginas.

---

# 2. Situación actual

Durante la primera publicación pública de Xpendz, concentrar la mayor parte del contenido dentro de una sola Landing fue una decisión razonable.

Esa arquitectura permitió:

- presentar el producto rápidamente;
- mostrar capturas reales;
- comunicar amplitud funcional;
- generar confianza inicial;
- incorporar páginas obligatorias para Google Play;
- construir una primera presencia pública sin depender de una estructura web extensa.

Para una etapa temprana, esa aproximación tenía una ventaja clara: simplicidad operacional.

Una Landing amplia permitía lanzar más rápido, validar la imagen pública de Xpendz y centralizar en un solo lugar casi toda la información importante para el usuario.

Ese enfoque fue adecuado mientras el objetivo principal era establecer credibilidad y demostrar que Xpendz era un producto real, serio y funcional.

---

# 3. Problema

A medida que la Landing V2 maduró, comenzó a asumir demasiadas responsabilidades al mismo tiempo.

Actualmente la página principal intenta:

- explicar el producto;
- mostrar prácticamente todas sus capacidades;
- construir confianza;
- responder objeciones;
- introducir planes;
- exponer páginas de cumplimiento;
- servir parcialmente como superficie de soporte.

Como consecuencia, la experiencia de adquisición pierde claridad.

Los principales problemas identificados son los siguientes.

## 3.1 Concentración excesiva de información

La Landing contiene demasiado contenido para una única misión.

El visitante no siempre distingue qué información es esencial para decidir instalar la aplicación y qué información pertenece a una etapa posterior de exploración o soporte.

---

## 3.2 Mensajes repetidos

Varios bloques comunican ideas muy similares mediante formatos distintos.

Esto aumenta la longitud percibida de la página sin aportar suficiente información nueva en cada scroll.

---

## 3.3 Priorización débil

No toda la información tiene la misma importancia dentro del recorrido de un visitante nuevo.

La arquitectura actual no separa con suficiente claridad:

- lo que debe entenderse primero;
- lo que debe utilizarse para generar confianza;
- lo que debe consultarse solo si el usuario desea profundizar.

---

## 3.4 Navegación centrada en cumplimiento

La navegación principal actual da una prominencia excesiva a páginas legales o de soporte frente a páginas de descubrimiento del producto.

Esto es correcto desde una perspectiva de accesibilidad del contenido, pero no desde una perspectiva de adquisición.

---

## 3.5 Escalabilidad limitada

La arquitectura actual no está preparada para crecer de manera natural a medida que Xpendz incorpore nuevas versiones, más plataformas, nuevos modelos de monetización y mayor profundidad funcional.

Una sola Landing extensa no puede seguir absorbiendo indefinidamente todas las necesidades futuras del sitio.

---

# 4. Objetivos

La nueva arquitectura deberá cumplir los siguientes objetivos.

- simplificar la adquisición;
- mejorar la narrativa del producto;
- fortalecer la conversión;
- separar el descubrimiento del producto del cumplimiento legal;
- facilitar la escalabilidad futura del sitio;
- permitir una estructura reutilizable para otros productos del ecosistema jcadenas.com.

En términos prácticos, el visitante debe poder recorrer el sitio en una secuencia más clara:

> descubrir, comprender, confiar, descargar y comenzar a usar.

---

# 5. No objetivos

Este RFC no busca modificar aspectos que pertenecen a otras decisiones ya resueltas o a futuras iteraciones especializadas.

No pretende:

- rediseñar visualmente la marca;
- cambiar la identidad de Xpendz;
- rediseñar el Header;
- redefinir la experiencia móvil;
- reescribir por completo la estrategia SEO;
- introducir cambios de implementación técnica;
- reemplazar la política legal vigente;
- convertir este documento en una especificación de UI.

Este RFC se limita a definir la arquitectura de información y la distribución estratégica del contenido público.

---

# 6. Principios arquitectónicos

Toda decisión futura sobre el sitio público de Xpendz deberá respetar los siguientes principios.

## 6.1 Una responsabilidad principal por página

Cada página deberá existir para cumplir una misión concreta.

Cuando una página intente resolver demasiados objetivos al mismo tiempo, deberá dividirse o simplificarse.

---

## 6.2 Adquisición antes que exhaustividad

La página principal no deberá funcionar como inventario completo del producto.

Su función será ayudar al visitante a entender el valor de Xpendz y avanzar hacia la descarga.

---

## 6.3 Descubrimiento separado de cumplimiento

La información legal y de soporte debe seguir siendo accesible, pero no debe competir con las páginas cuyo objetivo es presentar el producto y favorecer la conversión.

---

## 6.4 Cada scroll debe aportar una decisión

El visitante debe sentir que cada bloque responde una pregunta distinta y lo acerca a la siguiente acción lógica.

La arquitectura no debe depender de volumen, sino de progresión.

---

## 6.5 Escalabilidad por módulos

El sitio deberá poder crecer mediante nuevas páginas y nuevas capas de contenido sin obligar a rehacer continuamente la Landing.

---

# 7. Arquitectura pública propuesta

La estructura pública de Xpendz evolucionará desde una Landing extensa hacia un sitio modular con páginas especializadas.

```
Inicio
│
├── Funciones
├── Privacidad y seguridad
│   └── Política de privacidad
├── Descargar
└── Eliminar cuenta
```

Cada página existirá por una razón concreta.

---

# 8. Rol de cada página

## Inicio

Introducir Xpendz.

La página principal deberá responder una pregunta central:

> ¿Por qué debería interesarme Xpendz?

Su misión es explicar el valor del producto, mostrar una visión general comprensible y orientar al visitante hacia la descarga.

No deberá convertirse en el repositorio completo de todo el contenido público.

---

## Funciones

Explicar capacidades en profundidad.

Aquí se describirán con mayor detalle los principales componentes del producto, sus flujos y su utilidad real para el usuario.

Esta página existe para absorber el contenido que resulta excesivo dentro de la Landing, sin perder claridad ni profundidad.

---

## Privacidad y seguridad

Traducir la confianza del producto a un lenguaje claro para el usuario.

Su objetivo no es reemplazar el documento legal, sino explicar de forma accesible cómo Xpendz protege la información, qué principios sigue y por qué el usuario puede confiar en la plataforma.

La política legal de privacidad continuará disponible como referencia oficial permanente.

---

## Política de privacidad

Mantener el cumplimiento legal y documental.

Esta página seguirá cumpliendo el rol normativo y de transparencia formal exigido por la publicación pública y por la relación de confianza con el usuario.

---

## Eliminar cuenta

Garantizar cumplimiento y derechos del usuario.

Debe continuar existiendo como página dedicada, pero con carácter secundario dentro del recorrido de adquisición.

Su función es servir como superficie de soporte y cumplimiento, no como punto principal de entrada al producto.

---

## Descargar

Convertir.

Esta página deberá facilitar la instalación desde Google Play y futuras plataformas, reduciendo fricción y concentrando la decisión final en una superficie clara.

---

# 9. Redistribución del contenido

La nueva arquitectura no requiere inventar grandes volúmenes de contenido nuevo.

Su objetivo principal es redistribuir mejor el contenido ya existente.

## Contenido que permanece en Inicio

- Hero.
- Propuesta de valor principal.
- Historia breve del producto.
- Beneficios más importantes.
- Evidencia visual suficiente para demostrar que la aplicación es real.
- Señales esenciales de confianza.
- Llamadas a la acción principales.
- Información de planes solo si es estratégicamente relevante para la conversión actual.

---

## Contenido que se mueve a Funciones

- inventario detallado de capacidades;
- descripción extensa de módulos;
- walkthroughs más completos;
- listados funcionales exhaustivos;
- contenido que sirve para profundizar, pero no para decidir en los primeros segundos.

---

## Contenido que se mueve a Privacidad y seguridad

- explicación accesible sobre privacidad;
- explicación accesible sobre seguridad;
- mensajes de confianza relacionados con protección de datos;
- contexto sobre sincronización y resguardo de información desde una perspectiva de usuario.

---

## Contenido que permanece en Política de privacidad

- base legal;
- tratamiento de datos;
- autenticación;
- almacenamiento local;
- sincronización;
- eliminación de cuenta;
- cambios de política;
- información de contacto formal.

---

## Contenido que permanece en Eliminar cuenta

- guía paso a paso;
- explicación de qué datos se eliminan;
- canal de soporte;
- tiempos de procesamiento;
- preguntas frecuentes relacionadas con la eliminación.

---

## Criterio para precios y planes

La información de planes podrá mantenerse en Inicio únicamente si cumple una función clara dentro del recorrido de conversión.

Si genera distracción, ambigüedad o introduce decisiones prematuras, deberá reducirse o moverse a una superficie específica.

---

# 10. Principios de navegación

La navegación principal dejará de organizarse alrededor del cumplimiento y pasará a organizarse alrededor del descubrimiento del producto.

La navegación deseada será:

- Inicio;
- Funciones;
- Privacidad y Seguridad;
- Descargar.

Este cambio responde a un principio simple: la navegación principal debe reflejar el recorrido mental de un visitante nuevo.

Primero debe poder:

- descubrir qué es Xpendz;
- entender lo que puede hacer;
- confiar en la plataforma;
- saber cómo instalarla.

La página Eliminar cuenta deberá seguir siendo accesible desde:

- el footer;
- las páginas legales;
- futuras superficies de soporte;
- enlaces de cumplimiento cuando correspondan.

Sin embargo, ya no deberá competir en igualdad de jerarquía con las páginas principales de adquisición.

---

# 11. Recorrido ideal del visitante

La arquitectura pública deberá acompañar al usuario en una secuencia clara.

```
Descubrir
↓
Comprender
↓
Confiar
↓
Descargar
↓
Usar
```

## Descubrir

La Landing presenta la existencia del producto y su promesa principal.

---

## Comprender

La página Funciones permite profundizar sin sobrecargar la experiencia inicial.

---

## Confiar

La página Privacidad y seguridad, junto con la política legal y la página de eliminación de cuenta, convierten la confianza en un sistema comprensible y verificable.

---

## Descargar

La página Descargar actúa como punto de decisión y entrada directa a la instalación.

---

## Usar

La arquitectura pública debe preparar correctamente la expectativa antes de que el usuario entre en la aplicación.

Un sitio bien estructurado no solo ayuda a convertir, sino también a reducir decepciones y mejorar la calidad de la adopción.

---

# 12. Visión de largo plazo

Esta arquitectura no debe entenderse únicamente como una solución puntual para Xpendz.

Debe convertirse en un modelo reutilizable para futuros productos publicados dentro de jcadenas.com.

Ejemplos futuros:

- jcadenas.com/xpendz
- jcadenas.com/app2
- jcadenas.com/app3

Cada producto debería poder adoptar, con las adaptaciones necesarias, una estructura pública consistente basada en los mismos principios:

- página principal orientada a adquisición;
- páginas específicas para profundización funcional;
- capa de confianza separada de la promoción;
- superficies legales y de soporte claramente identificables;
- arquitectura preparada para múltiples plataformas y futuras extensiones.

A largo plazo, esto permitirá construir un ecosistema de productos más coherente, profesional y mantenible.

---

# 13. Criterios de éxito

La nueva arquitectura será considerada exitosa cuando produzca los siguientes resultados.

- una Landing más breve y enfocada;
- navegación más clara para visitantes nuevos;
- menor redundancia entre secciones;
- recorrido de conversión más evidente;
- mejor separación entre descubrimiento, confianza y cumplimiento;
- mayor facilidad para incorporar nuevas páginas sin desordenar la estructura principal;
- una base reutilizable para futuros sitios de producto dentro de jcadenas.com.

Estos criterios deberán utilizarse como referencia para evaluar cualquier decisión posterior relacionada con el sitio público de Xpendz.

---

# 14. Alcance estratégico de este RFC

A partir de este documento, toda decisión significativa sobre la evolución del sitio público deberá responder a la siguiente pregunta:

> **¿Esta modificación mejora la arquitectura de adquisición y confianza o vuelve a concentrar demasiadas responsabilidades en una sola página?**

Si una propuesta aumenta la complejidad de la Landing sin aportar una mejora clara en comprensión o conversión, deberá replantearse.

---

# 15. Documento vivo

Este RFC constituye la referencia oficial para la arquitectura de información del sitio público de Xpendz.

Toda modificación significativa de la estructura pública, la distribución del contenido o la jerarquía de navegación deberá reflejarse en este documento mediante una nueva versión.
