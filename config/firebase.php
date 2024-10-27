<?php

declare(strict_types=1);

return [
    /*
     * ------------------------------------------------------------------------
     * Default Firebase project
     * ------------------------------------------------------------------------
     */

    'default' => env('FIREBASE_PROJECT', 'forgedream'),

    /*
     * ------------------------------------------------------------------------
     * Firebase project configurations
     * ------------------------------------------------------------------------
     */

    'projects' => [
        'forgedream' => [

            /*
             * ------------------------------------------------------------------------
             * Credentials / Service Account
             * ------------------------------------------------------------------------
             */

            'credentials' => [
                'type' => 'service_account',
                'project_id' => 'forgedream',
                'private_key_id' => 'ba1ad72f1f7a5753a28a490a7276759bdc329003',
                'private_key' => '-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC3D1Z8IoEEIc+4\nJTil3+xLRYafwJMj3kVBWHPk/+dHwEoISpLYRr4b+FauK9z/JeHRs2gFzusL2tbg\nN9Ky2d38ukcJyy4CidXQ1EolKPjvcU0wxwpVxANiQhCb2fkewVG9u6XhAJA86L7Q\nFhMneL3vUJ5wtNVIVtY2jDFMJve2NNRBgy0OmpBonSBSNdbOesU8h+ffbVdhnsHr\nLuSYh+SnIivUlenW8b2otu2W5fMlEcf7xdTa5RkTR/EIDLmrN6w9Xvllq79bVsYI\nxq5jHQQhlYbCAq0blt4C18qJJ+7EyuEHClnEUFdzw99+4WjTjph8uDMKE7BxOd/o\n9In/itX7AgMBAAECggEAJZ4pxBWlFI/MK0e+1dtnp+owKYj906ub6LtACamKwgRi\nUkTc20PiUkYcresGnYoP1zN6Z2MniwacDHR8QFOkGgi/i2Qs3smrXiAZ4nwCd9X9\nKk5ksc43ccwotJY86tSIMyiqBExE17duar12jzBxO4oCHSAUCisKFyiFAuSpF9B2\ncCxaKMcbQI9XP5YhPMvxbtkXGKNwbzAF6CjLnWj4Gc+2ioy1qHPe69TwaC3Chw/0\n7zYbufc76ig+ydd99vSrobUUPzCV+Su4zQD5TvfTYHRWm6dV+3TNSEvwIn2XjGJI\nbnXiFOPXf+i1UdjNbi6dnXxEAWwNCoyJFqxzNQqh0QKBgQD7EsK2ZJlPM2vZHD45\n6uJNGRE9f89XjEA6OcUJwBjULKJe/vU7WZnydgJmL49B+ENDR5BLsREfTDSiM5Rk\nGonPp9GN3ASIs+FikMmEYkdr5Pe+hw5jYHi6gou21rG1cLLTGvdmUC8rVwoYRtXe\nx5nSHUi8x/OzgMdoUI/bl9XqqwKBgQC6puthAEypaRM1wx5sKV0ZxhBQaQ3pbeVl\nKQM2SHNeoKc8jaMI5Fw0xzaoegL0aYo16Npck7eFm55R3DX1np6WI+LASHJp5ZNK\nMTu00zhqG1ZkyUrq7coidCzHxxKNCxqJ3SpK+85JcBp/72aiHx22yxCn9mmBRq3D\nJDiB27rB8QKBgQCSLR4IKxHHNtz3jqX7+nC/CnUrJRqGkjVisPey8ZCDF2mBfVcx\nsr0amPJUpCP3+J7QsP2l0/VwD2IlfXpLvde2erJasVpCbNgwFrP8y2thufEzkFYk\nLaqcjBzj2qOkS3URy4V2oACWbxqFf9hM2FEKL9qFbrTIMZXneeAHraLx+QKBgA+r\nf8tO+SCn36L91IoEFvrY8/msOCzGuyF5BfoCrxzco+2jfnJ6qXsM1nvicmkOiznn\naJ2pERk4bVw1/pm2TV4ReTHnYyOc0HbEF10g9nWCAgjIFXAPso6d7jx/bAFHU10L\nokdVSIZF0RO4h4dI0XfNKILRXx4pTuE5Iz1TsyQhAoGBAMj5aK8knt1WH82w+N+W\nIs3RtV5aQPpMJGyQHh9Cnhez89rSQEXFlUd5y7UJWvhhcbjvFN1sIvhOdScGpzDr\nSflEDcZUrGGq2HmhiZ7EwHwPCT46M6/7Iua7hn3CMJVEF1oI5xBedIzMu9AUT6sS\nmzeHKM60IYAsA/pO6/ogjEUJ\n-----END PRIVATE KEY-----\n',
                'client_email' => 'firebase-adminsdk-1jxfy@forgedream.iam.gserviceaccount.com',
                'client_id' => '102927252830397553945',
                'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
                'token_uri' => 'https://oauth2.googleapis.com/token',
                'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
                'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-1jxfy%40forgedream.iam.gserviceaccount.com',
                'universe_domain' => 'googleapis.com',
            ],

            /*
             * ------------------------------------------------------------------------
             * Firebase Auth Component
             * ------------------------------------------------------------------------
             */

            'auth' => [
                'tenant_id' => env('FIREBASE_AUTH_TENANT_ID'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firestore Component
             * ------------------------------------------------------------------------
             */

            'firestore' => [
                // 'database' => env('FIREBASE_FIRESTORE_DATABASE'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firebase Realtime Database
             * ------------------------------------------------------------------------
             */

            'database' => [
                'url' => env('FIREBASE_DATABASE_URL'),
            ],

            'dynamic_links' => [
                'default_domain' => env('FIREBASE_DYNAMIC_LINKS_DEFAULT_DOMAIN'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firebase Cloud Storage
             * ------------------------------------------------------------------------
             */

            'storage' => [
                'default_bucket' => env('FIREBASE_STORAGE_DEFAULT_BUCKET'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Caching
             * ------------------------------------------------------------------------
             */

            'cache_store' => env('FIREBASE_CACHE_STORE', 'file'),

            /*
             * ------------------------------------------------------------------------
             * Logging
             * ------------------------------------------------------------------------
             */

            'logging' => [
                'http_log_channel' => env('FIREBASE_HTTP_LOG_CHANNEL'),
                'http_debug_log_channel' => env('FIREBASE_HTTP_DEBUG_LOG_CHANNEL'),
            ],

            /*
             * ------------------------------------------------------------------------
             * HTTP Client Options
             * ------------------------------------------------------------------------
             */

            'http_client_options' => [
                'proxy' => env('FIREBASE_HTTP_CLIENT_PROXY'),
                'timeout' => env('FIREBASE_HTTP_CLIENT_TIMEOUT'),
                'guzzle_middlewares' => [],
            ],
        ],
    ],
];
