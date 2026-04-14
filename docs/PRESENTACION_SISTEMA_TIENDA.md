# Presentación — Sistema de gestión para tienda de ropa

Documento dual: **guion / estructura de diapositivas** y **prompt** para generar la presentación en Canva, Gamma, PowerPoint, Google Slides o con una herramienta de IA.

---

## Identidad visual

| Elemento | Uso sugerido |
|----------|----------------|
| **Negro** | Fondos de portada, barras, texto principal sobre fondo claro |
| **Blanco** | Fondos de contenido, respiración, contraste |
| **Celeste** | Acentos, iconos, CTAs, líneas divisorias, datos comerciales destacados |

Mantener alto contraste (negro/blanco) y usar el celeste con moderación para jerarquía visual.

---

## Información comercial (texto listo para slides)

- **Planes:** Individual y Full. **No hay límite de facturación** en ninguno de los planes (el precio mensual no depende del volumen de comprobantes emitidos).
- **Precios (mensual, más IVA):**
  - Plan **Individual:** ₡6 500 + IVA  
  - Plan **Full:** ₡15 000 + IVA  
- **Personalizaciones:** El sistema admite desarrollos a medida. Si el alcance es muy grande o impacta el núcleo del sistema actual, se cotiza aparte.
- **Fin de contrato — base de datos:** La entrega o migración de la base de datos con **productos y facturas** tiene un **costo adicional** (definir en contrato o al cierre).
- **Contacto:** consultas y personalizaciones — **7182-9512** (indicar país si aplica fuera de Costa Rica).

---

## Comparación de planes (según el proyecto)

| Área | Plan Individual | Plan Full |
|------|-----------------|-----------|
| Alcance general | Facturación electrónica, catálogo de productos, clientes, impuestos, **CxC**, reportes de facturación (resumen y listado) y confirmación de documentos | Todo lo del plan Individual **más** proveedores, monedas, proformas, compras, CxP, gastos, caja, contabilidad, factura electrónica de compra, comparativa/proformas de compra y reportes operativos extendidos |
| Límite de facturación | Sin límite | Sin límite |

*La restricción real de rutas está definida en el middleware `app.type === 'individual'` del código; la tabla resume la intención comercial.*

---

## Módulos del sistema (con descripción breve)

1. **Inicio / panel** — Punto de entrada tras el inicio de sesión; visión general del día a día.
2. **Autenticación y usuarios** — Login, recuperación de contraseña, alta de usuarios y permisos por rol (admin, encargado, vendedor, etc.).
3. **Clientes** — Ficha de clientes, historial útil para facturación y cobros; importación y exportación de datos.
4. **Proveedores** *(Full)* — Registro de proveedores para compras y cuentas por pagar.
5. **Productos e inventario** — Catálogo, stock, duplicado de ítems, ajuste de cantidades; importación/exportación masiva; impresión de códigos de barras (unitario y en lote).
6. **Impuestos** — Tarifas y códigos alineados con requisitos de facturación electrónica.
7. **Monedas** *(Full)* — Soporte de divisas para operaciones que lo requieran.
8. **Configuración general** — Parámetros del negocio (nombre, logos, comportamientos como inventario en cero, etc.).
9. **Configuración factura electrónica** — Credenciales y perfiles de emisión conectados con el proveedor tributario / Hacienda.
10. **Facturación (ventas)** — Emisión de facturas, tiquete/recibo, PDF, asignación de vendedor, anulaciones, notas de crédito y débito, cobros parciales y envío/consulta ante Hacienda (XML, estado de recepción).
11. **Proformas** *(Full)* — Cotizaciones o pedidos previos a la factura definitiva; impresión y PDF.
12. **Compras** *(Full)* — Registro de facturas de compra a proveedores, pagos asociados e integración con recepción tributaria.
13. **Proformas de compra y comparativa de proveedores** *(Full)* — Cotizaciones de compra y relación producto–proveedor para decisiones de abastecimiento.
14. **Factura electrónica de compra** *(Full)* — Flujo dedicado para documentos de compra en el esquema electrónico.
15. **Cuentas por cobrar (CxC)** — Seguimiento de facturas de venta al crédito; listados, impresión por cliente y control de pagadas *(incluido en Individual y Full)*.
16. **Cuentas por pagar (CxP)** *(Full)* — Obligaciones con proveedores; vencimientos y reportes de vencidas.
17. **Gastos** *(Full)* — Registro de egresos operativos y reportes por período y usuario.
18. **Caja** *(Full)* — Apertura, movimiento y cierre de caja ligados a la operación diaria (según rol).
19. **Contabilidad** *(Full)* — Módulo de apoyo contable (asientos / vistas según implementación actual).
20. **Receptor / confirmación de documentos** — Bandeja para mensajes y XML recibidos; confirmación ante Hacienda y reporte de receptores.
21. **Integración Hacienda** — Consulta de recepción, descarga de XML y callbacks de respuesta para facturas y compras.
22. **Reportes** — En **Individual:** resumen de ventas, listado de facturas y confirmación de documentos/receptores. En **Full**, además: facturas por vendedor/cliente, productos vendidos, facturas de proveedor, CxP/CxC vencidas y gastos.
23. **Utilidades del sistema** — Enlaces de mantenimiento (por ejemplo almacenamiento), operaciones puntuales como “inventario en cero” bajo configuración autorizada.

---

## Sugerencia de orden de diapositivas (12–16 slides)

1. Portada — nombre comercial, tagline, paleta negro / blanco / celeste.  
2. Problema — control de inventario + facturación electrónica + cobros/pagos.  
3. Solución — un solo sistema web para la tienda de ropa.  
4. Arquitectura en una frase — “ERP ligero orientado a retail y cumplimiento tributario”.  
5–7. **Planes y precios** — tabla Individual vs Full, **sin límite de facturación**, precios + IVA, contacto **7182-9512**.  
8–10. **Módulos** — agrupar en bloques: *Catálogo y maestros*, *Ventas y Hacienda*, *Compras y finanzas (Full)*, *Reportes y administración*.  
11. **Personalizaciones** — cotización si el cambio es grande o toca el núcleo.  
12. **Datos al cierre** — costo adicional por base con productos y facturas.  
13. Cierre — llamada a la acción (demo, llamada, correo).

---

## Prompt (copiar y pegar en IA o herramienta de diseño)

```text
Crea una presentación comercial en español para un sistema web de facturación e inventario (Laravel): facturación electrónica Costa Rica, clientes, productos y reportes.

Paleta obligatoria: negro, blanco y celeste (acentos en celeste, fondos mayormente blanco o negro según slide).

Incluir sección de planes:
- Plan Individual y Plan Full. Ambos sin límite de facturación.
- Precio Individual: 6500 colones costarricenses + IVA al mes.
- Precio Full: 15000 colones costarricenses + IVA al mes.
- Personalizaciones: sí; si son muy grandes o afectan el núcleo del sistema, bajo cotización.
- Al finalizar contrato, la base de datos con productos y facturas tiene costo adicional.
- Contacto para consultas y personalizaciones: teléfono 71829512.

OBLIGATORIO: dedicar al menos una diapositiva (o dos columnas en una sola slide) que separe claramente qué incluye cada plan. No mezclar listados sin etiquetar "Individual" o "Full".

--- PLAN INDIVIDUAL (incluido) ---
- Inicio / panel principal.
- Autenticación, usuarios y roles.
- Clientes (incl. importación/exportación).
- Productos e inventario: catálogo, stock, códigos de barras, import/export.
- Impuestos (tarifas para facturación electrónica).
- Configuración general del negocio.
- Configuración de factura electrónica (credenciales / perfiles de emisión).
- Facturación de ventas: facturas, tiquete/PDF, notas de crédito y débito, cobros a factura, integración y consultas Hacienda (XML, recepción).
- Receptor / confirmación de documentos recibidos y envío a Hacienda.
- Reportes incluidos en este plan: resumen de ventas, listado de facturas, reporte de receptores/confirmación de documentos.

--- PLAN FULL (incluye todo lo del Individual, MÁS) ---
- Proveedores.
- Monedas (divisas).
- Proformas de venta.
- Compras a proveedores y pagos de compras; cuentas por pagar (CxP).
- Proformas de compra y comparativa producto–proveedor.
- Módulo de factura electrónica de compra (flujo dedicado).
- Gastos operativos y reportes de gastos.
- Caja (apertura/cierre y operación diaria).
- Contabilidad.
- Reportes extendidos: facturas de proveedor, productos vendidos, facturas por vendedor, facturas por cliente, CxP vencidas, CxC vencidas (vista de reporte), gastos agregados, etc. (todo lo operativo que no esté en la lista del Individual).

Utilidades de sistema (respaldo/enlaces técnicos): mencionar brevemente solo en nota al pie o slide de "Implementación", no como módulo de negocio principal.

Instrucción de diseño: crear slides con iconos simples; para módulos, usar dos bloques visuales claramente titulados "Plan Individual" y "Solo plan Full (además del Individual)" o una tabla comparativa con filas por área y columnas Individual | Full (marca con ✓ o "—").

Tono: profesional, claro, orientado a dueños de empresas, pensado en llamar el interés de lo clientes por ende precios y planes al inicio (que incluye cada uno), después lo relacionado con el sistema
```

---

## Notas para quien presenta

- Aclarar que “sin límite de facturación” refiere al modelo de precio mensual, no a límites técnicos del servidor (si el cliente necesita infraestructura dedicada, se trata aparte).  
- El detalle exacto de qué reporte o pantalla ve cada rol puede demostrarse en vivo con el ambiente de prueba.  
- Mantener coherencia con el contrato vigente para el costo de exportación de base de datos al cierre.
