<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions">
        <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
    </a>
</p>

<h1 style="text-align: center; font-size: 2.5em;">Gestor de Productos en Laravel</h1>

<h2 style="font-size: 2em;">Descripción del Proyecto</h2>
<p style="font-size: 1.2em;">
    El gestor de productos permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) para los productos, utilizando Firebase como base de datos. Este proyecto seguirá el patrón MVC (Modelo-Vista-Controlador), donde:
</p>
<ul style="font-size: 1.2em;">
    <li><strong>Modelo:</strong> Interactúa con la base de datos (Firebase).</li>
    <li><strong>Vista:</strong> Se encargará de mostrar la interfaz de usuario.</li>
    <li><strong>Controlador:</strong> Maneja la lógica de la aplicación y la interacción entre el modelo y la vista.</li>
</ul>

<h2 style="font-size: 2em;">Requisitos Previos</h2>
<p style="font-size: 1.2em;">
    Asegúrate de tener instalado lo siguiente en tu sistema:
</p>
<ul style="font-size: 1.2em;">
    <li><strong>PHP:</strong> versión 8.0 o superior</li>
    <li><strong>Composer:</strong> gestor de dependencias de PHP</li>
    <li><strong>Node.js:</strong> para la gestión de paquetes front-end</li>
</ul>

<h2 style="font-size: 2em;">Pasos para Instalar Laravel y Configurar Firebase</h2>

<h3 style="font-size: 1.5em;">1. Instalar Laravel:</h3>
<p style="font-size: 1.2em;">
    Ejecuta el siguiente comando en tu terminal para crear un nuevo proyecto de Laravel:
</p>
<pre style="background-color: #f9f9f9; padding: 10px; border-radius: 5px;">
composer create-project --prefer-dist laravel/laravel gestor-productos
</pre>

<h3 style="font-size: 1.5em;">2. Instalar la biblioteca de Firebase:</h3>
<p style="font-size: 1.2em;">
    Navega al directorio de tu proyecto y ejecuta:
</p>
<pre style="background-color: #f9f9f9; padding: 10px; border-radius: 5px;">
composer require kreait/firebase-php
</pre>

<h3 style="font-size: 1.5em;">3. Configurar tu proyecto de Firebase:</h3>
<ul style="font-size: 1.2em;">
    <li>Crea un proyecto en <a href="https://console.firebase.google.com/" target="_blank">Firebase Console</a>.</li>
    <li>Agrega una base de datos en tiempo real y obtén el archivo de credenciales JSON.</li>
    <li>Coloca el archivo JSON en la carpeta <code>storage/app</code> de tu proyecto.</li>
</ul>
