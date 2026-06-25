# 📧 Solucionar Problema de Remitente de Correo

## ❌ Problema Actual

**Correo enviado desde:** `servicios@jcadenas.com`  
**Cliente ve como remitente:** `u775031495@srv524.main-hosting.eu` ⚠️

**Advertencia de Gmail/Outlook:**
> "No se puede comprobar que este correo proviene del remitente, por lo que es posible que no sea seguro responder a él."

---

## 🔍 Causa del Problema

1. **SPF no configurado** - El servidor receptor no puede verificar que `srv524.main-hosting.eu` está autorizado para enviar correos en nombre de `jcadenas.com`
2. **DKIM no configurado** - El correo no tiene firma digital que demuestre autenticidad
3. **Posible: Header From incorrecto** - El SMTP puede estar sobrescribiendo el remitente

---

## ✅ Solución 1: Configurar SPF (OBLIGATORIO)

### **¿Qué es SPF?**
SPF (Sender Policy Framework) autoriza qué servidores pueden enviar correos desde tu dominio.

### **Pasos en Hostinger:**

1. **Ir al Panel de Hostinger**
   ```
   hPanel > Dominios > jcadenas.com > Registros DNS
   ```

2. **Agregar Registro SPF**
   ```
   Tipo: TXT
   Nombre: @  (o jcadenas.com)
   Valor: v=spf1 include:_spf.hostinger.com ~all
   TTL: 14400
   ```

3. **Guardar y esperar** (propagación: 1-24 horas)

### **Verificar SPF:**
```bash
# Desde línea de comandos:
nslookup -type=txt jcadenas.com

# Online:
https://mxtoolbox.com/spf.aspx
```

---

## ✅ Solución 2: Configurar DKIM (OBLIGATORIO)

### **¿Qué es DKIM?**
DKIM (DomainKeys Identified Mail) firma digitalmente tus correos para demostrar autenticidad.

### **Pasos en Hostinger:**

1. **Ir al Panel de Email**
   ```
   hPanel > Email > Email Accounts > servicios@jcadenas.com
   ```

2. **Buscar sección "DKIM"**
   - Debería haber un botón "Enable DKIM" o "Generate DKIM Keys"
   - Click para generar claves DKIM

3. **Copiar el registro DKIM generado**
   ```
   Hostinger te dará algo como:
   
   Tipo: TXT
   Nombre: default._domainkey.jcadenas.com
   Valor: v=DKIM1; k=rsa; p=MIGfMA0GCSqGSIb3DQEBAQUAA4GN... (largo)
   ```

4. **Agregar en Registros DNS**
   ```
   hPanel > Dominios > jcadenas.com > Registros DNS > Agregar Registro
   ```

5. **Guardar y esperar** (propagación: 1-24 horas)

### **Verificar DKIM:**
```bash
# Desde línea de comandos:
nslookup -type=txt default._domainkey.jcadenas.com

# Online:
https://mxtoolbox.com/dkim.aspx
```

---

## ✅ Solución 3: Configurar DMARC (RECOMENDADO)

### **¿Qué es DMARC?**
DMARC usa SPF y DKIM para decidir qué hacer con correos que fallan autenticación.

### **Agregar Registro DMARC:**

```
Tipo: TXT
Nombre: _dmarc.jcadenas.com
Valor: v=DMARC1; p=none; rua=mailto:servicios@jcadenas.com
TTL: 14400
```

**Explicación:**
- `p=none` - Solo monitorear (no rechazar correos)
- `rua=mailto:...` - Enviar reportes a este email

**Después de 1-2 semanas, cambiar a:**
```
v=DMARC1; p=quarantine; rua=mailto:servicios@jcadenas.com
```

---

## ✅ Solución 4: Verificar Configuración SMTP

Voy a crear una herramienta para verificar cómo se están enviando los correos.

---

## 📋 Checklist de Configuración

### **En Hostinger Panel:**

- [ ] **SPF configurado**
  ```
  Registro TXT: v=spf1 include:_spf.hostinger.com ~all
  ```

- [ ] **DKIM habilitado**
  ```
  Email > servicios@jcadenas.com > Enable DKIM
  Agregar registro TXT generado
  ```

- [ ] **DMARC configurado** (opcional pero recomendado)
  ```
  Registro TXT: v=DMARC1; p=none; rua=mailto:servicios@jcadenas.com
  ```

- [ ] **Esperar propagación DNS** (1-24 horas)

- [ ] **Probar envío de correo de prueba**

---

## 🧪 Cómo Verificar que Funciona

### **1. Verificar Registros DNS:**

**SPF:**
```bash
nslookup -type=txt jcadenas.com
# Debería aparecer: "v=spf1 include:_spf.hostinger.com ~all"
```

**DKIM:**
```bash
nslookup -type=txt default._domainkey.jcadenas.com
# Debería aparecer: "v=DKIM1; k=rsa; p=..."
```

**Online:**
- https://mxtoolbox.com/SuperTool.aspx
- Ingresar: `jcadenas.com`
- Verificar SPF, DKIM, DMARC

### **2. Enviar Correo de Prueba:**

Desde tu admin:
```
https://jcadenas.com/admin/diagnose.php
→ Sección "Prueba de Envío de Correo"
→ Ingresar tu email personal
→ Enviar
```

### **3. Verificar Headers del Correo:**

En Gmail:
1. Abrir el correo
2. Click en "⋮" (tres puntos) > "Mostrar original"
3. Buscar:
   ```
   SPF: PASS
   DKIM: PASS
   DMARC: PASS
   ```

**Antes de configurar:**
```
From: u775031495@srv524.main-hosting.eu
SPF: FAIL
DKIM: FAIL
```

**Después de configurar:**
```
From: servicios@jcadenas.com
SPF: PASS
DKIM: PASS
DMARC: PASS
```

---

## ⏱️ Tiempo de Propagación

| Configuración | Tiempo | Prioridad |
|---------------|--------|-----------|
| SPF | 1-4 horas | ⭐⭐⭐ CRÍTICO |
| DKIM | 1-4 horas | ⭐⭐⭐ CRÍTICO |
| DMARC | 1-4 horas | ⭐⭐ Recomendado |
| Verificación completa | 24 horas | - |

---

## 🎯 Resultado Esperado

### **Antes:**
```
De: u775031495@srv524.main-hosting.eu
⚠️ No se puede verificar el remitente
```

### **Después:**
```
De: Ing. Joel Cadenas <servicios@jcadenas.com>
✅ Correo verificado
```

---

## 📞 Si No Funciona Después de 24h

1. **Contactar Soporte de Hostinger:**
   ```
   Tema: Configurar SPF y DKIM para jcadenas.com
   
   Mensaje:
   "Necesito configurar SPF y DKIM para mi dominio jcadenas.com
   para que los correos enviados desde servicios@jcadenas.com
   no aparezcan como spam. Por favor ayúdenme a configurar los
   registros DNS correctos."
   ```

2. **Verificar que el email existe:**
   ```
   hPanel > Email > Email Accounts
   → Verificar que servicios@jcadenas.com existe
   → Verificar que tiene contraseña configurada
   ```

3. **Revisar logs de error:**
   ```
   https://jcadenas.com/logs/email_debug.log
   ```

---

## 📚 Referencias

- [Hostinger: Configurar SPF](https://support.hostinger.com/en/articles/1583299-how-to-add-an-spf-record)
- [Hostinger: Configurar DKIM](https://support.hostinger.com/en/articles/1583311-how-to-set-up-dkim)
- [MXToolbox - Verificación](https://mxtoolbox.com/)
- [Google: SPF/DKIM/DMARC](https://support.google.com/a/answer/174124)

---

**Una vez configurado SPF y DKIM, los correos llegarán como "servicios@jcadenas.com" sin advertencias.** ✅
