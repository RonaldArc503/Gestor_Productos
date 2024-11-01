<?php

use Illuminate\Support\Str;

return [

    /*
    |----------------------------------------------------------------------
    | Default Database Connection Name
    |----------------------------------------------------------------------
    |
    | Aquí puedes especificar cuál de las conexiones de base de datos
    | definidas a continuación deseas utilizar como tu conexión predeterminada
    | para operaciones de base de datos.
    |
    */

    'default' => 'firebase',
    'project' => env('FIREBASE_PROJECT'),
    'credentials' => env('FIREBASE_CREDENTIALS'),
    'database_url' => env('FIREBASE_DATABASE_URL'),
    /*
    |----------------------------------------------------------------------
    | Database Connections
    |----------------------------------------------------------------------
    |
    | A continuación se definen todas las conexiones de base de datos para
    | tu aplicación. Se proporcionan ejemplos de configuración.
    |
    */

    'connections' => [

        'firebase' => [
            'driver' => 'firebase',
            'credentials' => [
                'type' => 'service_account',
                'project_id' => 'forgedream',
                'private_key_id' => 'ba1ad72f1f7a5753a28a490a7276759bdc329003',
                'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC3D1Z8IoEEIc+4\nJTil3+xLRYafwJMj3kVBWHPk/+dHwEoISpLYRr4b+FauK9z/JeHRs2gFzusL2tbg\nN9Ky2d38ukcJyy4CidXQ1EolKPjvcU0wxwpVxANiQhCb2fkewVG9u6XhAJA86L7Q\nFhMneL3vUJ5wtNVIVtY2jDFMJve2NNRBgy0OmpBonSBSNdbOesU8h+ffbVdhnsHr\nLuSYh+SnIivUlenW8b2otu2W5fMlEcf7xdTa5RkTR/EIDLmrN6w9Xvllq79bVsYI\nxq5jHQQhlYbCAq0blt4C18qJJ+7EyuEHClnEUFdzw99+4WjTjph8uDMKE7BxOd/o\n9In/itX7AgMBAAECggEAJZ4pxBWlFI/MK0e+1dtnp+owKYj906ub6LtACamKwgRi\nUkTc20PiUkYcresGnYoP1zN6Z2MniwacDHR8QFOkGgi/i2Qs3smrXiAZ4nwCd9X9\nKk5ksc43ccwotJY86tSIMyiqBExE17duar12jzBxO4oCHSAUCisKFyiFAuSpF9B2\ncCxaKMcbQI9XP5YhPMvxbtkXGKNwbzAF6CjLnWj4Gc+2ioy1qHPe69TwaC3Chw/0\n7zYbufc76ig+ydd99vSrobUUPzCV+Su4zQD5TvfTYHRWm6dV+3TNSEvwIn2XjGJI\nbnXiFOPXf+i1UdjNbi6dnXxEAWwNCoyJFqxzNQqh0QKBgQD7EsK2ZJlPM2vZHD45\n6uJNGRE9f89XjEA6OcUJwBjULKJe/vU7WZnydgJmL49B+ENDR5BLsREfTDSiM5Rk\nGonPp9GN3ASIs+FikMmEYkdr5Pe+hw5jYHi6gou21rG1cLLTGvdmUC8rVwoYRtXe\nx5nSHUi8x/OzgMdoUI/bl9XqqwKBgQC6puthAEypaRM1wx5sKV0ZxhBQaQ3pbeVl\nKQM2SHNeoKc8jaMI5Fw0xzaoegL0aYo16Npck7eFm55R3DX1np6WI+LASHJp5ZNK\nMTu00zhqG1ZkyUrq7coidCzHxxKNCxqJ3SpK+85JcBp/72aiHx22yxCn9mmBRq3D\nJDiB27rB8QKBgQCSLR4IKxHHNtz3jqX7+nC/CnUrJRqGkjVisPey8ZCDF2mBfVcx\nsr0amPJUpCP3+J7QsP2l0/VwD2IlfXpLvde2erJasVpCbNgwFrP8y2thufEzkFYk\nLaqcjBzj2qOkS3URy4V2oACWbxqFf9hM2FEKL9qFbrTIMZXneeAHraLx+QKBgA+r\nf8tO+SCn36L91IoEFvrY8/msOCzGuyF5BfoCrxzco+2jfnJ6qXsM1nvicmkOiznn\naJ2pERk4bVw1/pm2TV4ReTHnYyOc0HbEF10g9nWCAgjIFXAPso6d7jx/bAFHU10L\nokdVSIZF0RO4h4dI0XfNKILRXx4pTuE5Iz1TsyQhAoGBAMj5aK8knt1WH82w+N+W\nIs3RtV5aQPpMJGyQHh9Cnhez89rSQEXFlUd5y7UJWvhhcbjvFN1sIvhOdScGpzDr\nSflEDcZUrGGq2HmhiZ7EwHwPCT46M6/7Iua7hn3CMJVEF1oI5xBedIzMu9AUT6sS\nmzeHKM60IYAsA/pO6/ogjEUJ\n-----END PRIVATE KEY-----\n",
                'client_email' => 'firebase-adminsdk-1jxfy@forgedream.iam.gserviceaccount.com',
                'client_id' => '102927252830397553945',
                'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
                'token_uri' => 'https://oauth2.googleapis.com/token',
                'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
                'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-1jxfy%40forgedream.iam.gserviceaccount.com',
                'universe_domain' => 'googleapis.com',
            ],
        ],

    ],

    /*
    |----------------------------------------------------------------------
    | Migration Repository Table
    |----------------------------------------------------------------------
    |
    | Esta tabla lleva un registro de todas las migraciones que ya se han
    | ejecutado en tu aplicación.
    |
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |----------------------------------------------------------------------
    | Redis Databases
    |----------------------------------------------------------------------
    |
    | Aquí puedes definir la configuración de conexión para Redis.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
