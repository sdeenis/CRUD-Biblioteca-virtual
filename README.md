# 📚 Biblioteca Virtual

Este es un sistema de gestión para una **Biblioteca Virtual**, desarrollado en **PHP** con **MySQL**. Permite la administración de libros, usuarios y préstamos, incluyendo funcionalidades avanzadas como transacciones SQL y prepared statements para mejorar la seguridad y eficiencia.

## 🚀 Características principales

### 🔹 Administración de libros
- Listado de todos los libros disponibles.
- Posibilidad de añadir, modificar y eliminar libros.
- Control de stock.

### 🔹 Sistema de préstamos
- Registro de préstamos y devoluciones.
- Relación entre usuarios y libros prestados.

### 🔹 Diferentes rangos de usuario y acciones de administrador

## 🛠️ Tecnologías utilizadas
- **PHP**: Lógica del servidor.
- **MySQL**: Almacenamiento de datos.
- **HTML y CSS**: Interfaz de usuario.

## 🔥 Features avanzadas

✅ **Transacciones SQL**  
  - Se utilizan transacciones para asegurar la integridad de los datos al realizar operaciones críticas como el préstamo de libros.

✅ **Statements preparados**  
  - Uso de `mysqli_stmt_prepare()` para prevenir inyecciones SQL y mejorar la seguridad.

✅ **Gestión de sesiones con PHP**  
  - Control de autenticación con `$_SESSION` para gestionar accesos y roles de usuario.

✅ **Estructura modular**  
  - Separación del código en archivos organizados para facilitar el mantenimiento.
