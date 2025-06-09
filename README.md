<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel  is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Proyecto Jass Unas

## Técnicas de Prueba del Software

### Pruebas de Caja Negra

#### User

| Campo       | Prueba                              | Resultado Esperado               |
|-------------|-------------------------------------|----------------------------------|
| id          | Valor numérico positivo             | Registro exitoso                 |
| id          | Valor no numérico                   | Error: "ID debe ser numérico"    |
| nombre      | Cadena de texto no vacía            | Registro exitoso                 |
| nombre      | Cadena vacía                        | Error: "Nombre es obligatorio"   |
| email       | Formato de correo electrónico válido| Registro exitoso                 |
| email       | Formato de correo electrónico inválido| Error: "Email inválido"         |
| contraseña  | Longitud mínima y complejidad       | Registro exitoso                 |
| contraseña  | Longitud o complejidad insuficiente | Error: "Contraseña débil"        |
| rol         | Valor predefinido (ej: "cliente", "administrador") | Registro exitoso |
| rol         | Valor no predefinido                | Error: "Rol no válido"           |

#### Cliente

| Campo       | Prueba                              | Resultado Esperado               |
|-------------|-------------------------------------|----------------------------------|
| id          | Valor numérico positivo             | Registro exitoso                 |
| id          | Valor no numérico                   | Error: "ID debe ser numérico"    |
| nombre      | Cadena de texto no vacía            | Registro exitoso                 |
| nombre      | Cadena vacía                        | Error: "Nombre es obligatorio"   |
| dirección   | Cadena de texto                     | Registro exitoso                 |
| idUsuario   | ID de usuario existente             | Registro exitoso                 |
| idUsuario   | ID de usuario inexistente           | Error: "Usuario no encontrado"   |

#### Medidor

| Campo       | Prueba                              | Resultado Esperado               |
|-------------|-------------------------------------|----------------------------------|
| id          | Valor numérico positivo             | Registro exitoso                 |
| id          | Valor no numérico                   | Error: "ID debe ser numérico"    |
| numeroSerie | Cadena de texto única               | Registro exitoso                 |
| numeroSerie | Cadena de texto repetida            | Error: "Número de serie ya existe"|
| ubicación   | Cadena de texto                     | Registro exitoso                 |
| estado      | Valor predefinido (ej: "activo", "inactivo") | Registro exitoso |
| estado      | Valor no predefinido                | Error: "Estado no válido"        |
| idCliente   | ID de cliente existente             | Registro exitoso                 |
| idCliente   | ID de cliente inexistente           | Error: "Cliente no encontrado"   |

#### Factura

| Campo       | Prueba                              | Resultado Esperado               |
|-------------|-------------------------------------|----------------------------------|
| id          | Valor numérico positivo             | Registro exitoso                 |
| id          | Valor no numérico                   | Error: "ID debe ser numérico"    |
| fechaEmision| Fecha válida                        | Registro exitoso                 |
| fechaEmision| Fecha inválida                      | Error: "Fecha inválida"          |
| monto       | Valor numérico positivo             | Registro exitoso                 |
| monto       | Valor no numérico o negativo        | Error: "Monto inválido"          |
| estadoPago  | Valor predefinido ("Pendiente", "Pagado") | Registro exitoso |
| estadoPago  | Valor no predefinido                | Error: "Estado de pago no válido"|
| idCliente   | ID de cliente existente             | Registro exitoso                 |
| idCliente   | ID de cliente inexistente           | Error: "Cliente no encontrado"   |

#### Pago

| Campo       | Prueba                              | Resultado Esperado               |
|-------------|-------------------------------------|----------------------------------|
| id          | Valor numérico positivo             | Registro exitoso                 |
| id          | Valor no numérico                   | Error: "ID debe ser numérico"    |
| fechaPago   | Fecha válida                        | Registro exitoso                 |
| fechaPago   | Fecha inválida                      | Error: "Fecha inválida"          |
| monto       | Valor numérico positivo             | Registro exitoso                 |
| monto       | Valor no numérico o negativo        | Error: "Monto inválido"          |
| metodoPago  | Cadena de texto                     | Registro exitoso                 |
| idFactura   | ID de factura existente             | Registro exitoso                 |
| idFactura   | ID de factura inexistente           | Error: "Factura no encontrada"   |

### Pruebas de Caja Blanca

#### User

| Campo       | Validación Correcta                 | Validación Incorrecta            | Explicación                        |
|-------------|-------------------------------------|----------------------------------|------------------------------------|
| id          | Número entero positivo (ej: > 0)    | Texto, número negativo, celda vacía | El ID debe ser un número único y positivo. |
| nombre      | Texto (no vacío)                    | Celda vacía, número              | El nombre es obligatorio y debe ser texto. |
| email       | Formato de correo electrónico (ej: @.<em>) | Texto sin formato de correo, celda vacía | El email debe tener un formato válido. |
| contraseña  | Longitud mínima (ej: > 8 caracteres), complejidad (ej: combinación de letras, números, símbolos) | Contraseña corta, contraseña solo con letras, celda vacía | La contraseña debe ser segura. |
| rol         | Lista de valores permitidos (ej: "cliente", "administrador") | Texto no permitido, celda vacía | El rol debe ser uno de los valores predefinidos. |

#### Cliente

| Campo       | Validación Correcta                 | Validación Incorrecta            | Explicación                        |
|-------------|-------------------------------------|----------------------------------|------------------------------------|
| id          | Número entero positivo              | Texto, número negativo, celda vacía | El ID debe ser un número único y positivo. |
| nombre      | Texto (no vacío)                    | Celda vacía, número              | El nombre es obligatorio y debe ser texto. |
| dirección   | Texto                               | Celda vacía                      | La dirección puede ser opcional, pero si se ingresa, debe ser texto. |
| idUsuario   | Número entero positivo (referencia a la tabla User) | Texto, número negativo, ID de usuario inexistente | El idUsuario debe existir en la tabla User. |

#### Medidor

| Campo       | Validación Correcta                 | Validación Incorrecta            | Explicación                        |
|-------------|-------------------------------------|----------------------------------|------------------------------------|
| id          | Número entero positivo              | Texto, número negativo, celda vacía | El ID debe ser un número único y positivo. |
| numeroSerie | Texto (único)                       | Número, número de serie repetido | El número de serie debe ser único. |
| ubicación   | Texto                               | Celda vacía                      | La ubicación puede ser opcional. |
| estado      | Lista de valores permitidos (ej: "activo", "inactivo") | Texto no permitido, celda vacía | El estado debe ser uno de los valores predefinidos. |
| idCliente   | Número entero positivo (referencia a la tabla Cliente) | Texto, número negativo, ID de cliente inexistente | El idCliente debe existir en la tabla Cliente. |

#### Factura

| Campo       | Validación Correcta                 | Validación Incorrecta            | Explicación                        |
|-------------|-------------------------------------|----------------------------------|------------------------------------|
| id          | Número entero positivo              | Texto, número negativo, celda vacía | El ID debe ser un número único y positivo. |
| fechaEmision| Formato de fecha (ej: dd/mm/aaaa)   | Texto, fecha inválida            | La fecha de emisión debe ser válida. |
| monto       | Número decimal positivo (ej: > 0)   | Texto, número negativo, celda vacía | El monto debe ser un valor numérico positivo. |
| estadoPago  | Lista de valores permitidos (ej: "Pendiente", "Pagado") | Texto no permitido, celda vacía | El estado de pago debe ser uno de los valores predefinidos. |
| idCliente   | Número entero positivo (referencia a la tabla Cliente) | Texto, número negativo, ID de cliente inexistente | El idCliente debe existir en la tabla Cliente. |

#### Pago

| Campo       | Validación Correcta                 | Validación Incorrecta            | Explicación                        |
|-------------|-------------------------------------|----------------------------------|------------------------------------|
| id          | Número entero positivo              | Texto, número negativo, celda vacía | El ID debe ser un número único y positivo. |
| fechaPago   | Formato de fecha (ej: dd/mm/aaaa)   | Texto, fecha inválida            | La fecha de pago debe ser válida. |
| monto       | Número decimal positivo (ej: > 0)   | Texto, número negativo, celda vacía | El monto debe ser un valor numérico positivo. |
| metodoPago  | Texto                               | Celda vacía                      | El método de pago puede ser opcional. |
| idFactura   | Número entero positivo (referencia a la tabla Factura) | Texto, número negativo, ID de factura inexistente | El idFactura debe existir en la tabla Factura. |
