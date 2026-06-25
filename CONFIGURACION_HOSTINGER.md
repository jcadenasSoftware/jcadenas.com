# 🔧 Guía de Configuración en Hostinger

Esta guía te ayudará a resolver los problemas de correo y descarga de archivos ZIP.

---

## ❌ Problemas Actuales

1. **Correos no se envían** - SMTP_PASS no configurado
2. **ZIPs no se encuentran** - Directorio de descargas no existe

---

## ✅ Solución Paso a Paso

### 1️⃣ Crear Archivo de Configuración Local

**En Hostinger, usando File Manager:**

1. Ir a `/public_html/jcadenas/`
2. Crear nuevo archivo: `config.local.php`
3. Copiar y pegar este contenido:

```php
<?php
/**
 * Configuración Local para Hostinger (Producción)
 */

// ========== SMTP PASSWORD (OBLIGATORIO) ==========
// Obtener desde: Hostinger Panel > Email > Accounts > servicios@jcadenas.com > Show Password
define('SMTP_PASS', 'AQUI_TU_CONTRASEÑA_SMTP_REAL');

// ========== DIRECTORIO DE DESCARGAS (OBLIGATORIO) ==========
// Ver paso 2 para crear este directorio
define('SECURE_DOWNLOAD_BASE', '/home/uXXXXXX/secure_downloads');
// Reemplaza uXXXXXX con tu número de usuario real

?>
```

4. **Guardar el archivo**

---

### 2️⃣ Obtener Contraseña SMTP

**Opción A: Desde Hostinger Panel**
1. Ir a: **hPanel > Email > Email Accounts**
2. Buscar: `servicios@jcadenas.com`
3. Click en "Manage"
4. Click en "Show Password" o "Reset Password"
5. Copiar la contraseña
6. Pegar en `config.local.php` línea 8

**Opción B: Si no existe el correo**
1. Crear nuevo email account: `servicios@jcadenas.com`
2. Establecer una contraseña segura
3. Guardar y copiar la contraseña
4. Pegar en `config.local.php`

---

### 3️⃣ Crear Directorio de Descargas

**Opción A: File Manager (Recomendado)**

1. En File Manager, ir a la raíz `/home/uXXXXXX/`
   - Hacer click en "Home" o ir arriba de `public_html`
2. Hacer click en "New Folder"
3. Nombre: `secure_downloads`
4. Guardar

**Opción B: SSH**

```bash
# Conectar por SSH
cd ~
mkdir -p secure_downloads
chmod 755 secure_downloads
```

**Encontrar tu número de usuario:**
- En File Manager, la ruta completa se muestra arriba
- Ejemplo: `/home/u123456789/public_html/` → tu usuario es `u123456789`

---

### 4️⃣ Actualizar config.local.php con Ruta Real

1. Abrir `config.local.php`
2. En la línea del `SECURE_DOWNLOAD_BASE`, reemplazar:
   ```php
   define('SECURE_DOWNLOAD_BASE', '/home/u123456789/secure_downloads');
   ```
   - Cambiar `u123456789` por tu número real
3. Guardar

---

### 5️⃣ Verificar Configuración

1. Ir a: `https://jcadenas.com/admin/diagnose.php`
2. Verificar que TODO esté en verde ✓:
   - ✅ SMTP Pass: Configurada
   - ✅ Directorio: Existe
   - ✅ Escribible: Sí

3. Hacer prueba de correo:
   - Ingresar tu email de prueba
   - Click en "Enviar Correo de Prueba"
   - Verificar que llegue (revisar spam también)

---

### 6️⃣ Subir Archivos ZIP de Proyectos

**Ahora que el directorio existe:**

1. Ir a: `https://jcadenas.com/admin/upload_zip.php`
2. Seleccionar proyecto
3. Seleccionar archivo `.zip` del proyecto
4. Click "Subir"
5. Verificar que diga "Archivo subido correctamente"

**Estructura creada automáticamente:**
```
/home/uXXXXXX/
  └── secure_downloads/
       ├── 1/
       │   └── proyecto1.zip
       ├── 2/
       │   └── calculadora.zip
       └── 3/
           └── app-android.zip
```

---

### 7️⃣ Aprobar Compras y Enviar Enlaces

Ahora puedes:

1. Ir a `/admin/purchases.php`
2. Click en "Aprobar y enviar" en cualquier compra
3. **El correo SE ENVIARÁ correctamente** ✅
4. El cliente recibirá el enlace de descarga
5. El archivo ZIP **SÍ se encontrará** ✅

---

## 🔍 Verificación Final

**Checklist completo:**

- [✓] `config.local.php` creado con SMTP_PASS
- [✓] Directorio `/home/uXXXXXX/secure_downloads` existe
- [✓] Permisos del directorio son 755
- [✓] Diagnóstico muestra TODO en verde
- [✓] Prueba de correo funcionó
- [✓] ZIPs subidos correctamente

---

## 🐛 Solución de Problemas

### Error: "SMTP_PASS no está configurado"
- Verificar que `config.local.php` existe
- Verificar que la línea `define('SMTP_PASS', ...)` esté sin comentarios
- Verificar que la contraseña sea correcta

### Error: "Directorio no existe"
- Verificar que usaste el número de usuario correcto (uXXXXXX)
- Verificar que creaste la carpeta `secure_downloads`
- Probar con ruta completa desde SSH: `ls -la /home/uXXXXXX/secure_downloads`

### Error: "No se pudo enviar el correo"
- Verificar credenciales SMTP en diagnóstico
- Probar crear el email `servicios@jcadenas.com` si no existe
- Revisar logs en `/logs/email_debug.log`

### Correo no llega al cliente
- Revisar carpeta de spam
- Verificar que el email del cliente sea válido
- Revisar logs: `/logs/email_debug.log`

---

## 📂 Archivos a Subir a Hostinger

```
✅ SUBIR:
- config.local.php (crear en servidor)
- admin/diagnose.php ⭐ NUEVO
- admin/purchases.php (actualizado)
- admin/purchases_approve.php (actualizado con logging)

❌ NO SUBIR:
- config.local.example.php (solo ejemplo)
- CONFIGURACION_HOSTINGER.md (solo guía)
```

---

## 🚀 Testing Final

1. **Probar flujo completo:**
   - Hacer una compra de prueba en `/store.php`
   - Ir a `/admin/purchases.php`
   - Aprobar la compra
   - Verificar que el correo llegue
   - Click en el enlace de descarga
   - Verificar que el ZIP se descargue

2. **Si TODO funciona:** ✅ ¡Listo!

---

## 📞 Contacto

Si sigues teniendo problemas después de seguir todos los pasos, verifica:
1. Los logs en `/logs/email_debug.log`
2. El diagnóstico en `/admin/diagnose.php`
3. Los permisos de archivos (644) y carpetas (755)

---

**Última actualización:** 2025-01-02
